<?php

namespace App\Http\Controllers;

use App\Models\Putovanje;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct(private DashboardService $dashboard) {}

    public function index()
    {
        if (Auth::check()) {
            return view('dashboard', $this->dashboard->getStatistike());
        }

        $putovanja = Putovanje::with('termini', 'tipPrevoza', 'slike')->get();
        return view('pocetna.index', compact('putovanja'));
    }
}
