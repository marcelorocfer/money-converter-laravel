<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MoneyConverterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'payment' => 'required',
            'currency' => 'required',
            'value_to_conversion' => 'required|numeric|min:1001|max:99999',
        ];
    }

    public function messages()
    {
        return [
            'payment.required' => 'A forma de pagamento é obrigatória.',
            'currency.required' => 'A moeda de destino é obrigatória.',
            'value_to_conversion.required' => 'O valor para conversão é obrigatório.',
            'value_to_conversion.min' => 'O valor mínimo para conversão é de 1001 reais.',
            'value_to_conversion.max' => 'O valor máximo para conversão é de 99999 reais.',
        ];

    }
}
