<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class ChangePayExport implements FromCollection, WithMapping, WithHeadings, WithStyles, WithColumnWidths
{
    protected $data;
    private $row = 0;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function map($data): array
    {
        return [
            ++$this->row,
            $data->period,
            $data->phase,
            $data->no_regist,
            $data->name,
            $data->grade_from,
            $data->grade_to,
            $data->major_from,
            $data->major_to,
            $data->bill_from,
            $data->bill_to,
            $data->amount,
            $data->balance_from,
            $data->balance_to,
            $data->user,
            $data->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            [
                'DATA PERUBAHAN',
            ],
            [' '],
            [
                'No',
                'Periode',
                'Gelombang',
                'Nomor',
                'Nama',
                'Dari Kelompok',
                'Menjadi Kelompok',
                'Dari Jurusan',
                'Menjadi Jurusan',
                'Dari Tagihan',
                'Menjadi Tagihan',
                'Dibayar',
                'Dari Selisih',
                'Menjadi Selisih',
                'User',
                'Update',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A3:P3')->getFont()->setBold(true);
        $sheet->mergeCells('A1:P1');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 7,
            'C' => 12,
            'D' => 7,
            'E' => 50,
            'F' => 15,
            'G' => 17,
            'H' => 15,
            'I' => 15,
            'J' => 15,
            'K' => 15,
            'L' => 15,
            'M' => 15,
            'N' => 15,
            'O' => 20,
            'P' => 20,
        ];
    }
}
