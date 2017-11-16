<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWikiLitePages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wiki_lite_pages', function(Blueprint $table) {
            $table->increments('revision');
            $table->uuid('id');
            $table->uuid('parent_id')
                ->nullable();
            $table->integer('user_id')
                ->default(0);
            $table->dateTimeTz('updated_at');
            $table->text('title');
            $table->text('slug');
            $table->longText('content');
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wiki_lite_pages');
    }
}