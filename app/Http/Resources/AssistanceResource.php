<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AssistanceResource extends JsonResource
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
                'contract_id' => $this->contract_id,
                'worker_id' => $this->worker_id,
                'hoursWorked' => $this->hoursWorked,
                'assistanceDate' => $this->assistanceDate,
                'assistance' => $this->assistance,
                'created_at'  => $this->formatTime($this->created_at),
                'updated_at'  => $this->formatTime($this->updated_at)
            ],
            'relationships' => [
                'contract' => ContractResource::make($this->whenLoaded('contract')),
                'worker' => WorkerResource::make($this->whenLoaded('worker'))
            ]
        ];
    }
    public function formatTime($time)
    {
        return $time ? Carbon::createFromFormat('Y-m-d H:i:s', $time)->format('Y-m-d H:i:s') : $time;
    }
}
