<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index()
    {
    	return User::all();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function store(Request $request)
    {
        return $request;

        $user = user::create($request->all());

        return response()->json($user, 201);
    }

    public function update(Request $request, User $user)
    {
		return $request;

        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function delete(User $user)
    {
        return $user;

        $user->delete();

        return response()->json(null, 204);
    }
}
