<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    // Display all items
    public function index() {
        $items = Item::all();
        return view('item', compact('items'));
    }

    // Store a new item
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric'
        ]);

        Item::create($request->all());
        return redirect()->back()->with('success', 'Item added successfully!'); // green
    }

    // Update an existing item
    public function update(Request $request, Item $item) {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric'
        ]);

        $item->update($request->all());
        return redirect()->back()->with('update', 'Item updated successfully!'); // yellow
    }

    // Delete an item
    public function destroy(Item $item) {
        $item->delete();
        return redirect()->back()->with('delete', 'Item deleted successfully!'); // red
    }
}