<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Item;
use Carbon\Carbon;

class InventoryController extends Controller
{
    // Show the Inventory Page
    public function index()
    {
        $inventories = Inventory::with('item')->get();
        $items = Item::all();
        return view('inventory', compact('inventories', 'items'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $inventory = Inventory::where('item_id', $request->item_id)->first();

        if ($inventory) {
            $inventory->quantity += $request->quantity;
            $inventory->save();
        } else {
            Inventory::create([
                'item_id' => $request->item_id,
                'quantity' => $request->quantity,
                'date_added' => Carbon::now(),
            ]);
        }

        return redirect()->back()->with('success', 'Inventory updated successfully!');
    }
}