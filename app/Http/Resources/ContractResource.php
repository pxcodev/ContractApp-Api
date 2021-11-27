<?php

namespace App\Http\Resources;

use App\Models\ContractStatus;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ContractResource extends JsonResource
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
                'contractType' => $this->whenLoaded('contractType'),
                'contractStatus' => $this->whenLoaded('contractStatus'),
            ],
            'relationships' => [
                'assistances' => AssistanceResource::collection($this->whenLoaded('assistances')),
                'assignments' => AssignmentsResource::collection($this->whenLoaded('assignments')),
                'payments' => PaymentResource::collection($this->whenLoaded('payments'))
            ]
        ];
    }
    public function formatTime($time)
    {
        return $time ? Carbon::createFromFormat('Y-m-d H:i:s', $time)->format('Y-m-d H:i:s') : $time;
    }
}
