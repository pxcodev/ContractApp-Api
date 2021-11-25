<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class WorkerAssignmentResource extends JsonResource
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
                'names' => $this->names,
                'surnames' => $this->surnames,
                'identificationDocument' => $this->identificationDocument,
                'gender' => $this->gender,
                'nationality' => $this->nationality,
                'workerAddress' => $this->workerAddress,
                'phone' => $this->phone,
                'registrationDate' => $this->registrationDate,
                'worker_type_id' => $this->worker_type_id,
                'hourly' => $this->hourly,
                'delete' => $this->delete,
                'created_at'  => $this->formatTime($this->created_at),
                'updated_at'  => $this->formatTime($this->updated_at),
                'checked' => $this->checked
            ],
            'relationships' => [
                'assignments' => $this->resource->assignments
            ]
        ];
    }
    public function formatTime($time)
    {
        return $time ? Carbon::createFromFormat('Y-m-d H:i:s', $time)->format('Y-m-d H:i:s') : $time;
    }
}
