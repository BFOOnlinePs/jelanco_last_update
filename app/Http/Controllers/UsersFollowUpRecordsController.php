<?php

namespace App\Http\Controllers;

use App\Models\UsersFollowUpRecordsModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsersFollowUpRecordsController extends Controller
{
    public function create_for_supplier(Request $request){
        $data = new UsersFollowUpRecordsModel();
        $data->user_id = $request->supplier_id;
        $data->note_text = $request->note_text;
        $data->insert_date = Carbon::now();
        $data->insert_by = auth()->user()->id;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.procurement_officer.' . $extension;
            $file->storeAs('attachment', $filename, 'public');
            $data->attachment = $filename;
        }
        $data->notification_date = $request->notification_date;
        if ($data->save()){
            return redirect()->route('users.supplier.details',['id'=>$request->supplier_id])->with(['success'=>'تم اضافة البيانات بنجاح','tab_id'=>7]);
        }
        else{
            return redirect()->route('users.supplier.details',['id'=>$request->supplier_id])->with(['fail'=>'لم يتم اضافة البيانات هناك خلل ما','tab_id'=>7]);
        }
    }

    public function delete_for_supplier($id){
        $data = UsersFollowUpRecordsModel::find($id);
        if ($data->delete()){
            return redirect()->route('users.supplier.details',['id'=>$data->user_id])->with(['success'=>'تم اضافة البيانات بنجاح','tab_id'=>7]);
        }
        else{
            return redirect()->route('users.supplier.details',['id'=>$data->user_id])->with(['fail'=>'لم يتم اضافة البيانات هناك خلل ما','tab_id'=>7]);
        }
    }

    public function edit_for_supplier($id){
        $data = UsersFollowUpRecordsModel::where('id',$id)->first();
        return view('admin.users.supplier.follow_up_record.edit',['data'=>$data]);
    }

    public function update_for_supplier(Request $request){
        $data = UsersFollowUpRecordsModel::where('id',$request->id)->first();
        $data->note_text = $request->note_text;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.procurement_officer.' . $extension;
            $file->storeAs('attachment', $filename, 'public');
            $data->attachment = $filename;
        }
        if ($data->save()){
            return redirect()->route('users.supplier.details',['id'=>$data->user_id])->with(['success'=>'تم تعديل البيانات بنجاح','tab_id'=>7]);
        }
        else{
            return redirect()->route('users.supplier.details',['id'=>$data->user_id])->with(['fail'=>'هناك خلل ما لم يتم تعديل البيانات','tab_id'=>7]);
        }
    }
}
