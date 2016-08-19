<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone', 31)->nullable();
            $table->unique('phone');
            $table->string('password', 31)->nullable();
            $table->string('openid');
            $table->unique('openid');
            $table->string('unionid');
            $table->unique('unionid');
            $table->string('nickname')->nullable();
            $table->string('head_image_url')->nullable();
            $table->decimal('total_beans', 11, 4)->default(0.00);
            $table->decimal('balance_beans', 11, 4)->default(0.00);
            $table->decimal('puan_beans', 11, 4)->default(0.00);
            $table->decimal('ohmate_beans', 11, 4)->default(0.00);
            $table->string('source')->nullable();
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
        //
        Schema::drop('customers');
    }
}
