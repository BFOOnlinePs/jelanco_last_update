<?php

namespace App\Http\Controllers;

use App\Models\UserCategoryModel;
use Illuminate\Http\Request;

class UserCategoryController extends Controller
{
    public function index(){
        $data = UserCategoryModel::get();
        return view('admin.setting.user_category.index',['data'=>$data]);
    }

    public function create(Request $request){
        $data = new UserCategoryModel();
        $data->name = $request->name;
        if($data->save()){
            return redirect()->route('setting.user_category.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
                return redirect()->route('setting.user_category.index')->with(['fail'=>'لم تتم اضافة البيانات هناك خلل ما']);
        }
    }

    public function edit($id){
        $data = UserCategoryModel::find($id);
        return view('admin.setting.user_category.edit',['data'=>$data]);
    }

    public function update(Request $request){
        $data = UserCategoryModel::find($request->id);
        $data->name = $request->name;
        if($data->save()){
            return redirect()->route('setting.user_category.index')->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
                return redirect()->route('setting.user_category.index')->with(['fail'=>'لم يتم تعديل البيانات هناك خلل ما']);
        }
    }
}
