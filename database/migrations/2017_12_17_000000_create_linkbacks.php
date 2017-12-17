<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkbacks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wiki_lite_linkbacks', function(Blueprint $table) {
            $table->increments('id');
            $table->uuid('source_uuid');
            $table->text('slug');
        });
    }
}