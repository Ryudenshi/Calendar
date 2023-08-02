<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\ReminderSetting;
use App\Http\Resources\ReminderSettingResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderSettingController extends Controller
{
    // Get all reminder settings for a specific reminder
    public function index($reminderId)
    {
        $reminderSettings = ReminderSetting::where('reminder_id', $reminderId)->get();
        return ReminderSettingResource::collection($reminderSettings);
    }

    // Get reminder setting details by ID
    public function show($id)
    {
        $reminderSetting = ReminderSetting::findOrFail($id);
        return new ReminderSettingResource($reminderSetting);
    }

    // Create a new reminder setting
    public function store(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user
        $reminderSettingData = $request->all();

        // You might want to add additional validation or checks here

        $reminderSetting = ReminderSetting::create($reminderSettingData);
        return response()->json(['message' => 'Reminder setting created successfully', 'reminderSetting' => new ReminderSettingResource($reminderSetting)]);
    }

    // Update reminder setting details
    public function update(Request $request, $id)
    {
        $reminderSetting = ReminderSetting::findOrFail($id);
        $reminderSetting->update($request->all());
        return new ReminderSettingResource($reminderSetting);
    }

    // Delete a reminder setting
    public function destroy($id)
    {
        $reminderSetting = ReminderSetting::findOrFail($id);
        $reminderSetting->delete();
        return response()->json(['message' => 'Reminder setting deleted successfully']);
    }
}