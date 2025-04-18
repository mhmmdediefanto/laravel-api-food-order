<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::latest()->paginate(10);
        return response()->json([
            'message' => 'Data Items',
            'count' => $items->count(),
            'data' => [
                'items' => $items,
                'status' => 200
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required',
            'category' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|mimes:png,jpg,jpeg,gif,svg,webp|max:2048',
        ]);

        if ($request->image) {
            $imagePath = $request->file('image')->store('items', 'public');
            $validatedData['image'] = $imagePath;
        }


        $item = Item::create($validatedData);

        return response()->json([
            'message' => 'Item created successfully.',
            'data' => $item,
            'status' => 200
        ]);
    }

    public function update(Request $request, Item $item)
    {
        // dd(request()->all());
        try {
            $rules = [
                'name' => 'required|max:255',
                'price' => 'required',
                'image' => 'nullable|mimes:png,jpg,jpeg,gif,svg,webp|max:2048',
            ];

            $validatedData = $request->validate($rules);
            if ($request->image) {
                if ($item->image) {
                    if (Storage::disk('public')->exists($item->image)) {
                        Storage::disk('public')->delete($item->image);
                    }
                }
                $validatedData['image'] = $request->file('image')->store('items', 'public');
            }

            $validatedData['user_id'] = Auth::user()->id;

            $item->update($validatedData);

            return response()->json([
                'message' => 'Item updated successfully.',
                'data' => $item,
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($id)
    {
        $produkId = Item::find($id);
        if (!$produkId) {
            return response()->json([
                'message' => 'Data produk not found',
                'status' => 404
            ], 200);
        }

        return response()->json([
            'message' => 'Data produk',
            'data' => $produkId,
            'status' => 200,
        ], 200);
    }

    public function destroy($id)
    {
        $item = Item::find($id);
        if (!$item) {
            return response()->json([
                'message' => 'Data produk not found',
                'status' => 404
            ], 200);
        }

        if ($item->image) {
            Storage::delete($item->image);
        }

        $item->delete();

        return response()->json([
            'message' => 'Data produk deleted successfully',
            'status' => 200
        ], 200);
    }
}
