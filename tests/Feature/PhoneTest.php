<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Account;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Phone;

class PhoneTest extends TestCase
{
    use RefreshDatabase;
    
    public function testAddPhone()
    {
        $account = Account::firstOrCreate([
            'email' => 'batman@gmail.com',
            'fullname' => 'Batman',
            'isAuthorized' => 1,
        ]);
        
        $response = $this->json('POST', 'api/phone/create', [
            'account_id' => $account->id,
            'phone' => '01234567890',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('phones', [
            'account_id' => $account->id,
            'phone' => '01234567890',
        ]);
       
        $response = $this->json('POST', 'api/phone/create', [
            'account_id' => $account->id,
            'phone' => '01234567890',
        ]);
        
        $response->assertStatus(422);
    }
    
    
    public function testUpdatePhone() {
        
        $account = Account::firstOrCreate([
            'email' => 'stephen@gmail.com',
            'fullname' => 'Stephen',
        ]);
        
        $phone = Phone::firstOrCreate([
            'account_id' => $account->id,
            'phone' => '01234567890',
        ]);
        
        $response = $this->json('PUT', 'api/phone/'.$phone->id, [
            'account_id' => $account->id,
            'phone' => '01234567890',
            'updatedby' => $account->id,
        ]);
        $response->assertStatus(422);
        
        $response = $this->json('PUT', 'api/phone/'.$phone->id, [
            'account_id' => $account->id,
            'phone' => '11234567890',
            'updatedby' => $account->id,
        ]);
        $response->assertStatus(200);
        $response->assertSee('11234567890');
    }
    
    public function testDestoryPhone() {
        $account = Account::firstOrCreate([
            'email' => 'stephen@gmail.com',
            'fullname' => 'Stephen',
        ]);
        
        $phone = Phone::firstOrCreate([
            'account_id' => $account->id,
            'phone' => '01234567890',
        ]);
        
        $response = $this->json('DELETE', 'api/phone/'.$phone->id);
        $response->assertSee('01234567890');
    }
    
    public function testPaginationPhone() {
        
        factory(Phone::class, 100)->create();
        
        $response = $this->json('GET', 'api/phone/1');
        $response->assertSee('1?page=1');
        
        $response = $this->json('GET', 'api/phone/1?page=5');
        $response->assertSee('1?page=6');
    }
    
}
