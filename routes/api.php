<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Route::post('/sanctum/token', [LoginController::class,'login' ]);
Route::post('/login', [LoginController::class,'login' ]);
Route::post('/registration', function(Request $request){
    $user = User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>bcrypt(request('password')),

    ]);
    $user->save();
    $token= $user->createToken($request->device_name)->plainTextToken;
    return $token;

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
