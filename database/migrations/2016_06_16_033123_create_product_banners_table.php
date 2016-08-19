<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_url');
            $table->integer('weight')->default(0);
            $table->unsignedInteger('product_id')->nullable();
            $table->foreign('product_id')
                ->references('id')->on('products');
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
        Schema::table('product_banners', function (Blueprint $table) {
            $table->dropForeign('product_banners_product_id_foreign');
            $table->dropColumn('product_id');
        });
        Schema::drop('product_banners');
    }
}
