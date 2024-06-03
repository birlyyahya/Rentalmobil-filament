<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use App\Http\Responses\LoginResponse;
use Filament\Forms\Concerns\InteractsWithForms;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class Login extends Component
{
    use WithRateLimiting;

    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var bool */
    public $remember = false;

    protected $rules = [
        'email' => ['required', 'email'],
        'password' => ['required'],
    ];

    public function authenticate()
    {
        $this->validate();

        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->addError('email', __('filament::login.messages.throttled', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => ceil($exception->secondsUntilAvailable / 60),
            ]));

            return null;
        }


        if (!Auth::guard('members')->attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remember)) {
            $this->addError('email', __('filament::login.messages.failed'));

            return null;
        }
        return redirect()->to('/reservasi');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
