<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MoneyConvertMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->replyTo($this->data->user['email'], $this->data->user['name'])
            ->to($this->data->user['email'], $this->data->user['name'])
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Conversão de Moedas')
            ->markdown('email.money-convert', [
                'target_currency' => $this->data['target_currency'],
                'value_to_be_converted' => $this->data['value_to_be_converted'],
                'payment_method' => $this->data['payment_method'],
                'payment_tax' => $this->data['payment_tax'],
                'conversion_tax' => $this->data['conversion_tax'],
                'target_currency_purchased_value' => $this->data['target_currency_purchased_value'],
            ]);
    }
}
