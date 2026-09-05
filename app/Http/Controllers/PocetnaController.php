<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Putovanje;
use App\Services\DashboardService;

class PocetnaController extends Controller
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
