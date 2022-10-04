<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class PayTrExport implements FromCollection, WithMapping, WithHeadings, WithStyles, WithColumnWidths
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
            $data->method,
            $data->transfer_date,
            $data->transfer_no,
            $data->remark,
            $data->amount,
            $data->tr_at,
            $data->created_at,
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
                'Metode',
                'Tgl Transfer',
                'No. Transfer',
                'Keterangan',
                'Jumlah',
                'Tgl Transaksi',
                'Update',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A3:N3')->getFont()->setBold(true);
        $sheet->mergeCells('A1:N1');
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
            'K' => 12,
            'L' => 12,
            'M' => 12,
            'N' => 18,
        ];
    }
}
