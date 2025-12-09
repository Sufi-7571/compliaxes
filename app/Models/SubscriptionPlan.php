<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'max_website',
        'scans_per_week',
        'fix_suggestions',
        'pdf_export',
        'api_access',
        'issue_history',
        'priority_scanning',
        'max_pages_per_scan',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'fix_suggestions' => 'boolean',
        'pdf_export' => 'boolean',
        'api_access' => 'boolean',
        'issue_history' => 'boolean',
        'priority_scanning' => 'boolean',
    ];

    // Relationships
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
