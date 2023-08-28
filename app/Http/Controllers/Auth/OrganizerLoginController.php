<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class OrganizerLoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $organizer = Organizer::where('email', $request->email)->first();

        if
        (!auth()->guard('organizer')->attempt($request->only(['email', 'password']))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
    }
}
