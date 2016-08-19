<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddresesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned()->nullable();
            $table->boolean('default')->default(0);
            $table->string('phone', 20);
            $table->string('name', 100);
            $table->integer('zipcode');
            $table->string('province');
            $table->string('city');
            $table->string('district', 50)->nullable();
            $table->text('address');
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign('addresses_customer_id_foreign');
            $table->dropColumn('customer_id');
        });
        Schema::drop('addresses');

    }
}
