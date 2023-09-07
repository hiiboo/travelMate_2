<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\Organizer;
use App\Http\Requests\EventRequest;
use App\Http\Requests\EventStatusRequest;
use App\Http\Requests\EventTitleRequest;
use App\Http\Requests\EventImagePathRequest;
use App\Http\Resources\EventStatusResource;
use App\Http\Resources\EventTitleResource;
use App\Http\Resources\EventImagePathResource;
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
    public function index()
    {
        // with translations, genres, reviews
        $events = Event::with(['translations', 'genres', 'reviews'])->get();

        return response()->json([
            'data' => EventResource::collection($events),
            'message' => 'Events retrieved successfully',
        ]
        );
    }


    /**
     * Store a newly created resource in storage.
     */
public function store(Organizer $organizer, EventRequest $request)
    {
        $this->authorize('create', Event::class);

        $organizer = auth('organizer-api')->user(); 

        $event = $organizer->events()->create($request->validated());

        // EventTranslationJob::dispatch($event); 

        return response()->json([
            'data' => new EventResource($event),
            'message' => 'Event created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return new EventResource($event);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(EventRequest $request, Event $event)
    {
        $this->authorize('update', $event);

        $event->update($request->validated());

        // EventTranslationJob::dispatch($event);

        return response()->json([
            'data' => new EventResource($event),
            'message' => 'Event updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return response()->json([
            'message' => 'Event deleted successfully',
        ]);
    }

    public function myEvents()
    {
        $this->authorize('myEvents', Event::class);

        $organizer = auth('organizer-api')->user();
        // getEvents method in organizer model
        $events = $organizer->getEvents();
        return EventResource::collection($events);
    }

    public function geteventStatus(Event $event)
    {
        $this->authorize('eventStatus', $event);

        return EventStatusResource::make($event);
    }

    // update event status where event is created by the organizer
    public function updateEventStatus(EventStatusRequest $request, Event $event)
    {
        $this->authorize('eventStatus', $event);

        $event->update($request->only('status'));
        return response(
            [
                'message' => 'Event status updated successfully',
                'data' => new EventStatusResource($event),
            ],
            200
        );
    }
    // get event title where event is created by the organizer
    public function getEventTitle(Event $event)
    {
        $this->authorize('eventTitle', $event);

        return response(
            [
                'message' => 'Event title fetched successfully',
                'data' => new EventTitleResource($event),
            ],
            200
        );
    }

    // update event title where event is created by the organizer
    public function updateEventTitle(EventTitleRequest $request, Event $event)
    {
        $this->authorize('eventTitle', $event);

        $event->update($request->only('title'));
        return response(
            [
                'message' => 'Event title updated successfully',
                'data' => new EventTitleResource($event),
            ],
            200
        );
    }

    // get event_image_path where event is created by the organizer
    public function getEventImagePath(Event $event)
    {
        $this->authorize('eventImagePath', $event);

        return response(
            [
                'message' => 'Event image path fetched successfully',
                'data' => new EventImagePathResource($event),
            ],
            200
        );
    }

    // update event_image_path where event is created by the organizer
    public function updateEventImagePath(EventImagePathRequest $request, Event $event)
    {
        $this->authorize('eventImagePath', $event);

        $event->update($request->only('event_image_path'));
        return response(
            [
                'message' => 'Event image path updated successfully',
                'data' => new EventImagePathResource($event),
            ],
            200
        );
    }

}
