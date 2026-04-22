<?php

namespace App\Models;

use App\Models\User;

class Company extends Model
{
    protected $fillable = ['name', 'logo'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
