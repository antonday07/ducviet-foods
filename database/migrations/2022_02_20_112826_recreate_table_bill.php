<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RecreateTableBill extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        //  Schema::dropIfExists('bills');
        //  Schema::dropIfExists('bill_details');
        // DB::statement('SET FOREIGN_KEY_CHECKS = 1');

         Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->text("note");
            $table->dateTime("date")->comment('date create order');
            $table->decimal("total_price", 10, 2);
            $table->string("delivery_address");
            $table->integer("status")->nullable()->default(null)->comment('1: order, 2: shipping, 3: shipped');
            $table->integer("status_payment")->nullable()->default(null)->comment('1: paid, 2: unpaid');
            $table->timestamps();
        });

        Schema::create('bill_details', function (Blueprint $table) {
            $table->id();
            $table->integer("product_id");
            $table->integer("bill_id");
            $table->integer("amount")->comment('amount product add');
            $table->decimal("price", 10, 2);
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
        Schema::dropIfExists('bills');
        Schema::dropIfExists('bill_details');
    }
}
