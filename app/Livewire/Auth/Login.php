<?php

namespace App\Livewire\Auth;

use Auth;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Login extends Component
{
    // #[Rule('required|email')]
    public ?string $email;

    // #[Rule('required')]
    public ?string $password;

    public function render(): View
    {
        return view('livewire.auth.login');
    }

    public function tryToLogin(): void
    {
        // dentro do método attempt o próprio Laravel vai ligar a sessão e vai procurar o usuário que tenha email e password para poder verificar e por baixo dos panos fazer tudo
        // Auth/SessionGuard.php > attempt: - verificar se tem credenciais validas; e - no login ele vai ligar a sessão.
        // Como sabe qual model utilizar? Em config/auth.php, dentro tem a configuração, drive ultilizando, provider; providers users significa que está usando o driver eloquent e o model App\Models\User::class
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {

            $this->addError('invalidCredentials', trans('auth.failed'));

            return;
        }

        $this->redirect(route('dashboard'));
    }
}
