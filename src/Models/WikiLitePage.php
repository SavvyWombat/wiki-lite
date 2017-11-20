<?php

namespace SavvyWombat\WikiLite\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WikiLitePage extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [ 'updated_at' ];



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