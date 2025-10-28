<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DeliveredClothingExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($item) {
            return [
                'الاسم' => $item->name,
                'رقم الهوية' => $item->id_num,
                'عدد الأطفال' => $item->children_count,
                'المبلغ' => $item->amount,
                'تاريخ الاستحقاق' => $item->due_date,
                'تاريخ الاستلام' => $item->receipt_date,
                'اسم المشروع' => optional($item->project)->name,
                'مكان التسليم' => optional($item->distributionPlace)->name,
                'ملاحظات' => $item->notes,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'الاسم',
            'رقم الهوية',
            'عدد الأطفال',
            'المبلغ',
            'تاريخ الاستحقاق',
            'تاريخ الاستلام',
            'اسم المشروع',
            'مكان التسليم',
            'ملاحظات'
        ];
    }
}

