<?php

namespace App\Http\Controllers;

use App\Models\ClearanceAttachmentModel;
use Illuminate\Http\Request;

class ClearanceAttachmentController extends Controller
{
    public function index()
    {
        $data = ClearanceAttachmentModel::get();
        return view('admin.clearance_attachment.index', ['data' => $data]);
    }

    public function create(Request $request)
    {
        $data = new ClearanceAttachmentModel();
        $data->type_name = $request->type_name;
        if ($data->save()) {
            return redirect()->route('clearance_attachment.index')->with(['success' => 'تم اضافة البيانات بنجاح']);
        } else {
            return redirect()->route('clearance_attachment.index')->with(['fail' => 'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function edit($id)
    {
        $data = ClearanceAttachmentModel::find($id);
        return view('admin.clearance_attachment.edit',['data'=>$data]);
    }

    public function update(Request $request){
        $data = ClearanceAttachmentModel::find($request->id);
        $data->type_name = $request->type_name;
        if ($data->save()) {
            return redirect()->route('clearance_attachment.index')->with(['success' => 'تم تعديل البيانات بنجاح']);
        } else {
            return redirect()->route('clearance_attachment.index')->with(['fail' => 'هناك خلل ما لم يتم تعديل البيانات']);
        }
    }
}
