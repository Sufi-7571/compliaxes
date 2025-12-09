<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'website',
        'message',
        'is_agency',
        'consent',
        'status',
    ];

    protected $casts = [
        'is_agency' => 'boolean',
        'consent' => 'boolean',
    ];
}
