<?php

namespace App\Http\Controllers;

use App\Models\ChatMessageModel;
use App\Models\OrderModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChatMessageController extends Controller
{
    public function send_message_page(){
        if (auth()->user()->user_role == 1 || auth()->user()->user_role == 2){
            $users = User::where('user_role',9)->get();
        }
        else{
            $users = User::where('user_role',2)->get();
        }
        return view('admin.message.send_message_page',['users'=>$users]);
    }

    public function list_users_ajax(Request $request){
            $users = User::where('user_role',1)->orWhere('user_role',2)->orWhere('user_role',9)->whereNot('id',auth()->user()->id)->when($request->filled('search_input'),function ($query) use ($request){
                $query->where('name','like','%'.$request->search_input.'%')->get();
            })->take(10)->get();

        return response()->json([
            'success' => 'true',
            'view' => view('admin.message.ajax.list_users',['users'=>$users])->render()
        ]);
    }

    public function list_message_ajax(Request $request){
        $data = ChatMessageModel::where(function($query) {
            $query->where('sender', auth()->user()->id)
                ->where('reciver', auth()->user()->id);
        })
            ->orWhere(function($query) use ($request) {
                $query->where('sender', $request->reciver)
                    ->orWhere('reciver', $request->reciver);
            })
            ->orderBy('id', 'desc')
            ->take(20)
            ->get()
            ->sortBy('id');
        $user_reciver = User::where('id',$request->reciver)->first();
        if (!$data->isEmpty()){
            return response()->json([
                'success'=>'true',
                'status'=>'not_empty',
                'view'=>view('admin.message.ajax.list_message',['data'=>$data,'user_reciver'=>$user_reciver])->render(),
            ]);
        }
        else{
            return response()->json([
                'success'=>'true',
                'status'=>'empty',
                'view'=>view('admin.message.ajax.list_message',['data'=>$data,'user_reciver'=>$user_reciver])->render(),
            ]);
        }
    }

    public function send_message(Request $request){
        $data = new ChatMessageModel();
        $data->sender = auth()->user()->id;
        $data->receiver = $request->receiver;
        $data->insert_at = Carbon::now();
        $data->read = 0;
        $data->message_title = $request->message_title;
        $data->message_text = $request->message_text;
        if ($data->save()){
            return redirect()->route('message.send_message_page')->with(['success'=>'تم ارسال الرسالة بنجاح']);
        }
        else{
            return redirect()->route('message.send_message_page')->with(['fail'=>'هناك خلل ما لم يتم ارسالة الرسالة']);
        }
    }

    public function create_message_ajax(Request $request){
        $data = new ChatMessageModel();
        $data->sender = auth()->user()->id;
        $data->reciver = $request->reciver;
        $data->message = $request->message;
        $data->insert_at = Carbon::now();
        $data->status = 1;
        if ($data->save()){
            return response()->json([
                'success' => 'true',
                'message' => 'تم ارسال الرسالة بنجاح',
                'data' => $data,
            ]);
        }
    }

    public function orders_table_ajax(Request $request){
//        $data = OrderModel::where('reference_number','like','%'.$request->order_search.'%')->take(10)->get();
        $data = OrderModel::whereIn('id',function ($query) use ($request){
            $query->select('order_tag')->where(function($query) {
                $query->where('sender', auth()->user()->id)
                    ->where('reciver', auth()->user()->id);
            })
                ->orWhere(function($query) use ($request) {
                    $query->where('sender', $request->reciver)
                        ->orWhere('reciver', $request->reciver);
                })->from('chat_message')->get();
        })->where('reference_number','like','%'.$request->order_search.'%')->take(10)->get();
        return response()->json([
            'success' => 'true',
            'view' => view('admin.message.ajax.list_orders',['data'=>$data])->render(),
        ]);
    }

    public function list_orders_for_tag(Request $request){
        $data = OrderModel::where('reference_number','like','%'.$request->order_search_for_tag.'%')->take(10)->get();
        return response()->json([
            'success' => 'true',
            'view' => view('admin.message.ajax.list_orders_for_tag',['data'=>$data])->render(),
        ]);
    }

    public function create_tag_for_message(Request $request){
        $data = ChatMessageModel::where('id',$request->chat_message_id)->first();
        $data->order_tag = $request->order_tag;
        if ($data->save()){
            return response()->json([
                'success' => 'true',
                'message' => 'تم عمل تاغ للرسالة بنجاح'
            ]);
        }
        else{
            return response()->json([
                'success' => 'false',
                'message' => 'هناك خلل ما لم يتم عمل تاغ للرسالة'
            ]);
        }
    }

    public function delete_message_tag(Request $request){
        $data = ChatMessageModel::where('id',$request->id)->first();
        $data->order_tag = $request->order_tag;
        if ($data->save()){
            return response()->json([
                'success' => 'true',
                'message' => 'تم حذف التاغ بنجاح'
            ]);
        }
    }
}
