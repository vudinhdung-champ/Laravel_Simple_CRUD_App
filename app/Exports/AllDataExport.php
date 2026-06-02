<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AllDataExport implements WithMultipleSheets
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Trả về mảng các sheet — mỗi phần tử là 1 sheet trong file Excel
     */
    public function sheets(): array
    {
        return [
            'Đăng ký dịch vụ' => new SubscriptionExport($this->userId),
            'Lời hứa'         => new PromiseExport($this->userId),
            'Ghi chú'         => new NotebookExport($this->userId),
        ];
    }
}
