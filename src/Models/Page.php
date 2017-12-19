<?php

namespace SavvyWombat\WikiLite\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use SebastianBergmann\Diff\Differ;
use Webpatser\Uuid\Uuid;

class Page extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [ 'updated_at' ];

    /**
     * Specifies the tables primary key column. Assumes `id` if not set
     *
     * @var string
     */
    protected $primaryKey = 'revision';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wiki_lite_pages';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;



    /**
     * Boot function for using with User Events.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function($model) {
            // enforce uuid on new pages
            if (is_null($model->uuid)) {
                $model->uuid = Uuid::generate(4)->string;
            }
            // enforce updated_at date to be now
            // this is because we are really creating the revision of a page
            $model->updated_at = Carbon::now()->toDateTimeString();

            // extract any wiki links from the content
            $links = $model->links();

            LinkBack::where('source_uuid', $model->uuid)->delete();

            foreach ($links as $slug => $title) {

                $linkback = new LinkBack();
                $linkback->source_uuid = $model->uuid;
                $linkback->target_slug = $slug;
                $linkback->save();
            }

            // make sure any linkbacks follow a change in slug
            try {
                $lastRevision = $model->revisions($model->slug)->first();

                if ($lastRevision && $lastRevision->slug != $model->slug) {
                    LinkBack::where('target_slug', $lastRevision->slug)->update([ "target_slug" => $model->slug, ]);
                }
            } catch(ModelNotFoundException $e) {
                // Nothing to do
            }
        });
    }



    /**
     * Get a unified diff of the content comparing this page with a newer one
     *
     * @param \SavvyWombat\WikiLite\Models\Page $newPage
     * @return string
     */
    public function diff(Page $newPage)
    {
        $differ = new Differ();

        return $differ->diff($this->content, $newPage->content);
    }



    /**
     * Links back to this page
     */
    public function linksBack()
    {
        return $this->hasMany(LinkBack::class, "target_slug", "slug");
    }



    /**
     * Extract the links from the
     */
    public function links()
    {
        $wikilinks = [];
        preg_match_all("#\[\[(.*)\]\]#U",
            $this->content,
            $wikilinks,
            PREG_SET_ORDER
        );

        $links = [];
        foreach ($wikilinks as $wikilink) {
            if (isset($wikilink[1])) {
                $links[str_slug($wikilink[1])] = $wikilink[1];
            }
        }

        return $links;
    }



    /**
     * Only get the latest revision of the given slug
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRevisions($query, $slug = "")
    {
        return $query->where(function($query) use ($slug) {
            if (!empty($slug)) {
                $uuid = Page::where('slug', $slug)
                    ->orderBy('revision', 'desc')
                    ->firstOrFail()
                    ->uuid;

                $query->where('uuid', $uuid);
            } else {
                $subQuery = 'SELECT max(revision) FROM wiki_lite_pages GROUP BY uuid';
                $query->whereRaw("revision in ($subQuery)");
            }
        })
        ->orderBy('revision', 'desc');
    }



    /**
     * Set the slug automatically when entering a title
     */
    public function setTitleAttribute($title)
    {
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = str_slug($title);
    }



    /**
     * Prevent the uuid from being modified once set
     */
    public function setUuidAttribute($uuid)
    {
        if (!isset($this->attributes['uuid']) || is_null($this->attributes['uuid'])) {
            $this->attributes['uuid'] = $uuid;
        }
    }
}