<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class QuoteRequest extends Request
{
    /**
     * Hash to append to the redirect url.
     *
     * @var string
     */
    protected $redirectHash = '#create-quote';

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
            'description' => 'required|string',
            'stones_description' => 'required|string',
            'metals_description' => 'required|string',
            'setting_details' => 'required|string',
            'size_details' => 'required|string',
            'other_details' => 'required|string',
            'price' => 'required|numeric',
            'shipping' => 'required|numeric',
            'tax_id' => 'required|integer',
            'jewelry_type_id' => 'required|integer',
        ];
    }
}
