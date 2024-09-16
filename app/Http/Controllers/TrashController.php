<?php

namespace App\Http\Controllers;

use App\Models\CurrencyModel;
use App\Models\OrderModel;
use App\Models\OrderStatusModel;
use App\Models\PriceOffersModel;
use App\Models\User;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function index(){
        $currency = CurrencyModel::get();
        $data = OrderModel::where('delete_status', 1)->orderBy('id','DESC')->get();
        foreach ($data as $key) {
            $key->user = User::where('id', $key->user_id)->first();
            $key->supplier = PriceOffersModel::where('order_id', $key->id)->get();
            foreach ($key->supplier as $child) {
                $child->name = User::select('name')->where('id', $child->supplier_id)->first();
            }
        }
        $supplier = User::where('user_role', 4)->get();
        return view('admin.trash.index', ['data' => $data, 'currency' => $currency, 'supplier' => $supplier]);
    }

    public function updateOrderStatus($id){
        $data = OrderModel::find($id);
        $data->delete_status = 0;
        if ($data->save()){
            return redirect()->route('trash.index')->with(['success'=>'تم حفظ البيانات بنجاح']);
        }
    }
}
