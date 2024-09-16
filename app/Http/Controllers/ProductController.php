<?php

namespace App\Http\Controllers;
use App\Imports\UsersImport;
use App\Models\CategoryProductModel;
use App\Models\OrderItemsModel;
use App\Models\ProductModel;
use App\Models\ProductNotesModel;
use App\Models\ProductSupplierModel;
use App\Models\UnitsModel;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function home(){
        $product_count = ProductModel::count();
        $category_count = CategoryProductModel::count();
        $unit_count = UnitsModel::count();
        return view('admin.product.home',['product_count'=>$product_count,'category_count'=>$category_count,'unit_count'=>$unit_count]);
    }

    public function index(){
        $product_count = ProductModel::count();
        $category_count = CategoryProductModel::count();
        $unit_count = UnitsModel::count();
        $data = ProductModel::paginate(20);
        foreach ($data as $key){
            $key->category = CategoryProductModel::where('id',$key->category_id)->first();
            $key->unit = UnitsModel::where('id',$key->unit_id)->first();
        }
        $category = CategoryProductModel::get();
        $unit = UnitsModel::get();
        return view('admin.product.index',['data'=>$data,'category'=>$category,'unit'=>$unit,'product_count'=>$product_count,'category_count'=>$category_count,'unit_count'=>$unit_count]);
    }

    public function search_table(Request $request){
        $data = ProductModel::where('product_name_ar','like',"%{$request->product_search}%")->orWhere('product_name_en','like',"%{$request->product_search}%")->orWhere('barcode','like',"%{$request->product_search}%")->paginate(20);
        foreach ($data as $key){
            $key->category = CategoryProductModel::where('id',$key->category_id)->first();
            $key->unit = UnitsModel::where('id',$key->unit_id)->first();
        }
        if ($request->ajax()) {
            $data = ProductModel::where('product_name_ar','like',"%{$request->product_search}%")->orWhere('product_name_en','like',"%{$request->product_search}%")->orWhere('barcode','like',"%{$request->product_search}%")->paginate(20);
            foreach ($data as $key){
                $key->category = CategoryProductModel::where('id',$key->category_id)->first();
                $key->unit = UnitsModel::where('id',$key->unit_id)->first();
            }
            return response()->view('admin.product.ajax.search_product',['data'=>$data]);
        }
        return response()->view('admin.product.ajax.search_product',['data'=>$data]);
    }

    public function create(Request $request){
        $data = new ProductModel();
        $data->product_name_ar = $request->product_name_ar;
        $data->product_name_en = $request->product_name_en;
        $data->category_id = $request->category_id;
        $data->unit_id = $request->unit_id;
        $data->barcode = $request->barcode;
        $data->certified = $request->certified;
        $data->less_qty = $request->less_qty;
        $data->product_status = 1;
        $data->product_price = $request->product_price;
        if ($request->hasFile('product_photo')) {
            $file = $request->file('product_photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('product', $filename, 'public');
            $data->product_photo = $filename;
        }
        if ($data->save()){
            return redirect()->route('product.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('product.index')->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function edit($id){
        $data = ProductModel::find($id);
        $data['category'] = CategoryProductModel::where('id',$data->category_id)->first();
        $data['unit'] = UnitsModel::where('id',$data->unit_id)->first();
        $category = CategoryProductModel::get();
        $units = UnitsModel::get();
        return view('admin.product.edit',['data'=>$data,'category'=>$category,'units'=>$units]);
    }

    public function update($id,Request $request){
        $data = ProductModel::find($id);
        $data->product_name_ar = $request->product_name_ar;
        $data->product_name_en = $request->product_name_en;
        $data->category_id = $request->category_id;
        $data->unit_id = $request->unit_id;
        $data->barcode = $request->barcode;
        $data->certified = $request->certified;
        $data->less_qty = $request->less_qty;
        if ($request->hasFile('product_photo')) {
            $file = $request->file('product_photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('product', $filename, 'public');
            $data->product_photo = $filename;
        }
        if ($request->product_status == 'on'){
            $data->product_status = 1;
        }
        else{
            $data->product_status = 0;
        }
        $data->product_price = $request->product_price;
        if ($data->save()){
            return redirect()->route('product.index')->with(['success'=>'تم تعديل المنتج بنجاح']);
        }
        else{
            return redirect()->route('product.index')->with(['fail'=>'هناك خلل ما لم يتم تعديل البيانات']);
        }
    }

    public function import(Request $request)
    {
        Excel::import(new UsersImport, $request->file('file'));
        return redirect()->route('product.index')->with('success', 'تم اضافة البيانات بنجاح');
    }

    public function details($id){
        // TODO this for product supplier table
            $supplier = User::where('user_role',4)->get();
        // *********
        $data = ProductModel::find($id);
        $data['category'] = CategoryProductModel::where('id',$data->category_id)->first();
        $data['unit'] = UnitsModel::where('id',$data->unit_id)->first();
        $category = CategoryProductModel::get();
        $units = UnitsModel::get();
        $data['product_supplier'] = ProductSupplierModel::where(['product_id'=>$data->id])->get();
        foreach ($data['product_supplier'] as $key){
            $key->user = User::where('id',$key->user_id)->first();
        }
        $product_notes = ProductNotesModel::get();
        $order_items = OrderItemsModel::where('product_id',$id)->get();
        return view('admin.product.details',['data'=>$data,'category'=>$category,'units'=>$units,'supplier'=>$supplier,'product_notes'=>$product_notes,'order_items'=>$order_items]);
    }

    public function createForProductSupplier(Request $request){
        $if_found = ProductSupplierModel::where(['user_id'=>$request->user_id,'product_id'=>$request->product_id])->first();
        if ($if_found){
            return redirect()->route('product.details',['id'=>$request->product_id])->with(['fail'=>'هذا المورد او الشركة مسجل من قبل']);
        }
        else{
            $data = new ProductSupplierModel();
            $data->user_id = $request->user_id;
            $data->product_id = $request->product_id;
            if ($data->save()){
                return redirect()->route('product.details',['id'=>$request->product_id])->with(['success'=>'تم اضافة المورد او الشركة بنجاح']);
            }
            else{
                return redirect()->route('product.details',['id'=>$request->product_id])->with(['fail'=>'هناك خلل ما لم تتم اضافة البيانات بنجاح']);
            }
        }
    }

    public function edit_product_ajax(Request $request){
        $data = ProductModel::where('id',$request->product_id)->first();
        if ($data->product_name_ar == ''){
            $data->product_name_ar = $request->product_name_ar;
        }
        $data->product_name_en = $request->product_name_en;
        if ($data->save()){
            return response()->json([
                'success'=>'true',
                'data'=>$data,
            ]);
        }
    }

    public function delete_image(Request $request){
        $data = ProductModel::where('id',$request->product_id)->first();
        $data->product_photo = null;
        if($data->save()){
            return 'asd';
        }
    }

    public function create_product_notes(Request $request){
        $data = new ProductNotesModel();
        $data->product_id = $request->product_id;
        $data->notes = $request->notes;
        if($data->save()){
            return redirect()->route('product.details',['id'=>$request->product_id])->with(['success'=>'تم اضافة الملاحظة بنجاح' , 'tab_id'=>2]);
        }
    }

    public function delete_product_notes($id){
        $data = ProductNotesModel::where('id',$id)->first();
        if($data->delete()){
            return redirect()->route('product.details',['id'=>$data->product_id])->with(['success'=>'تم حذف الملاحظة بنجاح' , 'tab_id'=>2]);
        }
    }
}
