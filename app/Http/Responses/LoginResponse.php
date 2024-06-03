<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // return whatever you want as url
        if (!empty(auth()->user()->roles)) { // Misalkan ada field `is_admin` untuk memeriksa apakah user adalah admin
            return redirect()->intended('adminpanel');
        }

        return redirect()->route('home');
    }
}
