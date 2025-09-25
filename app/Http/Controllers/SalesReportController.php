<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Item;
use Carbon\Carbon;

class SalesReportController extends Controller
{
    // Show the sales report page
    public function index()
    {
        $items = Item::all();
        return view('sales-report', compact('items'));
    }

    // Fetch sales data for chart
    public function getSalesData(Request $request)
    {
        $items = $request->items ?? [];
        $startDate = $request->start_date ?? now()->startOfYear()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->endOfYear()->format('Y-m-d');

        $query = Sale::with('item')->whereBetween('date_tendered', [$startDate, $endDate]);

        if (!empty($items)) {
            $query->whereIn('item_id', $items);
        }

        $sales = $query->get();

        $chartData = [];

        foreach ($sales as $sale) {
            $month = Carbon::parse($sale->date_tendered)->format('F');
            $chartData[$sale->item->name][$month] = ($chartData[$sale->item->name][$month] ?? 0) + $sale->total_sales;
        }

        return response()->json($chartData);
    }
}