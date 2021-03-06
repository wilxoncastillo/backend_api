<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendConfirmationEmail;

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
        $rules =[
            'name' => ['required', 'string', 'max:255'],
            'rut' =>  ['required', 'regex:/[0-9]{5,8}-[0-9,Kk]{1}/', 'unique:users'], 
            'phone' => ['required', 'regex:/[0-9]{9}/', 'unique:users'],  
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        $validator = \Validator::make($request->all(), $rules);
        
        try {
	        if ($validator->fails()) {
	            return [
	                'created' => false,
	                'errors'  => $validator->errors()->all()
	            ];
	        }

	        $user = user::create([
	        	'name' => $request->get('name'),
	            'rut' =>  $request->get('rut'), 
	            'phone' => $request->get('phone'),  
	            'email' => $request->get('email'),
	            'password' => bcrypt($request->get('password')),
	            'api_token' => Str::random(60),
	            'confirmation_code' => Str::random(60),
	        ]);

	        Mail::to($user)->queue(new SendConfirmationEmail($user));

	        return response()->json($user, 201);
		
		} catch (Exception $e) {
            \Log::info('Error creating user: '.$e);
            return \Response::json(['created' => false], 500);
        }
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


    public function verify($code)
	{
	    $user = User::where('confirmation_code', $code)->first();

	    if (! $user)
	        return redirect('/login');

	    $user->email_verified_at = now();
	    $user->confirmation_code = null;
	    $user->active = true;
        $user->save();

	    return redirect('/login')->with('notification', $user->name . ' has confirmado correctamente tu correo!');
	}
}