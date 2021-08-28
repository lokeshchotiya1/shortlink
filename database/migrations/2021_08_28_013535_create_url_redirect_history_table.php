<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrlRedirectHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('url_redirect_history', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->bigInteger('url_id')->unsigned();            
            $table->foreign('url_id')->references('id')->on('short_links');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('url_redirect_history', function (Blueprint $table) {
            //
        });
    }
}
