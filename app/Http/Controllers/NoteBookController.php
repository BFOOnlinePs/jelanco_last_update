<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserNoteBookModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class NoteBookController extends Controller
{
    public function index()
    {
        $users = User::where('user_role',2)->get();
        $data = UserNoteBookModel::where('user_id',auth()->user()->id)->get();
        return view('admin.note_book.index',['data'=>$data , 'users'=>$users]);
    }

    public function create(Request $request){
        $data = new UserNoteBookModel();
        $data->user_id = auth()->user()->id;
        $data->note_text = $request->note_text;
        $data->note_description = $request->note_description;
        $data->insert_at = Carbon::now();
        $data->status = 'new';
        if($data->save()){
            return redirect()->route('note_book.index')->with(['success'=>'تم انشاء الملاحظة بنجاح']);
        }
        else{
            return redirect()->route('note_book.index')->with(['fail'=>'هناك خلل ما لم يتم انشاء ']);
        }
    }

    public function update(Request $request)
    {
        $data = UserNoteBookModel::where('id',$request->id)->first();
        $data->note_text = $request->note_text;
        $data->note_description = $request->note_description;
        if ($data->save()){
            return response()->json([
                'success' => true,
                'message' => 'تم تعديل البيانات بنجاح'
            ]);
        }
    }

    public function update_status(Request $request)
    {
        $data = UserNoteBookModel::where('id',$request->id)->first();
        $data->status = $request->value;
        if($data->save()){
            return response()->json([
                'success' => true,
                'message' => 'تم تغيير الحالة بنجاح'
            ]);
        }
    }

    public function note_book_table_ajax(Request $request)
    {
        $data = UserNoteBookModel::query()->with('user');
        if ($request->filled('status')){
            $data->where('status',$request->status);
        }
        if ($request->filled('user_id')){
            $data->where('user_id',$request->user_id);
        }
        if ($request->filled('from_date') || $request->filled('to_date')){
            $data->whereBetween('insert_at',[$request->from_date,$request->to_date]);
        }
        $data = $data->whereNot('status','deleted')->whereNot('status','done')->get();
        return response()->json([
            'success' => true,
            'view' => view('admin.note_book.ajax.note_book_table',['data'=>$data])->render(),
        ]);
    }

    public function archive_note_book_index()
    {
        return view('admin.note_book.archive');
    }

    public function archive_note_book_table_ajax(Request $request)
    {
        $data = UserNoteBookModel::where('status','deleted')->orWhere('status','done')->where('user_id',auth()->user()->id)->get();
        return response()->json([
            'success' => true,
            'view' => view('admin.note_book.ajax.archive_note_book_table',['data'=>$data])->render()
        ]);
    }

    public function note_book_pdf()
    {
        $data = UserNoteBookModel::whereNot('status','done')->whereNot('status','deleted')->where('user_id',auth()->user()->id)->get();
        $pdf = PDF::loadView('admin.note_book.pdf.note_book_pdf', ['data'=>$data]);
        return $pdf->stream('note_book.pdf');
    }
}
