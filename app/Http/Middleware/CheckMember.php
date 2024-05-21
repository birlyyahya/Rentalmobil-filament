<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Pastikan pengguna login dengan guard 'members'
        if (Auth::guard('members')->check()) {
            return $next($request);
        }

        // Jika tidak login sebagai member, redirect ke halaman login member
        return redirect('/member/login');
    }
}
