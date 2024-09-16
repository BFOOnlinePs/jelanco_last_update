<?php

namespace App\Http\Controllers;

use App\Models\CategoryProductModel;
use App\Models\CurrencyModel;
use App\Models\ProductModel;
use App\Models\UnitsModel;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class CategoryController extends Controller
{
    public function index(){
        $product_count = ProductModel::count();
        $category_count = CategoryProductModel::count();
        $unit_count = UnitsModel::count();

        $data = CategoryProductModel::get();
        return view('admin.category.index',['data'=>$data,'product_count'=>$product_count,'category_count'=>$category_count,'unit_count'=>$unit_count]);
    }

    public function create(Request $request){
        $data = new CategoryProductModel();
        $data->cat_name = $request->cat_name;
        if ($request->hasFile('cat_pic')) {
            $file = $request->file('cat_pic');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('category', $filename, 'public');
            $data->cat_pic = $filename;
        }
        if ($data->save()){
            return redirect()->route('category.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('category.index')->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function edit($id){
        $data = CategoryProductModel::find($id);
        return view('admin.category.edit',['data'=>$data]);
    }

    public function update($id,Request $request){
        $data = CategoryProductModel::find($id);
        $data->cat_name = $request->cat_name;
        if ($request->cat_pic != ''){
            if ($request->hasFile('cat_pic')) {
                $file = $request->file('cat_pic');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->storeAs('category', $filename, 'public');
                $data->cat_pic = $filename;
            }
        }
        if ($data->save()){
            return redirect()->route('category.index')->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('category.index')->with(['fail'=>'هناك خلل ما لم يتم تعديل البيانات']);
        }
    }
}
