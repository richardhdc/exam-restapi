<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\Client;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ClientDataResource;
use App\Http\Requests\ClientUpdateRequest;

class ClientController extends Controller
{
    public function store(ClientRequest $request) {
        $client = Client::create($request->all());
        return new ClientResource($client);
    }
    
    public function view($id) {
        $client = Client::find($id);
        return new ClientDataResource($client);
    }
    
    public function update(ClientUpdateRequest $request, $id) {
        $client = Client::find($id);
        if ($client->count() && $client->id == $request->updatedby) {
            $client->update($request->except(['updatedby']));
            return new ClientDataResource($client);
        }
    }
    
    public function destroy($id) {
        $client = Client::findOrfail($id);
        if($client->delete()) {
            return new ClientDataResource($client);
        } 
    }
    
    
}
