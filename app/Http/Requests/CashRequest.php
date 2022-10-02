<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CashRequest extends FormRequest
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
            'user' => 'required',
            'discount' => 'required|numeric',
            'amount' => 'required|numeric',
            'reference' => 'max:45',
            'payment_method' => 'required',
            'received_at' => 'required',
        ];
    }
}
