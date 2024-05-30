<?php

namespace App\Models;

use App\Models\OrdersProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * Order's Product items
     *
     * @return void
     */
    public function orderProducts()
    {
        return $this->hasMany(OrdersProduct::class, 'products_id', 'products_id');
    }


    
}
