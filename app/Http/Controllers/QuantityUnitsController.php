<?php

namespace App\Http\Controllers;

use App\Models\QuantityUnits;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuantityUnitsController extends Controller
{

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        QuantityUnits::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return back()->with('message', 'Quantity unit created successfully.');
    }

    public function update(Request $request, string $encodedId)
    {
        $decodedId = base64_decode($encodedId); 
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        try {
            $quantityUnits = QuantityUnits::find($decodedId);
            $quantityUnits->name = $request->name;
            $quantityUnits->description = $request->description;
            $quantityUnits->save();
            return back()->with('message', 'Quantity unit updated successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to update Quantity unit. Please try again later.');
        }
    }

    
    public function destroy(string $encodedId) 
    {
        $decodedId = base64_decode($encodedId); 
        try {
            $quantityUnits = QuantityUnits::findOrFail($decodedId);
            $quantityUnits->delete();
            return  back()->with('message', 'Quantity unit deteled successfully.');
        } catch (ModelNotFoundException $e) {
            return abort(404, 'Quantity unit not found'); 
        }
    }
}
