<?php

namespace App\Http\Requests;

use App\Phone;
use Illuminate\Foundation\Http\FormRequest;

class PhoneAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account_id' => 'required|numeric',
            'phone' => 'required|regex:/[0-9]{11}/',
        ];
    }
    
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $phone = Phone::where('account_id', $this->input('account_id'))
                ->where('phone', $this->input('phone'))
                ->get();
            if ($phone->count()) {
                $validator->errors()->add('phone', 'This phone already exist!');
            }
        });
    }
}
