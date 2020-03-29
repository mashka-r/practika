<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use App\Models\User;

class LogController extends Controller
{
    public function login(Request $request) 
    {
        if (!$user = User::where('email', $request->input('email'))->first()) {
            return response()->json(['message' => 'Пользователь не найден!','status' => 404]);
        } 
        
        if (!Hash::check(request('password'), $user->password)) {
            return response()->json(['message' => 'Неверный пароль!','status' => 403]);
        }
        
        $token = $user->createToken('mytoken');
        $response = [
            'succes'     => 'true',
            'message'    => 'Вы успешно прошли аутентификацию!',
            'token_type' => 'Bearer',
            'token'      => $token->accessToken
        ];

        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token->revoke();
    }
}
