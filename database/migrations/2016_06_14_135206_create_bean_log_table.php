<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeanLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bean_log', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->string('action');
            $table->string('action_ch');
            $table->decimal('beans', 11, 4)->default(0.00);
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
        Schema::table('bean_log', function (Blueprint $table) {
            $table->dropForeign('bean_log_customer_id_foreign');
            $table->dropColumn('customer_id');
        });
        Schema::drop('bean_log');
    }
}
