<?php

namespace App\Http\Controllers\Auth;

use Filament\Facades\Filament;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;

class LogoutController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        Auth::guard('members')->logout();

        // session()->invalidate();
        // session()->regenerateToken();

        return redirect()->back();

    }
}


