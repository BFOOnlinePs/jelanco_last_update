<?php

namespace App\Http\Controllers\procurement_officer;

use App\Http\Controllers\Controller;
use App\Models\CurrencyModel;
use App\Models\DeliveryEstimationCostModel;
use App\Models\EstimationCostElementsModel;
use App\Models\OrderLocalDeliveryItemsModel;
use App\Models\OrderLocalDeliveryModel;
use App\Models\OrderModel;
use App\Models\User;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public $progress_status = 8;
    public function index($order_id){
        $order = OrderModel::where('id',$order_id)->first();
        $order->user = User::where('id',$order->user_id)->first();
        $order->to_user = User::where('id',$order->to_user)->first();

        $data = OrderLocalDeliveryModel::where('order_id',$order_id)->get();
        $estimation_cost_element = EstimationCostElementsModel::get();
        $delivery_company = User::where('user_role',7)->get();
        foreach ($data as $key) {
            $key->user = User::where('id', $key->delivery_company_id)->first();
            $key->order_local_delivery_items = OrderLocalDeliveryItemsModel::where('order_local_delivery_id', $key->id)->get();
            foreach ($key->order_local_delivery_items as $child) {
                $child->estimation_cost_element = EstimationCostElementsModel::where('id', $child->estimation_cost_element_id)->first();
            }
        }
        $currency = CurrencyModel::get();
        return view('admin.orders.procurement_officer.delivery.index',['data'=>$data,'order'=>$order,'estimation_cost_element'=>$estimation_cost_element,'delivery_company'=>$delivery_company,'currency'=>$currency]);
    }

    public function create(Request $request){
        $check_progress_status = OrderModel::where('id',$request->order_id)->first();
        $data = new OrderLocalDeliveryModel();
        $data->order_id = $request->order_id;
        $data->delivery_company_id = $request->delivery_company_id;
        $data->notes = $request->notes;
        if (($check_progress_status->progress_status) <= $this->progress_status){
            $check_progress_status->progress_status = $this->progress_status;
            $check_progress_status->save();
        }
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'procurement_officer.' . $extension;
            $file->storeAs('attachment', $filename, 'public');
            $data->attachment = $filename;
        }
        if ($data->save()){
            return redirect()->route('procurement_officer.orders.delivery.index',['order_id'=>$request->order_id])->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('procurement_officer.orders.delivery.index',['order_id'=>$request->order_id])->with(['fail'=>'هناك خطا ما لم يتم اضافة البيانات']);
        }
    }

//    public function get_table_order_local_delivery_items(Request $request){
//        $data = OrderLocalDeliveryModel::where('id',$request->order_local_delivery_id)->get();
//        foreach ($data as $key){
//            $key->user = User::where('id',$key->delivery_company_id)->first();
//            $key->order_local_delivery_items = OrderLocalDeliveryItemsModel::where('order_local_delivery_id',$key->id)->get();
//            foreach ($key->order_local_delivery_items as $child){
//                $child->estimation_cost_element = EstimationCostElementsModel::where('id',$child->order_local_delivery_id)->first();
//            }
//        }
//        return response()->view('admin.orders.procurement_officer.ajax.delivery_table',['data'=>$data]);
//    }

    public function edit($id){
        $data = OrderLocalDeliveryModel::where('id',$id)->first();
        $order = OrderModel::where('id',$data->order_id)->first();
        $order->user = User::where('id',$order->user_id)->first();
        $order->to_user = User::where('id',$order->to_user)->first();
        $delivery_company = User::where('user_role',7)->get();
        return view('admin.orders.procurement_officer.delivery.edit',['data'=>$data,'order'=>$order,'delivery_company'=>$delivery_company]);
    }

    public function update(Request $request){
        $data = OrderLocalDeliveryModel::where('id',$request->id)->first();
        $data->delivery_company_id = $request->delivery_company_id;
        $data->notes = $request->notes;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'procurement_officer.' . $extension;
            $file->storeAs('attachment', $filename, 'public');
            $data->attachment = $filename;
        }
        if ($data->save()){
            return redirect()->route('procurement_officer.orders.delivery.index',['order_id'=>$data->order_id])->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('procurement_officer.orders.delivery.index',['order_id'=>$data->order_id])->with(['fail'=>'هناك خطا ما لم يتم تعديل البيانات']);
        }
    }

    public function create_order_local_delivery_items(Request $request){
        $order_local_delivert_items = new OrderLocalDeliveryItemsModel();
        $order_local_delivert_items->order_local_delivery_id = $request->order_local_delivery_id;
        $order_local_delivert_items->estimation_cost_element_id = $request->estimation_cost_element_id;
        $order_local_delivert_items->estimation_cost_price = 0;
        if ($order_local_delivert_items->save()){
            $data = OrderLocalDeliveryItemsModel::where('order_local_delivery_id',$request->order_local_delivery_id)->get();
            foreach ($data as $key){
                $key->estimation_cost_element = EstimationCostElementsModel::where('id',$key->estimation_cost_element_id)->first();
            }
            return response()->json([
            'success'=>'true',
            'view'=>view('admin.orders.procurement_officer.ajax.delivery_table',['data'=>$data])->render(),
        ]);
        }
    }

    public function delete_order_local_delivery_items(Request $request){
        $data = OrderLocalDeliveryItemsModel::where('id',$request->order_local_delivery_items_id);
        if ($data->delete()){
            return response()->json([
                'success'=>'true'
            ]);
        }
    }

    public function update_order_local_delivery_items(Request $request){
        $data = OrderLocalDeliveryItemsModel::find($request->order_local_delivery_items_id);
        $data->estimation_cost_price = $request->estimation_price;
        if ($data->save()){
            return response()->json([
                'success'=>'true'
            ]);
        }
    }

    public function delete($id){
            $data = OrderLocalDeliveryModel::where('id',$id)->first();
        if ($data->delete()){
            return redirect()->back()->with(['success'=>'تم حذف البيانات بنجاح']);
        }
        else{
            return redirect()->back()->with(['fail'=>'لم يتم حذف البيانات هناك خلل ما']);
        }
    }

    public function edit_delivery_note(Request $request){
        $data = OrderLocalDeliveryModel::where('id',$request->note_id)->first();
        $data->notes = $request->note_text;
        if($data->save()){
            return redirect()->back()->with(['success'=>'تم التعديل بنجاح']);
        }
        else{
            return redirect()->back()->with(['fail'=>'هناك خلل ما لم يتم التعديل بنجاح']);
        }
    }
}
