<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request, $id = null)
    {
        $this->authorize('show', User::class); 

        if (!$request->route('id')) {
            $users = User::all();
        } else {
            $users = User::where('id', $id)->get();
        }

        return response()->json($users);
    }
}
