<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Client;

class ClientCreateTest extends TestCase
{
    use RefreshDatabase;


    
    public function testClientNewAccount()
    {
        $response = $this->json('POST', 'api/client/create', [
            'email' => 'Stephen',
            'name' => 'Stephen',
            'address' => 'Pasay City',
        ]);
        $response->assertStatus(422);
        
        $response = $this->json('POST', 'api/client/create', [
            'email' => 'stephen@gmail.com',
            'name' => 'Stephen',
            'address' => 'Pasay City',
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('clients', [
            'email' => 'stephen@gmail.com',
            'name' => 'Stephen',
            'address' => 'Pasay City',
        ]);
        
    }
    
    public function testViewClient() {
        $client = Client::firstOrCreate([
            'email' => 'stephen@gmail.com',
            'name' => 'Stephen',
            'address' => 'Pasay City',
        ]);
        
        $response = $this->json('GET', 'api/client/'.$client->id);
        $response->assertSee('stephen@gmail.com');
    }
    
    public function testUpdateClient() {
        
        $client = Client::firstOrCreate([
            'email' => 'stephen@gmail.com',
            'name' => 'Stephen',
            'address' => 'Pasay City',
        ]);
        
        $response = $this->json('PUT', 'api/client/'.$client->id, [
            'email' => 'stephen@gmail.com',
            'name' => 'Stephen1',
            'address' => 'Pasay City',
            'updatedby' => $client->id,
        ]);
        $response->assertSee('Stephen1');
    }

    public function testDestoryClient() {
        $client = Client::firstOrCreate([
            'email' => 'stephen@gmail.com',
            'name' => 'Stephen',
            'address' => 'Pasay City',
        ]);
        
        $response = $this->json('DELETE', 'api/client/'.$client->id);
        $response->assertSee('stephen@gmail.com');
    }
    
    
   
}
