<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use stdClass;

class CustomerController extends Controller
{
    private function getUserData(string $sectionName, string $title, object $pageData = new stdClass()): array
    {
        $user = Auth::user();
        $userName = $user ? $user->name : 'Guest';
        $userId = $user ? $user->id : 'Guest';
        $reminder = $user->reminders()
            ->where('is_completed', 0)
            ->orderBy('priority', 'asc')
            ->orderBy('reminder_time', 'asc')
            ->get();

        if ($title === "Index") {
            $pageData->Schedules = $user->schedule()->get();
        }else if ($title == "List Customer"){
            $pageData->Customers =  $user->customers()->get();
        }else if ($title == "List all Customers"){
            
            $customers = Customers::all(); 
            $customersWithUserDetails = [];
            
            foreach ($customers as $customer) {
                $user = User::find($customer->user_id);
            
                if ($user) {
                    $customersWithUserDetails[] = [
                        "id" => $customer->id, 
                        'customer_name' => $customer->name, 
                        'username' => $user->name,
                        'userrole' => $user->role,
                    ];
                }
            }
            
            $pageData->customers = $customersWithUserDetails ?: [];
            
            
        }

        return [
            'title' => $title,
            'sectionName' => $sectionName,
            'userName' => $userName,
            'user' => $user,
            'pageData' => $pageData,
            'displayReminder' => $reminder
        ];
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|unique:customers,email|max:255',
            'phone' => 'nullable|min:10|max:15',
            'address' => 'nullable|string|max:250|max:250',
        ]);

        if ($validator->fails()) {
            if ($request->input('returnType') === 'json') {
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }
            }
            return back()->withErrors($validator)->withInput();
        }

        $user_id = Auth::id();

        try {
            $customer = Customers::create([
                "user_id" => $user_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            if ($request->input('returnType') === 'json') {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Customer created successfully.',
                    'customer' => $customer,
                ], 200);
            }

            return back()->with('message', 'Customer created successfully.');
        } catch (Exception $e) {
            if ($request->input('returnType') === 'json') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to create customer. Please try again later.',
                ], 500);
            }
            return back()->with('error', 'Failed to create customer. Please try again later.');
        }
    }

    public function update(Request $request, string $encodedId)
    {
        $decodedId = base64_decode($encodedId); 
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => [
                'nullable',
                'string',
                'email',
                Rule::unique('customers')->ignore($decodedId),
            ],
            'phone' => 'nullable|min:10',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        
        try {
            $customer = Customers::find($decodedId);
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->save();
            return back()->with('message', 'Customer updated successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to update customer. Please try again later.');
        }
    }

    public function destroy(string $encodedId) 
    {
        $decodedId = base64_decode($encodedId); 
        try {
            $customer = Customers::findOrFail($decodedId);
            $customer->delete();
            return  back()->with('message', 'Customer deteled successfully.');
        } catch (ModelNotFoundException $e) {
            return abort(404, 'Customer not found'); 
        }
    }

    public function add()
    {
        $data = $this->getUserData('Customer', 'Add Customer');
        return view('manager.customer.store', $data);
    }

    public function list()
    {

        $data = $this->getUserData('Customer', 'List Customer');
        return view('manager.customer.list', $data);
    }

    public function view(string $encodedId) 
    {
        $decodedId = base64_decode($encodedId); 
        try {
            $customer = Auth::user()->customers()->findOrFail($decodedId);
            $data = $this->getUserData('Customer', 'View Customer', $customer);
            return view('manager.customer.view', $data);
        } catch (ModelNotFoundException $e) {
            return abort(404, 'Customer not found'); 
        }
    }

    public function edit(string $encodedId) 
    {
        $decodedId = base64_decode($encodedId); 
        try {
            $customer = Auth::user()->customers()->findOrFail($decodedId);
            $data = $this->getUserData('Customer', 'Edit Customer', $customer);
            return view('manager.customer.edit', $data);
        } catch (ModelNotFoundException $e) {
            return abort(404, 'Customer not found'); 
        }
    }

    public function admin_add()
    {
        $data = $this->getUserData('Customer', 'Add Customer');
        return view('admin.customer.store', $data);
    }

    public function admin_list()
    {

        $data = $this->getUserData('Customer', 'List Customer');
        return view('admin.customer.list', $data);
    }

    public function admin_view(string $encodedId) 
    {
        $decodedId = base64_decode($encodedId); 
        try {
            $customer = Auth::user()->customers()->findOrFail($decodedId);
            $data = $this->getUserData('Customer', 'View Customer', $customer);
            return view('admin.customer.view', $data);
        } catch (ModelNotFoundException $e) {
            return abort(404, 'Customer not found'); 
        }
    }

    public function admin_edit(string $encodedId) 
    {
        $decodedId = base64_decode($encodedId); 
        try {
            $customer = Auth::user()->customers()->findOrFail($decodedId);
            $data = $this->getUserData('Customer', 'Edit Customer', $customer);
            return view('admin.customer.edit', $data);
        } catch (ModelNotFoundException $e) {
            return abort(404, 'Customer not found'); 
        }
    }

    public function admin_list_all()
    {

        $data = $this->getUserData('Customer', 'List all Customers');
        return view('admin.customer.list-all', $data);
    }

    
    public function admin_view_all(string $encodedId) 
    {
        $decodedId = base64_decode($encodedId); 
        try {
            $pageData = new stdClass();
            $customer = Customers::findOrFail($decodedId);
            $user = User::find($customer->user_id);
            $customersWithUsernames = [
                "id"=> $customer->id, 
                'name' => $customer->name, 
                'phone' => $customer->phone, 
                'email' => $customer->email,
                'address' => $customer->address,
                'created_at' => $customer->created_at,
                'creater_name' => $user->name,
                'creater_email' => $user->email,
                'creater_role' => $user->role,
            ];

            $pageData->customer = $customersWithUsernames;

            $data = $this->getUserData('Customer', 'View all Customer', $pageData);
            return view('admin.customer.view-all', $data);
        } catch (ModelNotFoundException $e) {
            return abort(404, 'Customer not found'); 
        }
    }
}
