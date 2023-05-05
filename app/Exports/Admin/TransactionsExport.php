<?php

namespace App\Exports\Admin;

use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Excel;

class TransactionsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    private $query;

    private $fileName = 'transactions.xlsx';

    private $writerType = Excel::XLSX;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query->latest('id');
    }

    public function headings(): array
    {
        return [
            'ID',
            'KODE',
            'PROGRAM',
            'NAMA',
            'EMAIL',
            'NOMOR TELEPON',
            'NOMINAL DONASI',
            'KODE UNIK',
            'STATUS',
            'TANGGAL TRANSAKSI',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->code,
            $row->campaign_name,
            $row->user_name,
            $row->user_email,
            $row->user_phone,
            $row->amount,
            $row->unique_code,
            $row->status,
            $row->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
