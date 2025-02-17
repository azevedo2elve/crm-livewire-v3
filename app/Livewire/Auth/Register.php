<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Notifications\WelcomeNotification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component; //para adicionar anotação Rule para adicionar atributos dentro dessas regras

class Register extends Component
{
    // ?string indica que a propriedade pode ser null ou string

    #[Rule(['required', 'max:255'])]
    public ?string $name = null;

    #[Rule(['required', 'email', 'max:255', 'confirmed', 'unique:users,email'])]
    public ?string $email = null;

    public ?string $email_confirmation = null;

    #[Rule(['required'])]
    public ?string $password = null;

    public function render(): View
    {
        return view('livewire.auth.register')
            ->layout('components.layouts.guest');
    }

    public function submit(): void
    {
        $this->validate();

        $user = User::query()->create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => $this->password,
        ]);

        auth()->login($user);

        $user->notify(new WelcomeNotification()); //é uma instância, então precisa ser um novo (new)

        $this->redirect('/');
    }
}
