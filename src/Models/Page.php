<?php

namespace SavvyWombat\WikiLite\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
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
            // enforce new records to have a version 4 (truly random) UUID
            $model->id = Uuid::generate(4);

            // enforce updated_at date to be now
            // this is because we are really creating the revision of a page
            $model->updated_at = Carbon::now()->toDateTimeString();
        });
    }



    /**
     * Get subpages
     */
    public function pages()
    {
        return $this->hasMany(
            WikiLitePage::class,
            'parent_id',
            'id'
        );
    }

    /**
     * Get subpages
     */
    public function parent()
    {
        return $this->belongsTo(
            WikiLitePage::class,
            'id',
            'parent_id'
        );
    }



    /**
     * Set the slug automatically when entering a title
     */
    public function setTitleAttribute($title)
    {
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = str_slug($title);
    }
}