<?php

namespace App\Models;

use App\Models\Order;
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


}
