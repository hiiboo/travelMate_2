<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Organizer;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;


class OrganizerLoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $organizer = Organizer::where('email', $request->email)->first();
        // use sanctum and fault web guard
        // if ($organaizer || !Hash::check($request->password, $organizer->password)) {
        if
        (!auth()->guard('organizer')->attempt($request->only(['email', 'password']))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $organizer = Auth::guard('organizer')->user();

        $token = $organizer->createToken('organizer_token')->plainTextToken;
        return response()->json([
            'data' => $organizer,
            'token' => $token,
            'message' => 'Login successful'
        ]);
        // return response()->json([
        //     'data' => $organizer,
        //     'message' => 'Login successful'
        // ])->withCookie(cookie('token', $token, 60, null, null, false, true)); // httpOnlyをtrueに設定
    }
}
