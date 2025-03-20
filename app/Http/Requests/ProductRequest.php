<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class ProductRequest extends FormRequest
{
    public function authorize():bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name"        => "required|string|max:45",
            "description" => "required|string",
            "category_id" => "required|exists:App\Models\Shop\Category,id",
            "cost"        => "required|numeric",
        ];
    }

    protected function prepareForValidation()
    {
        $cost = $this->cost;
        if (Str::contains($cost, ',')) {
            $cost = Str::replace(',', '.', $cost);
        }
        $cost = round((float)$cost, 2);

        $this->merge([
            "cost" => $cost * 100,
        ]);
    }
}
