<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTinyUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiny_urls', function (Blueprint $table) {
            $table->string('id', 7)->primary();
            $table->string('full_url', 512);
            $table->integer('hits')->default('0');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE tiny_urls ADD seed INTEGER NOT NULL UNIQUE AUTO_INCREMENT;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiny_urls');
    }
}
