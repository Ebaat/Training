<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

 protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'date_of_birth',
        'bio',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    
}