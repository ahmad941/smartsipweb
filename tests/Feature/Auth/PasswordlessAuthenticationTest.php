<?php

use App\Models\User;

test('passwordless login screen can be rendered', function () {
    $response = $this->get('/siswa/login');

    $response->assertStatus(200);
});

test('new student can register using only email and is redirected to setup', function () {
    $response = $this->post('/siswa/login', [
        'email' => 'siswabaru@smartsip.id',
    ]);

    $this->assertAuthenticated();
    $user = User::where('email', 'siswabaru@smartsip.id')->first();
    expect($user)->not->toBeNull();
    expect($user->role)->toBe('siswa');

    $response->assertRedirect(route('student.profile.setup'));
});

test('existing student can login using only email and is remembered', function () {
    $user = User::factory()->create([
        'email' => 'siswalama@smartsip.id',
        'role' => 'siswa',
    ]);

    $response = $this->post('/siswa/login', [
        'email' => 'siswalama@smartsip.id',
    ]);

    $this->assertAuthenticatedAs($user);
});
