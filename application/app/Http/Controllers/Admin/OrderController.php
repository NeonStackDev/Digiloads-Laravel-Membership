<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(){
        $pageTitle = "Orders List";
        $orders = Order::with(['product','user'])->orderBy('created_at','desc')->paginate(getPaginate());
        return view('admin.orders.index',compact('orders','pageTitle'));
    }

    public function orderDetail($id){
        $pageTitle = "Order Details";
        $orderDetails = Order::with(['product','user', 'product.productImages'])->find($id);
        return view('admin.orders.order_details',compact('orderDetails','pageTitle'));

    }

}
