<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('activity_name');
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('activity_id')->nullable();
            $table->foreign('activity_id')
                ->references('id')->on('activities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_activity_id_foreign');
            $table->dropColumn('activity_id');
        });
        Schema::drop('activities');
    }
}
