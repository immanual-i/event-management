<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AttendeeController extends Controller
{
    use CanLoadRelationships, AuthorizesRequests;

    private array $relations = ['user'];

    public function index(Event $event)
    {
        $this->authorize('viewAny', Event::class);

        $attendees = $this->loadRelationships($event->attendees()->latest());

        return AttendeeResource::collection($attendees->paginate());
    }

    public function store(Request $request, Event $event)
    {
        $attendee =  $this->loadRelationships(
            $event->attendees()->create([
                'user_id' => $request->user()->id,
            ])
        );

        return new AttendeeResource($this->loadRelationships($attendee));
    }

    public function show(Event $event, Attendee $attendee)
    {
        $relations = ['event'];

        return new AttendeeResource($this->loadRelationships($attendee, $relations));
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(Event $event, Attendee $attendee)
    {
        // if (Gate::allows('delete-attendee', [$event, $attendee])) {
        //     $attendee->delete();
        //     return response(status: 204,);
        // }
        if ($this->authorize('delete', $attendee)) {
            $attendee->delete();
            return response(status: 204,);
        }
        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
