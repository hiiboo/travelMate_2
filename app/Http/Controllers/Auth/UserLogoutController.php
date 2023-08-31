<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserLogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $organizer = $request->user('web');
        $organizer->tokens()->delete();

        auth()->guard('web')->logout();

        return response()->json([
            'message' => 'Logged out',
        ]);
    }
}
