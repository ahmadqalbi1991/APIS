<?php

namespace App\Http\Controllers\Admin;

use App\Asset;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::with('customer')->whereHas('customer')->latest()->get();

        return view('admin.pages.orders', compact('orders'));
    }

    public function create() {
        $assets = Asset::with('user')->whereHas('user')->get();
        $customers = User::where(['role' => 'management', 'is_admin' => 0, 'is_verified' => 1])->get();
        return view('admin.pages.create-order', compact('assets', 'customers'));
    }

    public function store(Request $request) {
        $input = $request->except('_token');
        $input['created_by'] = \Auth::id();
        Order::create($input);

        return redirect()->route('admin.orders.index');
    }

    public function getCustomerId(Request $request) {
        $id = $request->get('id');
        $order = Order::find($id);

        return $order;
    }
}
