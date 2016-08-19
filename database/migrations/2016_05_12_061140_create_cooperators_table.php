<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCooperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cooperators', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('url')->nullable();
            $table->string('token')->nullable();
            $table->string('beans')->nullable();
            $table->string('beans_balance')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedInteger('cooperator_id')->nullable();
            $table->foreign('cooperator_id')
                ->references('id')->on('cooperators');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign('customers_cooperator_id_foreign');
            $table->dropColumn('cooperator_id');
        });
        Schema::drop('cooperators');
    }
}
