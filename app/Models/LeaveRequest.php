<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        
        'user_id',
        'start_date',
        'end_date',
        'sisa_cuti',
        'reason',
        'division_status',
        'hr_status',
        'director_status',
        'final_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
