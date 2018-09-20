<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Account;

class AccountCreateTest extends TestCase
{
    use RefreshDatabase;
    
    public function testAdminCreatingAccount()
    {
        $admin = Account::firstOrCreate([
            'email' => 'superman@gmail.com',
            'fullname' => 'Superman',
            'isAdmin' => 1,
            'isAuthorized' => 1,
        ]);
        
        $response = $this->json('POST', 'api/account/create', [
            'email' => 'stephen@gmail.com',
            'fullname' => 'Stephen',
            'isAdmin' => 1,
            'creator' => $admin->id,
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('accounts', [
            'email' => 'stephen@gmail.com',
            'fullname' => 'Stephen',
            'isAdmin' => 1,
        ]);
    }
    
    public function testAuthorizedCreatingAccount() {
        $admin = Account::firstOrCreate([
            'email' => 'batman@gmail.com',
            'fullname' => 'Batman',
            'isAuthorized' => 1,
        ]);
        
        $this->json('POST', 'api/account/create', [
            'email' => 'stan@gmail.com',
            'fullname' => 'Stan',
            'isAdmin' => 1,
            'creator' => $admin->id,
        ]);
        $this->assertDatabaseMissing('accounts', [
            'fullname' => 'Stan',
        ]);
        
        $this->json('POST', 'api/account/create', [
            'email' => 'steve@gmail.com',
            'fullname' => 'Steve',
            'creator' => $admin->id,
        ]);

        $this->assertDatabaseHas('accounts', [
            'fullname' => 'Steve',
        ]);
    }
    
    public function testViewAccount() {
        $account = Account::firstOrCreate([
            'email' => 'stephen@gmail.com',
            'fullname' => 'Stephen',
        ]);
        
        $response = $this->json('GET', 'api/account/'.$account->id);
        $response->assertSee('stephen@gmail.com');
    }
    
    public function testUpdateAccount() {
        
        $account = Account::firstOrCreate([
            'email' => 'stephen@gmail.com',
            'fullname' => 'Stephen',
        ]);
        
        $response = $this->json('PUT', 'api/account/'.$account->id, [
            'email' => 'stephen@gmail.com',
            'fullname' => 'Stephen1',
            'updatedby' => $account->id,
        ]);
        $response->assertSee('Stephen1');
    }
    
    public function testDestoryClient() {
        $account = Account::firstOrCreate([
            'email' => 'stephen@gmail.com',
            'fullname' => 'Stephen',
        ]);
        
        $response = $this->json('DELETE', 'api/account/'.$account->id);
        $response->assertSee('stephen@gmail.com');
    }
    
}
