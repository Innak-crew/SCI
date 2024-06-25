<?php

namespace App\Http\Controllers;
use App\Models\Designs;
use App\Models\RateHistory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\Models\Categories;
use App\Models\Customers;
use App\Models\Invoices;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\PaymentHistory;
use App\Models\Reminders;
use App\Models\Schedule;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'customer' => 'required|integer|exists:customers,id',
            'location' => 'required|string|max:255',
            'type' => 'required|in:Interior,Exterior,Both',
            'order_starting_date' => 'required|date',
            'order_ending_date' => 'nullable|date|after_or_equal:order_starting_date',
            'created_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:created_date',
            'estimated_cost' => 'nullable|numeric',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'advance_pay_amount' => 'nullable|numeric|min:0',
            'payment_status' => 'required|string|in:pending,completed,canceled',
            'terms_and_conditions' => 'nullable|string',
            'note' => 'nullable|array',
            'note.*' => 'nullable|string',
            'follow_date' => 'nullable|array',
            'follow_date.*' => 'nullable|date',
            'category' => 'nullable|array',
            'category.*' => 'string|max:255',
            'sub_category' => 'nullable|array',
            'sub_category.*' => 'string|max:255',

            'design' => 'nullable|array',
            'design.*' => 'nullable|integer|exists:designs,id',

            'rate_per' => 'nullable|array',
            'rate_per.*' => 'nullable|numeric|min:0',

            'sub_total' => 'nullable|array',
            'sub_total.*' => 'nullable|numeric|min:0',

            'order_item_quantity' => 'nullable|array',
            'order_item_quantity.*' => 'integer|min:1',
            
            'payment_date' => 'nullable|array',
            'payment_date.*' => 'nullable|date',
            
            'payment_amount' => 'nullable|array',
            'payment_amount.*' => 'nullable|numeric|min:0',
            
            'payment_method' => 'nullable|array',
            'payment_method.*' => 'nullable|string',
        ]);

        // dd($request->all());


        try {
            DB::beginTransaction();

            $user_id = Auth::id();

           // Find the customer
            $customer = Customers::find($request->customer);

            // Create new order
            $order = Orders::create([
                'user_id' => $user_id,
                'name' => $request->name ?? 'Order for ' . $customer->name,
                'location' => $request->location,
                'type' => $request->type,
                'customer_id' => $request->customer,
                'start_date' => $request->order_starting_date,
                'end_date' => $request->order_ending_date,
                'estimated_cost' => $request->estimated_cost,
                'deposit_received' => $request->deposit_received ?? null,
            ]);

            // Handle follow-ups
            if (isset($request->follow_date)) {
                foreach ($request->follow_date as $index => $followDate) {
                    $note = $request->note[$index] ?? '';

                    // Create schedule
                    $schedule = new Schedule();
                    $schedule->user_id = $user_id;
                    $schedule->order_id = $order->id;
                    $schedule->title = 'Follow-up Reminder';
                    $schedule->description = 'Follow-up needed for order with customer ' . $customer->name . ". Additional note: " . $note;
                    $schedule->start = Carbon::parse($followDate)->format('Y-m-d 00:00:00');
                    $schedule->level = 'Warning';
                    $schedule->save();

                    // Create reminder
                    $reminder = new Reminders();
                    $reminder->user_id = $user_id;
                    $reminder->title = 'Follow-up Reminder';
                    $reminder->description = 'Follow-up needed for order with customer ' . $customer->name . ". Additional note: " . $note;
                    $reminder->reminder_time = Carbon::parse($followDate)->format('Y-m-d 09:00:00');
                    $reminder->priority = 1;
                    $reminder->save();
                }
            }

            // Handle order items
            if (isset($request->design)) {
                for ($i = 0; $i < count($request->design); $i++) {
    
                    // Find or create the category
                    $category = Categories::firstOrCreate(['name' => $request->category[$i]], ['type' => $request->type]);

                    // Find or create the subcategory
                    $subCategory = Categories::firstOrCreate(
                        ['name' => $request->sub_category[$i], 'parent_id' => $category->id],
                        ['type' => $request->type]
                    );
            
                    // Find the design
                    $design = Designs::findOrFail($request->design[$i]);

                    $rate_per = $request->rate_per[$i] ?? 0;

                    $rate_per = $request->rate_per[$i] ?? 0;
                    $sub_total = $request->sub_total[$i];
                    $discount_percentage = $request->discount_percentage ?? 0;
                    $discount_amount = $sub_total * ($discount_percentage / 100);
                    $total = $sub_total - $discount_amount;

                    // Create order item
                    DB::table('order_items')->insert([
                        'order_id' => $order->id,
                        'category_id' => $subCategory->id,
                        'design_id' => $design->id,
                        'quantity' => $request->order_item_quantity[$i],
                        'rate_per' => $rate_per,
                        'sub_total' => $sub_total,
                        'discount_percentage' => $discount_percentage,
                        'discount_amount' => $discount_amount,
                        'total' => $total,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    

                }
            }

            // Create payment history
            if (isset($request->payment_date)) {
                foreach ($request->payment_date as $index => $paymentDate) {
                    $paymentHistory = new PaymentHistory();
                    $paymentHistory->order_id = $order->id;
                    $paymentHistory->payment_date = $paymentDate;
                    $paymentHistory->amount = $request->paid_amount[$index] ?? 0;
                    $paymentHistory->payment_method = $request->payment_method[$index] ?? '';
                    $paymentHistory->save();
                }
            }

            $latestInvoice = Invoices::orderBy('id', 'desc')->first();
            $nextInvoiceNumber = $latestInvoice ? ((int) substr($latestInvoice->invoice_number, 5)) + 1 : 1;
            $formattedInvoiceNumber = '#INV-' . str_pad($nextInvoiceNumber, 5, '0', STR_PAD_LEFT);

            $sub_total = $order->orderItems->sum('sub_total');
            $discountAmount = $sub_total * ($request->discount_percentage / 100);
            $totalAfterDiscount = $sub_total - $discountAmount;

            $balanceAmount = $totalAfterDiscount - $order->paymentHistory->sum('amount');


            // Create invoice
            $invoice = Invoices::create([
                'order_id' => $order->id,
                'user_id' => $user_id,
                'customer_id' => $customer->id,
                'invoice_number' => $formattedInvoiceNumber,
                'created_date' => $request->created_date,
                'due_date' => $request->due_date ?? null,
                'discount_percentage' => $request->discount_percentage ?? 0,
                'discount_amount' => $discountAmount ?? 0,
                'advance_pay_amount' => $request->advance_pay_amount ?? 0,
                'payment_status' => $request->payment_status ?? 'pending',
                'sub_total_amount' => $sub_total ?? 0,
                'total_amount' => $totalAfterDiscount ?? 0,
                'balance_amount' => $balanceAmount ?? 0,
                'terms_and_conditions' => $request->terms_and_conditions ?? '',
            ]);
            
            // Commit the transaction
            DB::commit();

            return redirect()->back()->with('message', 'Order created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Order creation failed:', ['error' => $e->getMessage()]);
            dd($e);
            return back()->with('error', 'Failed to create order. Please try again later.');
        }
    }

    public function update(Request $request, string $encodedId){

        // $decodeID = base64_decode($encodedId);

        // $order = Orders::findOrFail($decodeID);

        

         $request->validate([
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'customer' => 'required|integer|exists:customers,id',
            'location' => 'required|string|max:255',
            'type' => 'required|in:Interior,Exterior,Both',
            'order_starting_date' => 'required|date',
            'order_ending_date' => 'nullable|date|after_or_equal:order_starting_date',
            'status' => 'required|string',
            'invoice_id' => "required|integer|exists:invoices,id",
            'created_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:created_date',
            'estimated_cost' => 'nullable|numeric',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'advance_pay_amount' => 'nullable|numeric|min:0',
            'payment_status' => 'required|string|in:pending,paid,partially_paid,late,overdue',
            'terms_and_conditions' => 'nullable|string',
            
            'alt_payment_history_id' => 'nullable|array',
            'alt_payment_history_id.*' => 'nullable|integer|exists:payment_history,id',
            
            'alt_order_item' => 'nullable|array',
            'alt_order_item.*' => 'nullable|integer|exists:order_items,id',
            
            'alt_category_id' => 'nullable|array',
            'alt_category_id.*' => 'nullable|integer|exists:categories,id',
            
            'alt_sub_category_id' => 'nullable|array',
            'alt_sub_category_id.*' => 'nullable|integer|exists:categories,id',
            
            'alt_design' => 'nullable|array',
            'alt_design.*' => 'nullable|integer|exists:designs,id',
            
            'alt_order_item_quantity' => 'nullable|array',
            'alt_order_item_quantity.*' => 'nullable|numeric|min:0',
            
            'alt_rate_per' => 'nullable|array',
            'alt_rate_per.*' => 'nullable|numeric|min:0',
            
            'alt_sub_total' => 'nullable|array',
            'alt_sub_total.*' => 'nullable|numeric|min:0',
            
            'alt_category' => 'nullable|array',
            'alt_category.*' => 'nullable|string|max:255',
            
            'alt_sub_category' => 'nullable|array',
            'alt_sub_category.*' => 'nullable|string|max:255',
            
            'is_order_item_delete' => 'nullable|array',
            'is_order_item_delete.*' => 'nullable|integer|exists:order_items,id',
            
            'alt_followup_id' => 'nullable|array',
            'alt_followup_id.*' => 'nullable|integer|exists:schedule,id',
            
            'alt_follow_date' => 'nullable|array',
            'alt_follow_date.*' => 'nullable|date',
            
            'is_followup_delete' => 'nullable|array',
            'is_followup_delete.*' => 'nullable|integer|exists:schedule,id',
            
            'alt_note' => 'nullable|array',
            'alt_note.*' => 'nullable|string|max:255',
            
            'alt_payment_date' => 'nullable|array',
            'alt_payment_date.*' => 'nullable|date',
            
            'alt_payment_amount' => 'nullable|array',
            'alt_payment_amount.*' => 'nullable|numeric|min:0',
            
            'alt_payment_method' => 'nullable|array',
            'alt_payment_method.*' => 'nullable|string',
            
            'is_payment_history_delete' => 'nullable|array',
            'is_payment_history_delete.*' => 'nullable|integer|exists:payment_history,id',
            
            'note' => 'nullable|array',
            'note.*' => 'nullable|string|max:255',
            
            'follow_date' => 'nullable|array',
            'follow_date.*' => 'nullable|date',
            
            'payment_date' => 'nullable|array',
            'payment_date.*' => 'nullable|date',
            
            'payment_amount' => 'nullable|array',
            'payment_amount.*' => 'nullable|numeric|min:0',
            
            'payment_method' => 'nullable|array',
            'payment_method.*' => 'nullable|string',
            
            'category' => 'nullable|array',
            'category.*' => 'nullable|string|max:255',
            
            'sub_category' => 'nullable|array',
            'sub_category.*' => 'nullable|string|max:255',

            'design' => 'nullable|array',
            'design.*' => 'nullable|integer|exists:designs,id',

            'rate_per' => 'nullable|array',
            'rate_per.*' => 'nullable|numeric|min:0',

            'sub_total' => 'nullable|array',
            'sub_total.*' => 'nullable|numeric|min:0',
            
            'order_item_quantity' => 'nullable|array',
            'order_item_quantity.*' => 'nullable|integer|min:1',

        ]);

        // dd($request->all());


        try {

            DB::beginTransaction();

            $decodeID = base64_decode($encodedId);

            // Find customer
            $customer = Customers::find($request->customer);

            // Find the order
            $order = Orders::findOrFail($decodeID);

            // Update order fields
            $order->location = $request->location;
            $order->type = $request->type;
            $order->start_date = $request->order_starting_date;
            $order->status = $request->status;
            $order->end_date = $request->order_ending_date ?? null;
            $order->deposit_received = $request->deposit_received ?? null;
            $order->estimated_cost = $request->estimated_cost;
            $order->save();

            // Update customer-related details if customer changes
            if ($order->customer_id !== (int) $request->customer) {
                $order->customer_id = $request->customer;
                $order->name = $request->name ?? 'Order for ' . $customer->name;
                $order->save();
            }
            
            // Update or delete existing order items
            if (isset($request->alt_order_item_id)) {
                foreach ($request->alt_order_item_id as $index => $alreadyOrderId) {
                    $orderItem = OrderItems::find($alreadyOrderId);
    
                    if ($orderItem) {
                        // Handle deletion of order item
                        if (isset($request->is_order_item_delete) && in_array($alreadyOrderId, $request->is_order_item_delete)) {
                            $orderItem->delete();
                        } else {
                            // Update category and sub-category
                            $newSubCategory = $request->alt_sub_category[$index];
                            $newCategory = $request->alt_category[$index];
    
                                // Find or create the new main category
                                $category = Categories::firstOrCreate(
                                    ['name' => $newCategory],
                                    ['type' => $request->type]
                                );
                            
                                // Find or create the new subcategory under the new main category
                                $subCategory = Categories::firstOrCreate(
                                    ['name' => $newSubCategory, 'parent_id' => $category->id],
                                    ['type' => $request->type]
                                );
                                
                                $orderItem->update(['category_id' => $subCategory->id]);
                 

    
                            // Update Design, quantity, and total
                            if (isset($request->alt_order_item[$index])) {
                                $orderItem->update(['design_id' => $request->alt_design[$index]]);
                            }
    
                            if (isset($request->alt_order_item_quantity[$index])) {
                                $quantity = $request->alt_order_item_quantity[$index];
                                $rate_per = $request->alt_rate_per[$index];
                                $sub_total = $request->alt_sub_total[$index];
                                $discount_percentage = $request->discount_percentage ?? 0;
                                $discount_amount = $sub_total * ($discount_percentage / 100);
                                $total = $sub_total - $discount_amount;
    
                                $orderItem->update([
                                    'quantity' => $quantity,
                                    'rate_per' => $rate_per,
                                    'sub_total' => $sub_total,
                                    'discount_percentage' => $discount_percentage,
                                    'discount_amount' => $discount_amount,
                                    'total' => $total,
                                ]);
                            }
                        }
                    }
                }
            }

            // Create new order items
            if (isset($request->design)) {
                for ($i = 0; $i < count($request->design); $i++) {

                    // Find or create the category
                    $category = Categories::firstOrCreate(['name' => $request->category[$i]], ['type' => $request->type]);

                    // Find or create the subcategory
                    $subCategory = Categories::firstOrCreate(
                        ['name' => $request->sub_category[$i], 'parent_id' => $category->id],
                        ['type' => $request->type]
                    );

                    // Find the design
                    $design = Designs::findOrFail($request->design[$i]);
                    $rate_per = $request->rate_per[$i] ?? 0;
                    $sub_total = $request->sub_total[$i];
                    $discount_percentage = $request->discount_percentage ?? 0;
                    $discount_amount = $sub_total * ($discount_percentage / 100);
                    $total = $sub_total - $discount_amount;

                     // Create order item
                     DB::table('order_items')->insert([
                        'order_id' => $order->id,
                        'category_id' => $subCategory->id,
                        'design_id' => $design->id,
                        'quantity' => $request->order_item_quantity[$i],
                        'rate_per' => $rate_per,
                        'sub_total' => $sub_total,
                        'discount_percentage' => $discount_percentage,
                        'discount_amount' => $discount_amount,
                        'total' => $total,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Update or delete follow-ups
            if (isset($request->alt_followup_id)) {
                foreach ($request->alt_followup_id as $index => $alreadyFollowUpId) {
                    $schedule = Schedule::find($alreadyFollowUpId);
            
                    if ($schedule) {
                        $reminder = Reminders::where('title', $schedule->title)
                        ->where('description', $schedule->description)
                        ->first();
    
                        if (isset($request->is_followup_delete) && in_array($alreadyFollowUpId, $request->is_followup_delete)) {
                            if ($reminder) {
                                $reminder->delete();
                            }
                            $schedule->delete();
                        } else {
                            $additionalNote = $request->alt_note[$index] ?? '';
                            $newDescription = 'Follow-up needed for order with customer ' . $customer->name . ". Additional note: " . $additionalNote;
                            $newFollowDate = Carbon::parse($request->alt_follow_date[$index])->format('Y-m-d');
            
                            if ($schedule->description !== $newDescription) {
                                $schedule->update(['description' => $newDescription]);
                                $reminder = Reminders::where('title', $schedule->title)->where('description', $schedule->description)->first();
                                if ($reminder) {
                                    $reminder->update(['description' => $newDescription]);
                                }
                            }
            
                            if (Carbon::parse($schedule->start)->format('Y-m-d') !== $newFollowDate) {
                                $schedule->update(['start' => "$newFollowDate 00:00:00"]);
                                $reminder = Reminders::where('title', $schedule->title)->where('description', $schedule->description)->first();
                                if ($reminder) {
                                    $reminder->update(['start' => "$newFollowDate 09:00:00"]);
                                }
                            }
                        }
                    }
                }
            }

            // Create new follow-ups
            if (isset($request->follow_date)) {
                foreach ($request->follow_date as $index => $followDate) {
                    $note = $request->note[$index] ?? '';
    
                    $schedule = new Schedule();
                    $schedule->user_id = Auth::id();
                    $schedule->order_id = $order->id;
                    $schedule->title = 'Follow-up Reminder';
                    $schedule->description = 'Follow-up needed for order with customer ' . $customer->name . ". Additional note: " . $note;
                    $schedule->start = "$followDate 00:00:00";
                    $schedule->level = 'Warning';
                    $schedule->save();
    
                    $reminder = new Reminders();
                    $reminder->user_id = Auth::id();
                    $reminder->title = 'Follow-up Reminder';
                    $reminder->description = 'Follow-up needed for order with customer ' . $customer->name . ". Additional note: " . $note;
                    $reminder->reminder_time = "$followDate 09:00:00";
                    $reminder->priority = 1;
                    $reminder->save();
                }
            }

            // Update or delete payment history
            if (isset($request->alt_payment_history_id)) {
                foreach ($request->alt_payment_history_id as $index => $alreadyPaymentHistoryId) {
                    $paymentHistory = PaymentHistory::find($alreadyPaymentHistoryId);
                    if ($paymentHistory) {
                        if (isset($request->is_payment_history_delete) && in_array($alreadyPaymentHistoryId, $request->is_payment_history_delete)) {
                            $paymentHistory->delete();
                        } else {
                            // Update payment history details
                            $paymentHistory->update([
                                'payment_date' => $request->alt_payment_date[$index] ?? $paymentHistory->payment_date,
                                'amount' => $request->alt_payment_amount[$index] ?? $paymentHistory->amount,
                                'payment_method' => $request->alt_payment_method[$index] ?? $paymentHistory->payment_method,
                            ]);
                        }
                    }
                }
            }

            // Create new payment history
            if (isset($request->payment_date)) {
                foreach ($request->payment_date as $index => $paymentDate) {
                    $paymentHistory = new PaymentHistory();
                    $paymentHistory->order_id = $order->id;
                    $paymentHistory->payment_date = $paymentDate;
                    $paymentHistory->amount = $request->paid_amount[$index] ?? '';
                    $paymentHistory->payment_method = $request->payment_method[$index] ?? '';
                    $paymentHistory->save();
                }
            }

            // Update invoice
            if (isset($request->invoice_id)) {
                $invoice = Invoices::find($request->invoice_id);

                if ($invoice) {
                    // Calculate invoice details
                    $sub_total = $order->orderItems->sum('sub_total');
                    $discountAmount = $sub_total * ($request->discount_percentage / 100);
                    $totalAfterDiscount = $sub_total - $discountAmount;

                    $balanceAmount = $totalAfterDiscount - $order->paymentHistory->sum('amount');

                    $invoice->update([
                        'created_date' => $request->created_date,
                        'due_date' => $request->due_date,
                        'sub_total_amount' => $sub_total,
                        'discount_amount' => $discountAmount,
                        'discount_percentage' => $request->discount_percentage,
                        'advance_pay_amount' => $request->advance_pay_amount,
                        'payment_status' => $request->payment_status,
                        'terms_and_conditions' => $request->terms_and_conditions,
                        'total_amount' => $totalAfterDiscount,
                        'balance_amount' => $balanceAmount,
                    ]);
                }
            }

            // Commit the transaction
            DB::commit();
            return back()->with('message', 'Order updated successfully.');
            
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->with('error', 'Failed to update order. Please try again later.');
        }
    }
    
    public function destroy(string $encodedId) 
    {
        $decodedId = base64_decode($encodedId); 
        $order = Orders::findOrFail($decodedId);

        try {
            DB::beginTransaction();
            foreach ($order->orderItems as $orderItem) {
                $orderItem->delete();
            }
            foreach ($order->followup()->get() as $followup) {
                $reminder = Reminders::where('title', $followup->title)
                                    ->where('description', $followup->description)
                                    ->first();
                if ($reminder) {
                    $reminder->delete();
                }
                $followup->delete();
            }
            $order->delete();
            DB::commit();

            return back()->with('message', 'Order deleted successfully.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return abort(404, 'Order not found'); 
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while deleting the order.');
        }
    }

}
