<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @property array $prices
 */
class PricesUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'prices' => 'required|array',
            'prices.*.guid' => 'required|uuid',
            'prices.*.price' => 'required|numeric|between:1,500000'
        ];
    }
}
