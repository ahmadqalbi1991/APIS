<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomerIdAndOrderIdInCustody extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('custody', function (Blueprint $table) {
            $table->bigInteger('customer_id')->nullable()->unsigned();
            $table->bigInteger('order_id')->nullable()->unsigned();
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
            $table->dropColumn('customer_id');
            $table->dropColumn('order_id');
        });
    }
}
