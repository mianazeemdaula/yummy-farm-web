<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();
        $auth = $auth = auth()->user();
        if($auth->role == 'seller' || $auth->role == 'customer' ){
            abort(401,'You are not authorized');
        }
        $orders  = \App\Models\Order::count();
        $categories  = \App\Models\Category::count();
        $products = \App\Models\Product::count();
        return view('home', compact('users', 'orders', 'categories', 'products'));
    }
}
