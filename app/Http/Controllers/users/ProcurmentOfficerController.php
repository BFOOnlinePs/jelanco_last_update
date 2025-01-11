<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\CashPaymentsModel;
use App\Models\CompanyContactPersonModel;
use App\Models\CurrencyModel;
use App\Models\LetterBankModel;
use App\Models\LetterBankModificationModel;
use App\Models\OrderAttachmentModel;
use App\Models\OrderClearanceModel;
use App\Models\OrderInsuranceModel;
use App\Models\OrderItemsModel;
use App\Models\OrderLocalDeliveryModel;
use App\Models\OrderModel;
use App\Models\OrderNotesModel;
use App\Models\OrderStatusModel;
use App\Models\PriceOffersModel;
use App\Models\ProductModel;
use App\Models\ShippingPriceOfferModel;
use App\Models\UnitsModel;
use App\Models\User;
use App\Models\UserCategoryModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use PDF;

class ProcurmentOfficerController extends Controller
{
    public function index()
    {
        $data = User::where('user_role', 2)->get();
        $supplier = User::where('user_role', 4)->get();
        return view('admin.users.procurement_officer.index', ['data' => $data, 'supplier' => $supplier]);
    }

    public function add()
    {
        $user_category = UserCategoryModel::get();
        return view('admin.users.procurement_officer.add',['user_category'=>$user_category]);
    }

