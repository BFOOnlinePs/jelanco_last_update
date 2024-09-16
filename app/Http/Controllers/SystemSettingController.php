<?php

namespace App\Http\Controllers;

use App\Models\SystemSettingModel;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    public function index(){
        $data = SystemSettingModel::first();
        return view('admin.setting.system_setting.index',['data'=>$data]);
    }

    public function create(Request $request){
        $data = SystemSettingModel::findOrNew($request->id);
        $data->sidebar_color = $request->sidebar_color;
        if($data->save()){
            return redirect()->route('setting.system_setting.index')->with(['success'=>'تمت العملية بنجاح']);
        }
        else{
            return redirect()->route('setting.system_setting.index')->with(['fail'=>'لم تتم العملية بنجاح هناك مشكلة ما']);
        }
    }
}
