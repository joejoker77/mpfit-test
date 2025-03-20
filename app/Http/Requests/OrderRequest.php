<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function rules():array
    {
        return [
            'customerName'    => 'required|string|max:140',
            'customerNote'    => 'required|string|max:500',
            'productId'       => 'required|numeric',
            'productQuantity' => 'required|numeric|min:1',
        ];
    }
}
