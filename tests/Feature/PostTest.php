<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_example()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function test_users_can_post()
    {
        $log = $this->post('/login', [
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $log->assertRedirect(RouteServiceProvider::HOME);

        $response = $this->post('/post/add', [
            'message' => 'test',
            'user_id' => '1',
            'fire_type' => 'Residential',
            'image' => 'https://unsplash.it/640/425?image=30',
            'vehicle_id' => 1,
            'station_id' => 1,
            'address' => 'test',
        ]);
        $response->assertOk();
    }
}
