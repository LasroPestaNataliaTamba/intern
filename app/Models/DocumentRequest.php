<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'purpose',
        'needed_date',
        'attachment',
        'status',
        'processed_file'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
