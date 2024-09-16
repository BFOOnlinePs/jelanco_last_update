<?php

namespace App\Http\Controllers\procurement_officer;

use App\Http\Controllers\Controller;
use App\Models\CashPaymentsModel;
use App\Models\LetterBankModel;
use App\Models\OrderClearanceModel;
use App\Models\OrderInsuranceModel;
use App\Models\OrderLocalDeliveryModel;
use App\Models\OrderModel;
use App\Models\OrderNotesModel;
use App\Models\ShippingPriceOfferModel;
use App\Models\User;
use App\Models\UserNotesModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalenderController extends Controller
{
    public function index(Request $request, $order_id)
    {
        $order = OrderModel::where('id', $order_id)->first();
        $order->user = User::where('id',$order->user_id)->first();
        $order->to_user = User::where('id',$order->to_user)->first();

        return view('admin.orders.procurement_officer.calender.index', ['order' => $order]);
    }

    public function getEvents($order_id)
    {
        $cashPayment = CashPaymentsModel::select('due_date as start','order_id')->where('order_id',$order_id)->get();
        foreach ($cashPayment as $key) {
            $key->title = 'دفع نقدا';
            $key->color = '#FF0000';
            $key->url = route('procurement_officer.orders.financial_file.index',['order_id'=>$key->order_id]);
        }

        $letterBank = LetterBankModel::select('due_date as start','order_id')->where('order_id',$order_id)->get();
        foreach ($letterBank as $key) {
            $key->title = 'دفعة';
            $key->url = route('procurement_officer.orders.financial_file.index',['order_id'=>$key->order_id]);
        }
        $clearance = OrderClearanceModel::select('created_at as start','order_id')->where('order_id',$order_id)->get();
        foreach ($clearance as $key){
            $key->title = 'تخليص';
            $key->url = route('procurement_officer.orders.clearance.index',['order_id'=>$key->order_id]);
        }

        $insurance = OrderInsuranceModel::select('insert_at as start','order_id')->where('order_id',$order_id)->get();
        foreach ($insurance as $key){
            $key->title = 'تأمين';
            $key->url = route('procurement_officer.orders.insurance.index',['order_id'=>$key->order_id]);
        }

        $delivery = OrderLocalDeliveryModel::select('created_at as start')->where('order_id',$order_id)->get();
        foreach ($delivery as $key){
            $key->title = 'توصيل';
            if (!empty($key->order_id)){
                $key->url = route('procurement_officer.orders.delivery.index',['order_id'=>$key->order_id]);
            }
        }

        $shipping_price_offer = ShippingPriceOfferModel::select('created_at as start')->where('order_id',$order_id)->get();
        foreach ($shipping_price_offer as $key){
            $key->title = 'شحن';
            if (!empty($key->order_id)){
                $key->url = route('procurement_officer.orders.shipping.index',['order_id'=>$key->order_id]);
            }
        }

        $order_notes = OrderNotesModel::select('insert_date as start','note_text as title')->where('order_id',$order_id)->get();

        $data = $cashPayment->concat($letterBank)->concat($clearance)->concat($insurance)->concat($order_notes);
        return response()->json($data);
    }

    public function create(Request $request)
    {
        $order_notes = new OrderNotesModel();
        $order_notes->user_id = auth()->user()->id;
        $order_notes->note_text = $request->title;
        $order_notes->insert_date = $request->start;
        $order_notes->alert_date = $request->start;
        $order_notes->order_id = $request->order_id;
        $order_notes->status = 1;
        $order_notes->save();
        $data = new UserNotesModel();
        $data->start = $request->start;
        $data->title = $request->title;
        $data->insert_date = Carbon::now()->toDateString();
        $data->user_id = auth()->user()->id;
        if ($data->save()) {
            return response()->json($data);
        }
    }
}
