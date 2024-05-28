<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if ( ! Schema::hasTable('orders_products')) { 
            Schema::create('orders_products', function (Blueprint $table) {
                $table->integer('orders_products_id')->autoIncrement();
                $table->integer('orders_id');
                $table->bigInteger('products_id');
                $table->smallInteger('prepack_id');
                $table->smallInteger('pack_qty');
                $table->mediumInteger('categories_id');
                $table->mediumInteger('registries_id');
                $table->integer('inventory_id');
                $table->string('main_sku', 64);
                $table->string('sub_sku', 64);
                $table->string('products_name', 256);
                $table->float('products_price', 82);
                $table->float('final_price', 82);
                $table->tinyInteger('products_saletype');
                $table->float('products_tax', 74);
                $table->tinyInteger('final_sale');
                $table->smallInteger('products_quantity');
                $table->smallInteger('dispatch_quantity');
                $table->smallInteger('backorder_quantity');
                $table->smallInteger('backorder_additional_orderd_qty')->nullable();
                $table->smallInteger('adjusted_qty');
                $table->tinyInteger('shipment_id');
                $table->tinyInteger('is_addon');
                $table->string('customization_text', 1024)->nullable();
                $table->mediumText('customization_image')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_products');
    }
};
