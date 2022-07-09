<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class createCountiesDistrictsZipCodeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code_district');
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('zip_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('district_id')->unsigned();
            $table->integer('county_id')->unsigned();
            $table->string('code_locality');
            $table->string('name_locality');
            $table->string('code_arteria');
            $table->string('type_arteria');
            $table->string('prep1');
            $table->string('title_arteria');
            $table->string('prep2');
            $table->string('name_arteria');
            $table->string('local_arteria');
            $table->string('change');
            $table->string('door');
            $table->string('client');
            $table->string('number');
            $table->string('extension');
            $table->string('desig_postal');
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
        Schema::dropIfExists('counties');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('zip_codes');
    }
}
