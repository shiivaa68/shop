<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblSiteInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_site_info', function (Blueprint $table) {
            $table->increments('info_id');
            $table->string('site_email');
            $table->string('site_tel');
            $table->string('site_address');
            $table->string('site_title');
            $table->string('site_description');
            $table->string('site_copyright');
            $table->string('site_logo');
            
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
        Schema::dropIfExists('tbl_site_info');
    }
}
