<?php

namespace App\Http\Controllers;

use App\Models\CashPaymentsModel;
use App\Models\LetterBankModel;
use App\Models\OrderModel;
use App\Models\ShippingPriceOfferModel;
use App\Models\TasksModel;
use App\Models\UserNotesModel;
use App\Models\UsersFollowUpRecordsModel;
use Carbon\Carbon;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;
use function Laravel\Prompts\alert;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.calendar.index');
    }

    public function getEvents(Request $request)
    {
//        $user_notes = UserNotesModel::get();
            $user_notes = UserNotesModel::where('user_id',auth()->user()->id)->get();
            if(auth()->user()->user_role == 1 || auth()->user()->user_role == 2){
                $follow_up_records = UsersFollowUpRecordsModel::select('notification_date as start','users_follow_up_records.*','note_text as title')->get();
                foreach ($follow_up_records as $key){
                    $key->url = route('users.supplier.details',['id'=>$key->user_id]);
                }
            }
        if (auth()->user()->user_role == 1 || auth()->user()->user_role == 3) {
//            $user_notes = UserNotesModel::get();
            $cash_payment = CashPaymentsModel::select('due_date as start', 'order_id')->whereBetween('due_date', [Carbon::now(), Carbon::now()->addMonth()])->get();
            foreach ($cash_payment as $key) {
                $key->title = 'دفعة لفاتورة ' . $key->order_id;
                $key->url = route('procurement_officer.orders.financial_file.index', ['order_id' => $key->order_id]);
            }
            $lettter_bank = LetterBankModel::select('due_date as start', 'order_id')->whereBetween('due_date', [Carbon::now(), Carbon::now()->addMonth()])->get();
            foreach ($lettter_bank as $key) {
                $key->title = 'اعتماد بنكي لفاتورة ' . $key->order_id;
                $key->url = route('procurement_officer.orders.financial_file.index', ['order_id' => $key->order_id]);
            }
            $get_calender_for_user = TasksModel::select('to_user', 'start_date as start', 'title')->get();

        } else {
            // TODO the $follow_up_records is broken
            $follow_up_records = UsersFollowUpRecordsModel::select('notification_date as start','users_follow_up_records.*','note_text as title')->get();

//            $user_notes = UserNotesModel::where('user_id',auth()->user()->id)->get();
            $cash_payment = CashPaymentsModel::select('due_date as start', 'order_id')->whereBetween('due_date', [Carbon::now(), Carbon::now()->addMonth()])->get();
            foreach ($cash_payment as $key) {
                $key->title = 'دفعة لفاتورة ' . $key->order_id;
                $key->url = route('procurement_officer.orders.financial_file.index', ['order_id' => $key->order_id]);
            }
            $lettter_bank = LetterBankModel::select('due_date as start', 'order_id')->whereBetween('due_date', [Carbon::now(), Carbon::now()->addMonth()])->get();
            foreach ($lettter_bank as $key) {
                $key->title = 'اعتماد بنكي لفاتورة ' . $key->order_id;
                $key->url = route('procurement_officer.orders.financial_file.index', ['order_id' => $key->order_id]);
            }
            $get_calender_for_user = TasksModel::select('to_user', 'start_date as start', 'title')->where('to_user', auth()->user()->id)->get();
        }

        $data = $cash_payment->concat($lettter_bank)->concat($get_calender_for_user)->concat($user_notes)->concat($follow_up_records);
        return response()->json($data);
    }

    public function create(Request $request)
    {
        $data = new UserNotesModel();
        $data->start = $request->start;
        $data->user_id = auth()->user()->id;
        $data->title = $request->title;
        if ($request->hasFile('attachment_file')) {
            $file = $request->file('attachment_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('attachment', $filename, 'public');
            $data->attachment_file = $filename;
        }
        $data->insert_date = Carbon::now();
        if ($data->save()) {
            return response()->json($data);
        }

    }

    public function updateEventDrop(Request $request)
    {
        $data = UserNotesModel::find($request->id);
        $data->start = $request->start;
        if ($data->save()) {
            return response()->json($data);
        }
    }

    public function update(Request $request)
    {
        $data = UserNotesModel::where('id', $request->id)->first();
        $data->title = $request->title;
        if ($request->hasFile('attachment_file')) {
            $file = $request->file('attachment_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('attachment', $filename, 'public');
            $data->attachment_file = $filename;
        }
        if ($data->save()) {
            return response()->json($data);
        }
    }
}
