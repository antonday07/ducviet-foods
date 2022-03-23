<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->string('bill_phone')->nullable()->default(null)->comment('phone number of user');
            $table->string('bill_email')->nullable()->default(null)->comment('email of user');
            $table->string('bill_name')->nullable()->default(null)->comment('name of user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->dropColumn('bill_phone');
            $table->dropColumn('bill_email');
            $table->dropColumn('bill_name');
        });
    }
}
