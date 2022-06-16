<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MoneyConverter extends Model
{
    use HasFactory;

    protected $fillable = [
        'target_currency',
        'value_to_be_converted',
        'payment_method',
        'target_currency_value',
        'target_currency_purchased_value',
        'payment_tax',
        'conversion_tax',
        'total_amount_with_taxes',
        'user_id',
    ];

    /**
     * Get the user for the money converter.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
