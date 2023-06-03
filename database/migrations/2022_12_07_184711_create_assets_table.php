<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('server_rack', ['yes', 'no']);
            $table->string('server_rack_number')->nullable();
            $table->string('manufacture')->nullable();
            $table->string('model')->nullable();
            $table->string('serial')->nullable();
            $table->string('cpu_manufacture')->nullable();
            $table->string('cpu_part_number')->nullable();
            $table->string('cpu_qty')->nullable();
            $table->string('memory_qty')->nullable();
            $table->string('memory_capacity')->nullable();
            $table->string('asset_tag')->nullable();
            $table->string('hardware_manufacture')->nullable();
            $table->string('hard_drive_qty')->nullable();
            $table->string('hard_drive_capacity')->nullable();
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
        Schema::dropIfExists('assets');
    }
}
