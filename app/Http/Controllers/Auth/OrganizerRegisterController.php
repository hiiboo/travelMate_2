<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Organizer;
use Illuminate\Http\Request;

class OrganizerRegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        $organizer = Organizer::create($request->getData());
        // $token = $organizer->createToken('organizer_token')->plainTextToken;

        return response()->json([
            'data' => $organizer,
            'message' => 'Registration successful',
            // 'token' => $token,
        ]);
}
}
