<?php

namespace App\Http\Controllers;

use App\Models\TasksTypeModel;
use Illuminate\Http\Request;

class TaskTypeController extends Controller
{
    public function index(){
        $data = TasksTypeModel::get();
        return view('admin.task_type.index',['data'=>$data]);
    }

    public function create(Request $request){
        $data = new TasksTypeModel();
        $data->type_name = $request->type_name;
        if ($data->save()){
            return redirect()->route('tasks_type.index')->with(['success'=>'تم اضافة نوع المهمة بنجاح']);
        }
        else{
            return redirect()->route('tasks_type.index')->with(['fail'=>'هناك خلل ما لم تتم الاضافة بنجاح']);
        }
    }

    public function edit($id){
        $data = TasksTypeModel::find($id);
        return view('admin.task_type.edit',['data'=>$data]);
    }

    public function update(Request $request){
        $data = TasksTypeModel::find($request->id);
        $data->type_name = $request->type_name;
        if ($data->save()){
            return redirect()->route('tasks_type.index')->with(['success'=>'تم تعديل نوع المهمة بنجاح']);
        }
        else{
            return redirect()->route('tasks_type.index')->with(['fail'=>'هناك خلل ما لم يتم التعديل']);
        }
    }
}
