<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PromiseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $startDate = Carbon::parse($this->date_made);

        $deadLine = Carbon::parse($this->deadline);


        return [
            'id' => $this->id,
            'promiser_name' => $this->promiser_name,
            'promise_content' => $this->promise_content,
            'date_made' => $startDate->format('d/m/Y'),
            'deadline' => $deadLine->format('d/m/Y'),
            'status' => $this->status,
            'importance_level' => (int) $this->importance_level
        ];
    }
}
