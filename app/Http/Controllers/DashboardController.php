<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;


use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $user = Auth::user();
        $websites = $user->websites()->with('latestScan')->get();

        $totalIssues = 0;
        $criticalIssues = 0;
        $resolvedIssues = 0;

        foreach ($websites as $website) {
            if ($website->latestScan) {
                $totalIssues += $website->latestScan->total_issues;
                $criticalIssues += $website->latestScan->critical_issues;
                $resolvedIssues += $website->latestScan->issues()
                    ->where('status', 'resolved')
                    ->count();
            }
        }

        return view('dashboard', compact('user', 'websites', 'totalIssues', 'criticalIssues', 'resolvedIssues'));
    }
}
