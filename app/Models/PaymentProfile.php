<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_name',
        'client_names',
        'address_one',
        'address_two',
        'acc_id',
        'user_id'
    ];
}
