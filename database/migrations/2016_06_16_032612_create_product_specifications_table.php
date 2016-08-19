<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_specifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('specification_name');
            $table->decimal('specification_price');
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
        Schema::table('product_specifications', function (Blueprint $table) {
            $table->dropForeign('product_specifications_product_id_foreign');
            $table->dropColumn('product_id');
        });
        Schema::drop('product_specifications');
    }
}
