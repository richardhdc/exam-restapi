<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\Http\Requests\AccountRequest;
use App\Http\Resources\AccountResource;
use App\Http\Resources\AccountDataResource;
use App\Http\Requests\AccountUpdateRequest;

class AccountController extends Controller
{
    
    public function store(AccountRequest $request) {
        $data = [];
        $admin = Account::find($request->creator);
        
        if ($request->isAdmin) {
            if ($admin->isAdmin) {
                $data['email'] = $request->email;
                $data['fullname'] = $request->fullname;
                $data['isAdmin'] = $request->isAdmin; 
            }
        } else {
            if ($admin->isAuthorized || $admin->isAdmin) {
                $data['email'] = $request->email;
                $data['fullname'] = $request->fullname;
            }
        }
        if ($data) {
            $account = Account::create($data);
            return new AccountResource($account);
        }
        return [];
    }
    
    public function view($id) {
        $client = Account::find($id);
        return new AccountDataResource($client);
    }
    
    public function update(AccountUpdateRequest $request, $id) {
        $account = Account::find($id);
        if ($account && $account->id == $request->updatedby) {
            $account->update($request->except(['updatedby']));
            return new AccountDataResource($account);
        }
    }
    
    public function destroy($id) {
        $client = Account::findOrfail($id);
        if($client->delete()) {
            return new AccountDataResource($client);
        }
    }
}
