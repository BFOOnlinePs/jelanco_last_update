<?php

namespace App\Http\Controllers\procurement_officer;

use App\Http\Controllers\Controller;
use App\Models\CurrencyModel;
use App\Models\OrderModel;
use App\Models\OrderStatusModel;
use App\Models\ShippingMethodsModel;
use App\Models\ShippingPriceOfferModel;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Currency;

class ShippingController extends Controller
{
    public $progress_status = 5;
    public function index($order_id)
    {
//        $check_if_find_award_status = ShippingPriceOfferModel::where('award_status',1)->where('order_id',$order_id)->first();
//        $shipping_award = '';
        $shipping_award = ShippingPriceOfferModel::where('order_id', $order_id)->where('award_status', 1)->get();
        foreach ($shipping_award as $key) {
            $key->comapny = User::where('id', $key->shipping_company_id)->first();
        }
        $order = OrderModel::where('id', $order_id)->first();
        $order->user = User::where('id',$order->user_id)->first();
        $order->to_user = User::where('id',$order->to_user)->first();

        $user = User::where('user_role', 5)->get();
        $currency = CurrencyModel::get();
        $data = ShippingPriceOfferModel::where('order_id', $order_id)->get();
        foreach ($data as $key) {
            $key->shipping = User::where('id', $key->shipping_company_id)->first();
            $key->added_by = User::where('id', $key->user_id)->first();
            $key->currency = CurrencyModel::where('id', $key->currency_id)->first();
        }
        $shipping_methods = ShippingMethodsModel::get();
        return view('admin.orders.procurement_officer.shipping.index', ['data' => $data, 'order' => $order, 'user' => $user, 'currency' => $currency, 'shipping_award' => $shipping_award,'shipping_methods'=>$shipping_methods]);
    }

