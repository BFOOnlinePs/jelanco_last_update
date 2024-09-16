<?php

namespace App\Http\Controllers\procurement_officer;

use App\Http\Controllers\Controller;
use App\Models\BankModel;
use App\Models\CashPaymentsModel;
use App\Models\LetterBankModel;
use App\Models\LetterBankModificationModel;
use App\Models\OrderClearanceModel;
use App\Models\OrderInsuranceModel;
use App\Models\OrderLocalDeliveryModel;
use App\Models\OrderModel;
use App\Models\OrderNotesModel;
use App\Models\PriceOffersModel;
use App\Models\ShippingPriceOfferModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderNotesController extends Controller
{
    public function index($order_id){
        $order = OrderModel::where('id',$order_id)->first();
        $order->user = User::where('id',$order->user_id)->first();
        $order->to_user = User::where('id',$order->to_user)->first();

        $order_notes = OrderNotesModel::where('order_id',$order_id)->get();

        $price_offer = PriceOffersModel::where('order_id',$order_id)->get();
        $insurance = OrderInsuranceModel::where('order_id',$order_id)->get();
        $clerance = OrderClearanceModel::where('order_id',$order_id)->get();
        foreach ($price_offer as $key){
            $key->supplier = User::where('id',$key->supplier_id)->first();
        }
        $letter_bank = LetterBankModel::where('order_id',$order_id)->get();
        foreach ($letter_bank as $key){
            $key->letter_bank_modification = LetterBankModificationModel::where('letter_bank_id',$key->id)->get();
            $key->bank = BankModel::where('id',$key->bank_id)->first();
        }
        $cash_payments = CashPaymentsModel::where('order_id',$order_id)->get();
        $shipping = ShippingPriceOfferModel::where('order_id',$order_id)->get();
        $delivery = OrderLocalDeliveryModel::where('order_id',$order_id)->get();
        $anchor = PriceOffersModel::where('order_id',$order_id)->where('status',1)->get();
        $order_notes = OrderNotesModel::where('order_id',$order_id)->get();
        foreach ($shipping as $key){
            $key->shipping_company = User::where('id',$key->shipping_company_id)->first();
        }
        return view('admin.orders.procurement_officer.notes.index',['order'=>$order,'price_offer'=>$price_offer,'anchor'=>$anchor,'letter_bank'=>$letter_bank,'insurance'=>$insurance,'clerance'=>$clerance,'cash_payments'=>$cash_payments,'order_notes'=>$order_notes,'delivery'=>$delivery,'shipping'=>$shipping]);
    }

    function create_order_notes(Request $request){
        $data = new OrderNotesModel();
        $data->order_id = $request->order_id;
        $data->user_id = auth()->user()->id;
        $data->note_text = $request->note_text;
        $data->alert_date = $request->alert_date;
        $data->insert_date = Carbon::now();
        $data->status = 1;
        if ($data->save()){
            return redirect()->route('procurement_officer.orders.notes.index',['order_id'=>$request->order_id])->with(['success'=>'تم اضافة الملاحظة بنجاح','tab_id'=>10]);
        }
        else{
            return redirect()->route('procurement_officer.orders.notes.index',['order_id'=>$request->order_id])->with(['fail'=>'لم تتم الاضافة هناك خلل ما','tab_id'=>10]);
        }
    }

    public function edit_order_notes($id){
        $data = OrderNotesModel::find($id);
        return view('admin.orders.procurement_officer.notes.edit',['data'=>$data]);
    }

    public function update_order_notes($id,Request $request){
        $data = OrderNotesModel::find($id);
        $data->note_text = $request->note_text;
        $data->alert_date = $request->alert_date;
        if ($data->save()){
            return redirect()->route('procurement_officer.orders.notes.index',['order_id'=>$data->order_id])->with(['success'=>'تم تعديل الملاحظة بنجاح']);
        }
        else{
            return redirect()->route('procurement_officer.orders.notes.index',['order_id'=>$data->order_id])->with(['fail'=>'هناك خطا ما لم يتم تعديل الملاحطة']);
        }
    }

    public function delete_order_notes($id){
        $data = OrderNotesModel::find($id);
        if ($data->delete()){
            return redirect()->route('orders.procurement_officer.order_items_index',['order_id'=>$data->order_id])->with(['success'=>'تم تعديل الملاحظة بنجاح','tab_id'=>10]);
        }
        else{
            return redirect()->route('orders.procurement_officer.order_items_index',['order_id'=>$data->order_id])->with(['success'=>'تم تعديل الملاحظة بنجاح','tab_id'=>10]);
        }
    }

    public function edit_order_notes_note(Request $request){
        $data = OrderNotesModel::where('id',$request->note_id)->first();
        $data->note_text = $request->note_text;
        if($data->save()){
            return redirect()->back()->with(['success'=>'تم التعديل بنجاح']);
        }
        else{
            return redirect()->back()->with(['fail'=>'هناك خلل ما لم يتم التعديل بنجاح']);
        }
    }
}
