<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('supplier_name')->nullable()->comment('供应商名称');
            $table->text('supplier_desc')->nullable()->comment('供应商描述');
            $table->string('logo_image_url')->nullable()->comment('Logo图片地址');
            $table->timestamps();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')
                ->references('id')->on('suppliers');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')
                ->references('id')->on('suppliers');
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
            $table->dropForeign('products_supplier_id_foreign');
            $table->dropColumn('supplier_id');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_supplier_id_foreign');
            $table->dropColumn('supplier_id');
        });
        Schema::drop('suppliers');
    }
}
