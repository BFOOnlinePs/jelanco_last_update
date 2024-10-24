<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\BankModel;
use App\Models\BankSupplierModel;
use App\Models\CompanyContactPersonModel;
use App\Models\OrderModel;
use App\Models\PriceOffersModel;
use App\Models\ProductModel;
use App\Models\ProductSupplierModel;
use App\Models\SupplierNotesModel;
use App\Models\SuppliersFollowByModel;
use App\Models\User;
use App\Models\UserCategoryModel;
use App\Models\UsersFollowUpRecordsModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class SupplierController extends Controller
{
    public function index(){
        $data = User::where('user_role',4)->get();
        // foreach($data as $key){
        //     $key->officers = SuppliersFollowByModel::where('supplier_id',$key->id)->get();
        // }
        $officer = User::where('user_role',2)->get();
        return view('admin.users.supplier.index',['data'=>$data,'officer'=>$officer]);
    }

    public function add(){
        $officer = User::where('user_role',2)->get();
        $user_category = UserCategoryModel::get();
        return view('admin.users.supplier.add',['officer'=>$officer,'user_category'=>$user_category]);
    }

    public function create(Request $request){
        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->user_phone1 = $request->user_phone1;
        $data->user_phone2 = $request->user_phone2;
        $data->user_role = 4;
        $data->user_status = 1;
        if(auth()->user()->user_role == 1){
            $data->follow_by = json_encode($request->follow_by);
        }
        if(auth()->user()->user_role == 2){
            $data->follow_by = '["'.auth()->user()->id.'"]';
        }
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
        $data->user_category = json_encode($request->user_category);
        $data->user_account_number = $request->user_account_number;
        $data->user_bank_name = $request->user_bank_name;
        $data->user_bank_address = $request->user_bank_address;
        $data->user_swift_code = $request->user_swift_code;
        $data->user_iban_number = $request->user_iban_number;

        $data->potential_suppliers = $request->customRadio;
        if ($data->save()){
            return redirect()->route('users.supplier.index')->with(['success'=>'تم اضافة البيانات بنجاح','tab_id'=>1]);
        }
        else{
            return redirect()->back()->withInput();
        }
    }

    public function edit($id){
        $data = User::where('id',$id)->first();
        $officer = User::where('user_role',2)->get();
        $user_category = UserCategoryModel::get();
        return view('admin.users.supplier.edit',['data'=>$data,'user_category'=>$user_category,'user_category'=>$user_category,'officer'=>$officer]);
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
        if(auth()->user()->user_role == 1){
            $data->follow_by = json_encode($request->follow_by);
        }
        if(auth()->user()->user_role == 2){
            $data->follow_by = '["'.auth()->user()->id.'"]';
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
        $data->potential_suppliers = $request->customRadio;
        if ($data->save()) {
            return redirect()->route('users.supplier.edit', ['id'=>$id])->with(['success' => 'تم تعديل البيانات بنجاح','tab_id'=>1]);
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function details($id){
        $data = User::where('id',$id)->first();
        $company_contact_person = CompanyContactPersonModel::where('company_id',$id)->get();
        $product_supplier = ProductSupplierModel::where('user_id',$id)->get();
        $order_supplier = OrderModel::join('price_offers','price_offers.order_id','=','orders.id')->where('price_offers.supplier_id',$id)->get();
        $supplier_notes = SupplierNotesModel::where('supplier_id',$id)->get();
        foreach ($order_supplier as $key){
            $key->supplier = User::where('id',$key->supplier_id)->first();
        }
        foreach ($product_supplier as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
        }
        $products = ProductModel::take(15)->get();
        $banks = BankModel::get();
        $supplier_banks = BankSupplierModel::where('supplier_id',$id)->get();
        $users_follow_up_records = UsersFollowUpRecordsModel::where('user_id',$data->id)->get();
        foreach ($supplier_banks as $key){
            $key->added_by = User::where('id',$key->added_by)->first();
            $key->bank = BankModel::where('id',$key->bank_id)->first();
        }
        return view('admin.users.supplier.details',['data'=>$data,'banks'=>$banks,'company_contact_person'=>$company_contact_person,'order_supplier'=>$order_supplier,'product_supplier'=>$product_supplier,'users_follow_up_records'=>$users_follow_up_records,'products'=>$products,'supplier_banks'=>$supplier_banks , 'supplier_notes'=>$supplier_notes]);
    }

    public function product_list_ajax(Request $request){
        $product_supplier = ProductSupplierModel::where('user_id',$request->user_id)->get();

        foreach ($product_supplier as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
        }
        return response()->json([
            'success' => 'true',
            'data' => view('admin.users.supplier.ajax.product_list', ['product_supplier' => $product_supplier])->render()
        ]);
    }

    public function product_search_ajax(Request $request){
        $user = User::where('id',$request->user_id)->first();
        $data = ProductModel::when(!empty($request->search_product),function($query) use ($request){
            $query->where('product_name_ar','like','%'.$request->search_product.'%')->orWhere('product_name_en','like','%'.$request->search_product.'%')->orWhere('barcode','like','%'.$request->search_product.'%');
        })->paginate(10);
        return response()->json([
            'success' => 'true',
            'data' => view('admin.users.supplier.ajax.product_search', ['data' => $data,'user' => $user])->render()
        ]);
    }

    public function add_to_product_supplier_ajax(Request $request){
        $check_find = ProductSupplierModel::where('user_id',$request->user_id)->where('product_id',$request->product_id)->first();
        $message = '';
        $status = '';
        if($request->checked == 'true'){
            $data = new ProductSupplierModel();
            $data->user_id = $request->user_id;
            $data->product_id = $request->product_id;
            $message = 'تم اضافة هذا الصنف بنجاح';
            $status = 'save';
            if (!$data->save()) {
                return redirect()->back()->with(['fail' => 'هناك خلل ما لم يتم تعديل البيانات', 'tab_id' => 8]);
            }
        }
        else if($request->checked == 'false'){
            $message = 'تم ازالة هذا الصنف بنجاح';
            $status = 'delete';
            $check_find->delete();
        }
        // if ($check_find){
            // return response()->json([
            //     'status'=>'false',
            //     'message'=>'هذا الصنف مضاف مسبقا'
            // ]);
        // }
        // else{
                // $data = new ProductSupplierModel();
                // $data->user_id = $request->user_id;
                // $data->product_id = $request->product_id;

                // if (!$data->save()) {
                //     return redirect()->back()->with(['fail' => 'هناك خلل ما لم يتم تعديل البيانات', 'tab_id' => 8]);
                // }

            // }
            $product_supplier = ProductSupplierModel::where('user_id',$request->user_id)->get();

            foreach ($product_supplier as $key){
                $key->product = ProductModel::where('id',$key->product_id)->first();
            }
            return response()->json([
                'success' => 'true',
                'status' => $status,
                'message' => $message,
                'data' => view('admin.users.supplier.ajax.product_list', ['product_supplier' => $product_supplier])->render()
            ]);
    }

    public function createProductSupplier(Request $request){
        $check_find = ProductSupplierModel::where('user_id',$request->user_id)->where('product_id',$request->product_id)->first();
        // if ($check_find){
        //     return redirect()->back()->with(['fail'=>'تم اضافة هذا المنتج من قبل','tab_id'=>8]);
        // }
        // else{
        //     $is_found = false;
        //     for($i = 0 ; $i < count($request->product_id);$i++){
        //         if(!(ProductSupplierModel::where('user_id',$request->user_id)->where('product_id',$request->product_id[$i])->first())){
        //             $data = new ProductSupplierModel();
        //             $data->user_id = $request->user_id;
        //             $data->product_id = $request->product_id[$i];

        //             if (!$data->save()) {
        //                 return redirect()->back()->with(['fail' => 'هناك خلل ما لم يتم تعديل البيانات', 'tab_id' => 8]);
        //             }
        //         }
        //         else{
        //             $is_found = true;
        //         }
        //     }
        //     return redirect()->back()->with(['success'=>'تم اضافة البيانات بنجاح','tab_id'=>8]);
        // }
        if ($check_find){
            return redirect()->back()->with(['fail'=>'تم اضافة هذا المنتج من قبل','tab_id'=>8]);
        }
        else{
                    $data = new ProductSupplierModel();
                    $data->user_id = $request->user_id;
                    $data->product_id = $request->product_id;

                    if (!$data->save()) {
                        return redirect()->back()->with(['fail' => 'هناك خلل ما لم يتم تعديل البيانات', 'tab_id' => 8]);
                    }

            }
            return redirect()->back()->with(['success'=>'تم اضافة البيانات بنجاح','tab_id'=>8]);

    }

    public function contact_person_edit($id){
        $data = CompanyContactPersonModel::where('id',$id)->first();
        return view('admin.users.supplier.contact_person.edit',['data'=>$data]);
    }

    public function contact_person_update(Request $request){
        $data = CompanyContactPersonModel::where('id',$request->id)->first();
        $data->contact_name = $request->contact_name;
        $data->mobile_number = $request->mobile_number;
        $data->email = $request->email;
        $data->whats_app_number = $request->whats_app_number;
        $data->wechat_number = $request->wechat_number;
        $data->address = $request->address;
        if ($request->photo != ''){
            if ($request->hasFile('user_photo')) {
                $file = $request->file('user_photo');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->storeAs('user_photo', $filename, 'public');
                $data->user_photo = $filename;
            }
        }
        if ($data->save()) {
            return redirect()->route('users.supplier.details', ['id'=>$data->company_id])->with(['success' => 'تم تعديل البيانات بنجاح','tab_id'=>3]);
        } else {
            return redirect()->route('users.supplier.details', ['id'=>$data->company_id])->with(['fail' => 'هناك خطا ما لم يتم التعديل بنجاح','tab_id'=>3]);
        }
    }

    public function create_bank_supplier(Request $request){
        $check_if_find = BankSupplierModel::where('bank_id',$request->bank_id)->first();
        $data = new BankSupplierModel();
        $data->beneficiary_name = $request->beneficiary_name;
        $data->bank_id = $request->bank_id;
        $data->supplier_id = $request->supplier_id;
        $data->added_by = auth()->user()->id;
        $data->notes = $request->notes;
        $data->account_number = $request->account_number;
        $data->account_owner = $request->account_owner;
        $data->user_bank_name = $request->user_bank_name;
        $data->user_bank_address = $request->user_bank_address;
        $data->user_swift_code = $request->user_swift_code;
        $data->user_iban_number = $request->user_iban_number;
        $data->contact_person = $request->contact_person;
        $data->contact_mobile = $request->contact_mobile;
        if ($data->save()) {
            return redirect()->back()->with(['success' => 'تم تعديل البيانات بنجاح','tab_id'=>2]);
        } else {
            return redirect()->back()->with(['fail' => 'هناك خطا ما لم يتم التعديل بنجاح','tab_id'=>2]);
        }
    }

    public function edit_bank_supplier($id){
        $data = BankSupplierModel::find($id);
        $data->supplier = User::where('id',$data->supplier_id)->first();
        $data->bank = BankModel::where('id',$data->bank_id)->first();
        $banks = BankModel::get();
        return view('admin.users.supplier.bank.edit',['data'=>$data,'banks'=>$banks]);
    }

    public function update_bank_supplier(Request $request){
        $data = BankSupplierModel::where('id',$request->id)->first();
        $data->bank_id = $request->bank_id;
        $data->beneficiary_name = $request->beneficiary_name;
        $data->bank_id = $request->bank_id;
        $data->supplier_id = $request->supplier_id;
        $data->added_by = auth()->user()->id;
        $data->notes = $request->notes;
        $data->account_number = $request->account_number;
        $data->account_owner = $request->account_owner;
        $data->user_bank_name = $request->user_bank_name;
        $data->user_bank_address = $request->user_bank_address;
        $data->user_swift_code = $request->user_swift_code;
        $data->user_iban_number = $request->user_iban_number;
        $data->contact_person = $request->contact_person;
        $data->contact_mobile = $request->contact_mobile;
        if ($data->save()) {
            return redirect()->back()->with(['success' => 'تم تعديل البيانات بنجاح','tab_id'=>3]);
        } else {
            return redirect()->back()->with(['fail' => 'هناك خطا ما لم يتم التعديل بنجاح','tab_id'=>3]);
        }
    }

    public function delete_bank_supplier($id){
        $data = BankSupplierModel::find($id);
        if ($data->delete()){
            return response()->json([
                'success'=>'true'
            ]);
        }
        else{
            return response()->json([
                'success'=>'false'
            ]);
        }
    }

    public function delete_product_supplier($id){
        $data = ProductSupplierModel::where('id',$id)->first();
        if ($data->delete()){
            return redirect()->back()->with(['success'=>'تم حذف البيانات بنجاح','tab_id'=>8]);
        }
        else{
            return redirect()->back()->with(['fail'=>'هناك خلل ما لم يتم حذف البيانات','tab_id'=>8]);
        }
    }

    public function update_follow_by(Request $request){
        // $check_if_find = User::where('id',$request->user_id)->first();
        $data = User::where('id',$request->user_id)->first();
        if($request->follow_by == null){
            $data->follow_by = null;
        }
        else{
            $data->follow_by = json_encode($request->follow_by);
        }
        if($data->save()){
            return response()->json([
                'success'=>'true'
            ]);
        }
        else{
            return response()->json([
                'success'=>'false'
            ]);
        }
    }

    public function supplier_table(Request $request){
        $data = User::where('user_role',4)
        ->where(function($query) use($request){
            $query->where('name','like','%'.$request->search.'%');
        })
        ->when(!empty($request->follow_by),function($query) use($request){
            $query->whereJsonContains('follow_by',$request->follow_by);
        })
            ->when(!empty($request->potential_suppliers),function($query) use($request){
                $query->where('potential_suppliers',$request->potential_suppliers);
            })
        ->get();
        // foreach($data as $key){
        //     $key->officers = User::where('follow_by',$key->id)->get();
        // }

        $officer = User::where('user_role',2)->get();
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.users.supplier.ajax.supplier_table',['data'=>$data,'officer'=>$officer])->render()
        ]);
    }

    public function create_supplier_notes(Request $request)
    {
        $data = new SupplierNotesModel();
        $data->supplier_id = $request->supplier_id;
        $data->text = $request->text;
        $data->insert_at = Carbon::now();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('supplier_notes', $filename, 'public');
            $data->file = $filename;
        }
        if ($data->save()) {
            return redirect()->back()->with(['success' => 'تم اضافة البيانات بنجاح','tab_id'=>9]);
        } else {
            return redirect()->back()->with(['fail' => 'هناك خطا ما لم تتم الاضافة بنجاح','tab_id'=>9]);
        }
    }

    public function delete_supplier_notes($id)
    {
        $data = SupplierNotesModel::where('id',$id)->first();
        if ($data->delete()) {
            return redirect()->back()->with(['success' => 'تم حذف البيانات بنجاح','tab_id'=>9]);
        } else {
            return redirect()->back()->with(['fail' => 'هناك خلل ما لم يتم حذف البيانات','tab_id'=>9]);
        }
    }

    public function update_supplier_notes(Request $request)
    {
        $data = SupplierNotesModel::where('id',$request->id)->first();
        $data->text = $request->text;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('supplier_notes', $filename, 'public');
            $data->file = $filename;
        }
        if ($data->save()) {
            return redirect()->back()->with(['success' => 'تم تعديل البيانات بنجاح','tab_id'=>9]);
        } else {
            return redirect()->back()->with(['fail' => 'هناك خلل ما لم يتم تعديل البيانات','tab_id'=>9]);
        }
    }
}
