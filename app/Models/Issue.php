<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'scan_id',
        'severity',
        'page_url',
        'issue_type',
        'wcag_level',
        'wcag_rule',
        'description',
        'element_selector',
        'element_html',
        'fix_sugesstion',
        'code_before',
        'code_after',
        'status',
    ];

    // Relationship

    public function scan()
    {
        return $this->belongsTo(Scan::class);
    }
}
