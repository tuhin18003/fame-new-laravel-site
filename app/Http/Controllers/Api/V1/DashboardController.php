<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\OrdersProduct;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    
    /**
     * Get dashboard data - OnLoad
     * protected data
     *
     * @param string $request
     * @return void
     */
    public function dashboard( Request $request){

        $date = '';
        //specific date
        if( isset( $request->date ) ){
            $date = isset( $request->date ) ? [ 'date' => $request->date ] : '';
        }
        else if( isset($request->start_date) && isset($request->end_date)){
            //date range
            $date = isset( $request->start_date ) && isset( $request->end_date ) ? [ 'start_date' => $request->start_date, 'end_date' => $request->end_date ] : '';
        }
        
        //count all orders
        $total_orders = Order::countAllRows( $date );
        
        //count all sold items
        $items_sold = OrdersProduct::countAllSoldItems( $date );

        //sales revenue
        $sales_revenue = Order::countSalesRevenue( $date );


        return \response()->json([
            'total_orders' => $total_orders,
            'items_sold' => $items_sold,
            'sales_revenue' => $sales_revenue
        ]);

    }

}
