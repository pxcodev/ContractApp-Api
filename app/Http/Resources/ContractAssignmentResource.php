<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ContractAssignmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'contractAddress' => $this->contractAddress,
                'contract_type_id' => $this->contract_type_id,
                'contract_status_id' => $this->contract_status_id,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'totalCost' => $this->totalCost,
                'delete' => $this->delete,
                'created_at'  => $this->formatTime($this->created_at),
                'updated_at'  => $this->formatTime($this->updated_at),
                'checked' => $this->checked
            ],
            'relationships' => [
                'assignments' => $this->assignments
            ]
        ];
    }
    public function formatTime($time)
    {
        return $time ? Carbon::createFromFormat('Y-m-d H:i:s', $time)->format('Y-m-d H:i:s') : $time;
    }
}
