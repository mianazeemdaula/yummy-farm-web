<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inbox;

class ChatController extends Controller
{
    public function index()
    {
        $collection = Inbox::with(['seller','customer'])->get();
        return view('admin.chat.index', compact('collection'));
    }
}
