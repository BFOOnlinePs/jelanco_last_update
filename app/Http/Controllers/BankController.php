<?php

namespace App\Http\Controllers;

use App\Models\BankModel;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index(){
        $data = BankModel::get();
        return view('admin.bank.index',['data'=>$data]);
    }

    public function create(Request $request){
        $data = new BankModel();
        $data->account_number = $request->account_number;
        $data->account_owner = $request->account_owner;
        $data->user_bank_name = $request->user_bank_name;
        $data->user_bank_address = $request->user_bank_address;
        $data->user_swift_code = $request->user_swift_code;
        $data->user_iban_number = $request->user_iban_number;
        $data->contact_person = $request->contact_person;
        $data->contact_mobile = $request->contact_mobile;
        $data->notes = $request->notes;
        if ($data->save()){
            return redirect()->route('bank.index')->with(['success'=>'تم اضافة البنك بنجاح']);
        }
        else{
            return redirect()->route('bank.index')->with(['fail'=>'لم تتم الاضافة عناك خلل ما']);
        }
    }

    public function edit($id){
        $data = BankModel::find($id);
        return view('admin.bank.edit',['data'=>$data]);
    }

    public function update($id,Request $request){
        $data = BankModel::find($id);
        $data->account_number = $request->account_number;
        $data->account_owner = $request->account_owner;
        $data->user_bank_name = $request->user_bank_name;
        $data->user_bank_address = $request->user_bank_address;
        $data->user_swift_code = $request->user_swift_code;
        $data->user_iban_number = $request->user_iban_number;
        $data->contact_person = $request->contact_person;
        $data->contact_mobile = $request->contact_mobile;
        $data->notes = $request->notes;
        if ($data->save()){
            return redirect()->route('bank.index')->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('bank.index')->with(['fail'=>'لم يتم التعديل هناك خلل ما']);
        }
    }
}
