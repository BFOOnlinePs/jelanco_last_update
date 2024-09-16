<?php

namespace App\Http\Controllers;

use App\Models\CompanyContactPersonModel;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;

class CompanyContactPersonController extends Controller
{
    public function createForSupplier(Request $request){
        $data = new CompanyContactPersonModel();
        $data->company_id = $request->company_id;
        $data->contact_name = $request->contact_name;
        $data->mobile_number = $request->mobile_number;
        $data->email = $request->email;
        $data->whats_app_number = $request->whats_app_number;
        $data->wechat_number = $request->wechat_number;
        $data->address = $request->address;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('user_photo', $filename, 'public');
            $data->photo = $filename;
        }
        if ($data->save()){
            return redirect()->route('users.supplier.details',['id'=>$request->company_id])->with(['success'=>'تم اضافة جهة التواصل بنجاح','tab_id'=>3]);
        }
        else{
            return redirect()->route('users.supplier.details',['id'=>$request->company_id])->with(['fail'=>'لم تتم الاضافة هناك خلل ما','tab_id'=>3]);
        }
    }

    public function delete($id){
        $data = CompanyContactPersonModel::find($id);
        if ($data->delete()){
            return \response()->json([
                'message'=>'success'
            ]);
        }
    }
}
