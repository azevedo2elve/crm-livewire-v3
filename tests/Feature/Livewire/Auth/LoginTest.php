<?php

use App\Livewire\Auth\Login;
use App\Models\User;
use Livewire\Livewire;

it('should render the component', function () {
    Livewire::test(Login::class)
        ->assertOk();
});

it('should be able to login with correct credentials', function () {
    $user = User::factory()->create([
        'email'    => 'joe@doe.com',
        'password' => 'password',
    ]);

    Livewire::test(Login::class)
        ->set('email', 'joe@doe.com')
        ->set('password', 'password')
        ->call('login')
        ->assertHasNoErrors()
        ->assertRedirect('dashboard');

    expect(auth()->check())->toBeTrue()
        ->and(auth()->user())->id->toBe($user->id);
});

it('should not be able to login with wrong credentials', function () {
    User::factory()->create([
        'email'    => 'joe@doe.com',
        'password' => 'password',
    ]);

    Livewire::test(Login::class)
        ->set('email', 'joe@doe.com')
        ->set('password', 'wrong-password')
        ->call('login')
        ->assertHasErrors();

    expect(auth()->check())->toBeFalse();
});
