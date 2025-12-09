<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactRequest;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'website' => 'nullable|url|max:255',
            'message' => 'nullable|string|max:1000',
            'is_agency' => 'boolean',
            'consent' => 'required|accepted'
        ]);

        ContactRequest::create($validated);

        return redirect()->back()->with('success', 'Thank you! We will contact you soon.');
    }
}
