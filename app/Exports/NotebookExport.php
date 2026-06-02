<?php

namespace App\Exports;

use App\Models\Notebook;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class NotebookExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function title(): string
    {
        return 'Ghi chú';
    }

    // Lấy dữ liệu từ database //
    public function collection()
    {
        return Notebook::where('user_id', $this->userId)->get();
    }

    public function headings(): array
    {
        return ['ID', 'Tiêu đề', 'Nội dung', 'Danh mục', 'Ngày tạo', 'Ngày cập nhật'];
    }

    public function map($notebook): array
    {
        return [
            $notebook->id,
            $notebook->title,
            $notebook->content,
            $notebook->category,
            $notebook->created_at,
            $notebook->updated_at,
        ];
    }
}
