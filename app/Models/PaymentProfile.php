<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\User;

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

    public function user(){
        return $this->belongsTo(User::class);
    }
}
