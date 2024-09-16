<?php

namespace App\Http\Controllers;

use App\Models\CashPaymentsModel;
use App\Models\OrderModel;
use App\Models\PriceOffersModel;
use App\Models\ProductModel;
use App\Models\TasksModel;
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
        $order_count = OrderModel::count();
        $product_count = ProductModel::count();
        $supplier_count = User::where('user_role',4)->count();
        $task_count = TasksModel::count();
        $data = OrderModel::join('price_offers', 'price_offers.order_id', '=', 'orders.id')->where('orders.order_status' ,'!=', -1)->take(5)->orderBy('orders.id', 'desc')->get();
        foreach ($data as $key) {
            $key->user = User::where('id', $key->user_id)->first();
            $carbonDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $key->created_at);
            $key->created_at = $carbonDate->format('Y-m-d');
            $key->supplier = PriceOffersModel::where('order_id', $key->order_id)->get();
            foreach ($key->supplier as $child) {
                $child->name = User::select('name')->where('id', $child->supplier_id)->first();
            }
        }
        return view('admin.home', ['data' => $data,'order_count'=>$order_count,'product_count'=>$product_count,'supplier_count'=>$supplier_count,'task_count'=>$task_count]);
    }
}
