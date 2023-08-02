<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Reminder;
use App\Http\Resources\ReminderResource;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    // Get all reminders for a specific user
    public function index($userId)
    {
        $reminders = Reminder::where('user_id', $userId)->get();
        return ReminderResource::collection($reminders);
    }

    // Get reminder details by ID
    public function show($id)
    {
        $reminder = Reminder::findOrFail($id);
        return new ReminderResource($reminder);
    }

    // Create a new reminder
    public function store(Request $request)
    {
        $reminder = Reminder::create($request->all());
        return new ReminderResource($reminder);
    }

    // Update reminder details
    public function update(Request $request, $id)
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->update($request->all());
        return new ReminderResource($reminder);
    }

    // Delete a reminder
    public function destroy($id)
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->delete();
        return response()->json(['message' => 'Reminder deleted successfully']);
    }
}
