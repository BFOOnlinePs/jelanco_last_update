<?php

namespace App\Http\Controllers;

use App\Models\OrderStatusModel;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function index(){
        $data = OrderStatusModel::get();
        return view('admin.order_status.index',['data'=>$data]);
    }

    public function create(Request $request){
        $data = new OrderStatusModel();
        $data->name = $request->name;
        $data->status_color = $request->status_color;
        $data->status_text_color = $request->status_text_color;
        if ($data->save()){
            return redirect()->route('order_status.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('order_status.index')->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function edit($id){
        $data = OrderStatusModel::where('id',$id)->first();
        return view('admin.order_status.edit',['data'=>$data]);
    }

    public function update(Request $request){
        $data = OrderStatusModel::where('id',$request->id)->first();
        $data->name = $request->name;
        $data->status_color = $request->status_color;
        $data->status_text_color = $request->status_text_color;
        if ($data->save()){
            return redirect()->route('order_status.index')->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('order_status.index')->with(['fail'=>'هناك خلل ما لم يتم تعديل البيانات']);
        }
    }
}
