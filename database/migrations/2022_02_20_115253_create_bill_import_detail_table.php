<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillImportDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_import_detail', function (Blueprint $table) {
            $table->id();
            $table->integer("product_id");
            $table->integer("bill_import_id");
            $table->date('entry_date')->comment('date import this product');
            $table->date('expiry_date')->comment('date expiry this product');
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
        Schema::dropIfExists('bill_import_detail');
    }
}
