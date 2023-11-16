<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'month' => $this->month,
            'year' => $this->year,
            'paid' => $this->paid?$this->paid:0,
            'outstanding' => $this->outstanding,
            'overdue' => $this->overdue
        ];
    }
}
