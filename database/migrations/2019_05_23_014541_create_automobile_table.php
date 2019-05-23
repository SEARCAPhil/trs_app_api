<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutomobileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('automobile', function (Blueprint $table) {
            $table->increments('id');
            $table->string('plate_no', 50);
            $table->string('manufacturer', 150);
            $table->string('model')->nullable();
            $table->year('year')->nullable();
            $table->string('color')->nullable();
            $table->string('conduction_no', 100)->nullable();
            $table->string('transmission_type', 50)->nullable();
            $table->date('date_acquired');
            $table->date('date_registered');
            $table->text('notes')->nullable();
            $table->string('image')->nullable();
            $table->string('availability')->nullable()->comment('temporary field only and for deletion');
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
        Schema::dropIfExists('automobile');
    }
}
