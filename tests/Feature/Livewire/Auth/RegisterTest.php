<?php
use App\Livewire\Auth\Register;
use Livewire\Livewire;

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseHas};

// teste para confirmar que o component está renderizando
it('should render the component', function () {
    Livewire::test(Register::class)
        ->assertOk();
});

// permitir que seja registrado um novo usuário no sistema
it('should be able to register a new user in the system', function () {
    Livewire::test(Register::class)
        ->set('name', 'Joe Doe')
        ->set('email', 'joe@doe.com')
        ->set('email_confirmation', 'joe@doe.com')
        ->set('password', 'password')
        ->call('submit')
        ->assertHasNoErrors();

    assertDatabaseHas('users', [
        'name'  => 'Joe Doe',
        'email' => 'joe@doe.com',
    ]);

    assertDatabaseCount('users', 1);
});
