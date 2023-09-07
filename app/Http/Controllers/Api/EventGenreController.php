<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Resources\EventResource;
use App\Http\Requests\UpdateEventGenresRequest;

class EventGenreController extends Controller
{
    // get all genres for the event
    public function index(Event $event)
    {
        return response()->json(
            [
                'data' => $event->genres,
                'message' => 'Event genres retrieved successfully',
            ],
            200
        );
    }
    
    
    public function update(UpdateEventGenresRequest $request, Event $event)
    {
        $event->genres()->sync($request->genres);
        return response()->json(
            [
                'data' => new EventResource($event),
                'message' => 'Event genres updated successfully',
            ],
            200
        );
    }
}