    public function create(Request $request)
    {
        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->user_phone1 = $request->user_phone1;
        $data->user_phone2 = $request->user_phone2;
        $data->user_role = 2;
        $data->user_status = 1;
        $data->user_reg_date = Carbon::now();
        if ($request->hasFile('user_photo')) {

            $file = $request->file('user_photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('user_photo', $filename, 'public');
            $data->user_photo = $filename;
        }
        $data->user_notes = $request->user_notes;
        $data->user_website = $request->user_website;
        $data->user_address = $request->user_address;
        $data->user_category = $request->user_category;
//        $data->user_account_number = $request->user_account_number;
//        $data->user_bank_name = $request->user_bank_name;
//        $data->user_bank_address = $request->user_bank_address;
//        $data->user_swift_code = $request->user_swift_code;
//        $data->user_iban_number = $request->user_iban_number;
        if ($data->save()) {
            return redirect()->route('users.procurement_officer.index')->with(['success' => 'تم اضافة البيانات بنجاح']);
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        $data = User::where('id', $id)->first();
        $user_category = UserCategoryModel::get();

        return view('admin.users.procurement_officer.edit', ['data' => $data,'user_category'=>$user_category]);
    }

    public function update($id, Request $request)
    {
        $data = User::where('id', $id)->first();
        $data->name = $request->name;
        $data->email = $request->email;
        if ($request->password != '') {
            $data->password = Hash::make($request->password);
        }
        $data->user_phone1 = $request->user_phone1;
        $data->user_phone2 = $request->user_phone2;
        if ($request->photo != '') {
            if ($request->hasFile('user_photo')) {
                $file = $request->file('user_photo');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->storeAs('user_photo', $filename, 'public');
                $data->user_photo = $filename;
            }
        }
        $data->user_notes = $request->user_notes;
        $data->user_website = $request->user_website;
        $data->user_category = $request->user_category;
//        $data->user_account_number = $request->user_account_number;
//        $data->user_bank_name = $request->user_bank_name;
//        $data->account_owner = $request->account_owner;
//        $data->user_bank_address = $request->user_bank_address;
//        $data->user_swift_code = $request->user_swift_code;
//        $data->user_iban_number = $request->user_iban_number;
        if ($data->save()) {
            return redirect()->route('users.procurement_officer.edit', ['id' => $id])->with(['success' => 'تم تعديل البيانات بنجاح']);
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function details($id)
    {
        $data = User::where('id', $id)->first();
        $company_contact_person = CompanyContactPersonModel::where('company_id', $id)->get();
//        foreach ($company_contact_person as $key){
//            $key['company'] = User::where('id',$key->company_id)->first();
//        }
        return view('admin.users.procurement_officer.details', ['data' => $data, 'company_contact_person' => $company_contact_person]);
    }

    // TODO Fro Orders
    public function orders_index()
    {
        $order_status = OrderStatusModel::orderBy('id','desc')->get();
        $currency = CurrencyModel::get();
        $users = User::whereIn('user_role',[1,2,3])->orWhere('id',1)->get();
        $data = OrderModel::where('order_status', 1)->orderBy('id','DESC')->get();
        foreach ($data as $key) {
            $key->user = User::where('id', $key->user_id)->first();
            $key->supplier = PriceOffersModel::where('order_id', $key->id)->get();
            foreach ($key->supplier as $child) {
                $child->name = User::select('name')->where('id', $child->supplier_id)->first();
            }
        }
        $supplier = User::where('user_role', 4)->get();
        $user_category = UserCategoryModel::get();
        return view('admin.orders.procurement_officer.index', ['data' => $data, 'currency' => $currency, 'users'=>$users , 'supplier' => $supplier,'order_status'=>$order_status,'user_category'=>$user_category]);
    }

    public function order_items_index($order_id)
    {
        $data = OrderItemsModel::where('order_id', $order_id)->get();
        foreach ($data as $key) {
            $key->product = ProductModel::where('id', $key->product_id)->first();
            $key->unit = UnitsModel::where('id', $key->unit_id)->first();
        }
        $users = User::where('user_role', 4)->get();
        $unit = UnitsModel::get();
        $product = ProductModel::get();
        $order = OrderModel::where('id', $order_id)->first();
        $offer_price = PriceOffersModel::where('order_id', $order_id)->get();
        $offer_price_anchor = PriceOffersModel::where('order_id', $order_id)->where('status', 0)->get();
        $anchor = PriceOffersModel::where('status', 1)->get();
        foreach ($offer_price_anchor as $key) {
            $key->user = User::where('id', $key->user_id)->first();
            $key->supplier = User::where('id', $key->supplier_id)->first();
        }
        foreach ($anchor as $key) {
            $key->user = User::where('id', $key->user_id)->first();
            $key->supplier = User::where('id', $key->supplier_id)->first();
        }
        foreach ($offer_price as $key) {
            $key->user = User::where('id', $key->user_id)->first();
            $key->supplier = User::where('id', $key->supplier_id)->first();
        }

        $order_notes = OrderNotesModel::where('order_id', $order->id)->get();
        foreach ($order_notes as $key) {
            $key->user = User::where('id', $key->user_id)->first();
        }

        $order_attachment = OrderAttachmentModel::where('order_id', $order_id)->get();
        foreach ($order_attachment as $key) {
            $key->user = User::where('id', $key->user_id)->first();
        }

        $currency = CurrencyModel::get();
        return view('admin.orders.procurement_officer.order_items', ['data' => $data, 'order' => $order, 'unit' => $unit, 'product' => $product, 'users' => $users, 'offer_price' => $offer_price, 'anchor' => $anchor, 'offer_price_anchor' => $offer_price_anchor, 'order_notes' => $order_notes, 'order_attachment' => $order_attachment, 'currency' => $currency]);
    }

    public function create_order(Request $request)
    {
        $data = new OrderModel();
        $data->user_id = auth()->user()->id;
        $data->order_status = 2;
        $data->inserted_at = Carbon::now();
        if (empty($request->reference_number)){
            $data->reference_number = 0;
        }
        else{
            $data->reference_number = $request->reference_number;
        }
        $data->to_user = auth()->user()->id;
        $data->save();
        for ($i = 0; $i < count($request->supplier); $i++) {
            $price_offer = new PriceOffersModel();
            $price_offer->order_id = $data->id;
            $price_offer->user_id = auth()->user()->id;
            $price_offer->supplier_id = $request->supplier[$i];
            $price_offer->currency_id = CurrencyModel::first()->id;
            $price_offer->status = 0;
            $price_offer->save();
        }
        if ($price_offer) {
            return redirect()->route('procurement_officer.orders.product.index', ['order_id' => $data->id]);
        }
    }

    public function create_order_items(Request $request)
    {
        $data = new OrderItemsModel();
        $data->order_id = $request->order_id;
        $data->product_id = $request->product_id;
        $data->qty = $request->qty;
        $data->unit_id = $request->unit_id;
        $data->notes = $request->notes;
        $data->status = 1;
        if ($data->save()) {
            return redirect()->route('orders.procurement_officer.order_items_index', ['order_id' => $request->order_id])->with(['success' => 'تم اضافة البيانات بنجاح', 'tab_id' => 1]);
        } else {
            return redirect()->route('orders.procurement_officer.order_items_index', ['order_id' => $request->order_id])->with(['fail' => 'هناك خطا ما لم يتم اضافة البيانات']);
        }
    }

    public function deleteItems($order_item_id)
    {
        $data = OrderItemsModel::where('id', $order_item_id)->delete();
        if ($data) {
            return response()->json([
                'success' => 'true'
            ]);
        }
    }

    public function order_table(Request $request)
    {
        Cache::forget('order_table_data');
        Cache::forget('order_table_request');
        $order_status = OrderStatusModel::get();
        $supplierId = $request->supplier_id;
        $referenceNumber = $request->reference_number;
        $from = $request->from;
        $to = $request->to;

        $data = OrderModel::query()
            ->when(!empty($supplierId), function ($query) use ($supplierId) {
                $query->whereIn('id', function ($query) use ($supplierId) {
                    $query->select('order_id')
                        ->from('price_offers')
                        ->where('supplier_id', $supplierId);
                });
            })
            ->when(!empty($referenceNumber), function ($query) use ($referenceNumber) {
                $query->where('reference_number','like','%'. $referenceNumber. '%');
            })
            ->when(!empty($request->order_status), function ($query) use ($request) {
                $query->where('order_status', $request->order_status);
            })
            ->where(function ($query) use ($from, $to) {
                $query->whereBetween('inserted_at', [$from, $to])
                    ->orWhereNull('inserted_at');
            })
            ->when(!empty($request->to_user),function ($query) use ($request){
                $query->where('to_user','like','%'.$request->to_user.'%');
            })
            ->when(!empty($request->user_category), function ($query) use ($request) {
                $query->whereIn('id', function ($query) use ($request) {
                    $query->select('order_id')
                        ->from('price_offers')
                        ->whereIn('supplier_id', function ($query) use ($request){
                            $query->select('id')->from('users')->whereJsonContains('user_category',$request->user_category)->get();
                    });
                });
            })
            ->when(!empty($request->supplier_type), function ($query) use ($request) {
                $query->whereIn('id', function ($query) use ($request) {
                    $query->select('order_id')
                        ->from('price_offers')
                        ->whereIn('supplier_id', function ($query) use ($request){
                            $query->select('id')->from('users')->where('potential_suppliers',$request->supplier_type)->get();
                        });
                });
            })
            ->where('order_status', '!=', -1)->where('order_status', '!=', 0)->where('order_status','!=',10)
            ->where('delete_status',0)
            ->orderBy('id','desc')
            ->paginate(20);

        foreach ($data as $key) {
            $key->order_status_color = OrderStatusModel::find($key->order_status);
            $key->user = User::find($key->user_id);
            $key->to_user = User::where('id', $key->to_user)->first();
            $key->supplier = PriceOffersModel::where('order_id', $key->id)->get();
            $key->expected_arrival_date = ShippingPriceOfferModel::where('order_id',$key->id)->where('award_status',1)->first()->expected_arrival_date ?? '';
            foreach ($key->supplier as $child) {
                $child->name = User::find($child->supplier_id);
                $userCategoryIds = json_decode($child->name->user_category, true);
                if (is_array($userCategoryIds) && count($userCategoryIds) > 0) {
                    $child->user_categories = UserCategoryModel::whereIn('id', $userCategoryIds)->pluck('name')->toArray();
                } else {
                    $child->user_categories = [];
                }
            }
        }
        $users = User::where('user_role',1)->orWhere('user_role',2)->orWhere('user_role',3)->orWhere('user_role',9)->get();
        $requestData = $request->all();
        Cache::put('order_table_data',$data);
        Cache::put('order_table_request',$requestData);
        return response()->view('admin.orders.procurement_officer.ajax.order_table', ['data' => $data,'order_status'=>$order_status,'users'=>$users,'view'=>'admin']);
    }

    public function update_reference_number(Request $request)
    {
        $data = OrderModel::find($request->order_id);
        $data->reference_number = $request->reference_number;
        if ($request->view == 'officer_view'){
            if ($data->save()) {
                return redirect()->route('orders.procurement_officer.listOrderForOfficerIndex')->with(['success' => 'تم اضافة البيانات بنجاح', 'tab_id' => 1]);
            } else {
                return redirect()->route('orders.procurement_officer.listOrderForOfficerIndex')->with(['fail' => 'هناك خطا ما لم يتم اضافة البيانات']);
            }
        }
        else{
            if ($data->save()) {
                return redirect()->route('orders.procurement_officer.order_index')->with(['success' => 'تم اضافة البيانات بنجاح', 'tab_id' => 1]);
            } else {
                return redirect()->route('orders.procurement_officer.order_index')->with(['fail' => 'هناك خطا ما لم يتم اضافة البيانات']);
            }
        }

    }

    public function getReferenceNumber(Request $request)
    {
        $data = OrderModel::find($request->order_id);
        return response()->json($data);
    }

    public function delete_order($id){
        $data = OrderModel::find($id);
        $data->delete_status = 1;

        if ($data->update()) {
            return redirect()->route('orders.procurement_officer.order_index')->with(['success' => 'تم حذف الفاتورة بنجاح']);
        } else {
            return redirect()->route('orders.procurement_officer.order_index')->with(['fail' => 'هناك خلل ما لم تتم عملية الحذف']);
        }
    }

    public function list_orders_from_storekeeper(){
        $data =  OrderModel::where('order_status',1)->orderBy('id','DESC')->get();
        foreach ($data as $key){
            $key->user = User::where('id',$key->user_id)->first();
        }
        return view('admin.orders.procurement_officer.list_order_storekepper.index',['data'=>$data]);
    }

    public function updateOrderStatus(Request $request){
        $data = OrderModel::where('id',$request->order_id)->first();
        $data->order_status = $request->order_status_id;
        $order_status_color = OrderStatusModel::where('id',$data->order_status)->first();
        if ($data->save()){
            return response()->json([
                'success' => 'true',
                'order_status_color'=>$order_status_color
            ]);
        }
    }

    public function show_due_date(Request $request){
        $data = OrderModel::find($request->order_id);
        return response()->json($data);
    }

    public function update_due_date(Request $request){
        $data = OrderModel::where('id',$request->order_id)->first();
        $data->inserted_at = $request->due_date;
        if ($request->view == 'officer_view'){
            if ($data->save()) {
                return redirect()->route('orders.procurement_officer.listOrderForOfficerIndex')->with(['success' => 'تم تعديل البيانات بنجاح']);
            } else {
                return redirect()->route('orders.procurement_officer.listOrderForOfficerIndex')->with(['fail' => 'هناك خطا ما لم يتم تعديل البيانات']);
            }
        }
        else{
            if ($data->save()) {
                return redirect()->route('orders.procurement_officer.order_index')->with(['success' => 'تم تعديل البيانات بنجاح']);
            } else {
                return redirect()->route('orders.procurement_officer.order_index')->with(['fail' => 'هناك خطا ما لم يتم تعديل البيانات']);
            }
        }
    }

    public function updateToUser(Request $request){
        $data = OrderModel::where('id',$request->order_id)->first();
        $data->to_user = $request->to_user;
        if ($data->save()){
            return response()->json([
                'success' => 'true',
            ]);
        }
    }

    public function listOrderForOfficerIndex(){
        $order_status = OrderStatusModel::get();
        $currency = CurrencyModel::get();
        $users = User::whereIn('user_role',[1,2,3])->orWhere('id',1)->get();
        $data = OrderModel::where('order_status', 1)->orderBy('id','DESC')->get();
        foreach ($data as $key) {
            $key->user = User::where('id', $key->user_id)->first();
            $key->supplier = PriceOffersModel::where('order_id', $key->id)->get();
            foreach ($key->supplier as $child) {
                $child->name = User::select('name')->where('id', $child->supplier_id)->first();
            }
        }
        $supplier = User::where('user_role', 4)->get();
        return view('admin.orders.procurement_officer.listOrderForOfficer.index', ['data' => $data, 'currency' => $currency, 'users'=>$users , 'supplier' => $supplier,'order_status'=>$order_status,'view'=>'officer_view']);

    }

    public function listOrderForOfficer(Request $request){
        $order_status = OrderStatusModel::get();
        $supplierId = $request->supplier_id;
        $referenceNumber = $request->reference_number;
        $from = $request->from;
        $to = $request->to;

        $data = OrderModel::query()
            ->where('to_user',auth()->user()->id)
            ->when(!empty($supplierId), function ($query) use ($supplierId) {
                $query->whereIn('id', function ($query) use ($supplierId) {
                    $query->select('order_id')
                        ->from('price_offers')
                        ->where('supplier_id', $supplierId);
                });
            })
            ->when(!empty($referenceNumber), function ($query) use ($referenceNumber) {
                $query->where('reference_number','like','%'. $referenceNumber. '%');
            })
            ->when(!empty($request->order_status), function ($query) use ($request) {
                $query->where('order_status', $request->order_status);
            })
            ->where(function ($query) use ($from, $to) {
                $query->whereBetween('inserted_at', [$from, $to])
                    ->orWhereNull('inserted_at');
            })
//            ->when(!empty($request->to_user),function ($query) use ($request){
//                $query->where('to_user','like','%'.$request->to_user.'%');
//            })
//            ->when(!empty($request->order_status), function ($query) use ($request) {
//                $query->where('reference_number','like','%'. $request->order_status. '%');
//            })
            ->where('order_status', '!=', -1)
            ->orderBy('inserted_at','desc')
            ->take(30)
            ->get();

        foreach ($data as $key) {
            $key->order_status_color = OrderStatusModel::find($key->order_status);
            $key->user = User::find($key->user_id);
            $key->to_user = User::where('id', $key->to_user)->first();
            $key->supplier = PriceOffersModel::where('order_id', $key->id)->get();

            foreach ($key->supplier as $child) {
                $child->name = User::find($child->supplier_id);
            }
        }
        $users = User::where('user_role',1)->orWhere('user_role',2)->orWhere('user_role',3)->orWhere('user_role',9)->get();
        return response()->view('admin.orders.procurement_officer.ajax.order_table', ['data' => $data,'order_status'=>$order_status,'users'=>$users,'view'=>'officer_view']);
    }

    public function delete_note_from_order($id,$modal_name){
        $data = '';
        if($modal_name == 'price_offer'){
            $data = PriceOffersModel::where('id',$id)->first();
            $data->notes = null;
        }
        if($modal_name == 'anchor'){
            $data = PriceOffersModel::where('id',$id)->first();
            $data->award_note = null;
        }
        if($modal_name == 'cash_payments'){
            $data = CashPaymentsModel::where('id',$id)->first();
            $data->notes = null;
        }
        if($modal_name == 'letter_bank'){
            $data = LetterBankModel::where('id',$id)->first();
            $data->notes = null;
        }
        if($modal_name == 'letter_bank_modification'){
            $data = LetterBankModificationModel::where('id',$id)->first();
            $data->notes = null;
        }
        if($modal_name == 'shipping'){
            $data = ShippingPriceOfferModel::where('id',$id)->first();
            $data->note = null;
        }
        if($modal_name == 'insurance'){
            $data = OrderInsuranceModel::where('id',$id)->first();
            $data->notes = null;
        }
        if($modal_name == 'clerance'){
            $data = OrderClearanceModel::where('id',$id)->first();
            $data->notes = null;
        }
        if($modal_name == 'delivery'){
            $data = OrderLocalDeliveryModel::where('id',$id)->first();
            $data->notes = null;
        }
        if($modal_name == 'order_notes'){
            $data = OrderNotesModel::where('id',$id);
            if($data->delete()){
                return redirect()->back()->with(['success'=>'تم حذف الملاحظة بنجاح']);
            }
            else{
                return redirect()->back()->with(['fail'=>'لم يتم حذف الملاحظة بنجاح']);
            }
        }
        if($data->save()){
            return redirect()->back()->with(['success'=>'تم حذف الملاحظة بنجاح']);
        }
        else{
            return redirect()->back()->with(['fail'=>'لم يتم حذف الملاحظة بنجاح']);
        }
    }

    public function print_order_pdf(Request $request){
        $order_status = OrderStatusModel::get();
        $supplierId = $request->supplier_id;
        $referenceNumber = $request->reference_number;
        $from = $request->from;
        $to = $request->to;

        $data = Cache::get('order_table_data');
        $order_table_request = Cache::get('order_table_request');
        $order_table_request['supplier_id'] = User::where('id',$order_table_request['supplier_id'])->first();
        $order_table_request['to_user'] = User::where('id',$order_table_request['to_user'])->first();
        $order_table_request['order_status'] = OrderStatusModel::where('id',$order_table_request['order_status'])->first();
        $users = User::where('user_role',1)->orWhere('user_role',2)->orWhere('user_role',3)->orWhere('user_role',9)->get();
        foreach($data as $key){
            $key->supplier = PriceOffersModel::where('order_id', $key->id)->get();
            $key->expected_arrival_date = ShippingPriceOfferModel::where('order_id',$key->id)->first()->expected_arrival_date ?? '';
            foreach ($key->supplier as $child) {
                $child->name = User::find($child->supplier_id);
                $userCategoryIds = json_decode($child->name->user_category, true);
                if (is_array($userCategoryIds) && count($userCategoryIds) > 0) {
                    $child->user_categories = UserCategoryModel::whereIn('id', $userCategoryIds)->pluck('name')->toArray();
                } else {
                    $child->user_categories = [];
                }
            }
        }
        $pdf = PDF::loadView('admin.orders.procurement_officer.pdf.order_print', ['data' => $data,'order_status'=>$order_status,'users'=>$users,'view'=>'admin','request'=>$request,'order_table_request'=>$order_table_request]);
        return $pdf->stream('order_print.pdf');
//            return response()->view('admin.orders.procurement_officer.ajax.order_table', ['data' => $data,'order_status'=>$order_status,'users'=>$users,'view'=>'admin']);

    }
}
