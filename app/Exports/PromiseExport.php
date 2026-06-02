<?php

namespace App\Exports;

use App\Models\Promise;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;


class PromiseExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function title(): string
    {
        return 'Lời hứa';
    }

    // Lấy dữ liệu từ database //
    public function collection()
    {
        return Promise::where('user_id', $this->userId)->get();
    }

    public function headings(): array
    {
        return ['ID', 'Tên người hứa', 'Lời hứa', 'Ngày hứa', 'Hạn chót', 'Trạng thái', 'Mức độ ưu tiên', 'Ngày cập nhật'];
    }

    public function map($promise): array
    {
        return [
            $promise->id,
            $promise->promiser_name,
            $promise->promise_content,
            $promise->date_made,
            $promise->deadline,
            $promise->status,
            $promise->importance_level,
            $promise->updated_at,  
        ];
    }
}
