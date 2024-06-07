<?php

namespace App\Livewire\Auth;

use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Livewire\Component;

class Register extends Component
{
    /** @var string */
    public $nama_lengkap = '';

    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var string */
    public $passwordConfirmation = '';

    /** @var string */
    public $jenis_identitas = '';

    /** @var integer */
    public $no_identitas = '';

    /** @var string */
    public $telp = '';

    /** @var string */
    public $alamat = '';

    public function register()
    {
        $data = $this->validate([
            'nama_lengkap' => ['required'],
            'email' => ['required', 'email', 'unique:customers'],
            'password' => ['required', 'min:8', 'same:passwordConfirmation'],
            'no_identitas' => ['required','min:12', 'unique:customers'],
            'alamat' => ['required'],
            'telp' => ['required', 'numeric']
        ]);


        $user = Customer::create([
            'nama_lengkap' => $this->nama_lengkap,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'jenis_identitas' => $this->jenis_identitas,
            'no_identitas' => $this->no_identitas,
            'telp' => $this->telp,
            'alamat' => $this->alamat,
            'avatar' => 'customer_avatar/avatardefault.png',
            'status' => 'active',
        ]);

        event(new Registered($user));

        Auth::guard('members')->login($user, true);

        session()->regenerate();

        return redirect()->to('members');
    }

    public function render()
    {
        return view('livewire.auth.register')->extends('layouts.auth');
    }
}
