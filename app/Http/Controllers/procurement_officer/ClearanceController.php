<?php

namespace App\Http\Controllers\procurement_officer;

use App\Http\Controllers\Controller;
use App\Models\ClearanceAttachmentModel;
use App\Models\OrderClearanceAttachmentModel;
use App\Models\OrderClearanceModel;
use App\Models\OrderModel;
use App\Models\User;
use Illuminate\Http\Request;

class ClearanceController extends Controller
{
    public $progress_status = 7;
    public function index($order_id)
    {
        $order = OrderModel::where('id', $order_id)->first();
        $order->user = User::where('id',$order->user_id)->first();
        $order->to_user = User::where('id',$order->to_user)->first();

        $users = User::where('user_role', 6)->get();
        $clearance_attachment = ClearanceAttachmentModel::get();
        $data = OrderClearanceModel::where('order_id',$order_id)->get();
        foreach ($data as $key) {
            $key->company = User::where('id', $key->order_clearance_company_id)->first();
            $key->order_clearance_attachment = OrderClearanceAttachmentModel::where('order_clearance_id', $key->id)->get();
            foreach ($key->order_clearance_attachment as $child) {
                $child->attachment_type = ClearanceAttachmentModel::where('id', $child->attachment_type)->first();
            }
        }
        return view('admin.orders.procurement_officer.clearance.index', ['data' => $data, 'order' => $order, 'users' => $users, 'clearance_attachment' => $clearance_attachment]);
    }

    public function create(Request $request)
    {
        $check_progress_status = OrderModel::where('id',$request->order_id)->first();
        $order_clearance = new OrderClearanceModel();
        $order_clearance->order_id = $request->order_id;
        $order_clearance->order_clearance_company_id = $request->order_clearance_company_id;
        $order_clearance->notes = $request->notes;
        $order_clearance->status = 0;
        if (($check_progress_status->progress_status) <= $this->progress_status){
            $check_progress_status->progress_status = $this->progress_status;
            $check_progress_status->save();
        }
        if ($order_clearance->save()) {
            return redirect()->route('procurement_officer.orders.clearance.index', ['order_id' => $request->order_id])->with(['success' => 'تم اضافة البيانات بنجاح']);
        } else {
            return redirect()->route('procurement_officer.orders.clearance.index', ['order_id' => $request->order_id])->with(['fail' => 'لم يتم اضافة البيانات هناك خلل ما']);
        }
    }

    public function create_order_clearance_attachment(Request $request)
    {
        $order_clearance_attachment = new OrderClearanceAttachmentModel();
        $order_clearance_attachment->order_clearance_id = $request->order_clearance_id;
        $order_clearance_attachment->attachment_type = $request->attachment_type;
        $order_clearance_attachment->save();
        $data = OrderClearanceAttachmentModel::where('order_clearance_id', $order_clearance_attachment->order_clearance_id)->get();
//        foreach ($data as $key){
//            $key->company = User::where('id',$key->order_clearance_company_id)->first();
//            $key->order_clearance_attachment = OrderClearanceAttachmentModel::where('order_clearance_id',$key->id)->get();
//            foreach ($key->order_clearance_attachment as $child){
//                $child->attachment_type = ClearanceAttachmentModel::where('id',$child->attachment_type)->first();
//            }
//        }
        $query = OrderClearanceAttachmentModel::where('order_clearance_id', $request->order_clearance_id)->get();
        foreach ($query as $key) {
            $key->attachment_type = ClearanceAttachmentModel::where('id', $key->attachment_type)->first();
        }
        return response()->view('admin.orders.procurement_officer.ajax.clearance_table', ['data' => $query, 'order_id' => $request->order_id, 'index' => $request->id]);
//        return response()->json([
//            'success'=>'true',
//            'data'=>$data
//        ]);
    }

    public function update(Request $request)
    {
        $data = OrderClearanceAttachmentModel::find($request->id);
        if ($request->hasFile('attachment_original')) {
            $file = $request->file('attachment_original');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->storeAs('attachment', $filename, 'public');
            $data->attachment_original = $filename;
        }
        if ($request->hasFile('attachment_copy')) {
            $file = $request->file('attachment_copy');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->storeAs('attachment', $filename, 'public');
            $data->attachment_copy = $filename;
        }

        if ($data->save()) {
            $query = OrderClearanceAttachmentModel::where('order_clearance_id', $request->order_clearance_id)->get();
            foreach ($query as $key) {
                $key->attachment_type = ClearanceAttachmentModel::where('id', $key->attachment_type)->first();
            }
            return response()->view('admin.orders.procurement_officer.ajax.clearance_table', ['data' => $query, 'order_id' => $request->order_id, 'index' => $request->id]);
        }
    }

    public function delete_order_clearance_attachment(Request $request)
    {
        $query = OrderClearanceAttachmentModel::find($request->id);
        if ($query->delete()) {
            return response()->json([
                'success' => 'true'
            ]);
        }
    }

    public function update_to_null_order_clearance_attachment(Request $request)
    {
        $query = OrderClearanceAttachmentModel::find($request->id);
        if ($request->type == 'original') {
            $query->attachment_original = '';
        } else if ($request->type == 'copy') {
            $query->attachment_copy = '';
        }
        if ($query->save()) {
            $query = OrderClearanceAttachmentModel::where('order_clearance_id', $request->order_clearance_id)->get();
            foreach ($query as $key) {
                $key->attachment_type = ClearanceAttachmentModel::where('id', $key->attachment_type)->first();
            }
            return response()->view('admin.orders.procurement_officer.ajax.clearance_table', ['data' => $query, 'order_id' => $request->order_id, 'index' => $request->id]);
        }
    }

    public function clearance_status(Request $request)
    {
        $data = OrderClearanceModel::where('id', $request->id)->first();
        $data->status = $request->status;
        if ($data->save()) {
            return response()->json(
                [
                    'success' => 'true'
                ]
            );
        }
    }

    public function clearance_notes(Request $request)
    {
        $data = OrderClearanceModel::where('id', $request->id)->first();
        $data->notes = $request->notes;
        if ($data->save()) {
            return response()->json(
                [
                    'success' => 'true'
                ]
            );
        }
    }

    public function delete($id){
        $data = OrderClearanceModel::find($id);
        if ($data->delete   ()) {
            return redirect()->route('procurement_officer.orders.clearance.index', ['order_id' => $data->order_id])->with(['success' => 'تم حذف البيانات بنجاح']);
        } else {
            return redirect()->route('procurement_officer.orders.clearance.index', ['order_id' => $data->order_id])->with(['fail' => 'لم يتم حذف البيانات هناك خلل ما']);
        }
    }

    public function edit_clearance_note(Request $request){
        $data = OrderClearanceModel::where('id',$request->note_id)->first();
        $data->notes = $request->note_text;
        if($data->save()){
            return redirect()->back()->with(['success'=>'تم التعديل بنجاح']);
        }
        else{
            return redirect()->back()->with(['fail'=>'هناك خلل ما لم يتم التعديل بنجاح']);
        }
    }
}
