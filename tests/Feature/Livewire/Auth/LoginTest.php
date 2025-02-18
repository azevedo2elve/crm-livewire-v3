<?php

use App\Livewire\Auth\Login;
use App\Models\User;
use Livewire\Livewire;

it('should render the component', function () {
    Livewire::test(Login::class)
        ->assertOk();
});

it('should be able to login', function () {
    $user = User::factory()->create([
        'email'    => 'joe@doe.com',
        'password' => 'password', // não precisa passar o bcrypt porque o model já tem um $cast de hashed no password, por baixo dos panos ele vai fazer o hash e cuidar do que precisa
    ]);

    $livewire = Livewire::test(Login::class)
        ->set('email', 'joe@doe.com')
        ->set('password', 'password')
        ->call('tryToLogin')
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard'));

    expect(auth()->check())->toBeTrue()
        ->and(auth()->user())->id->toBe($user->id);
});

it('should make sure to inform the user an error when email and password doesnt work', function () {
    $livewire = Livewire::test(Login::class)
        ->set('email', 'joe@doe.com')
        ->set('password', 'password')
        ->call('tryToLogin')
        ->assertHasErrors(['invalidCredentials'])
        ->assertSee(trans('auth.failed')); // laravel tem uma mensagem no auth que se chama auth.failed (php artisan lang:publish)
    // assertSee é para ver o erro no componente/na tela
});

// it('should not be able to login with wrong credentials', function () {
//     User::factory()->create([
//         'email'    => 'joe@doe.com',
//         'password' => 'password', // não precisa passar o bcrypt porque o model já tem um $cast de hashed no password, por baixo dos panos ele vai fazer o hash e cuidar do que precisa
//     ]);

//     Livewire::test(Login::class)
//         ->set('email', 'joe@doe.com')
//         ->set('password', 'wrong-password')
//         ->call('login')
//         ->assertHasErrors();

//     expect(auth()->check())->toBeFalse();
// });
