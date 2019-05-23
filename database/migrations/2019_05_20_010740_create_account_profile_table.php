<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->nullable();
            $table->string('profile_name', 255);
            $table->string('last_name', 100);
            $table->string('first_name', 100);
            $table->string('middle_name', 100);
            $table->string('profile_email', 150);
            $table->string('department', 255);
            $table->string('department_alias', 255);
            $table->integer('dept_id');
            $table->string('position', 255);
            $table->string('profile_image', 255);
            $table->timestamp('date_modified');
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
        Schema::dropIfExists('account_profile');
    }
}
