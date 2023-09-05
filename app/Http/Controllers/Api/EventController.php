<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\Organizer;
use App\Http\Requests\EventRequest;
use App\Jobs\EventTranslationJob;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:organizer-api'])->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Organizer $organizer = null)
    {
        if ($organizer) {
            $events = $organizer->events;
        } else {
            $events = Event::all();
        }

        return EventResource::collection($events);
    }


    /**
     * Store a newly created resource in storage.
     */
public function store(Organizer $organizer, EventRequest $request)
    {
        $this->authorize('create', Event::class);

        $event = $organizer->events()->create($request->validated());

        EventTranslationJob::dispatch($event); 

        return response()->json([
            'data' => new EventResource($event),
            'message' => 'Event created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Organizer $organizer = null, Event $event)
    {
        return new EventResource($event);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(EventRequest $request, Organizer $organizer, Event $event)
    {
        $this->authorize('update', $event);

        $event->update($request->validated());

        EventTranslationJob::dispatch($event);

        return response()->json([
            'data' => new EventResource($event),
            'message' => 'Event updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organizer $organizer, Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return response()->json([
            'message' => 'Event deleted successfully',
        ]);
    }
}
