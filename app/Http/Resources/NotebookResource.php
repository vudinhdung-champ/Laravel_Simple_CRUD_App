<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class NotebookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $startDate = Carbon::parse($this->created_at);
    
        return [
            'chiSo' => $this->id,
            'tieuDe' => $this->title,
            'noiDung' => $this->content,
            'theLoai' => $this->category,
            'ngayTao' => $startDate->format('d/m/Y')

        ];
    }
}
