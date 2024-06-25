<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Validator;

class ScheduleController extends Controller
{
    public function store(Request $request)
    {
        

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'start' => 'required|date_format:Y-m-d\TH:i',
            'end' => 'nullable|date_format:Y-m-d\TH:i',
            'visibility' => 'required|string',
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $userId = Auth::id();
        
        try {
            // Create a new schedule entry
            $schedule = new Schedule();
            $schedule->user_id = $userId;
            $schedule->title = $request->title;
            $schedule->description = $request->description;
            $schedule->start = $request->start;
            $schedule->end = $request->end;
            $schedule->visibility = $request->visibility;
            $schedule->is_editable = $request->has('is_editable') ? 1 : 0;
            $schedule->level = $request->has('schedule_level') ? $request->schedule_level : "Primary";
            $schedule->save();
            // Return a response
            return back()->with('message', 'Schedule created successfully!');
        } catch (\Exception $e) {
            // Handle the exception
            return back()->with('error', 'Error creating schedule: ');
        }
    }

    public function update (Request $request, $id){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'start' => 'required|date_format:Y-m-d\TH:i',
            'end' => 'nullable|date_format:Y-m-d\TH:i',
            'visibility' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Error creating schedule');
        }

        $Schedule = Schedule::find($id);

        if (!$Schedule) {
            return back()->with('error', 'Schedule not found.');
        }

        
        $userId = Auth::id();

        // Update the Schedule's attributes
    
        try {
            $Schedule->title = $request->title;
            $Schedule->description = $request->description;
            $Schedule->start = $request->start;
            $Schedule->end = $request->end;
            $Schedule->visibility = $request->visibility;
            $Schedule->is_editable = $request->has('is_editable') ? 1 : 0;
            $Schedule->level = $request->has('schedule_level') ? $request->schedule_level : "Primary";
            $Schedule->updater_admin_or_manager_id = $userId;
    
            // Save the changes
            $Schedule->save();
    
            // Return a response
            return back()->with('message', 'Schedule Updated successfully!');
        } catch (\Exception $e) {
            // Handle the exception
            return back()->with('error', 'Error Updating schedule: ');
        }

    }
}