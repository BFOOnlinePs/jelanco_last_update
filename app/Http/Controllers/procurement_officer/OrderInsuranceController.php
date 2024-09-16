<?php

namespace App\Http\Controllers\procurement_officer;

use App\Http\Controllers\Controller;
use App\Models\OrderInsuranceModel;
use App\Models\OrderModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderInsuranceController extends Controller
{
    public $progress_status = 6;
    public function index($order_id)
    {
        $order = OrderModel::find($order_id);
        $order->user = User::where('id',$order->user_id)->first();
        $order->to_user = User::where('id',$order->to_user)->first();

        $data = OrderInsuranceModel::where('order_id',$order_id)->get();
        foreach ($data as $key){
            $key->company = User::where('id',$key->insurance_company_id)->first();
            $key->insert_by = User::where('id',$key->insert_by)->first();
        }
        $insurance_company = User::where('user_role',8)->get();
        return view('admin.orders.procurement_officer.insurance.index',['data'=>$data,'order'=>$order,'insurance_company'=>$insurance_company]);
    }

    public function create(Request $request){
        $check_progress_status = OrderModel::where('id',$request->order_id)->first();
        $data = new OrderInsuranceModel();
        $data->order_id = $request->order_id;
        $data->insurance_company_id = $request->insurance_company_id;

        if (($check_progress_status->progress_status) <= $this->progress_status){
            $check_progress_status->progress_status = $this->progress_status;
            $check_progress_status->save();
        }

        if ($request->hasFile('attachment')){
            $file = $request->file('attachment');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->storeAs('attachment',$filename,'public');
            $data->attachment = $filename;
        }
        $data->notes = $request->notes;
        $data->insert_by = auth()->user()->id;
        $data->insert_at = Carbon::now();
        $data->status = 0;
        if ($data->save()){
            return redirect()->route('procurement_officer.orders.insurance.index',['order_id'=>$request->order_id])->with(['success'=>'تم اضافة الباينات بنجاح']);
        }
        else{
            return redirect()->route('procurement_officer.orders.insurance.index',['order_id'=>$request->order_id])->with(['fail'=>'لم تتم اضافة الباينات هناك خلل ما']);
        }
    }

    public function edit($id){
        $data = OrderInsuranceModel::find($id);
        $insurance_company = User::where('user_role',8)->get();
        return view('admin.orders.procurement_officer.insurance.edit',['data'=>$data,'insurance_company'=>$insurance_company]);
    }

    public function update(Request $request){
        $data = OrderInsuranceModel::find($request->id);
        $data->insurance_company_id = $request->insurance_company_id;
        if ($request->hasFile('attachment')){
            $file = $request->file('attachment');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->storeAs('attachment',$filename,'public');
            $data->attachment = $filename;
        }
        $data->notes = $request->notes;
        if ($data->save()){
            return redirect()->route('procurement_officer.orders.insurance.index',['order_id'=>$data->order_id])->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('procurement_officer.orders.insurance.index',['order_id'=>$data->order_id])->with(['fail'=>'لم يتم التعديل هناك خطا ما']);
        }
    }

    public function delete($id){
        $data = OrderInsuranceModel::where('id',$id)->first();
        if ($data->delete()){
            return redirect()->route('procurement_officer.orders.insurance.index',['order_id'=>$data->order_id])->with(['success'=>'تم حذف البيانات بنجاح']);
        }
        else{
            return redirect()->route('procurement_officer.orders.insurance.index',['order_id'=>$data->order_id])->with(['fail'=>'لم يتم الحذف هناك خلل ما']);
        }
    }

    public function edit_insurance_note(Request $request){
        $data = OrderInsuranceModel::where('id',$request->note_id)->first();
        $data->notes = $request->note_text;
        if($data->save()){
            return redirect()->back()->with(['success'=>'تم التعديل بنجاح']);
        }
        else{
            return redirect()->back()->with(['fail'=>'هناك خلل ما لم يتم التعديل بنجاح']);
        }
    }
}