    public function create(Request $request)
    {
        $check_progress_status = OrderModel::where('id',$request->order_id)->first();
        $check_find = ShippingPriceOfferModel::where('order_id', $request->order_id)->where('shipping_company_id', $request->shipping_company_id)->first();
        if (!empty($check_find)) {
            return redirect()->route('procurement_officer.orders.shipping.index', ['order_id' => $check_find->order_id])->with(['fail' => 'لقد تم اضافة عرض سعر لهذه الشركة مسبقا']);
        } else {
            $data = new ShippingPriceOfferModel();
            $data->order_id = $request->order_id;
            $data->user_id = auth()->user()->id;
            $data->shipping_company_id = $request->shipping_company_id;
            $data->price = $request->price;
            $data->currency_id = $request->currency_id;

            if (($check_progress_status->progress_status) <= $this->progress_status){
                $check_progress_status->progress_status = $this->progress_status;
                $check_progress_status->save();
            }

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . 'procurement_officer.' . $extension;
                $file->storeAs('attachment', $filename, 'public');
                $data->attachment = $filename;
            }
            $data->status = 0;
            $data->note = $request->note;
            $data->award_status = 0;
            $data->cbn = $request->cbn;
            $data->total_weight = $request->total_weight;
            $data->shipping_type = $request->shipping_type;
            $data->net_weight = $request->net_weight;
            $data->shipping_rating = $request->shipping_rating;
            $data->container_size = $request->container_size;
            $data->cooling_type = $request->cooling_type;
            $data->shipping_method = $request->shipping_method;
            if ($data->save()) {
                return redirect()->route('procurement_officer.orders.shipping.index', ['order_id' => $data->order_id])->with(['success' => 'تم اضافة الباينات بنجاح']);
            } else {
                return redirect()->route('procurement_officer.orders.shipping.index', ['order_id' => $data->order_id])->with(['fail' => 'هناك خلل ما لم يتم اضافة البيانات']);
            }
        }
    }

    public function edit($id)
    {
        $data = ShippingPriceOfferModel::find($id);
        $currency = CurrencyModel::get();
        $user = User::where('user_role', 5)->get();
        $shipping_methods = ShippingMethodsModel::get();
        return view('admin.orders.procurement_officer.shipping.edit', ['data' => $data, 'currency' => $currency, 'user' => $user,'shipping_methods'=>$shipping_methods]);
    }

    public function update(Request $request)
    {
        $data = ShippingPriceOfferModel::find($request->id);
        $data->user_id = auth()->user()->id;
        $data->shipping_company_id = $request->shipping_company_id;
        $data->price = $request->price;
        $data->currency_id = $request->currency_id;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'procurement_officer.' . $extension;
            $file->storeAs('attachment', $filename, 'public');
            $data->attachment = $filename;
        }
        $data->status = 0;
        $data->note = $request->note;
        $data->cbn = $request->cbn;
        $data->total_weight = $request->total_weight;
        $data->shipping_type = $request->shipping_type;
        $data->net_weight = $request->net_weight;
        $data->shipping_rating = $request->shipping_rating;
        $data->container_size = $request->container_size;
        $data->cooling_type = $request->cooling_type;
        $data->shipping_method = $request->shipping_method;
        if ($data->save()) {
            return redirect()->route('procurement_officer.orders.shipping.index', ['order_id' => $data->order_id])->with(['success' => 'تم تعديل البيانات بنجاح']);
        } else {
            return redirect()->route('procurement_officer.orders.shipping.index', ['order_id' => $data->order_id])->with(['fail' => 'هناك خلل ما لم يتم تعديل البيانات']);
        }
    }

    public function delete($id)
    {
        $data = ShippingPriceOfferModel::where('id', $id);
        if ($data->delete()) {
            return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
        } else {
            return redirect()->back()->with(['fail' => 'هناك خلل ما لم يتم الحذف']);
        }
    }

    public function details($id)
    {
        $data = ShippingPriceOfferModel::where('id', $id)->first();
        $data['added_by'] = User::where('id', $data->user_id)->first();
        $data['shipping'] = User::where('id', $data->shipping_company_id)->first();
        $data['currency'] = CurrencyModel::where('id', $data->currency_id)->first();
        return view('admin.orders.procurement_officer.shipping.details', ['data' => $data]);
    }

    public function create_shipping_award(Request $request)
    {
        $data = ShippingPriceOfferModel::find($request->id);
        $data->shipping_reservation_date = $request->shipping_reservation_date;
        $data->expected_exit_date = $request->expected_exit_date;
        $data->expected_arrival_date = $request->expected_arrival_date;
        $data->shipping_line = $request->shipping_line;
        if ($request->hasFile('Initial_bill_of_lading')) {
            $file = $request->file('Initial_bill_of_lading');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'procurement_officer.' . $extension;
            $file->storeAs('attachment', $filename, 'public');
            $data->Initial_bill_of_lading = $filename;
        }
        if ($request->hasFile('actual_bill_of_lading')) {
            $file = $request->file('actual_bill_of_lading');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'procurement_officer.' . $extension;
            $file->storeAs('attachment', $filename, 'public');
            $data->actual_bill_of_lading = $filename;
        }
        $data->award_status = 1;
        $data->award_notes = $request->award_notes;
        if ($data->save()) {
            return redirect()->back()->with(['success' => 'تم اضافة الترسية بنجاح']);
        } else {
            return redirect()->back()->with(['fail' => 'هناك خلل ما لم تتم الاضافة بنجاح']);
        }
    }

    public function shipping_award_status_disable($id)
    {
        $data = ShippingPriceOfferModel::find($id);
        $data->award_status = 0;
        if ($data->save()) {
            return redirect()->back()->with(['success' => 'تم الغاء الترسية بنجاح']);
        } else {
            return redirect()->back()->with(['fail' => 'هناك خلل ما لم يتم الغاء الترسية']);
        }
    }

    public function edit_shipping_award($id)
    {
        $data = ShippingPriceOfferModel::find($id);
        return view('admin.orders.procurement_officer.shipping.award_shipping', ['data' => $data]);
    }

    public function update_shipping_award(Request $request)
    {
        $data = ShippingPriceOfferModel::find($request->id);
        $data->shipping_reservation_date = $request->shipping_reservation_date;
        $data->expected_exit_date = $request->expected_exit_date;
        $data->expected_arrival_date = $request->expected_arrival_date;
        $data->shipping_line = $request->shipping_line;
        $data->status = $request->status;
        if ($request->hasFile('Initial_bill_of_lading')) {
            $file = $request->file('Initial_bill_of_lading');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'procurement_officer.' . $extension;
            $file->storeAs('attachment', $filename, 'public');
            $data->Initial_bill_of_lading = $filename;
        }
        if ($request->hasFile('actual_bill_of_lading')) {
            $file = $request->file('actual_bill_of_lading');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'procurement_officer.' . $extension;
            $file->storeAs('attachment', $filename, 'public');
            $data->actual_bill_of_lading = $filename;
        }
        $data->award_notes = $request->award_notes;
        if ($data->save()) {
            return redirect()->route('procurement_officer.orders.shipping.index', ['order_id' => $data->order_id])->with(['success' => 'تم تعديل الترسية بنجاح']);
        } else {
            return redirect()->route('procurement_officer.orders.shipping.index', ['order_id' => $data->order_id])->with(['fail' => 'هناك خلل ما لم يتم التعديل']);
        }
    }

    public function edit_shipping_note(Request $request){
        $data = ShippingPriceOfferModel::where('id',$request->note_id)->first();
        $data->note = $request->note_text;
        if($data->save()){
            return redirect()->back()->with(['success'=>'تم التعديل بنجاح']);
        }
        else{
            return redirect()->back()->with(['fail'=>'هناك خلل ما لم يتم التعديل بنجاح']);
        }
    }

    public function update_shipping_status(Request $request){
        $data = ShippingPriceOfferModel::where('id',$request->id)->first();
        $data->status = $request->status;
        if ($data->save()){
            return response()->json([
                'success' => 'true'
            ]);
        }
    }
}
