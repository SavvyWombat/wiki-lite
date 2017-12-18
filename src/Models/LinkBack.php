<?php

namespace SavvyWombat\WikiLite\Models;

use Illuminate\Database\Eloquent\Model;

class LinkBack extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wiki_lite_linkbacks';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}