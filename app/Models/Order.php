<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\OrdersProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\DateFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Brick\Money\Money;

class Order extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'orders_id'
    ];

    /**
     * Count all rows in the table
     *
     * @param array $args
     * @return void
     */
    public static function countAllRows( $args = [] ) : int
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
            return self::whereBetween('date_purchased', [
                    $start_date . ' 00:00:00', 
                    $end_date . ' 23:59:59'
                ])->count();
        }

        //return all rows
        if( empty($args) ){
            return self::count();
        }



    }

    /**
     * Has many products on - orders_products table
     *
     * @return HasMany
     */
    public function ordersProduct(): HasMany{
        return $this->hasMany( OrdersProduct::class, 'orders_id', 'orders_id' );
    }

    /**
     * Count sales revenue
     *
     * @param array $args
     * @return void
     */
    public static function countSalesRevenue( $args = [] ) : array {
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

            $start = Carbon::parse($start_date);
            $end = Carbon::parse($end_date);
            $diffInMonths = $start->diffInMonths($end);
            $diffInDays = $start->diffInDays($end);

            $isMonth = false;
            if( $diffInDays > 30 ){
                $data = DB::table('orders')
                ->select(DB::raw('DATE_FORMAT(date_purchased, "%Y-%m") AS month_year, SUM(total_amount) as total_sales, SUM(subtotal_amount) as revenue, SUM(handling_cost) as handling_cost'))
                ->whereBetween('date_purchased', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                ->where( 'status_id', '=', '4' )
                ->groupBy('month_year')
                ->get();

                $isMonth = true;
            }
            else{
                
                $data = DB::table('orders')
                ->select(DB::raw('date_purchased, SUM(total_amount) as total_sales, SUM(subtotal_amount) as revenue, SUM(handling_cost) as handling_cost'))
                ->whereBetween('date_purchased', [
                    $start_date . ' 00:00:00', 
                    $end_date . ' 23:59:59'
                ])
                ->where( 'status_id', '=', '4' )
                ->groupBy('date_purchased')
                ->get();
            }

            $result = [];
            $total_sales = 0;
            $total_revenue = 0;
            foreach ($data as $row) {

                $date = true === $isMonth ? $row->month_year : DateFormatter::formateDate( $row->date_purchased, 'Y-m-d' );
                // $monthYear = ;

                // Check if the date already exists in the result array
                if (isset($result[$date])) {
                    // If date exists, add the total and profit to the existing values
                    $result[$date]['total_sales'] += \round( $row->total_sales, 2 );
                    $result[$date]['revenue'] += \round( $row->revenue + $row->handling_cost, 2 );
                    
                    //format money
                    $result[$date]['total_sales'] = \round( $result[$date]['total_sales'], 2 );
                    $result[$date]['revenue'] = \round( $result[$date]['revenue'], 2 );

                } else {
                    // If date doesn't exist, create a new entry in the result array
                    $result[$date] = [
                        'total_sales' => \round( $row->total_sales, 2 ),
                        'revenue' => \round( $row->revenue + $row->handling_cost, 2 )
                    ];
                }

                $total_sales += $row->total_sales;
                $total_revenue += $row->revenue + $row->handling_cost;
            }


            return array(
                'sales_revenue' => array(
                    'total_sales' => Money::of( $total_sales, 'USD'),
                    'total_revenue' => Money::of( $total_revenue, 'USD'),
                    'data' => $result
                )
            );
        }

        return array( 'message' => 'Please provide date to get sales revenue data.');
    }

}
