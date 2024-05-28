<?php

namespace App\Http\Controllers;

use auth;
use App\Models\Customer;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AuthController extends Controller
{
    use HasApiTokens, HasFactory;
    
    /**
     * Signup New user / customer
     *
     * @param Request $request
     * @return void
     */
    public function signup( Request $request ){

        $validated = $request->validate([
            'customers_firstname' => 'required',
            'customers_lastname' => 'required',
            'customers_email_address' => 'required|email',
            'customers_password' => 'required|confirmed',
        ]);

        $customer = Customer::create([
            'customers_firstname' => $request->customers_firstname,
            'customers_lastname' => $request->customers_lastname,
            'customers_email_address' => $request->customers_email_address,
            'customers_password' => Hash::make( $request->customers_password )
        ]);

        $token = $customer->createToken('fameCustomer')->plainTextToken;

        return response()->json([
            'customer' => $customer,
            'token' => $token
        ], 201 );
    }

    /**
     * login
     *
     * @param Request $request
     * @return void
     */
    public function login( Request $request ){

        $request->validate([
            'customers_email_address' => 'required|email',
            'customers_password' => 'required'
        ]);

        $Customer = Customer::where( 'customers_email_address', $request->customers_email_address )->first();

        if( empty($Customer ) ){
            return response()->json([
                'success' => false,
                'message' => 'Incorrect username or password!'
            ]);
        }

        $token = $Customer->createToken('fameCustomer')->plainTextToken;

        return response()->json([
            'success' => true,
            'customer' => $Customer,
            'token' => $token
        ]);

    }

    /**
     * customer log out
     */
    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
			'success' => true,
            'message' => 'Successfully logged out!'
        ]);
    }

}
