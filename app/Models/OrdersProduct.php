<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\DateFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrdersProduct extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'orders_id'
    ];

    /**
     * This has a specific order id on Order table
     *
     * @return BelongsTo
     */
    public function order() : BelongsTo
    {
        return $this->belongsTo( Order::class, 'orders_id', 'orders_id' );
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'products_id');
    }

    /**
     * Count all sold items
     *
     * @param array $args
     * @return void
     */
    public static function countAllSoldItems( $args = [] ) : int 
    {

        //check for specific date
        if( isset($args['date']) && !empty($args['date']) ){ 
            $start_date = DateFormatter::formateDate( $args['date'], 'Y-m-d' );
            $end_date = $start_date;
        }

        //check for date range
        if( isset($args['start_date']) && !empty($args['start_date']) && isset($args['end_date']) && !empty($args['end_date']) ){
            $start_date = DateFormatter::formateDate( $args['start_date'], 'Y-m-d' );
            $end_date = DateFormatter::formateDate( $args['end_date'], 'Y-m-d' );
        }

        //count rows on a specific date
        if( isset($start_date) && !empty($start_date) && isset($end_date) && !empty($end_date) ){
            return OrdersProduct::whereHas('order', function ($query) use ($start_date, $end_date) {
                $query->whereBetween('date_purchased', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
            })
            ->sum('orders_products.products_quantity'); // Specify columns you want
        }

        //return total sold items - from the beginning
        if( empty($args) ){
            return self::sum('products_quantity');
        }

    }


    /**
     * Most Sold Items
     *
     * @param array $args
     * @return void
     */
    public static function mostSoldItems( $args = []  ){
        //check for specific date
        if( isset($args['date']) && !empty($args['date']) ){ 
            $start_date = DateFormatter::formateDate( $args['date'], 'Y-m-d' );
            $end_date = $start_date;
        }

        //check for date range
        if( isset($args['start_date']) && !empty($args['start_date']) && isset($args['end_date']) && !empty($args['end_date']) ){
            $start_date = DateFormatter::formateDate( $args['start_date'], 'Y-m-d' );
            $end_date = DateFormatter::formateDate( $args['end_date'], 'Y-m-d' );
        }

        // Subquery to filter orders within the date range and join necessary tables
        $subQuery = DB::table('orders_products')
        ->join('orders', 'orders_products.orders_id', '=', 'orders.orders_id')
        ->whereBetween('orders.date_purchased', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'] )
        ->select('orders_products.products_id', DB::raw('sum(orders_products.dispatch_quantity) as total_sold'))
        ->groupBy('orders_products.products_id');

        // Main query to join the subquery with the products table and get the top 10 items
        return DB::table(DB::raw("({$subQuery->toSql()}) as sub"))
            ->mergeBindings($subQuery) // Merge bindings of the subquery
            ->join('products', 'sub.products_id', '=', 'products.products_id')
            ->select('sub.products_id', 'products.products_name', 'sub.total_sold')
            ->orderBy('sub.total_sold', 'desc')
            ->take( $args['get_total_items'] )
            ->get();

    }


}
