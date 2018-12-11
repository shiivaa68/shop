<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameProducIdToProductIdInTblOrderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_order_details', function (Blueprint $table) {
            //
           $table->renameColumn('produc_id','product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_order_details', function (Blueprint $table) {
            //
             $table->renameColumn('product_id','produc_id');
        });
    }
}
