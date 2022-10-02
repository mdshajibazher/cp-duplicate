<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\App;

class IsCapableToTransferStock implements Rule
{
    private $transferFromWarehouseId;
    private $productId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($transfer_from_warehouse_id,$product_id)
    {
       $this->transferFromWarehouseId = $transfer_from_warehouse_id;
       $this->productId = $product_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $qty)
    {
        if(!empty($qty) && !empty($this->transferFromWarehouseId) && !empty($this->productId)){
            $stock =  App::call('App\Http\Controllers\StockController@_getStockQtyByProductID',['product_id' => $this->productId, 'warehouse_id'=> $this->transferFromWarehouseId]);
            return $stock > $qty;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Stock is not transferable';
    }
}
