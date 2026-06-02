<?php

namespace App\Exports;

use App\Models\Subscription;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class SubscriptionExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $userId;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    // Lấy dữ liệu từ database // 

    public function collection()
    {
        return Subscription::where('user_id', $this->userId)->get();
    }

    public function title(): string
    {
        return 'Đăng ký dịch vụ';
    }

    public function headings(): array
    {
        return ['ID', 'Tên dịch vụ', 'Giá tiền (đơn vị đồng)', 'Chu kỳ', 'Ngày thu tiếp theo', 'Trạng thái'];
    }

    public function map($subscription): array
    {
        return [
            $subscription->id,
            $subscription->service_name,
            $subscription->price * 1000,
            $subscription->billing_cycle,
            $subscription->next_billing_date,
            $subscription->status,
            
        ];

    }

}
