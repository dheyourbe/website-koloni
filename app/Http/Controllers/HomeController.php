<?php

namespace App\Http\Controllers;

use App\Models\BilliardTable;
use App\Models\BilliardRental;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page.
     */
    public function index()
    {
        // Get count of available billiard tables
        $tableCount = BilliardTable::count();
        
        // Get user's recent rentals if authenticated
        $userRentals = null;
        if (auth()->check()) {
            $userRentals = BilliardRental::where('user_id', auth()->id())
                ->with('billiardTable')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }
        
        return view('home', compact('tableCount', 'userRentals'));
    }
    
    /**
     * Show user profile page.
     */
    public function profile()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $user = auth()->user();
        $rentals = BilliardRental::where('user_id', $user->id)
            ->with('billiardTable')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('profile', compact('user', 'rentals'));
    }
}
