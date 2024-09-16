<?php

namespace App\Http\Controllers;

use App\Models\OrderAttachmentModel;
use Illuminate\Http\Request;

class GlobalController extends Controller
{
    public function update_notes_for_view_attachment_modal_ajax(Request $request){
        $data = OrderAttachmentModel::where('id',$request->id)->first();
        $data->notes = $request->notes;
        if ($data->save()){
            return response()->json([
                'success'=>'true',
                'message'=>'تم تعديل الملاحظات بنجاح'
            ]);
        }
        else{
            return response()->json([
                'success'=>'false',
                'message'=>'هناك خلل ما لم يتم تعديل البيانات بنجاح'
            ]);
        }
    }

}
