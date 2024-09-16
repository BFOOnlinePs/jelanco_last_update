<?php

namespace App\Http\Controllers;

use App\Models\ShippingMethodsModel;
use Illuminate\Http\Request;

class ShippingMethodController extends Controller
{
    public function index(){
        $data = ShippingMethodsModel::get();
        return view('admin.shipping_methods.index',['data'=>$data]);
    }

    public function create(Request $request){
        $data = new ShippingMethodsModel();
        $data->name = $request->name;
        $data->description = $request->description;
        if ($data->save()){
            return redirect()->route('shipping_methods.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('shipping_methods.index')->with(['fail'=>'لم تتم الاضافة هناك خلل ما']);
        }
    }

    public function edit($id){
        $data = ShippingMethodsModel::find($id);
        return view('admin.shipping_methods.edit',['data'=>$data]);
    }

    public function update(Request $request){
        $data = ShippingMethodsModel::find($request->id);
        $data->name = $request->name;
        $data->description = $request->description;
        if ($data->save()){
            return redirect()->route('shipping_methods.index')->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('shipping_methods.index')->with(['fail'=>'هناك خلل ما لم يتم التعديل']);
        }
    }
}
