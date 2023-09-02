<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class UserRegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create($request->getData());
        $token = $user->createToken('user_token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'token' => $token,
            'message' => 'User registered successfully!',
        ]);
    }
}
