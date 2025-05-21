<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_initialization()
    {
        // Create a test user
        $user = User::factory()->create([
            'phone' => '255693662424',
            'jumuiya_id' => 1 // Add if required by your system
        ]);

        // Mock the HTTP response
        Http::fake([
            'palmpesa.drmlelwa.co.tz/api/pay-via-mobile' => Http::response([
                'success' => true,
                'message' => 'Payment initiated'
            ], 200)
        ]);

        // Authenticate the user and make the request
        $response = $this->actingAs($user)
            ->postJson('/make-payment', [
                "amount" => 500,
                "phone" => $user->phone,
                "transaction_id" => "TXN" . time(),
                "user_id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "address" => "Mbeya",
                "postcode" => "53127",
                "buyer_uuid" => 988776
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message'
            ]);
    }
}