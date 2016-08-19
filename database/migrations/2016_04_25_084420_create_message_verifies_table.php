<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageVerifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('message_verifies', function (Blueprint $table) {
            $table->increments('id')->comment('主键.');

            //个人信息
            $table->string('phone', 31)->comment('手机号码.');
            $table->string('code', 31)->comment('验证码.');
            $table->tinyInteger('status')->default(0)->comment('验证码状态，1表示已经被使用过.');
            $table->timestamp('expired')->nullable()->comment('验证码过期时间.');

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
        Schema::drop('message_verifies');
    }
}
