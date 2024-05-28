<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    // use RefreshDatabase;

    private $api_base = 'api';
    private $api_version = 'v1';
    public $api_url;
    
    public function setup() : void 
    {
        parent::setUp();
        $this->api_url = $this->api_base .'/'. $this->api_version;
    }

    protected function tearDown(): void
    {
        // Any cleanup can be done here
        parent::tearDown();
    }

    /**
     * A basic test example.
     */
    public function test_signup(): void
    {
        
        $user_email = fake()->email();

        $response = $this->postJson( "{$this->api_url}/signup", [
            'customers_firstname' => fake()->firstName,
            'customers_lastname' => fake()->lastName,
            'customers_email_address' => $user_email,
            'customers_password' => 'password',
            'customers_password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'customer' => [
                         'id',
                         'customers_firstname',
                         'customers_lastname',
                         'customers_email_address',
                         'created_at',
                         'updated_at',
                     ],
                     'token'
                 ]);

        $this->assertDatabaseHas('customers', [
            'customers_email_address' => $user_email
        ]);

        $customer = Customer::where('customers_email_address', $user_email )->first();
        $this->assertTrue(Hash::check( 'password', $customer->customers_password));

        // Cleanup: delete the specific customer created during this test
        Sanctum::actingAs($customer); // Log in as the created customer to access tokens
        $customer->tokens()->delete(); // Delete the tokens
        $customer->delete();

        // Assert the customer has been deleted
        $this->assertDatabaseMissing('customers', [
            'customers_email_address' => $user_email
        ]);

    }

    public function test_login() : void 
    {

        $user_email = fake()->email();

        //create a customer manually
        $customer = Customer::create([
            'customers_firstname' => fake()->firstName,
            'customers_lastname' => fake()->lastName,
            'customers_email_address' => $user_email,
            'customers_password' => Hash::make('password'),
        ]);

        // Attempt to log in with correct credentials
        $response = $this->postJson( "{$this->api_url}/login", [
            'customers_email_address' => $user_email,
            'customers_password' => 'password',
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'customer' => [
                        'id',
                        'customers_firstname',
                        'customers_lastname',
                        'customers_email_address',
                        'created_at',
                        'updated_at',
                    ],
                    'token'
                ]);

        //remove test data
        Sanctum::actingAs($customer); // Log in as the created customer to access tokens
        $customer->tokens()->delete(); // Delete the tokens
        $customer->delete();

        //check test data removed successfully
        $this->assertDatabaseMissing( 'customers', [
            'customers_email_address' => $user_email
        ]);

    }

}
