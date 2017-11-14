<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductForm extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'code' => 'required|max:255',
            'price' => 'max:255'
        ];
    }

    public function fields()
    {
        return $this->all('title', 'code', 'description', 'price', 'writeup');
    }
}
