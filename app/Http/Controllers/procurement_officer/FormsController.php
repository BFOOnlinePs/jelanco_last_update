<?php

namespace App\Http\Controllers\procurement_officer;

use App\Http\Controllers\Controller;
use App\Models\BankModel;
use App\Models\CashPaymentsModel;
use App\Models\CompanyContactPersonModel;
use App\Models\CurrencyModel;
use App\Models\LetterBankModel;
use App\Models\LetterBankModificationModel;
use App\Models\OrderItemsModel;
use App\Models\OrderModel;
use App\Models\PriceOffersModel;
use App\Models\ProductModel;
use App\Models\UnitsModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use PDF;

class FormsController extends Controller
{
    public function index($order_id){
        $order = OrderModel::where('id',$order_id)->first();
        $order->user = User::where('id',$order->user_id)->first();
        $order->to_user = User::where('id',$order->to_user)->first();

        $supplier = User::where('user_role',4)->get();
        return view('admin.orders.procurement_officer.forms.index',['order'=>$order,'supplier'=>$supplier]);
    }

    public function product_supplier_pdf(Request $request){
        $data = OrderItemsModel::where('order_id',$request->order_id)->get();
        $order = OrderModel::where('id',$request->order_id)->first();
        foreach ($data as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
//            $key->unit = UnitsModel::where('id',$key->unit_id)->first();
        }
        $company = User::where('id',$request->supplier_id)->first();
        $company->contact_person = CompanyContactPersonModel::where('company_id',$company->id)->value('contact_name');
//        $pdf = App::make('dompdf.wrapper');
        $pdf = new PDF('es', 'A4', 0, '', 10, 10, 0, 0, 0, 0, 'P');
//        $pdf->SetDefaultBodyCSS('background', asset('img/background/jelanco-background.jpg'));
        $pdf = PDF::loadView('admin.orders.procurement_officer.pdf.product_supplier',['data'=>$data,'company'=>$company,'order'=>$order]);
        // $pdf->getMpdf()->setFooter('<div style="text-align: center; font-size: 10px;">Page {PAGENO} of {nbpg}</div>');
        return $pdf->stream('product_supplier_pdf.pdf');
    }

    public function order_summery($order_id){
        $order = OrderModel::where('id', $order_id)->first();
        $anchor = PriceOffersModel::where('status', 1)->where('order_id', $order_id)->get();
        foreach ($anchor as $key) {
            $key->user = User::where('id', $key->user_id)->first();
            $key->supplier = User::where('id', $key->supplier_id)->first();
            $key->currency = CurrencyModel::where('id',$key->currency_id)->first();
        }
        $offer_price_anchor = PriceOffersModel::where('order_id', $order_id)->where('status', 0)->get();
        foreach ($offer_price_anchor as $key) {
            $key->user = User::where('id', $key->user_id)->first();
            $key->supplier = User::where('id', $key->supplier_id)->first();
        }

        $order_items = OrderItemsModel::where('order_id', $order_id)->get();
        foreach ($order_items as $order_item) {
            $order_item->product = ProductModel::where('id', $order_item->product_id)->first();
            $order_item->unit = UnitsModel::where('id', $order_item->unit_id)->first();
//            $order_item->offer_price_items = PriceOfferItemsModel::where('order_id',$order_item->order_id)->where('product_id',$order_item->product_id)->where('supplier_id',$key->supplier_id)->first();
        }
        $query = PriceOffersModel::where('order_id', $order_id)->get();
        foreach ($query as $key) {
            $key->user_name = User::where('id', $key->supplier_id)->get();
        }


        // TODO FinantialFile
        $order = OrderModel::where('id', $order_id)->first();
        $cash_payment = CashPaymentsModel::where('order_id', $order_id)->get();
        foreach ($cash_payment as $key) {
            $key->user_name = User::where('id', $key->user_id)->first();
        }
        $letter_bank = LetterBankModel::where('order_id', $order_id)->get();
        foreach ($letter_bank as $key) {
            $key->user_name = User::where('id', $key->user_id)->first();
            $key->bank_name = BankModel::where('id', $key->bank_id)->first();
            $key->modifications = $this->getExtentionId($key->id);
        }
        $banks = BankModel::get();

        $pdf = PDF::loadView('admin.orders.procurement_officer.forms.order_summary', ['anchor' => $anchor, 'order' => $order, 'offer_price_anchor' => $offer_price_anchor, 'order_items' => $order_items, 'query' => $query,'cash_payment' => $cash_payment, 'banks' => $banks, 'letter_bank' => $letter_bank]);
        return $pdf->stream('anchor.pdf');
    }

    function getExtentionId($id)
    {
        $data = LetterBankModificationModel::where('letter_bank_id', $id)->get();
        return $data;
    }

}
