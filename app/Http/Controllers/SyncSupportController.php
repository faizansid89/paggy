<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SyncSupportController extends Controller
{
    public function fetchSalesWithItems(Request $request)
    {
        $productController = new \App\Http\Controllers\API\ProductController();
        $data =  $productController->fetchSalesWithItems($request->branch_url);
        return redirect()->back()->with("message", "Run successfully.");
    }
    public function fetchInventory(Request $request)
    {
        $productController = new \App\Http\Controllers\API\ProductController();
        $data =  $productController->fetchInventory($request->branch_url);
        return redirect()->back()->with("message","Run successfully.");
    }
    public function fetchMissSale(Request $request)
    {
        $productController = new \App\Http\Controllers\API\ProductController();
        $data =  $productController->fetchMissSale($request->branch_url);
        return redirect()->back()->with("message","Run successfully.");
    }
    public function fetchOpeningBalance(Request $request)
    {
        $productController = new \App\Http\Controllers\API\ProductController();
        $data =  $productController->fetchOpeningBalance($request->branch_url);
        return redirect()->back()->with("message","Run successfully.");
    }
    public function fetchCustomers(Request $request)
    {
        $productController = new \App\Http\Controllers\API\ProductController();
        $data =  $productController->fetchCustomers($request->branch_url);
        return redirect()->back()->with("message","Run successfully.");
    }
    public function fetchReturnSales(Request $request)
    {
        $productController = new \App\Http\Controllers\API\ProductController();
        $data =  $productController->fetchReturnSales($request->branch_url);
        return redirect()->back()->with("message","Run successfully.");
    }


}
