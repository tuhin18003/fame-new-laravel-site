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

        if ( ! Schema::hasTable('orders')) { 
            Schema::create('orders', function (Blueprint $table) {
                $table->integer('orders_id')->autoIncrement();
                $table->integer('parent_id')->nullable();
                $table->string('orders_no', 24);
                $table->string('invoice_no', 24);
                $table->tinyInteger('status_id')->nullable();
                $table->bigInteger('customers_id')->nullable();
                $table->string('customers_company', 64);
                $table->string('customers_name', 64);
                $table->string('customers_street_address', 128);
                $table->string('customers_suburb', 64);
                $table->string('customers_city', 64);
                $table->string('customers_postcode', 10);
                $table->string('customers_state', 32);
                $table->string('customers_province', 32);
                $table->string('customers_country', 32);
                $table->string('customers_telephone', 32);
                $table->string('customers_fax', 32);
                $table->string('customers_email_address', 128);
                $table->tinyInteger('customers_address_format_id')->nullable();
                $table->string('customers_remote_addr', 16);
                $table->string('ip_country', 16);
                $table->string('delivery_company', 64);
                $table->string('delivery_name', 64);
                $table->string('delivery_street_address', 128);
                $table->string('delivery_suburb', 32);
                $table->string('delivery_city', 32);
                $table->string('delivery_postcode', 10);
                $table->string('delivery_state', 10);
                $table->smallInteger('delivery_zone_id')->nullable();
                $table->integer('delivery_country')->nullable();
                $table->string('delivery_phone', 32);
                $table->tinyInteger('mobile_carrier')->nullable();
                $table->tinyInteger('delivery_address_format_id')->nullable();
                $table->string('payment_method', 24);
                $table->tinyInteger('cc_mask')->nullable();
                $table->string('cc_type', 24);
                $table->string('cc_owner', 64);
                $table->tinyText('cc_number')->charset('binary');
                $table->string('cc_lastdigits', 4);
                $table->string('cc_expires', 6);
                $table->string('cc_cvc_code', 4);
                $table->dateTime('last_modified');
                $table->dateTime('date_purchased');
                $table->dateTime('date_invoiced');
                $table->dateTime('date_vendorpo');
                $table->dateTime('date_shipped');
                $table->dateTime('date_shipped2');
                $table->dateTime('date_shipped3');
                $table->dateTime('date_required');
                $table->dateTime('date_sync');
                $table->string('shipping_carrier', 32);
                $table->string('shipping_carrier2', 32);
                $table->string('shipping_carrier3', 32);
                $table->float('shipping_cost', 82);
                $table->string('shipping_method', 64);
                $table->string('shipping_id', 32);
                $table->string('shipping_id2', 32);
                $table->string('shipping_id3', 32);
                $table->enum('shipping_free', ['y', 'n']);
                $table->string('shipping_preferred', 16);
                $table->dateTime('backorder_shipping_date');
                $table->float('handling_cost', 52);
                $table->dateTime('orders_date_finished');
                $table->string('currency', 4);
                $table->double('currency_value');
                $table->string('gw_auth_code', 64);
                $table->string('gw_trans_id', 64);
                $table->string('gw_avs_code', 1);
                $table->string('gw_cvv_code', 1);
                $table->smallInteger('gw_reason_code')->nullable();
                $table->float('discount_rate', 82);
                $table->float('mileage_amount', 82);
                $table->float('discount_amount', 82);
                $table->float('refund_amount', 82);
                $table->float('total_amount', 82);
                $table->float('subtotal_amount', 82);
                $table->string('update_quantity', 1);
                $table->tinyInteger('ask_outofstock')->nullable();
                $table->string('site_code');
                $table->string('delivery_note', 512);
                $table->mediumText('comments');
                $table->mediumText('admin_notes');
                $table->mediumText('office_notes');
                $table->mediumText('user_agent');
            });

        }

        // Specify the table name
        $tableName = 'orders';
        $columnName = 'orders_no';
        if (!Schema::hasColumn($tableName, $columnName)) {
            Schema::table($tableName, function (Blueprint $table) use ($columnName) {
                // Adding a new column
                $table->string($columnName);
                // Modifying an existing column
                // $table->string($columnName)->change();
            });
        }


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('orders')) { 
            Schema::dropIfExists('orders');
        }
    }
};
