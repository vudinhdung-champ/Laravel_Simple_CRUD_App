<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $targetDate = Carbon::parse($this->next_billing_date);

        $daysLeft = now()->diffInDays($targetDate, false);
        $thong_bao_han = "";
        if ($daysLeft < 0) {
            $thong_bao_han = "Đã hết hạn " . abs((int) $daysLeft) . " ngày";
        } else if ($daysLeft == 0) {
            $thong_bao_han = "Đến hạn thanh toán hôm nay";
        } else if ($daysLeft > 0) {
            $thong_bao_han = "Còn " . (int) $daysLeft . " ngày nữa là đến hạn";
        }
        return [
            'id' => (int) $this->id,
            'service_name' => $this->service_name,
            'price' => (float) $this->price,
            'billing_cycle' => $this->billing_cycle,
            'status' => $this->status,
            'color_code' => $this->color_code,
            'notes' => $this->notes,
            'next_billing_date' => $targetDate->format('d/m/Y'),
            'alert_message' => $thong_bao_han,
            'is_red_alert' => $daysLeft <= 3 ? true : false
        ];
    }
}
