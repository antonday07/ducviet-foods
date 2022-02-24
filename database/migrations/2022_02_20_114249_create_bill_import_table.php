<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillImportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_import', function (Blueprint $table) {
            $table->id();
            $table->integer("employee_id");
            $table->integer("supplier_id");
            $table->string("code_bill")->comment('code of bill: b_1238asdj623');
            $table->dateTime('date_import')->comment('date create bill import');
            $table->text('description')->nullable()->default(null);
            $table->text("note");
            $table->integer('amount')->nullable()->default(0);
            $table->decimal('total_price', 10,2)->nullable()->default(0);
            $table->integer('status')->nullable()->default(null);
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
        Schema::dropIfExists('bill_import');
    }
}
