@component('mail::message')

## Valor de Compra: R${{ number_format($value_to_be_converted, 2, ',', '.') }}
## Método de Pagamento: {{ $payment_method == 'bank_slip' ? 'Boleto' : 'Cartão de Crédito' }}
## Taxa de Pagamento: R${{ number_format($payment_tax, 2, ',', '.') }}
## Taxa de Conversão: R${{ number_format($conversion_tax, 2, ',', '.') }}
## Moeda a ser comprada: {{ $target_currency }}
## Valor da Conversão: {{ $target_currency == 'USD' ? '$' : '€' }}{{ number_format($target_currency_purchased_value, 2, ',', '.') }}

@endcomponent
