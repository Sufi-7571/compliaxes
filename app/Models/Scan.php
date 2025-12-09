<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Issue;

class Scan extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'status',
        'total_pages',
        'total_issues',
        'critical_issues',
        'moderate_issues',
        'minor_issues',
        'accessibility_score',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
