<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Inventory;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        // Count all items
        $totalItems = Item::count();
        // Sum all inventory quantities (total stocks)
        $totalStocks = Inventory::sum('quantity');
        // Sum all sales
        $totalSales = Sale::sum('total_sales');

        return view('index', compact('totalItems', 'totalStocks', 'totalSales'));
    }
}
