<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSupplierIdToMemberOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('member_orders', function (Blueprint $table) {
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
        Schema::table('member_orders', function (Blueprint $table) {
            $table->dropForeign('member_orders_supplier_id_foreign');
        });
    }
}
