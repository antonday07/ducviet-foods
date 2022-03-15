<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnBillImportDetailEditColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bill_import', function (Blueprint $table) {
            $table->dropColumn('amount');
            $table->dropColumn('supplier_id');

        });
        Schema::table('bill_import_detail', function (Blueprint $table) {
            $table->integer('amount')->nullable()->default(0);
            $table->decimal('price', 10,2)->nullable()->default(0);
            $table->integer("supplier_id");
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
    }
}
