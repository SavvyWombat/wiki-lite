<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveParentFromWikiLitePages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wiki_lite_pages', function(Blueprint $table) {
            $table->dropColumn('parent_uuid');
        });
    }
}