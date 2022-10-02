<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ExpenseCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($expense){
                return [
                    'id' => $expense->id,
                    'expense_date' => $expense->expense_date->format('d-m-Y'),
                    'reasons' => $expense->reasons,
                    'amount' => $expense->amount,
                    'posted_by' => $expense->admin->name,
                    'expensecat_details' => $expense->expensecategory,
                    'expensecategory' => $expense->expensecategory->name,
                    'created_at' => $expense->created_at->format('d-m-Y g:i a'),
                ];
            })
        ];
    }
}
