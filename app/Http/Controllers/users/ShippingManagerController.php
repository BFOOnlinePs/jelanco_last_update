<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\CompanyContactPersonModel;
use App\Models\CurrencyModel;
use App\Models\OrderItemsModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\ShippingPriceOfferModel;
use App\Models\UnitsModel;
use App\Models\User;
use App\Models\UserCategoryModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ShippingManagerController extends Controller
{
    public function index(){
        $data = User::where('user_role',11)->get();
        return view('admin.users.shipping_manager.index',['data'=>$data]);
    }

    public function add(){
        $user_category = UserCategoryModel::get();
        return view('admin.users.shipping_manager.add',['user_category'=>$user_category]);
    }

    public function create(Request $request){
        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->user_phone1 = $request->user_phone1;
        $data->user_phone2 = $request->user_phone2;
        $data->user_role = 11;
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
        if ($data->save()){
            return redirect()->route('users.shipping_manager.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->back()->withInput();
        }
    }

    public function edit($id){
        $data = User::where('id',$id)->first();
        $user_category = UserCategoryModel::get();
        return view('admin.users.shipping_manager.edit',['data'=>$data,'user_category'=>$user_category,'user_category'=>$user_category]);
    }

    public function update($id,Request $request){
        $data = User::where('id',$id)->first();
        $data->name = $request->name;
        $data->email = $request->email;
        if ($request->password != ''){
            $data->password = Hash::make($request->password);
        }
        $data->user_phone1 = $request->user_phone1;
        $data->user_phone2 = $request->user_phone2;
        if ($request->photo != ''){
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
            return redirect()->route('users.shipping_manager.edit',['id'=>$id])->with(['success' => 'تم تعديل البيانات بنجاح']);
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function details($id){
        $data = User::where('id',$id)->first();
        $company_contact_person = CompanyContactPersonModel::where('company_id',$id)->get();
//        foreach ($company_contact_person as $key){
//            $key['company'] = User::where('id',$key->company_id)->first();
//        }
        return view('admin.users.shipping_manager.details',['data'=>$data,'company_contact_person'=>$company_contact_person]);
    }

    public function personal_account($id){
        $data = User::where('id',$id)->first();
        return view('admin.users.personal_account',['data'=>$data]);
    }

    public function shipping_details($order_id){
        $data = ShippingPriceOfferModel::where('order_id',$order_id)->first();
        if(!empty($data)){
            $data['added_by'] = User::where('id', $data->user_id ?? '')->first();
            $data['shipping'] = User::where('id', $data->shipping_company_id ?? '')->first();
            $data['currency'] = CurrencyModel::where('id', $data->currency_id ?? '')->first();
        }
        return view('admin.orders.shipping_manager.shipping_info',['data'=>$data]);
    }

    public function update_notes_in_orders(Request $request){
        $data = OrderModel::where('id',$request->id)->first();
        $data->st_notes = $request->st_notes;
        if ($data->save()){
            return response()->json([
                'success'=>'true',
                'message'=>'تم تعديل البيانات بنجاح'
            ]);
        }
    }

    public function upload_attachment_in_order(Request $request){
        $data = OrderModel::where('id',$request->id)->first();
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('attachment', $filename, 'public');
            $data->st_attachment = $filename;
        }
        if ($data->save()){
            return redirect()->route('orders.order_items.index',['order_id'=>$data->id])->with(['success'=>'تم اضافة المرفق بنجاح']);
        }
        else{
            return redirect()->route('orders.order_items.index',['order_id'=>$data->id])->with(['fail'=>'هناك خلل ما لم يتم اضافة المرفق']);
        }
    }

    public function delete_attachment_in_order($id){
        $data = OrderModel::where('id',$id)->first();
        $data->st_attachment = null;
        if ($data->save()){
            return redirect()->route('orders.order_items.index',['order_id'=>$id])->with(['success'=>'تم حذف البيانات بنجاح']);
        }
        else{
            return redirect()->route('orders.order_items.index',['order_id'=>$id])->with(['fail'=>'لم يتم حذف البيانات بنجاح']);
        }
    }
}
