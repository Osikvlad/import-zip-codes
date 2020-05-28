<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_data', function (Blueprint $table) {
            $table->id();
            $table->string('zip')->unique();
            $table->double('lat', 8, 5);
            $table->double('lng', 8, 5);
            $table->string('city');
            $table->string('state_id', 2);
            $table->string('state_name');
            $table->string('zcta');
            $table->string('parent_zcta')->nullable();
            $table->integer('population')->unsigned();
            $table->string('density');
            $table->integer('county_fips')->unsigned();
            $table->string('county_name');
            $table->string('county_weights');
            $table->string('county_names_all');
            $table->string('county_fips_all');
            $table->string('imprecise');
            $table->string('military');
            $table->string('timezone');
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
        Schema::dropIfExists('import_data');
    }
}
