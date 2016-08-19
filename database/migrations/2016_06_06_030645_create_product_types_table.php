<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('product_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_en', 11)->comment('用户类型-英');
            $table->string('type_ch', 11)->comment('用户类型-中');
            $table->timestamps();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('type_id')->nullable();
            $table->foreign('type_id')
                ->references('id')->on('product_types');
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_type_id_foreign');
            $table->dropColumn('type_id');
        });
        Schema::drop('product_types');
    }
}
