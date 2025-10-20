<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Inventory;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems = Item::count(); // Number of unique items
        $totalStocks = Inventory::sum('quantity'); // Total quantity in stock
        $totalSales = Sale::sum('total_sales'); // Total sales amount

        return view('index', compact('totalItems', 'totalStocks', 'totalSales'));
    }
}