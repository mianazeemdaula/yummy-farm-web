<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::with(['customer','seller'])->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Business name seller',
            'VAT number seller',
            'E-mail seller',
            'Payment receipt number',
            'Payment date',
            'Price excl VAT',
            'Price incl VAT',
            'Name customer',
            'First name customer',
            'E-mail customer',
        ];
    }

    public function map($order): array
    {
        return [
            $order->number,
            $order->seller->name,
            $order->seller->vat,
            $order->seller->email,
            $order->payment_id,
            $order->payment_date,
            $order->total_price / 1.21,
            $order->total_price,
            $order->customer->name,
            $order->customer->firstname,
            $order->customer->email,
        ];
    }
}
