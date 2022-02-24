<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAllTableAndAddColumnToExistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::rename('product_categories', 'categories');
        // Schema::rename('admins', 'employees');
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('image', 'avatar');
            $table->string('phone')->nullable()->default(null)->comment('phone number');
            $table->date('dob')->nullable()->default(null)->comment('phone number');
            $table->string('address')->nullable()->default(null)->comment('address of user');
        });
        Schema::table('promotions', function (Blueprint $table) {
            $table->renameColumn('percent', 'price');
            $table->integer('type')->comment('1: fixed price, 2: percent %');
            $table->date('date_from')->comment('date start promotion')->nullable()->default(null);
            $table->date('date_expiry')->comment('date expiry promotion')->nullable()->default(null);
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->string('code')->nullable()->default(null)->comment('code category: ct79sd123');
        });
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string('code')->nullable()->default(null)->comment('code unit: ut79sd123');
            $table->string("description");
            $table->timestamps();
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->string('phone')->nullable()->default(null)->comment('phone number');
            $table->string('address')->nullable()->default(null)->comment('address of user');
            $table->integer('role')->nullable()->default(null)->comment('1: admin, 2: employee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exist', function (Blueprint $table) {
            //
        });
        Schema::dropIfExists('units');
    }
}
