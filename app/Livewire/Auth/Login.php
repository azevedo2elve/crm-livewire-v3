<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Rule;
use Livewire\Component;

class Login extends Component
{
    #[Rule('required|email')]
    public ?string $email = null;

    #[Rule('required')]
    public ?string $password = null;

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('components.layouts.guest');
    }

    public function mount()
    {
        if(auth()->user()) {
            return redirect('/');
        }
    }

    public function login()
    {
        $credentials = $this->validate();

        if (auth()->attempt($credentials)) {
            request()->session()->regenerate();

            return redirect()->intended('/');
        }

        $this->addError('email', 'The provided credentials do not match our records.');
    }
}
