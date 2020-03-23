<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->only('email', 'password');

        if (!Auth::attempt($data)) {
            $response = [
                'success' => false,
                'message' => "Очепятка! Пользователь не найден",
            ];
            return response()->json($response, 404);
        }
        else {
            $user= Auth::user();
            $token = $user->createToken('mytoken');
            //$token->token->expires_at = $request->remember_me ?
            //    Carbon::now()->addMonth() :
            //    Carbon::now()->addDay();

            $token->token->save();

            $response = [
                'success' => true,
                'message' => "Вы успешно прошли аутентификацию",
                'token_type' => 'Bearer',
                'token' => $token ->accessToken,
            ];
            return response()->json($response, 200);
        }
    }
    public function logout()
    {
        $accessToken = auth()->user()->token()->revoke();
        return response()->json(['status' => 200]);
    }
}