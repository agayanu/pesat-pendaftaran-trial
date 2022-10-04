<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class PayExport implements FromCollection, WithMapping, WithHeadings, WithStyles, WithColumnWidths
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
            $data->grade,
            $data->major,
            $data->bill,
            $data->amount,
            $data->balance,
        ];
    }

    public function headings(): array
    {
        return [
            [
                'DATA PEMBAYARAN',
            ],
            [' '],
            [
                'No',
                'Periode',
                'Gelombang',
                'Nomor',
                'Nama',
                'Kelompok',
                'Jurusan',
                'Tagihan',
                'Jumlah',
                'Selisih',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A3:J3')->getFont()->setBold(true);
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 7,
            'C' => 12,
            'D' => 7,
            'E' => 50,
            'F' => 12,
            'G' => 12,
            'H' => 12,
            'I' => 12,
            'J' => 12,
        ];
    }
}
