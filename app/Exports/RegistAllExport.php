<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class RegistAllExport extends DefaultValueBinder implements FromCollection, WithMapping, WithHeadings, WithStyles, WithColumnWidths, WithCustomValueBinder
{
    protected $data;
    protected $createdFrom;
    protected $createdTo;
    private $row = 0;

    public function __construct($data,$createdFrom,$createdTo)
    {
        $this->data = $data;
        $this->createdFrom = $createdFrom;
        $this->createdTo = $createdTo;
    }

    public function collection()
    {
        return $this->data;
    }

    public function bindValue(Cell $cell, $value)
    {
        if ($cell->getColumn() == 'BT') {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        return parent::bindValue($cell, $value);
    }

    public function map($data): array
    {
        return [
            ++$this->row,
            $data->period,
            $data->no_regist,
            $data->name,
            $data->gender,
            $data->phase,
            $data->grade,
            $data->major,
            $data->status,
            $data->created_at,
            $data->receive_created_at,
            $data->nickname,
            $data->place,
            $data->birthday,
            $data->religion,
            $data->citizen,
            $data->birthday_id,
            $data->family_id,
            $data->kip,
            $data->pip,
            $data->kps,
            $data->kps_id,
            $data->family_status,
            $data->child_no,
            $data->child_qty,
            $data->blood,
            $data->glass,
            $data->height,
            $data->weight,
            $data->head_size,
            $data->distance,
            $data->time_hh,
            $data->time_mm,
            $data->transport,
            $data->stay,
            $data->stay_rt,
            $data->stay_rw,
            $data->stay_village,
            $data->stay_distric,
            $data->stay_city,
            $data->stay_province,
            $data->stay_address,
            $data->stay_postal,
            $data->stay_latitude,
            $data->stay_longitude,
            $data->home_rt,
            $data->home_rw,
            $data->home_village,
            $data->home_distric,
            $data->home_city,
            $data->home_province,
            $data->home_address,
            $data->home_postal,
            $data->home_latitude,
            $data->home_longitude,
            $data->id_card,
            $data->hp_student,
            $data->hp_parent,
            $data->hp_parent2,
            $data->email_student,
            $data->email_parent,
            $data->email_parent2,
            $data->school_name,
            $data->school_year,
            $data->school_nem_avg,
            $data->school_sttb_avg,
            $data->nisn,
            $data->exam_un_no,
            $data->skhun_no,
            $data->certificate_no,
            $data->no_account,
            $data->no_account2,
            $data->remark,
            $data->user,
            $data->updated_at,
        ];
    }

    public function headings(): array
    {
        return [
            [
                'DATA LENGKAP PENDAFTARAN',
            ],
            [' '],
            [
                $this->createdFrom.' s/d '.$this->createdTo,
            ],
            [' '],
            [
                'No',
                'Periode',
                'Nomor',
                'Nama',
                'JK',
                'Gelombang',
                'Kelompok',
                'Jurusan',
                'Status',
                'Tgl Daftar',
                'Tgl Diterima',
                'Nama Panggilan',
                'Tempat Lahir',
                'Tgl Lahir',
                'Agama',
                'Kewarganegaraan',
                'No. Akta Lahir',
                'No. Kartu Keluarga',
                'KIP',
                'PIP',
                'KPS',
                'No. KPS',
                'Status Dalam Keluarga',
                'Anak Ke-',
                'Jumlah Saudara',
                'Golongan Darah',
                'Kacamata',
                'Tinggi Badan',
                'Berat Badan',
                'Lingkar Kepala',
                'Jarak Tempat Tinggal',
                'Waktu Tempuh (jam)',
                'Waktu Tempuh (menit)',
                'Transportasi',
                'Jenis Tinggal',
                'RT (Tinggal)',
                'RW (Tinggal)',
                'Kelurahan (Tinggal)',
                'Kecamatan (Tinggal)',
                'Kota/Kabupaten (Tinggal)',
                'Provinsi (Tinggal)',
                'Alamat (Tinggal)',
                'Kode Pos (Tinggal)',
                'Lintang (Tinggal)',
                'Bujur (Tinggal)',
                'RT (Rumah)',
                'RW (Rumah)',
                'Kelurahan (Rumah)',
                'Kecamatan (Rumah)',
                'Kota/Kabupaten (Rumah)',
                'Provinsi (Rumah)',
                'Alamat (Rumah)',
                'Kode Pos (Rumah)',
                'Lintang (Rumah)',
                'Bujur (Rumah)',
                'NIK',
                'No. HP',
                'No. HP Ayah',
                'No. HP Ibu',
                'Email',
                'Email Ayah',
                'Email Ibu',
                'Asal Sekolah',
                'Tahun Lulus',
                'Rata-rata Nilai NEM',
                'Rata-rata Nilai STTB',
                'NISN',
                'No. Peserta UN',
                'No. SKHUN',
                'No. Ijazah',
                'No. Rekening Pendaftaran',
                'No. Rekening Pembayaran',
                'Keterangan',
                'User',
                'Update',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->mergeCells('A1:N1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A3:D3');
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A5:N5')->getAlignment()->setHorizontal('center');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 7,
            'C' => 7,
            'D' => 50,
            'E' => 10,
            'F' => 12,
            'G' => 11,
            'H' => 8,
            'I' => 15,
            'J' => 18,
            'K' => 18,
        ];
    }
}
