<?php

namespace App\Http\Controllers;

use App\Models\CriteriaModel;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function index(){
        $criteria = CriteriaModel::get();
        return view('admin.criteria.index',['criteria'=>$criteria]);
    }

    public function create(Request $request){
        $data = new CriteriaModel();
        $data->name = $request->name;
        $data->mark = $request->mark;
        if($data->save()){
            return redirect()->back()->with(['success'=>'تم اضافة البيانات بنجاح']);
        }else{
            return redirect()->back()->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function edit($id){
        $data = CriteriaModel::where('id',$id)->first();
        return view('admin.criteria.edit',['data'=>$data]);
    }

    public function update(Request $request){
        $data = CriteriaModel::where('id',$request->id)->first();
        $data->name = $request->name;
        $data->mark = $request->mark;
        if($data->save()){
            return redirect()->back()->with(['success'=>'تم تعديل البيانات بنجاح']);
        }else{
            return redirect()->back()->with(['fail'=>'هناك خلل ما لم يتم تعديل البيانات']);
        }
    }


    public function update_role_id(Request $request)
    {
        $data = CriteriaModel::where('id', $request->id)->first();
    
        // جلب الـ role_id الموجود حالياً وتحويله إلى array
        $roleIds = json_decode($data->role_id, true) ?: [];
    
        // إذا كان الـ checkbox محدداً، أضف role_id إذا لم يكن موجوداً
        if ($request->is_checked == 'true') {
            if (!in_array($request->role_id, $roleIds)) {
                $roleIds[] = $request->role_id;
            }
        } 
        // إذا لم يكن محدداً، أزل الـ role_id من الـ array
        else {
            if (($key = array_search($request->role_id, $roleIds)) !== false) {
                unset($roleIds[$key]);
            }
        }
    
        // تحديث قاعدة البيانات
        $data->role_id = json_encode(array_values($roleIds));
    
        if ($data->save()) {
            return response()->json([
                'success' => 'true',
                'message' => 'تم تعديل البيانات بنجاح',
            ]);
        }
    
        return response()->json(['success' => 'false', 'message' => 'خطأ في تحديث البيانات']);
    }

}
