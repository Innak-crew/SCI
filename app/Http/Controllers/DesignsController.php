<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\CategoryKey;
use App\Models\Designs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DesignsController extends Controller
{
    public function store(Request $request)
    {

        // Validate the request
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'type' => 'required|in:Interior,Exterior,Both',
            'unit_id' => 'required|numeric',
            'category' => 'required|string',
            'sub_category' => 'required|string',
            'category_key' => 'required|string',
        ]);


    
        DB::beginTransaction();
    
        try {
            $user_id = Auth::id();
    
            // Find or create the category and subcategory
            $category = Categories::firstOrCreate(['name' => $request->category, 'type' => $request->type]);

            // Now, attempt to find the subcategory by name and parent_id (category_id)
            $subCategory = Categories::firstOrCreate([
                'name' => $request->sub_category,
                'parent_id' => $category->id,
                'type' => $request->type,
            ]);

          
    
            $imagePath = null;

            // Handle image upload
            if ($request->hasFile('image')) {
                $timestamp = now()->format('YmdHis');
                $originalFileName = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
                $sanitizedFileName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalFileName);
                $extension = $request->file('image')->getClientOriginalExtension();
                $imageName = $timestamp . '_' . $sanitizedFileName . '.' . $extension;
                $path = $request->file('image')->storeAs('Designs', $imageName, 'public');
                $imagePath = "/storage/" . $path;
            } 

            // Find or create the category key
            $categoryKey = CategoryKey::firstOrCreate(['key' => $request->category_key]);
    
            // Create the design record
            Designs::create([
                'user_id' => $user_id,
                'name' => $request->name ?? null,
                'description' => $request->description ?? null,
                'category_id' => $subCategory->id,
                'category_key_id' => $categoryKey->id,
                'image_url' => $imagePath,
                'type' => $request->type,
                'unit_id' => $request->unit_id,
            ]);
    
            DB::commit();
            return redirect()->back()->with('message', 'Design uploaded successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->with('error', 'Failed to upload design. Please try again later.');
        }

    }

    public function update(Request $request, string $encodedId)
    {
        // Validate the request
        $request->validate([
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:Interior,Exterior,Both',
            'unit_id' => 'required|numeric',
            'category' => 'required|string',
            'sub_category' => 'required|string',
            'category_key' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
        $decodedId = base64_decode($encodedId);

            // Find the existing design
            $design = Designs::findOrFail($decodedId);

            $user_id = Auth::id();
    
             // Find or create the category and subcategory
             $category = Categories::firstOrCreate(['name' => $request->category, 'type' => $request->type]);

             // Now, attempt to find the subcategory by name and parent_id (category_id)
             $subCategory = Categories::firstOrCreate([
                 'name' => $request->sub_category,
                 'parent_id' => $category->id,
                 'type' => $request->type,
             ]);

            // Handle image update
            if ($request->hasFile('image')) {
                // Delete the old image
                if ($design->image_url && Storage::disk('public')->exists(str_replace('/storage/', '', $design->image_url))) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $design->image_url));
                }

                $timestamp = now()->format('YmdHis');
                $originalFileName = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
                $sanitizedFileName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalFileName);
                $extension = $request->file('image')->getClientOriginalExtension();
                $imageName = $timestamp . '_' . $sanitizedFileName . '.' . $extension;
                $path = $request->file('image')->storeAs('Designs', $imageName, 'public');
                $imagePath = "/storage/" . $path;
            } else {
                $imagePath = $design->image_url;
            }

            $categoryKey = CategoryKey::firstOrCreate(['key' => $request->category_key]);


            // Update the design record
            $design->update([
                'user_id' => $user_id,
                'name' => $request->name ?? null,
                'description' => $request->description ?? null,
                'category_id' => $subCategory->id,
                'category_key_id' => $categoryKey->id,
                'image_url' => $imagePath,
                'type' => $request->type,
                'unit_id' => $request->unit_id,
            ]);

            DB::commit();

            return redirect()->back()->with('message', 'Design updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update design. Please try again later.');
        }
    }

    public function destroy(string $encodedId)
    {
        DB::beginTransaction();

        try {
            $decodedId = base64_decode($encodedId);

            // Find the existing design
            $design = Designs::findOrFail($decodedId);

            // Delete the image from storage
            if ($design->image_url && Storage::disk('public')->exists(str_replace('/storage/', '', $design->image_url))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $design->image_url));
            }

            // Delete the design record
            $design->delete();

            DB::commit();

            return redirect()->back()->with('message', 'Design deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete design. Please try again later.');
        }
    }

}
