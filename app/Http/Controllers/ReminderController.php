<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReminderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'color' => 'required|string|max:20',
            'datetime' => 'required|date',
            'repeat_type' => 'nullable|in:none,daily,weekly,monthly,yearly',
        ]);

        $reminder = new Reminder($request->all());
        $reminder->user_id = Auth::user()->id;
        $reminder->save();

        $reminder->datetime = Carbon::parse($reminder->datetime)->format('Y-m-d\TH:i:s');

        return response()->json($reminder, 201);
    }

    public function update(Request $request, Reminder $reminder)
    {
        if (Auth::user()->id !== $reminder->user_id) {
            return response()->json(['message' => 'Access denied.'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'color' => 'required|string|max:20',
            'datetime' => 'required|date',
            'repeat_type' => 'nullable|in:none,daily,weekly,monthly,yearly',
        ]);

        $reminder->update($request->all());

        return response()->json(['reminder' => $reminder]);
    }

    public function destroy(Reminder $reminder)
    {
        if (Auth::user()->id !== $reminder->user_id) {
            return response()->json(['message' => 'Access denied.'], 403);
        }

        $reminder->delete();

        return response()->json(null, 204);
    }
}
