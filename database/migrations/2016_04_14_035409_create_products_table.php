<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('puan_id')->unsigned();
            $table->string('name', 100);
            $table->string('description', 225);
            $table->text('detail', 500)->nullable();
            $table->double('price', 10, 2);
            $table->string('default_spec');
            $table->double('beans', 10, 2);
            $table->string('tags')->nullable();
            $table->string('logo');
            $table->integer('sale_counts')->unsigned();
            $table->integer('view_counts')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->tinyInteger('is_on_sale')->default(1);
            $table->tinyInteger('is_show')->default(0);
            $table->integer('weight')->nullable()->default(0);
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_category_id_foreign');
            $table->dropColumn('category_id');
        });
        Schema::drop('products');
    }
}
