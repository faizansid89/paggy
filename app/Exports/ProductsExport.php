<?php

namespace App\Exports;

use App\Models\Products;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

// , WithMapping, WithChunkReading

class ProductsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $rows;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    public function collection()
    {
        return Products::whereIn('id', $this->rows)->get(['id', 'name', 'sku', 'created_at']);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Product Name',
            'SKU',
            'Created At',
        ];
    }

//    public function map($row): array
//    {
//        return [
//            $row->id,
//            $row->name,
//            $row->sku,
//            Carbon::parse($row->created_at)->toDateString(),
//        ];
//    }
//
//    public function chunkSize(): int
//    {
//        return 1000;
//    }
}
