<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrganizerLogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $organizer = $request->user('organizer');
        $organizer->tokens()->delete();

        auth()->guard('organizer')->logout();

        return response()->json([
            'message' => 'Logged out',
        ]);
    }
}
