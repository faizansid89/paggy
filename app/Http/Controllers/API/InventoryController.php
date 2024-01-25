<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;

class InventoryController extends Controller
{
    public function getInventoryByBranch($branch_id)
    {
        $inventories = Inventory::where('branch_id', $branch_id)->get();
        $success['data'] = $inventories;
        $success['msg'] = 'successfully!';
        $success['status'] = 200;
        $success['success'] = true;
        return response()->json($success);
    }

    public function inventories_by_product_unit_branch($product_id, $unit_id, $branch_id)
    {
        $inventory = Inventory::with(['productUnitStatus' => function ($q) use ($unit_id) {
            $q->where('unit_id', $unit_id);
        }])
            ->where('product_id', $product_id)
            ->where('branch_id', $branch_id)
            ->first();

        if ($inventory && $inventory->productUnitStatus->isNotEmpty()) {
            foreach ($inventory->productUnitStatus as $status) {
                $status->cost_price = round($status->cost_price, 2); // Round to 2 decimal places
                $status->sale_price = round($status->sale_price, 2); // Round to 2 decimal places
            }
        }

        $success['data'] = $inventory;
        $success['msg'] = 'successfully!';
        $success['status'] = 200;
        $success['success'] = true;
        return response()->json($success);
    }

}
