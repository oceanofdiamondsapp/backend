<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AccountRequest;
use App\Http\Requests\AccountUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use OOD\Users\User;

class AccountController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth.basic', ['except' => ['store']]);
    }

    /**
     * Update an account.
     * 
     * @param  AccountUpdateRequest $request
     * @param  integer               $id
     * @return Response
     */
    public function update(AccountUpdateRequest $request, $id)
    {
        // The user is updating their basic info
        if ($request->email) {
            Auth::user()->email = $request->email;
            Auth::user()->name = $request->name;
            Auth::user()->phone_number = $request->phone_number;
        }

        // The user is updating their password
        if ($request->password) {
            Auth::user()->password = Hash::make($request->password);
        }

        // Save the changes
        Auth::user()->save();

        // Return the response
        return $this->respond([
            'data' => Auth::user()
        ]);
    }

    /**
     * Store a new account created by the client app.
     * 
     * @return Response
     */
    public function store(Request $request)
    {
        if (User::where('email', $request->email)->first()) {
            return $this->respondBadRequest([
                'error' => 'An account with that email already exists'
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->roles()->attach(2);

        return $this->respond([
            'data' => $user
        ]);
    }
}
