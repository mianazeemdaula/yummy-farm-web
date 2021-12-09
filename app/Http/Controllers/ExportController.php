<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SellersExport;
use App\Exports\UsersExport;
use App\Exports\OrdersExport;
use App\Exports\PaymentsExport;

class ExportController extends Controller
{
    public function sellers()
    {
        return Excel::download(new SellersExport, 'sellers.xlsx');
    }

    public function users()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function orders()
    {
        return Excel::download(new OrdersExport, 'orders.xlsx');
    }

    public function payments()
    {
        return Excel::download(new PaymentsExport, 'payments.xlsx');
    }
}
