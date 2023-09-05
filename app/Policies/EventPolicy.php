<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use App\Models\Organizer;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Event $event): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $user instanceof Organizer;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Event $event)
    {
        if ($user instanceof Organizer) {
            return $event->isCreatedBy($user)
                ? Response::allow()
                : Response::deny('You do not have right to update this event.');
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Event $event)
    {
        if ($user instanceof Organizer) {
            return $event->isCreatedBy($user)
                ? Response::allow()
                : Response::deny('You do not have right to delete this event.');
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, Event $event)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, Event $event)
    {
        //
    }
}
