<?php

namespace App\Http\Controllers;

use App\Models\EstimationCostElementsModel;
use Illuminate\Http\Request;

class EstimationCostElementController extends Controller
{
    public function index(){
        $data = EstimationCostElementsModel::get();
        return view('admin.estimation_cost_element.index',['data'=>$data]);
    }

    public function create(Request $request){
        $data = new EstimationCostElementsModel();
        $data->name = $request->name;
        if ($data->save()){
            return redirect()->route('estimation_cost_element.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('estimation_cost_element.index')->with(['fail'=>'لم تتم الاضافة هناك خلل ما']);
        }
    }

    public function edit($id){
        $data = EstimationCostElementsModel::where('id',$id)->first();
        return view('admin.estimation_cost_element.edit',['data'=>$data]);
    }

    public function update(Request $request){
        $data = EstimationCostElementsModel::find($request->id);
        $data->name = $request->name;
        if ($data->save()){
            return redirect()->route('estimation_cost_element.index')->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('estimation_cost_element.index')->with(['fail'=>'لم يتم التعديل هناك خلل ما']);
        }
    }
}
