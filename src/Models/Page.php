<?php

namespace SavvyWombat\WikiLite\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Webpatser\Uuid\Uuid;

class Page extends Model
{
    /**
     * Specifies the tables primary key column. Assumes `id` if not set
     *
     * @var string
     */
    protected $primaryKey = 'revision';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [ 'updated_at' ];

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

        static::creating(function($model) {
            // enforce uuid on new pages
            if (is_null($model->uuid)) {
                $model->uuid = Uuid::generate(4)->string;
            }
            // enforce updated_at date to be now
            // this is because we are really creating the revision of a page
            $model->updated_at = Carbon::now()->toDateTimeString();
        });
    }



    /**
     * Only get the latest revision of the given slug
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRevisions($query, $slug)
    {
        return $query->where(function($query) use ($slug) {
                $uuid = Page::where('slug', $slug)
                    ->firstOrFail()
                    ->uuid;

                $query->where('uuid', $uuid);
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