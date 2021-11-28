<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PaymentMethodResource extends JsonResource
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
                'created_at'  => $this->formatTime($this->created_at),
                'updated_at'  => $this->formatTime($this->updated_at)
            ],
            'relationships' => [
                'payrollPayment' => PayrollPaymentResource::collection($this->whenLoaded('payrollPayment'))
            ]
        ];
    }
    public function formatTime($time)
    {
        return $time ? Carbon::createFromFormat('Y-m-d H:i:s', $time)->format('Y-m-d H:i:s') : $time;
    }
}
