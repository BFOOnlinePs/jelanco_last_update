<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\CompanyContactPersonModel;
use App\Models\CurrencyModel;
use App\Models\DeliveryEstimationCostModel;
use App\Models\EstimationCostElementsModel;
use App\Models\User;
use App\Models\UserCategoryModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LocalCarriersController extends Controller
{
    public function index(){
        $data = User::where('user_role',7)->get();
        return view('admin.users.local_carriers.index',['data'=>$data]);
    }

    public function add(){
        $user_category = UserCategoryModel::get();
        return view('admin.users.local_carriers.add',['user_category'=>$user_category]);
    }

    public function create(Request $request){
        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->user_phone1 = $request->user_phone1;
        $data->user_phone2 = $request->user_phone2;
        $data->user_role = 7;
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
        $data->user_account_number = $request->user_account_number;
        $data->user_bank_name = $request->user_bank_name;
        $data->user_bank_address = $request->user_bank_address;
        $data->user_swift_code = $request->user_swift_code;
        $data->user_iban_number = $request->user_iban_number;
        if ($data->save()){
            return redirect()->route('users.local_carriers.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->back()->withInput();
        }
    }

    public function edit($id){
        $data = User::where('id',$id)->first();
        $user_category = UserCategoryModel::get();

        return view('admin.users.local_carriers.edit',['data'=>$data,'user_category'=>$user_category]);
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
        $data->user_account_number = $request->user_account_number;
        $data->user_bank_name = $request->user_bank_name;
        $data->account_owner = $request->account_owner;
        $data->user_bank_address = $request->user_bank_address;
        $data->user_swift_code = $request->user_swift_code;
        $data->user_iban_number = $request->user_iban_number;
        if ($data->save()) {
            return redirect()->route('users.local_carriers.edit', ['id'=>$id])->with(['success' => 'تم تعديل البيانات بنجاح']);
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function details($id){
        $data = User::where('id',$id)->first();
        $company_contact_person = CompanyContactPersonModel::where('company_id',$id)->get();
        $currency = CurrencyModel::get();

        $estimation_cost_element = EstimationCostElementsModel::get();
        $delivery_estimation_cost = DeliveryEstimationCostModel::where('company_id',$data->id)->get();
        foreach ($delivery_estimation_cost as $key){
            $key->element_cost = EstimationCostElementsModel::where('id',$key->element_cost_id)->first();
            $key->currency = CurrencyModel::where('id',$key->currency_id)->first();
        }
        return view('admin.users.local_carriers.details',['data'=>$data,'company_contact_person'=>$company_contact_person,'currency'=>$currency,'delivery_estimation_cost'=>$delivery_estimation_cost,'estimation_cost_element'=>$estimation_cost_element]);
    }

    public function create_delivery_estimation_cost(Request $request){
        $check_if_find = DeliveryEstimationCostModel::where('element_cost_id',$request->element_cost_id)->where('company_id',$request->company_id)->first();
        if ($check_if_find){
            return redirect()->back()->with(['fail' => 'تقدير التكلفة مكرر']);
        }
        else{
            $data = new DeliveryEstimationCostModel();
            $data->element_cost_id = $request->element_cost_id;
            $data->company_id = $request->company_id;
            $data->estimation_price = $request->estimation_price;
            $data->currency_id = $request->currency_id;
            if ($data->save()){
                if ($data->save()) {
                    return redirect()->back()->with(['success' => 'تم اضافة البيانات ينجاح','tab_id'=>4]);
                } else {
                    return redirect()->back()->withInput();
                }
            }
        }
    }

    public function edit_delivery($id){
        $data = DeliveryEstimationCostModel::where('id',$id)->first();
        $data->element_cost_id = EstimationCostElementsModel::where('id',$data->element_cost_id)->first();
        $data->currency = CurrencyModel::where('id',$data->currency_id)->first();
        $currency = CurrencyModel::get();
        $element_cost = EstimationCostElementsModel::get();
        return view('admin.users.local_carriers.edit.details_delivery',['data'=>$data,'currency'=>$currency,'element_cost'=>$element_cost]);
    }

    public function update_delivery(Request $request){
        $data = DeliveryEstimationCostModel::find($request->id);
        $data->element_cost_id = $request->element_cost_id;
        $data->estimation_price = $request->estimation_price;
        $data->currency_id = $request->currency_id;
        if ($data->save()){
            return redirect()->back()->with(['success'=>'تم التعديل بنجاح']);
        }
        else{
            return redirect()->back()->with(['fail'=>'هناك خطا ما لم يتم التعديل']);
        }
    }

    public function delete_delivery($id){
        $data = DeliveryEstimationCostModel::find($id);
        if ($data->delete()){
            return redirect()->back()->with(['success'=>'تم حذف البيانات بنجاح','tab_id'=>4]);
        }
        else{
            return redirect()->back()->with(['fail'=>'هناك خطا ما لم يتم التعديل','tab_id'=>4]);
        }
    }
}
