<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use  App\Http\Resources\UserResource;
use App\Http\Requests\ForUpdateRequest;
use App\Http\Requests\ForStoreRequest;
use Hash;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('before', User::class); 
        $users = User::get();
        return UserResource::collection($users);
    }

    public function store(ForStoreRequest $request)
    {
        $this->authorize('before', User::class); 

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
        
        return response()->json($response);
    }

    public function show($id)
    {
        $this->authorize('before', User::class);
        $users = User::where('id', $id)->get();
        return UserResource::collection($users);
    }

    public function update(ForUpdateRequest $request, $id)
    {
        $this->authorize('before', User::class);
        $user = User::where('id', $id);
        $user->update($request->all());
 
        $response = [
            'success' => true,
            'message' => 'Данные обновлены',
        ];
        
        return response()->json($response);
    }

    public function destroy($id)
    {
        $this->authorize('before', User::class); 

        $user = User::find($id);
        $user->roles()->detach();
        $user->delete();

        $response = [
            'success' => true,
            'message' => 'Пользователь удален',
        ];
        
        return response()->json($response);
    }
}
