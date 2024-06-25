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

// campos obrigatórios / regras de validação
// nesse teste ele quer certificar que vai aparecer o erro caso o campo seja vázio, logo ao seta o campo com o valor vázio o test não vai passar
test('validation rules', function ($f) {
    Livewire::test(Register::class)
        ->set($f->field, $f->value) //vai setar no Register o campo do banco onde o valor tem que ser obrigatório
        ->call('submit')
        ->assertHasErrors([$f->field => $f->rule]); //certificar se tem erro com o $field sendo obrigatório
})->with([
    'name::required'     => (object)['field' => 'name', 'value' => '', 'rule' => 'required'], //criar um objeto onde vai ter o campo = name, valor = null e a regra = required, ou seja, obrigatório
    'name::max:255'      => (object)['field' => 'name', 'value' => str_repeat('*', 256), 'rule' => 'max'],
    'email::required'    => (object)['field' => 'email', 'value' => '', 'rule' => 'required'],
    'email::email'       => (object)['field' => 'email', 'value' => 'not-an-email', 'rule' => 'email'],
    'email::max:255'     => (object)['field' => 'email', 'value' => str_repeat('*' . '@doe.com', 256), 'rule' => 'max'],
    'email::confirmed'   => (object)['field' => 'email', 'value' => 'joe@doe.com', 'rule' => 'confirmed'],
    'password::required' => (object)['field' => 'password', 'value' => '', 'rule' => 'required'],
]); // com o with o teste vai rodar 3 vezes e cada vez o $field vai ser um valor 1º name, 2º email e 3º password
