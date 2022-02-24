<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RecreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('products', function (Blueprint $table) {
        //    // $table->dropForeign('products_product_category_id_foreign');
        //     $table->dropColumn('product_category_id');
        //    // $table->dropForeign('products_promotion_id_foreign');
        //     $table->dropColumn('promotion_id');
        // });
        // DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        // Schema::dropIfExists('products');
        // DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer("unit_id");
            $table->integer("category_id");
            $table->integer("promotion_id");
            $table->integer("supplier_id");
            $table->string("name");
            $table->string("slug");
            $table->decimal('entry_price', 10,2)->nullable()->default(0);
            $table->decimal('retail_price', 10,2)->nullable()->default(0);
            $table->text('description')->nullable()->default(null);
            $table->integer('status')->nullable()->default(null)->comment('1: selling, 2: pause selling, 3: out of stock');
            $table->string('image')->comment('image ');
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
        Schema::dropIfExists('products');
    }
}
