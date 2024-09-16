<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required',
            'user_phone1'=>'required|digits:10|numeric',
            'user_phone2'=>'nullable|digits:10|numeric',
            'user_photo' => 'nullable|image|mimes:jpg,png,jpeg|dimensions:min_width=100,min_height=100,max_width=700,max_height=700',
            'user_role'=>'required'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'=>'حقل الاسم لا يجب ان يكون فارغ',
            'email.required'=>'حقل الايميل لا يجب ان يكون فارغ',
            'email.email'=>'يجب ان يكون تنسيق هذا الحقل على شكل ايميل ويحتوي على @',
            'email.unique'=>'هذا الايميل مستخدم من قبل',
            'password.required'=>'حقل كلمة المرور مطلوب',
            'user_phone1.required'=>'حفل رقم الهاتف الاول مطلوب',
            'user_phone1.numeric'=>'يجب ان يحتوي على ارقام فقط',
            'user_phone1.digits'=>'يجب ان لا يزيد او يقل عن 10 ارقام فقط',
            'user_phone2.numeric'=>'يجب ان يحتوي على ارقام فقط',
            'user_phone2.digits'=>'يجب ان لا يزيد او يقل عن 10 ارقام فقط',
            'user_photo.mimes'=>'jpg,png,jpeg يجب ان يكون الباث الخاص بالصورة هو',
            'user_photo.dimensions'=>'يجب ان تكون ابعاد الصورة متناسبة مع الملاحظة',
            'user_role.required'=>'حقل الصلاحية مطلوب',
        ];
    }
}
