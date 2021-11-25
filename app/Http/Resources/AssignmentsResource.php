<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentsResource extends JsonResource
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
            'id' => $this->resource->id,
            'attributes' => [
                'contract_id' => $this->resource->contract_id,
                'worker_id' => $this->resource->worker_id,
                'delete' => $this->resource->delete,
            ],
            'relationships' => [
                'contract' => ContractResource::make($this->whenLoaded('contract')),
                'worker' => WorkerResource::make($this->whenLoaded('worker'))
            ]
        ];
    }
}
