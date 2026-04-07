<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repurchase extends Model
{
    protected $fillable = [
        'user_id',
        'item_name',
        'qty',
        'price',
        'total',
        'supplier',
        'proof_pdf',
        'bank_account',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 
