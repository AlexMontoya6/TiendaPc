<?php

use App\Models\User;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\DeleteUserForm;
use Livewire\Livewire;
use Tests\Traits\CreatesUsers;

uses(CreatesUsers::class);

test('user accounts can be deleted', function () {
    $user = self::loginAsUser();

    Livewire::test(DeleteUserForm::class)
        ->set('password', '12345678')
        ->call('deleteUser');

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});


test('correct password must be provided before account can be deleted', function () {
    $this->actingAs($user = User::factory()->create());

    Livewire::test(DeleteUserForm::class)
        ->set('password', 'wrong-password')
        ->call('deleteUser')
        ->assertHasErrors(['password']);

    expect($user->fresh())->not->toBeNull();
})->skip(function () {
    return ! Features::hasAccountDeletionFeatures();
}, 'Account deletion is not enabled.');
