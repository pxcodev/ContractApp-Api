<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class WorkerResource extends JsonResource
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
                'names' => $this->resource->names,
                'surnames' => $this->resource->surnames,
                'identificationDocument' => $this->resource->identificationDocument,
                'gender' => $this->resource->gender,
                'nationality' => $this->resource->nationality,
                'workerAddress' => $this->resource->workerAddress,
                'phone' => $this->resource->phone,
                'registrationDate' => $this->resource->registrationDate,
                'worker_type_id' => $this->resource->worker_type_id,
                'hourly' => $this->resource->hourly,
                'delete' => $this->resource->delete,
                'created_at'  => $this->formatTime($this->resource->created_at),
                'updated_at'  => $this->formatTime($this->resource->updated_at),
                'workerType' => $this->whenLoaded('workerType'),
            ],
            'relationships' => [
                'assistances' => AssistanceResource::collection($this->whenLoaded('assistances')),
                'assignments' => AssignmentsResource::collection($this->whenLoaded('assignments')),
                'payrollPayment' => PayrollPaymentResource::collection($this->whenLoaded('payrollPayment')),
            ]
        ];
    }
    public function formatTime($time)
    {
        return $time ? Carbon::createFromFormat('Y-m-d H:i:s', $time)->format('Y-m-d H:i:s') : $time;
    }
}
