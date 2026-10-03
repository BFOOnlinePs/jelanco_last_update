<?php

namespace App\Http\Controllers;

use App\Models\SystemSettingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SystemSettingController extends Controller
{
    public function index(){
        $data = SystemSettingModel::first();
        return view('admin.setting.system_setting.index',['data'=>$data]);
    }

    public function create(Request $request){
        $data = SystemSettingModel::findOrNew($request->id);
        $data->sidebar_color = $request->sidebar_color;
        if($data->save()){
            return redirect()->route('setting.system_setting.index')->with(['success'=>'تمت العملية بنجاح']);
        }
        else{
            return redirect()->route('setting.system_setting.index')->with(['fail'=>'لم تتم العملية بنجاح هناك مشكلة ما']);
        }
    }

    // رفع شعار الشركة، أو استعادة الشعار الافتراضي عند إرسال remove_logo
    public function update_logo(Request $request){
        $remove = $request->boolean('remove_logo');
        if (! $remove) {
            $request->validate([
                'company_logo' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
            ], [
                'company_logo.required' => 'الرجاء اختيار صورة الشعار',
                'company_logo.image' => 'الملف المختار ليس صورة',
                'company_logo.mimes' => 'صيغة الشعار يجب أن تكون PNG أو JPG أو WEBP',
                'company_logo.max' => 'حجم الشعار يجب ألا يزيد عن 2 ميجابايت',
            ]);
        }

        $data = SystemSettingModel::first() ?? new SystemSettingModel();
        $old_logo = $data->company_logo;

        if ($remove) {
            $data->company_logo = null;
        } else {
            $file = $request->file('company_logo');
            $filename = 'logo_' . time() . '.' . $file->extension();
            $file->storeAs(SystemSettingModel::LOGO_DIR, $filename, 'public');
            $data->company_logo = $filename;
        }

        if($data->save()){
            if (! empty($old_logo) && $old_logo !== $data->company_logo) {
                Storage::disk('public')->delete(SystemSettingModel::LOGO_DIR . '/' . $old_logo);
            }
            return redirect()->route('setting.system_setting.index')->with(['success'=>'تمت العملية بنجاح']);
        }
        else{
            return redirect()->route('setting.system_setting.index')->with(['fail'=>'لم تتم العملية بنجاح هناك مشكلة ما']);
        }
    }
}
