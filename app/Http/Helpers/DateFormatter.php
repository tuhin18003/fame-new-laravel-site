<?php

namespace App\Http\Helpers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DateFormatter 
{

	/**
	 * Date formatter
	 *
	 * @param [type] $date
	 * @param string $return_format
	 * @return void
	 */
	public static function formateDate( $date, $return_format = 'Y-m-d H:i:s' ){
		return \date( $return_format, \strtotime( $date) );
	}

}

?>