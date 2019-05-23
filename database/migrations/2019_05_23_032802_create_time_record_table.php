<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_record', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->useCurrent();
            $table->time('time')->useCurrent();
            $table->string('mode', 50)->default('in');
            $table->double('mileage')->nullable();
            $table->integer('tt_number')->nullable();
            $table->integer('driver_id')->nullable();
            $table->integer('guard_id')->nullable()->comment('This must not be null if other person encoded the data');
            $table->string('drivers_name')->nullable()->comment('for non-org driver');
            $table->integer('vehicle_id')->nullable();
            $table->integer('created_by');
            $table->string('plate_no', 50)->nullable()->comment('for non-orgs vehicle only');
            $table->text('remarks');
            $table->softDeletes();
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
        Schema::dropIfExists('time_record');
    }
}
