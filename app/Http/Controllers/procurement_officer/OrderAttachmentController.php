<?php

namespace App\Http\Controllers\procurement_officer;

use App\Http\Controllers\Controller;
use App\Models\BankModel;
use App\Models\CashPaymentsModel;
use App\Models\ClearanceAttachmentModel;
use App\Models\LetterBankModel;
use App\Models\LetterBankModificationModel;
use App\Models\OrderAttachmentModel;
use App\Models\OrderClearanceAttachmentModel;
use App\Models\OrderClearanceModel;
use App\Models\OrderInsuranceModel;
use App\Models\OrderLocalDeliveryModel;
use App\Models\OrderModel;
use App\Models\PriceOffersModel;
use App\Models\ShippingPriceOfferModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderAttachmentController extends Controller
{
    public function index($order_id){
        $order = OrderModel::where('id',$order_id)->first();
        $order->user = User::where('id',$order->user_id)->first();
        $order->to_user = User::where('id',$order->to_user)->first();

        $order_attachment = OrderAttachmentModel::where('order_id',$order_id)->get();
        $price_offer = PriceOffersModel::where('order_id',$order_id)->get();
        foreach ($price_offer as $key){
            $key->supplier = User::where('id',$key->supplier_id)->first();
        }
        $insurance = OrderInsuranceModel::where('order_id',$order_id)->get();
        $clerance = OrderClearanceModel::where('order_id',$order_id)->get();
        foreach ($clerance as $key) {
            $key->clerance_attachment = OrderClearanceAttachmentModel::where('order_clearance_id',$key->id)->get();
            foreach ($key->clerance_attachment as $child){
                $child->clerance_attachemnt = ClearanceAttachmentModel::where('id',$child->attachment_type)->first();
            }
        }
        $letter_bank = LetterBankModel::where('order_id',$order_id)->get();
        foreach ($letter_bank as $key){
            $key->letter_bank_modification = LetterBankModificationModel::where('letter_bank_id',$key->id)->get();
            $key->bank = BankModel::where('id',$key->bank_id)->first();
        }
        $cash_payments = CashPaymentsModel::where('order_id',$order_id)->get();
        $shipping = ShippingPriceOfferModel::where('order_id',$order_id)->get();
        foreach ($shipping as $key){
            $key->shipping_company = User::where('id',$key->shipping_company_id)->first();
        }
        $shipping_award = ShippingPriceOfferModel::where('order_id',$order_id)->where('award_status',1)->get();
        foreach ($shipping_award as $key){
            $key->shipping_company = User::where('id',$key->shipping_company_id)->first();
        }
        $anchor = PriceOffersModel::where('order_id',$order_id)->where('status',1)->get();
        foreach ($anchor as $key){
            $key->supplier = User::where('id',$key->supplier_id)->first();
        }
        $delivery = OrderLocalDeliveryModel::where('order_id',$order_id)->get();
        return view('admin.orders.procurement_officer.attachment.index',['order_attachment'=>$order_attachment,'order'=>$order,'price_offer'=>$price_offer,'shipping'=>$shipping,'letter_bank'=>$letter_bank,'insurance'=>$insurance,'anchor'=>$anchor,'clerance'=>$clerance,'delivery'=>$delivery,'cash_payments'=>$cash_payments,'shipping_award'=>$shipping_award]);
    }

    public function create_order_attachment(Request $request)
    {
        $data = new OrderAttachmentModel();
        $data->order_id = $request->order_id;
        $data->user_id = auth()->user()->id;
        $data->notes = $request->notes;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'procurement_officer.' . $extension;
            $file->storeAs('attachment', $filename, 'public');
            $data->attachment = $filename;
        }
        $data->insert_at = Carbon::now();
        $data->status = 1;
        if ($data->save()) {
            return redirect()->route('procurement_officer.orders.attachment.index', ['order_id' => $data->order_id])->with(['success' => 'تم اضافة الباينات بنجاح', 'tab_id' => 9]);
        } else {
            return redirect()->route('procurement_officer.orders.attachment.index', ['order_id' => $data->order_id])->with(['fail' => 'هناك خلل ما لم يتم اضافة البيانات', 'tab_id' => 9]);
        }
    }

//    public function edit_order_attachment($id){
//        $data = OrderAttachmentModel::find($id);
//        return view('admin.orders.procurement_officer.attachment.edit',['data'=>$data]);
//    }

    public function delete_order_attachment($id)
    {
        $data = OrderAttachmentModel::find($id);
        $order_id = $data->order_id;
        if ($data->delete()) {
            return redirect()->route('procurement_officer.orders.attachment.index', ['order_id' => $order_id])->with(['success' => 'تم حذف المرفق بنجاح', 'tab_id' => 9]);
        } else {
            return redirect()->route('procurement_officer.orders.attachment.index', ['order_id' => $order_id])->with(['fail' => 'هناك خلل ما لم يتم حذف البيانات', 'tab_id' => 9]);
        }
    }

}
