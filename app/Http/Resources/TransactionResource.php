<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PaymentResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return 
        [
            'id' => $this->id,
            'user_name' => $this->user->email,
            'amount' => $this->amount,
            'total_amount' => $this->total_amount,
            'due_on' => $this->due_on,
            'vat' => $this->vat,
            'is_vat_inclusive' => $this->is_vat_inclusive,
            'status' => $this->status,
            'payments' => PaymentResource::collection($this->payments)
        ];
    }
}
