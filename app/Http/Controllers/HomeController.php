<?php

namespace App\Http\Controllers;

use App\Models\MoneyConverter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\MoneyConverterRequest;

class HomeController extends Controller
{
    CONST BASE_URL = 'https://economia.awesomeapi.com.br/json/last/';
    CONST CONVERSION_VALUE_TAX = 0.01;
    CONST CONVERSION_VALUE_TAX_UNDER_THREE = 0.02;
    CONST PAYMENT_AMOUNT_TAX_BANK_SLIP = 0.0145;
    CONST PAYMENT_AMOUNT_TAX_CC = 0.0763;

    protected $model;

    public function __construct(MoneyConverter $model)
    {
        $this->middleware('auth');
        $this->model = $model;
    }

    public function index()
    {
        return view('home');
    }

    public function submit(MoneyConverterRequest $request)
    {
        $url = self::BASE_URL.$request->currency.'-BRL';
        $response = Http::get($url);

        $responseBody = $response->body();
        $responseData = json_decode($responseBody, true);

        if ($request->currency) {
            $key = $request->currency.'BRL';

            $data['target_currency'] = $request->currency;
            $data['target_currency_value'] = $responseData[$key]['bid'];
            $data['value_to_be_converted'] = $request->value_to_conversion;
            $data['payment_method'] = $request->payment;
            $data['user_id'] = Auth::id();

            $conversionTax = (intval($data['value_to_be_converted']) < 3000) ? self::CONVERSION_VALUE_TAX_UNDER_THREE : self::CONVERSION_VALUE_TAX;
            $paymentValueTax = ($data['payment_method'] == 'credit_card') ? self::PAYMENT_AMOUNT_TAX_CC : self::PAYMENT_AMOUNT_TAX_BANK_SLIP;

            $data['payment_tax'] = intval($data['value_to_be_converted']) * $paymentValueTax;
            $data['conversion_tax'] = intval($data['value_to_be_converted']) * $conversionTax;

            $data['total_amount_with_taxes'] = intval($data['value_to_be_converted']) - $data['conversion_tax'] - $data['payment_tax'];
            $data['target_currency_purchased_value'] = $data['total_amount_with_taxes'] / $data['target_currency_value'];

            $data['target_currency_purchased_value'] = number_format($data['target_currency_purchased_value'], 2, '.', '');

            $this->model->create($data);

            return response()->json($data, 200);
        }
    }
}
