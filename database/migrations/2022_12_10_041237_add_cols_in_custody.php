<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsInCustody extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('custody', function (Blueprint $table) {
            $table->bigInteger('address_country')->nullable()->unsigned();
            $table->bigInteger('address_state')->nullable()->unsigned();
            $table->bigInteger('address_city')->nullable()->unsigned();
            $table->bigInteger('location_country')->nullable()->unsigned();
            $table->bigInteger('location_state')->nullable()->unsigned();
            $table->bigInteger('location_city')->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('custody', function (Blueprint $table) {
            $table->dropColumn('address_country');
            $table->dropColumn('address_state');
            $table->dropColumn('address_city');
            $table->dropColumn('location_country');
            $table->dropColumn('location_state');
            $table->dropColumn('location_city');
        });
    }
}
