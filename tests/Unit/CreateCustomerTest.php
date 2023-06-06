<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCustomerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_customer()
    {
        
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'contact_information' => json_encode([
                'phone' => '1234567890',
                'address' => '123 Street, City',
            ]),
        ];

        $response = $this->postJson('/api/customers', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'contact_information',
                'created_at',
            ]);

        $this->assertDatabaseHas('customers', [
            'name' => $data['name'],
            'email' => $data['email'],
            'contact_information' => $data['contact_information'],
        ]);
    }
}
