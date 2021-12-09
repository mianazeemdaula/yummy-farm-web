<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $collection = Payment::all();
        return view('admin.payment.index', compact('collection'));
    }
}
