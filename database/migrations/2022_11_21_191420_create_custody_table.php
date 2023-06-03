<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustodyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custody', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('current_custody')->nullable();
            $table->string('status')->nullable();
            $table->string('receiving_party')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('change_date')->nullable();
            $table->string('initialized_by')->nullable();
            $table->string('partner_to_send_to')->nullable();
            $table->string('final_address')->nullable();
            $table->string('final_location')->nullable();
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
        Schema::dropIfExists('custody');
    }
}
