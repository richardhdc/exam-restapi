<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PhoneAddRequest;
use App\Phone;
use App\Http\Resources\PhoneResource;
use App\Http\Requests\PhoneUpdateRequest;
use App\Http\Resources\PhoneDataResource;
use App\Http\Resources\PhoneListResource;

class PhoneController extends Controller
{
    public function store(PhoneAddRequest $request) {
        $phone = Phone::firstOrCreate($request->all());
        return new PhoneResource($phone);
    }
    
    public function update(PhoneUpdateRequest $request, $id) {
        $phone = Phone::find($id);
        if ($phone->count() && $phone->account_id == $request->updatedby) {
            $phone->update($request->except(['updatedby']));
            return new PhoneDataResource($phone);
        }
    }
    
    public function destroy($id) {
        $phone = Phone::findOrfail($id);
        if($phone->delete()) {
            return new PhoneDataResource($phone);
        }
    }
    
    
    public function view($id) {
        $phone = Phone::where('account_id', $id)->paginate(10);
        return $phone;
    }
}
