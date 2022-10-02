<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeeCustCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function($employeecust){
                return [
                    'id' => $employeecust->id,
                    'employee_id' => $employeecust->employee_id,
                    'customers_array' => $employeecust->customers_array,
                    'from' => $employeecust->from,
                    'to' => $employeecust->to,
                    'fromformatted' => $employeecust->from->format('d-F-Y'),
                    'toformatted' => $employeecust->to->format('d-F-Y'),
                    'updated_at' => $employeecust->created_at->format('d-m-Y g:i a'),
                ];
            })
        ];
    }
}
