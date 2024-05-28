<?php

namespace App\Http\Controllers;

use auth;
use App\Models\Customer;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class CustomerController extends Controller
{
    use HasApiTokens, HasFactory;
    

}
