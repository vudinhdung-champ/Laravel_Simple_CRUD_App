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
        if($daysLeft < 0)
        {
            $thong_bao_han = "Đã hết hạn " . abs((int)$daysLeft) . " ngày";
        }
        else if($daysLeft == 0)
        {
            $thong_bao_han = "Đến hạn thanh toán hôm nay";
        }
        else if($daysLeft > 0)
        {
            $thong_bao_han = "Còn " . (int)$daysLeft . " ngày nữa là đến hạn";
        }
        return [
            'chiSo' => (int) $this->id,
            'tenDichVu' => $this->service_name,
            'giaTien' => (float) $this->price,
            'chuKy' => $this->billing_cycle,
            'trangThai' => $this->status,
            'mauSac' => $this->color_code,
            'ghiChu' => $this->notes,
            'ngayThuTien' => $targetDate->format('d/m/Y'),
            'hienThiHanMuc' => $thong_bao_han,
            'laBaoDongDo' => $daysLeft <= 3 ? true : false
        ];
    }
}
