<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\User;
//фасад
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            //'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return response()->json('Validation Error');
            //return ('lol');
        }
        else{
            $user = User::create([
                'name' => request('name'),
                'email' => request('email'),
                'password' => bcrypt(request('password'))
            ]);
            $response = [
                'success' => true,
                'data'    => $user->name,
                'message' => "Регистрация прошла успешно!",
            ];
            return response()->json($response, 200);
        }
    }
}
