<?php

namespace App\Http\Controllers\procurement_officer;

use App\Http\Controllers\Controller;
use App\Models\ChatMessageModel;
use App\Models\OrderModel;
use App\Models\User;
use Illuminate\Http\Request;

class ChatMessageController extends Controller
{
    public function index($order_id){
        $order = OrderModel::where('id',$order_id)->first();
        $data = ChatMessageModel::where('order_tag',$order_id)->get();
        foreach ($data as $key){
            $key->user_sender = User::where('id',$key->sender)->first();
            $key->user_reciver = User::where('id',$key->reciver)->first();
        }
        return view('admin.orders.procurement_officer.chat_message.index',['data'=>$data,'order'=>$order]);
    }
}
