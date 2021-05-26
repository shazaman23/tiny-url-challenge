<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TinyUrlsAddNsfwColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tiny_urls', function (Blueprint $table) {
            $table->boolean('nsfw')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tiny_urls', function (Blueprint $table) {
            $table->dropColumn('nsfw');
        });
    }
}
