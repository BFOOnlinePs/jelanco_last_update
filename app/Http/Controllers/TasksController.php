<?php

namespace App\Http\Controllers;

use App\Models\TasksModel;
use App\Models\TasksTypeModel;
use App\Models\User;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index(){
        $user = User::where('user_role',2)->orWhere('user_role',3)->orWhere('user_role',9)->get();
        $data = TasksModel::get();
        foreach ($data as $key){
            $key->from_user = User::where('id',$key->from_user)->first();
            $key->to_user = User::where('id',$key->to_user)->first();
            $key->task_type = TasksTypeModel::where('id',$key->task_type)->first();
        }
        $task_type = TasksTypeModel::get();
        return view('admin.tasks.index',['data'=>$data,'user'=>$user,'task_type'=>$task_type]);
    }

    public function create(Request $request){
        $data = new TasksModel();
        $data->from_user = auth()->user()->id;
        $data->to_user = $request->to_user;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->start_date = $request->start_date;
        $data->start_time = $request->start_time;
        $data->duration = $request->duration;
        $data->duration_unit = $request->duration_unit;
        $data->task_status = 1;
        $data->task_type = $request->task_type;
        if ($data->save()){
            return redirect()->route('tasks.index')->with(['success'=>'تم اضافة المهمة بنجاح']);
        }
        else{
            return redirect()->route('tasks.index')->with(['fail'=>'هناك خلل ما لم تتم الاضافة']);
        }
    }

    public function edit($id){
        $data = TasksModel::find($id);
        $user = User::where('user_role',2)->orWhere('user_role',3)->orWhere('user_role',9)->get();
        $task_type = TasksTypeModel::get();
        return view('admin.tasks.edit',['data'=>$data,'user'=>$user,'task_type'=>$task_type]);
    }

    public function update(Request $request){
        $data = TasksModel::find($request->id);
        $data->from_user = auth()->user()->id;
        $data->to_user = $request->to_user;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->start_date = $request->start_date;
        $data->start_time = $request->start_time;
        $data->duration = $request->duration;
        $data->duration_unit = $request->duration_unit;
        $data->task_status = 1;
        $data->task_type = $request->task_type;
        if ($data->save()){
            return redirect()->route('tasks.index')->with(['success'=>'تم تعديل المهمة بنجاح']);
        }
        else{
            return redirect()->route('tasks.index')->with(['fail'=>'هناك خلل ما لم يتم التعديل']);
        }
    }
}
