<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentsExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Payment::all();
    }

    public function headings(): array
    {
        return [
            '#',
            'Order #',
            'Payment',
            'Status',
            'Date',
        ];
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->id,
            $order->id,
            $order->id,
            $order->created_at,
        ];
    }
}
