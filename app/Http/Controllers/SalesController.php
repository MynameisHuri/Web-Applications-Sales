<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Item;
use App\Models\Inventory;
use Carbon\Carbon;

class SalesController extends Controller
{

    public function index()
    {
        $sales = Sale::with('item')->get();

        $items = Item::with('inventory')->get();

        return view('sales', compact('sales', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $inventory = Inventory::where('item_id', $request->item_id)->first();
        if (!$inventory || $request->quantity > $inventory->quantity) {
            return redirect()->back()->with('error', 'Quantity exceeds available stock!');
        }

        $item = Item::find($request->item_id);
        $total_sales = $item->price * $request->quantity;

        Sale::create([
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'total_sales' => $total_sales,
            'date_tendered' => Carbon::now(),
        ]);

        $inventory->quantity -= $request->quantity;
        $inventory->save();

        return redirect()->back()->with('success', 'Sale added successfully!');
    }
}