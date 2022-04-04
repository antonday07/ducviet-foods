<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSoldQuantityToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bill_import_detail', function (Blueprint $table) {
            $table->integer("sold_quantity")->default(0)->nullable()->comment("Quantity sold of bill import database");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bill_import_detail', function (Blueprint $table) {
            $table->dropColumn('sold_quantity');
        });
    }
}
