<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SaveInventoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'branch_auto_id' => 'required',
            'branch_id' => 'required',
            'type' => 'required',
            'bill_id' => 'required',
            'product_id' => 'required',
            'sku' => 'required',
            'batch_code' => 'required',
            'quantity' => 'required',
            'cost_price' => 'required',
            'sale_price' => 'required',
            'total' => 'required',
            'profit' => 'required',
            'is_sync' => 'required',
            'created_by' => 'required',
        ];
    }
}
