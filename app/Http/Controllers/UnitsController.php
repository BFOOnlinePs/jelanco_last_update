<?php

namespace App\Http\Controllers;

use App\Models\CategoryProductModel;
use App\Models\ProductModel;
use App\Models\UnitsModel;
use Illuminate\Http\Request;

class UnitsController extends Controller
{
    public function index(Request $request){
        $product_count = ProductModel::count();
        $category_count = CategoryProductModel::count();
        $unit_count = UnitsModel::count();

        $search = trim((string) $request->input('search'));

        $data = UnitsModel::when($search !== '', function ($query) use ($search) {
                $query->where('unit_name', 'like', "%{$search}%")
                    ->orWhere('unit_name_en', 'like', "%{$search}%");
            })
            ->orderBy('unit_name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.units.index',['data'=>$data,'search'=>$search,'product_count'=>$product_count,'category_count'=>$category_count,'unit_count'=>$unit_count]);
    }

    public function create(Request $request){
        $data = new UnitsModel();
        $data->unit_name = $request->unit_name;
        $data->unit_name_en = $request->unit_name_en;
        if ($data->save()){
            return redirect()->route('units.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('units.index')->with(['fail'=>'لم يتم اضافة البيانات هناك خلل ما']);
        }
    }

    public function edit($id){
        $data = UnitsModel::where('id',$id)->first();
        return view('admin.units.edit',['data'=>$data]);
    }

    public function update(Request $request){
        $data = UnitsModel::where('id',$request->unit_id)->first();
        $data->unit_name = $request->unit_name;
        $data->unit_name_en = $request->unit_name_en;
        if ($data->save()){
            return redirect()->route('units.index')->with(['success'=>'تم تعديل الوحدة بنجاح']);
        }
    }

    public function updateUnitName(Request $request){
        $data = UnitsModel::where('id',$request->id)->first();
        $data->unit_name = $request->unit_name;
        $data->unit_name_en = $request->unit_name_en;
        if ($data->save()){
            return response()->json([
                'success'=>'true',
            ]);
        }
    }
}
