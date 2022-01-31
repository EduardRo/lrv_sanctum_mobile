<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function register_new_user()
    {
        $response = $this->post('/api/registration',[
            'name'=>'Mihai Boroc',
            'email'=>'mihai.boroc@yahoo.com',
            'password'=>'secret',
            'password_confirmation'=>'secret',
            'device_name'=>'SamsungPhone',
        ]);
        $response->assertSuccessful();
        $this->assertNotEmpty($response->getContent());
        //$this->assertDatabaseHas('users',['users',['email'=>'mihai.boroc@yahoo.com']]); 
        //$this->assertDatabaseHas('personal_access_tokens',['name'=>'SamsungPhone']);

    }
   
}
