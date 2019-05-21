<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_session', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->nullable();
            $table->string('uuid')->nullable()->comment('For mobile identity');
            $table->string('user_agent');
            $table->string('app_token', 255);
            $table->text('access_token')->nullable();
            $table->integer('app_id');
            $table->timestamp('validity')->nullable();
            $table->timestamp('date_created')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_session');
    }
}
