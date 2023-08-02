<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Reminder;
use App\Http\Resources\ReminderResource;
use App\Models\ReminderSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user(); // Get the authenticated user
        $reminderData = $request->input('reminder');
        $reminderData['user_id'] = $user->id; // Associate the reminder with the user

        $reminder = Reminder::create($reminderData);

        // Now create reminder settings if they are provided
        $settingsData = $request->input('settings', []);

        foreach ($settingsData as $setting) {
            $setting['reminder_id'] = $reminder->id;
            ReminderSetting::create($setting);
        }

        return response()->json(['message' => 'Reminder created successfully', 'reminder' => new ReminderResource($reminder)]);
    }

    // Update reminder details
    public function update(Request $request, $id)
    {
        $reminder = Reminder::findOrFail($id);

        // Check if the authenticated user is the owner of the reminder
        if (Auth::user()->id !== $reminder->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $reminder->update($request->all());
        return response()->json(['message' => 'Reminder updated successfully', 'reminder' => new ReminderResource($reminder)]);
    }

    // Delete a reminder
    public function destroy($id)
    {
        $reminder = Reminder::findOrFail($id);

        // Check if the authenticated user is the owner of the reminder
        if (Auth::user()->id !== $reminder->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $reminder->delete();
        return response()->json(['message' => 'Reminder deleted successfully']);
    }
}
