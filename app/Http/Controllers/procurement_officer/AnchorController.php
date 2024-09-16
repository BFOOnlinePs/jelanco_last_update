<?php

namespace App\Http\Controllers\procurement_officer;

use App\Http\Controllers\Controller;
use App\Models\CurrencyModel;
use App\Models\OrderItemsModel;
use App\Models\OrderModel;
use App\Models\PriceOfferItemsModel;
use App\Models\PriceOffersModel;
use App\Models\ProductModel;
use App\Models\UnitsModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
use Termwind\Components\Anchor;

class AnchorController extends Controller
{
    public $progress_status = 3;
    public function index($order_id)
    {
        $order = OrderModel::where('id', $order_id)->first();
        $order->user = User::where('id',$order->user_id)->first();
        $order->to_user = User::where('id',$order->to_user)->first();
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
        return view('admin.orders.procurement_officer.anchor.index', ['anchor' => $anchor, 'order' => $order, 'offer_price_anchor' => $offer_price_anchor, 'order_items' => $order_items, 'query' => $query]);
    }

//    function getPriceOffer_Price($order_id,$supplier_id,$product_id){
//        $data = PriceOfferItemsModel::where('order_id',$order_id)->where('supplier_id',$supplier_id)->where('product_id',$product_id)->value('price');
//        return $data;
//    }

    public function create_anchor(Request $request)
    {

        $check_progress_status = OrderModel::where('id',$request->order_id)->first();

        $data = PriceOffersModel::find($request->offer_price_id);
        $data->status = 1;
        $data->award_note = $request->award_note;
        $data->insert_at = Carbon::now();
        if (($check_progress_status->progress_status) <= $this->progress_status){
            $check_progress_status->progress_status = $this->progress_status;
            $check_progress_status->save();
        }

        if ($request->hasFile('award_attachment')) {
            $file = $request->file('award_attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'procurement_officer.' . $extension;
            $file->storeAs('award_attachment', $filename, 'public');
            $data->award_attachment = $filename;
        }
        if ($data->save()) {
            return redirect()->route('procurement_officer.orders.anchor.index', ['order_id' => $request->order_id])->with(['success' => 'تم اضافة البيانات بنجاح', 'tab_id' => 3]);
        } else {
            return redirect()->route('procurement_officer.orders.anchor.index', ['order_id' => $request->order_id])->with(['fail' => 'هناك خطا ما لم تتم اضافة البيانات', 'tab_id' => 3]);
        }
    }

    public function delete_anchor($id)
    {
        $data = PriceOffersModel::where('id', $id)->first();
        $data->status = 0;
        if ($data->save()) {
            return redirect()->route('procurement_officer.orders.anchor.index', ['order_id' => $data->order_id])->with(['success' => 'تم الحذف بنجاح', 'tab_id' => 3]);
        } else {
            return redirect()->route('procurement_officer.orders.anchor.index', ['order_id' => $data->order_id])->with(['fail' => 'لم بتم الحذف هناك خطا ما', 'tab_id' => 3]);
        }
    }

    public function updateNotesForAnchor(Request $request)
    {
        $data = PriceOffersModel::where('id', $request->id)->first();
        $data->award_note = $request->award_note;
        if ($data->save()) {
            return response()->json($data);
        }
    }

    public function anchor_table_pdf($order_id,$price_offer)
    {
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

        $pdf = PDF::loadView('admin.orders.procurement_officer.anchor.pdf.anchor_table', ['anchor' => $anchor, 'order' => $order, 'offer_price_anchor' => $offer_price_anchor, 'order_items' => $order_items, 'query' => $query,'price_offer'=>$price_offer]);
        return $pdf->stream('anchor.pdf');

//        $offer_price_anchor = PriceOffersModel::where('id', $id)->first();
//        $order = OrderModel::where('id', $offer_price_anchor->order_id)->first();
//        $offer_price_anchor->user = User::where('id', $offer_price_anchor->user_id)->first();
//        $offer_price_anchor->supplier = User::where('id', $offer_price_anchor->supplier_id)->first();
//
//        $price_offer_items = OrderItemsModel::where('order_id',$offer_price_anchor->order_id)->get();
//        foreach ($price_offer_items as $key){
//            $key->product = ProductModel::where('id',$key->product_id)->first();
//            $key->unit = UnitsModel::where('id',$key->unit_id)->first();
//        }
//        $pdf = PDF::loadView('admin.orders.procurement_officer.anchor.pdf.anchor_table', ['anchor' => $offer_price_anchor, 'offer_price_anchor' => $offer_price_anchor, 'order' => $order, 'price_offer_items' => $price_offer_items]);
//        return $pdf->stream('anchor.pdf');
    }

    public function compare_price_offers($order_id){
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

        $pdf = PDF::loadView('admin.orders.procurement_officer.anchor.pdf.compare_price_offers', ['anchor' => $anchor, 'order' => $order, 'offer_price_anchor' => $offer_price_anchor, 'order_items' => $order_items, 'query' => $query]);
        return $pdf->stream('anchor.pdf');
    }

    public function upload_image(Request $request){
        $data = PriceOffersModel::where('id',$request->price_offer_id)->first();
        if ($request->hasFile('award_attachment')) {
            $file = $request->file('award_attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'procurement_officer.' . $extension;
            $file->storeAs('award_attachment', $filename, 'public');
            $data->award_attachment = $filename;
        }
        if ($data->save()) {
            return redirect()->route('procurement_officer.orders.anchor.index', ['order_id' => $data->order_id])->with(['success' => 'تم اضافة الصورة بنجاح']);
        } else {
            return redirect()->route('procurement_officer.orders.anchor.index', ['order_id' => $data->order_id])->with(['fail' => 'لم تتم الاضافة بنجاح هناك خلل ما']);
        }
    }

    public function delete_attachment($id){
        $data = PriceOffersModel::where('id',$id)->first();
        $data->award_attachment = null;
        if ($data->save()) {
            return redirect()->route('procurement_officer.orders.anchor.index', ['order_id' => $data->order_id])->with(['success' => 'تم اضافة الصورة بنجاح']);
        } else {
            return redirect()->route('procurement_officer.orders.anchor.index', ['order_id' => $data->order_id])->with(['fail' => 'لم تتم الاضافة بنجاح هناك خلل ما']);
        }
    }

    public function edit_anchor_note(Request $request){
        $data = PriceOffersModel::where('id',$request->note_id)->first();
        $data->award_note = $request->note_text;
        if($data->save()){
            return redirect()->back()->with(['success'=>'تم التعديل بنجاح']);
        }
        else{
            return redirect()->back()->with(['fail'=>'هناك خلل ما لم يتم التعديل بنجاح']);
        }
    }
}
