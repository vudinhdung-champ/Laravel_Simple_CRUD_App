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
            'chiSo' => $this->id,
            'tenNguoiHua' => $this->promiser_name,
            'noiDung' => $this->promise_content,
            'thoiDiemHua' => $startDate->format('d/m/Y'),
            'deadline' => $deadLine->format('d/m/Y'),
            'Trangthai' => $this->status,
            'doQuanTrong' => (int) $this->importance_level
        ];
    }
}
