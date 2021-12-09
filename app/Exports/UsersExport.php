<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::where('role','customer')->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'firstname',
            'Business Name',
            'Username',
            'Email',
            'Address',
            'Address Line 2',
            'Country',
            'Phone',
            'VAT',
            'Bank Account',
            'RPR',
            'Status',
            'Signup Date',
        ];
    }

    public function map($seller): array
    {
        return [
            $seller->id,
            $seller->name,
            $seller->firstname,
            $seller->business_name,
            $seller->username,
            $seller->email,
            $seller->address,
            $seller->address_line_2,
            $seller->country,
            $seller->phone,
            $seller->vat,
            $seller->bank_account,
            $seller->rpr,
            $seller->status,
            $seller->created_at,
        ];
    }
}
