<?php

namespace App\Http\Controllers\procurement_officer;

use App\Exports\PriceOfferExport;
use App\Http\Controllers\Controller;
use App\Imports\PriceOffersImport;
use App\Models\CurrencyModel;
use App\Models\OrderItemsModel;
use App\Models\OrderModel;
use App\Models\PriceOfferItemsModel;
use App\Models\PriceOffersModel;
use App\Models\ProductModel;
use App\Models\UnitsModel;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PriceOfferController extends Controller
{
    public $progress_status = 2;
    public function index($order_id)
    {
        $order = OrderModel::where('id', $order_id)->first();
        $order->user = User::where('id',$order->user_id)->first();
        $order->to_user = User::where('id',$order->to_user)->first();
        $data = PriceOffersModel::where('order_id', $order_id)->get();
        foreach ($data as $key) {
            $key->supplier = User::where('id', $key->supplier_id)->first();
            $key->user = User::where('id', $key->user_id)->first();
        }
        $order_items = OrderItemsModel::where('order_id', $order_id)->get();

        foreach ($order_items as $order_item) {
            $order_item->product = ProductModel::where('id', $order_item->product_id)->first();
            $order_item->unit = UnitsModel::where('id', $order_item->unit_id)->first();
//            $order_item->offer_price_items = PriceOfferItemsModel::where('order_id',$order_item->order_id)->where('product_id',$order_item->product_id)->where('supplier_id',$key->supplier_id)->first();
        }
        $users = User::where('user_role', 4)->get();
        $currency = CurrencyModel::get();

        return view('admin.orders.procurement_officer.price_offer.index', ['data' => $data, 'order' => $order, 'users' => $users, 'currency' => $currency, 'order_items' => $order_items]);
    }

    public function get_price_offer_item_price($order_id,$product_id,$supplier_id){
        $data = PriceOfferItemsModel::where('order_id',$order_id)->where('supplier_id',$supplier_id)->where('product_id',$product_id)->first();
        return $data->price ?? '';
    }

    public function create_price_offer(Request $request)
    {

        $check_progress_status = OrderModel::where('id',$request->order_id)->first();
        $check_find = PriceOffersModel::where('order_id',$request->order_id)->where('supplier_id',$request->supplier_id)->first();
        if (!empty($check_find)){
            return redirect()->route('procurement_officer.orders.price_offer.index', ['order_id' => $request->order_id])->with(['fail' => 'تم اضافة عرض سعر لهذا المورد من قبل']);
        }
        else{
            $data = new PriceOffersModel();
            $data->order_id = $request->order_id;
            $data->user_id = auth()->user()->id;
            $data->supplier_id = $request->supplier_id;
//            $data->price = $request->price;
            if (($check_progress_status->progress_status) <= $this->progress_status){
                $check_progress_status->progress_status = $this->progress_status;
                $check_progress_status->save();
            }
            $data->currency_id = CurrencyModel::first()->value('id');
            if ($request->attachment != '') {
                if ($request->hasFile('attachment')) {
                    $file = $request->file('attachment');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . 'procurement_officer.' . $extension;
                    $file->storeAs('attachment', $filename, 'public');
                    $data->attachment = $filename;
                }
            }
            $data->notes = $request->notes;
            $data->status = 0;
            if ($data->save()) {
                return redirect()->route('procurement_officer.orders.price_offer.index', ['order_id' => $request->order_id])->with(['success' => 'تم اضافة البيانات بنجاح', 'tab_id' => 2]);
            } else {
                return redirect()->route('procurement_officer.orders.price_offer.index', ['order_id' => $request->order_id])->with(['fail' => 'هناك خلل ما لم يتم اضافة البيانات']);
            }
        }
    }

    public function edit_price_offer($id)
    {
        $data = PriceOffersModel::where('id', $id)->first();
        $data->supplier = User::where('id', $data->supplier_id)->first();
        $users = User::get();
        return view('admin.orders.procurement_officer.price_offer.edit', ['data' => $data, 'users' => $users]);
    }

    public function update_price_offer($id, Request $request)
    {
        $data = PriceOffersModel::find($id);
        $data->supplier_id = $request->supplier_id;
        $data->price = $request->price;
        if ($request->attachment != '') {
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . 'procurement_officer.' . $extension;
                $file->storeAs('attachment', $filename, 'public');
                $data->attachment = $filename;
            }
        }
        $data->notes = $request->notes;
        if ($data->save()) {
            return redirect()->route('procurement_officer.orders.price_offer.index', ['order_id' => $data->order_id])->with(['success' => 'تم تعديل البيانات بنجاح']);
        } else {
            return redirect()->route('procurement_officer.orders.price_offer.index', ['order_id' => $data->order_id])->with(['fail' => 'لم يتم التعديل هناك خلل ما']);
        }
    }

    public function details_offer_price($id)
    {
        $data = PriceOffersModel::find($id);
        $data->supplier = User::where('id', $data->supplier_id)->first();
        return view('admin.orders.procurement_officer.price_offer.details', ['data' => $data]);
    }

    public function delete_offer_price($id){
        $data = PriceOffersModel::where('id',$id);
        $order = PriceOffersModel::where('id',$id)->first();
        if ($data->delete()) {
            return redirect()->route('procurement_officer.orders.price_offer.index', ['order_id' => $order->order_id])->with(['success' => 'تم حذف البيانات بنجاح']);
        } else {
            return redirect()->route('procurement_officer.orders.price_offer.index', ['order_id' => $order->order_id])->with(['fail' => 'لم بتم حذف الباينات هناك خلل ما']);
        }
    }

    public function updateCurrency(Request $request){
        $data = PriceOffersModel::where('order_id',$request->order_id)->where('supplier_id',$request->supplier_id)->first();
        $data->currency_id = $request->currency_id;
        if ($data->save()){
            return response()->json([
                'data'=>$data,
                'success'=>'true'
            ]);
        }
    }

    public function exportExcel($order_id){
        $fileName = 'price_offer.xlsx';

        return Excel::download(new PriceOfferExport($order_id), $fileName);
    }

    public function importExcel(Request $request){
        Excel::import(new PriceOffersImport($request->order_id,$request->supplier_id),$request->file('file'));
        return redirect()->back()->with(['success'=> 'تم تعديل البيانات بنجاح']);
    }

    public function edit_price_offer_note(Request $request){
        $data = PriceOffersModel::where('id',$request->note_id)->first();
        $data->notes = $request->note_text;
        if($data->save()){
            return redirect()->back()->with(['success'=>'تم التعديل بنجاح']);
        }
        else{
            return redirect()->back()->with(['fail'=>'هناك خلل ما لم يتم التعديل بنجاح']);
        }
    }

    public function get_product_for_other_orders(Request $request)
    {
        $data = PriceOfferItemsModel::where('product_id',$request->product_id)->with('order')->get();
        $product = ProductModel::where('id',$request->product_id)->first();
        return response()->json([
            'success' => 'true',
            'data' => $data,
            'product' => $product
        ]);
    }
}
