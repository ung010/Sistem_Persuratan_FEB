<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_view_halaman_login(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Login');
    }

    public function test_sukses_login(): void
    {
        $dataLogin = [
            'email' => 'mahasiswa@gmail.com',
            'password' => 'mountain082'
        ];

        $response = $this->post('/', $dataLogin);
        $response->assertStatus(302);
        $response->assertRedirect('/user');
    }

    public function test_gagal_login_karna_email_dan_password_salah(): void
    {
        $dataLogin = [
            'email' => '123@gmail.com',
            'password' => 'icikiwir'
        ];

        $response = $this->post('/', $dataLogin);

        $response->assertStatus(302);
        $response->assertRedirect('/');

        $response->assertSessionHas('errors');
    }
}
