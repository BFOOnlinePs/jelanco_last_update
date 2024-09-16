<?php

namespace App\Http\Controllers\storekeeper;

use App\Http\Controllers\Controller;
use App\Models\CurrencyModel;
use App\Models\OrderModel;
use App\Models\OrderStatusModel;
use App\Models\PriceOffersModel;
use App\Models\User;
use App\Models\UserCategoryModel;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $order_status = OrderStatusModel::get();
        $currency = CurrencyModel::get();
        $users = User::whereIn('user_role',[1,2,3])->orWhere('id',1)->get();
        $data = OrderModel::where('order_status', 1)->orderBy('id','DESC')->get();
        foreach ($data as $key) {
            $key->user = User::where('id', $key->user_id)->first();
            $key->supplier = PriceOffersModel::where('order_id', $key->id)->get();
            foreach ($key->supplier as $child) {
                $child->name = User::select('name')->where('id', $child->supplier_id)->first();
            }
        }
        $supplier = User::where('user_role', 4)->get();
        $user_category = UserCategoryModel::get();
        return view('admin.orders.storekeeper.orders.index', ['data' => $data, 'currency' => $currency, 'users'=>$users , 'supplier' => $supplier,'order_status'=>$order_status,'user_category'=>$user_category]);
    }
}
