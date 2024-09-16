<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use App\Models\OrderStatusModel;
use App\Models\PriceOffersModel;
use App\Models\User;
use Illuminate\Http\Request;

class OrderArchiveController extends Controller
{
    public function index(){
        $data = OrderModel::where('order_status',10)->orderBy('id','DESC')->get();
        $users = User::whereIn('user_role',[1,2,3])->orWhere('id',1)->get();
        $order_status = OrderStatusModel::get();
        foreach ($data as $key) {
            $key->user = User::where('id', $key->user_id)->first();
            $key->supplier = PriceOffersModel::where('order_id', $key->id)->get();
            foreach ($key->supplier as $child) {
                $child->name = User::select('name')->where('id', $child->supplier_id)->first();
            }
        }
        $supplier = User::where('user_role', 4)->get();
        return view('admin.orders.procurement_officer.order_archive.index',['data'=>$data,'order_status'=>$order_status,'supplier'=>$supplier,'users'=>$users]);
    }

    public function archive_order_table(Request $request)
    {
        $order_status = OrderStatusModel::get();
        $supplierId = $request->supplier_id;
        $referenceNumber = $request->reference_number;
        $from = $request->from;
        $to = $request->to;

        $data = OrderModel::query()
            ->when(!empty($supplierId), function ($query) use ($supplierId) {
                $query->whereIn('id', function ($query) use ($supplierId) {
                    $query->select('order_id')
                        ->from('price_offers')
                        ->where('supplier_id', $supplierId);
                });
            })
            ->when(!empty($referenceNumber), function ($query) use ($referenceNumber) {
                $query->where('reference_number','like','%'. $referenceNumber. '%');
            })
            ->when(!empty($request->order_status), function ($query) use ($request) {
                $query->where('order_status', $request->order_status);
            })
            ->where(function ($query) use ($from, $to) {
                $query->whereBetween('inserted_at', [$from, $to])
                    ->orWhereNull('inserted_at');
            })
            ->when(!empty($request->to_user),function ($query) use ($request){
                $query->where('to_user','like','%'.$request->to_user.'%');
            })
            ->where('order_status', '=', 10)->where('delete_status','!=',1)
            ->orderBy('inserted_at','desc')
            ->take(30)
            ->get();

        foreach ($data as $key) {
            $key->order_status_color = OrderStatusModel::find($key->order_status);
            $key->user = User::find($key->user_id);
            $key->to_user = User::where('id', $key->to_user)->first();
            $key->supplier = PriceOffersModel::where('order_id', $key->id)->get();

            foreach ($key->supplier as $child) {
                $child->name = User::find($child->supplier_id);
            }
        }
        $users = User::where('user_role',1)->orWhere('user_role',2)->orWhere('user_role',3)->orWhere('user_role',9)->get();
        return response()->view('admin.orders.procurement_officer.order_archive.ajax.archive_table', ['data' => $data,'order_status'=>$order_status,'users'=>$users,'view'=>'admin']);
    }

    public function update_reference_number(Request $request)
    {
        $data = OrderModel::find($request->order_id);
        $data->reference_number = $request->reference_number;
        if ($request->view == 'officer_view'){
            if ($data->save()) {
                return redirect()->route('order_archive.index')->with(['success' => 'تم اضافة البيانات بنجاح', 'tab_id' => 1]);
            } else {
                return redirect()->route('order_archive.index')->with(['fail' => 'هناك خطا ما لم يتم اضافة البيانات']);
            }
        }
        else{
            if ($data->save()) {
                return redirect()->route('order_archive.index')->with(['success' => 'تم اضافة البيانات بنجاح', 'tab_id' => 1]);
            } else {
                return redirect()->route('order_archive.index')->with(['fail' => 'هناك خطا ما لم يتم اضافة البيانات']);
            }
        }

    }

    public function update_due_date(Request $request){
        $data = OrderModel::where('id',$request->order_id)->first();
        $data->inserted_at = $request->due_date;
        if ($request->view == 'officer_view'){
            if ($data->save()) {
                return redirect()->route('order_archive.index')->with(['success' => 'تم تعديل البيانات بنجاح']);
            } else {
                return redirect()->route('order_archive.index')->with(['fail' => 'هناك خطا ما لم يتم تعديل البيانات']);
            }
        }
        else{
            if ($data->save()) {
                return redirect()->route('order_archive.index')->with(['success' => 'تم تعديل البيانات بنجاح']);
            } else {
                return redirect()->route('order_archive.index')->with(['fail' => 'هناك خطا ما لم يتم تعديل البيانات']);
            }
        }
    }
}
