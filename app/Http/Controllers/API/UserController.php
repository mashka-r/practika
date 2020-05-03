<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use  App\Http\Resources\UserResource;
use App\Http\Requests\ForUpdateRequest;
use App\Http\Requests\UserRequest;
use Hash;

class UserController extends Controller
{

    public function index($id = null)
    {
        $this->authorize('index', User::class); 

        if ($id){
            $users = User::where('id', $id)->get();
        } else {
            $users = User::get();
        }
        return UserResource::collection($users);
    }

    public function create(UserRequest $request)
    {
        $this->authorize('create', User::class); 

        $user = User::create([
            'name'     => request('name'),
            'email'    => request('email'),
            'password' => Hash::make(request('password'))
        ]);

        $user->roles()->attach(Role::where('name', 'Registered')->get());

        $response = [
            'success' => true,
            'message' => 'Регистрация пользователя '.$user->name.' прошла успешно!',
        ];
        
        return response()->json($response, 200);
    }

    public function update(ForUpdateRequest $request, $id)
    {
        if ($request->name) {
            User::where('id', $id)
                ->update(['name' => request('name')]);
        }

        if ($request->email) {
            User::where('id', $id)
                ->update(['email' => request('email')]);
        }

        if ($request->password) {
            User::where('id', $id)
                ->update(['password' => Hash::make(request('password'))]);
        }
    }
 
    public function delete($id) 
    {
        $this->authorize('delete', User::class); 

        $user = User::find($id);
        $user->roles()->detach();
        $user->delete();

        $response = [
            'success' => true,
            'message' => 'Пользователь удален!',
        ];
        
        return response()->json($response, 200);
    }
}
