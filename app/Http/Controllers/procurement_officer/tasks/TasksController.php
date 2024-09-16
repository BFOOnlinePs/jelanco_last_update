<?php

namespace App\Http\Controllers\procurement_officer\tasks;

use App\Http\Controllers\Controller;
use App\Models\TasksModel;
use App\Models\TasksTypeModel;
use App\Models\User;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index(){
        $data = TasksModel::where('to_user',auth()->user()->id)->get();
        foreach ($data as $key){
            $key->from_user = User::where('id',$key->from_user)->first();
            $key->to_user = User::where('id',$key->to_user)->first();
            $key->task_type = TasksTypeModel::where('id',$key->task_type)->first();
        }
        return view('admin.tasks.procurement_officer.index',['data'=>$data]);
    }
}
