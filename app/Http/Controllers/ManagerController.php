<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Schedule;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class ManagerController extends Controller
{
    private function pageDataToBeEmpty ($pageData) {
        if($pageData->isEmpty()) {$pageData = [];}
        return $pageData;
    }

    // Common method to get user data
    private function getUserData($sectionName, $title, $pageData = new stdClass())
    {
        $user = Auth::user();
        $userName = $user ? $user->name : 'Guest';
        $userId = $user ? $user->id : 'Guest';
        $totalPages = 1;

        $reminder = $user->reminders()
            ->where('is_completed', 0)
            ->orderBy('priority', 'asc')
            ->orderBy('reminder_time', 'asc')
            ->get();


        if($title == "Index"){
            $publicSchedules = Schedule::where('visibility', 'public')->get();
            $managerSchedules = Schedule::where('visibility', 'manager')->get();
            $userSchedules = $user->schedule()->get();
            $pageData->Schedules = $publicSchedules->merge($userSchedules);
            $pageData->Schedules = $pageData->Schedules->merge($managerSchedules);
        }else if ($title == "List Reminder"){
            $pageData->reminders = $user->reminders()->orderBy('created_at', 'desc')->get();
        }
       
        // dd($pageData->reminders);
        return [
            'title' => $title,
            'sectionName' => $sectionName,
            'userName' => $userName,
            'user' => $user,
            'user_id' => $userId,
            "pageData" => $pageData,
            'displayReminder' => $reminder
        ];
    }

     public function index()
    {
        $data = $this->getUserData('Dashboard', 'Index');
        return view('manager.index', $data);
    }

    public function profile()
   {
       $data = $this->getUserData('General', 'Profile');
       return view('manager.profile', $data);
   }

   public function invoice()
  {
      $data = $this->getUserData('General', 'Invoice');
      return view('manager.invoice', $data);
  }

   public function reminder()
   {
       $data = $this->getUserData('Reminder', 'Set Reminder');
       return view('manager.reminder.index', $data);
   }

   public function reminder_list()
   {
       $data = $this->getUserData('Reminder', 'List Reminder');
       return view('manager.reminder.list', $data);
   }

   public function reminder_view(string $encodedId) 
   {
       $decodedId = base64_decode($encodedId); 
       try {
           $reminder = Auth::user()->reminders()->findOrFail($decodedId);
           $data = $this->getUserData('Reminder', 'View Reminder', $reminder);
           $user_id = Auth::id();
           if($user_id != $reminder->user_id){
               abort(403, 'You can only view reminders you created.');
           }
           return view('manager.reminder.view', $data);
       } catch (ModelNotFoundException $e) {
           return abort(404, 'Customer not found'); 
       }
   }

   public function reminder_edit(string $encodedId) 
   {
       $decodedId = base64_decode($encodedId); 
       try {
           $reminder = Auth::user()->reminders()->findOrFail($decodedId);
           try {
               $data = $this->getUserData('Reminder', 'Edit Reminder', $reminder);
             } catch (Exception $e) {
               return abort(500, 'An error occurred while processing your request.');
             }
           $user_id = Auth::id();
           if($user_id != $reminder->user_id){
               abort(403, 'You can only edit reminders you created.');
           }
           return view('manager.reminder.edit', $data);
       } catch (ModelNotFoundException $e) {
           return abort(404, 'Customer not found'); 
       }
   }




}
