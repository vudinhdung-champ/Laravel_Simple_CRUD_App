<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Str;

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
        $isList = $request->route()->getActionMethod() === 'index';

        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $isList ? Str::limit($this->content, 150) : $this->content,
            'category' => $this->category,
            'createdAt' => $startDate->format('d/m/Y')

        ];
    }
}
