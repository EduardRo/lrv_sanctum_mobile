<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function login_existing_user()
    {
        $user = User::create([
            'name'=>'Mihai Boroc',
            'email'=>'mihai.boroc@yahoo.com',
            'password'=>bcrypt('secret'),
        ]);

        $response = $this->post('/api/login',[
            'email'=>$user->email,
            'password'=>'secret',
            'device_name'=>'SamsungPhone'
        ]);

        $response->assertSuccessful();
        $this->assertNotEmpty($response->getContent());
        $this->assertDatabaseHas('personal_access_tokens',[
            'name'=>'SamsungPhone',
            'tokenable_type'=>User::class,
            'tokenable_id'=>$user->id

        ]);
    }
    /** @test */
    public function get_user_from_token(){
        $user = User::create([
            'name'=>'Mihai Boroc',
            'email'=>'mihai.boroc@yahoo.com',
            'password'=>bcrypt('secret'),
        ]);

        $token = $user->createToken('SamsungPhone')->plainTextToken;
        $response = $this->get('/api/user',[
            'Authorization'=>'Bearer '.$token

        ]);
        $response->assertSuccessful();
        $response->assertJson(function($json){
            $json->where('email', 'mihai.boroc@yahoo.com')->missing('password')->etc();
        });

    }
}
