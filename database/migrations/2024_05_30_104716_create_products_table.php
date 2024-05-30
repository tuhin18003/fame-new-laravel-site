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

        if ( ! Schema::hasTable('products')) { 
            
            Schema::create('products', function (Blueprint $table) {
                $table->bigIncrements('products_id');
                $table->tinyInteger('site_id');
                $table->smallInteger('categories_id');
                $table->smallInteger('manufacturers_id');
                $table->tinyInteger('vendor_id');
                $table->tinyInteger('prepack_id');
                $table->tinyInteger('fabrics_id');
                $table->mediumInteger('color_chart_id');
                $table->string('products_name', 512);
                $table->string('list_name', 256);
                $table->tinyInteger('products_status');
                $table->tinyInteger('products_multiplier');
                $table->tinyInteger('products_stocktype');
                $table->tinyInteger('products_hotbuy');
                $table->tinyInteger('products_giftwrap');
                $table->tinyInteger('products_availability');
                $table->tinyInteger('is_new');
                $table->tinyInteger('is_featured');
                $table->tinyInteger('is_exclude');
                $table->tinyInteger('is_main');
                $table->tinyInteger('is_ready');
                $table->tinyInteger('is_preorder');
                $table->tinyInteger('is_confirm');
                $table->tinyInteger('is_grouped');
                $table->tinyInteger('is_inventory');
                $table->tinyInteger('is_swatch');
                $table->tinyInteger('is_measured');
                $table->tinyInteger('products_tax_class_id');
                $table->integer('products_quantity');
                $table->smallInteger('case_quantity');
                $table->integer('stock_on_hand');
                $table->smallInteger('products_moq');
                $table->smallInteger('max_order_quantity');
                $table->smallInteger('max_preorder_quantity');
                $table->tinyInteger('products_unit');
                $table->tinyInteger('size_chart');
                $table->string('products_model', 16);
                $table->smallInteger('products_options_values_id');
                $table->string('products_small_image', 256);
                $table->string('products_large_image', 256);
                $table->string('products_zoom_image', 256);
                $table->string('products_detail_image', 256);
                $table->string('products_hover_image', 256);
                $table->string('image_footer', 256);
                $table->string('products_url', 256);
                $table->string('products_ratio', 256);
                $table->string('products_scale', 64);
                $table->string('self_contents', 128);
                $table->tinyInteger('map_price');
                $table->float('products_price', 8,2);
                $table->float('retail_price', 8,2);
                $table->float('wholesale_price', 8,2);
                $table->float('a_price', 8,2);
                $table->float('b_price', 8,2);
                $table->float('c_price', 8,2);
                $table->float('products_prime_cost', 8,2);
                $table->tinyInteger('products_saletype');
                $table->float('products_shipping_cost', 8,2);
                $table->datetime('products_date_modified');
                $table->datetime('products_date_added');
                $table->datetime('products_date_updated');
                $table->datetime('products_date_avail');
                $table->bigInteger('products_viewed');
                $table->integer('products_sold');
                $table->string('products_freeship', 1);
                $table->string('products_oversize', 1);
                $table->tinyInteger('shipping_leadtime');
                $table->tinyInteger('products_max_tare_qty');
                $table->float('products_weight', 8, 2);
                $table->float('case_weight', 8, 2);
                $table->float('products_width', 8, 2);
                $table->float('products_height', 8, 2);
                $table->integer('products_length');
                $table->integer('products_style');
                $table->integer('products_texture');
                $table->integer('products_capsize');
                $table->integer('products_construction');
                $table->integer('extension_length');
                $table->integer('products_hairstyle');
                $table->string('sku_prefix', 16);
                $table->string('sku_base', 32);
                $table->tinyInteger('sku_group');
                $table->string('sku_color', 64);
                $table->string('sku_size', 64);
                $table->smallInteger('sku_order');
                $table->string('products_sku', 128);
                $table->string('original_sku', 64);
                $table->tinyInteger('mpn_matched');
                $table->string('mfg_sku', 32);
                $table->string('style_no', 32);
                $table->string('products_barcode', 64);
                $table->string('products_amazon_id', 32);
                $table->integer('products_material');
                $table->integer('products_color');
                $table->integer('products_feed');
                $table->string('products_item_no', 12);
                $table->string('products_template', 64);
                $table->string('products_html_path', 256);
                $table->string('alter_html_path', 256);
                $table->string('products_search', 256);
                $table->string('products_title', 128);
                $table->string('products_keyword', 128);
                $table->string('products_description', 512);
                $table->string('products_short_description', 256);
                $table->string('related_skus', 128);
                $table->string('image_alttext', 128);
                $table->text('products_specs');
                $table->text('products_explain');
                $table->string('is_customizable_text', 8);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
