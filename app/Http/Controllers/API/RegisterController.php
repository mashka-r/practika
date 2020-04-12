<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Hash;
use App\Models\User;
use Validator;

class RegisterController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json('Validation Error');
            
        } else {
            $user = User::create([
                'name'     => request('name'),
                'email'    => request('email'),
                'password' => Hash::make(request('password'))
            ]);
            $user->roles()->attach(2);
            $response = [
                'success' => true,
                'message' => $user->name.', '.'регистрация прошла успешно!',
            ];
            
            return response()->json($response, 200);
        }
    }
}
