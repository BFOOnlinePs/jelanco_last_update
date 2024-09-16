<?php

namespace App\Http\Controllers\procurement_officer;

use App\Http\Controllers\Controller;
use App\Models\CategoryProductModel;
use App\Models\OrderAttachmentModel;
use App\Models\OrderItemsModel;
use App\Models\OrderModel;
use App\Models\PriceOffersModel;
use App\Models\ProductModel;
use App\Models\ProductSupplierModel;
use App\Models\UnitsModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
use PhpOffice\PhpSpreadsheet\Calculation\Category;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class ProductController extends Controller
{
    public $progress_status = 1;
    public function index($order_id){
        $order = OrderModel::where('id',$order_id)->first();
        $data = OrderItemsModel::where('order_id',$order_id)->get();
        $order->user = User::where('id',$order->user_id)->first();
        $order->to_user = User::where('id',$order->to_user)->first();
        foreach ($data as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
        }
//        $product_supplier = ProductSupplierModel::whereIn('product_id',function ($query) use ($order_id){
//            $query->select('product_id')->from('order_items')->where('order_id',$order_id)->get();
//        })->get()->groupBy('user_id');
//        foreach ($product_supplier as $user_id => $products) {
//            $user = User::find($user_id);
//
//            // Attach user information to each product
//            foreach ($products as $product) {
//                $product->user = $user;
//            }
//        }
        $product_supplier = User::whereIn('id',function ($query) use ($order_id){
            $query->select('user_id')->from('product_supplier')
            ->whereIn('product_id',function ($query) use ($order_id){
                $query->select('product_id')->from('order_items')->where('order_id',$order_id);
            });
        })->get();
        $unit = UnitsModel::get();
        $category = CategoryProductModel::get();
       $product = ProductModel::with('orderItems')->whereIn('id',function ($query) use ($order_id){
           $query->select('product_id')->from('product_supplier')->whereIn('user_id',function ($query) use ($order_id){
                $query->select('supplier_id')->from('price_offers')->where('price_offers.order_id',$order_id);
           });
       })->get();
       $price_offer = PriceOffersModel::where('order_id',$order_id)->get();
       $order_attachment = OrderAttachmentModel::where('order_id',$order_id)->first();
       $users = User::where('user_role',4)->get();
        return view('admin.orders.procurement_officer.product.index',['order'=>$order,'data'=>$data,'unit'=>$unit,'product'=>$product,'order_attachment'=>$order_attachment,'price_offer'=>$price_offer,'product_supplier'=>$product_supplier,'users'=>$users,'category'=>$category]);
    }

    public function create_order_items(Request $request){
        $request->session()->put('checkbox_states', $request->input('checkbox', []));

        $check_progress_status = OrderModel::where('id',$request->order_id)->first();
        $check_find = OrderItemsModel::where('order_id',$request->order_id)->where('product_id',$request->product_id)->first();
        if (!empty($check_find)){
            return redirect()->route('procurement_officer.orders.product.index',['order_id'=>$request->order_id])->with(['fail'=>'هذا الصنف تم اضافته مسبقا']);
        }
        else{
            $if_save = 0;
            for($i = 0;$i<count($request->checkbox);$i++){
                $product_find = OrderItemsModel::where('order_id',$request->order_id)->where('product_id',$request->checkbox[$i])->first();
                if(!$product_find){
                    $data = new OrderItemsModel();
                    $data->order_id = $request->order_id;
                    $data->product_id = $request->checkbox[$i];
                    $get_unit_id = ProductModel::where('id',$request->checkbox[$i])->first();
                    $data->qty = $request->qty;
                    $data->unit_id = $get_unit_id->unit_id;
                    $data->status = 1;
                    $data->notes = $request->notes;
                    $data->save();
                    $if_save = 1;
                }
            }

            if (($check_progress_status->progress_status) <= $this->progress_status){
                $check_progress_status->progress_status = $this->progress_status;
                $check_progress_status->save();
            }

            if ($if_save == 1){
                return redirect()->route('procurement_officer.orders.product.index',['order_id'=>$request->order_id])->with(['success'=>'تم اضافة البيانات بنجاح']);
            }
            else{
                return redirect()->route('procurement_officer.orders.product.index',['order_id'=>$request->order_id])->with(['fail'=>'هذا المنتج تم اختياره من قبل']);
            }
        }
    }

    public function product_list_pdf($order_id){
        $order = OrderModel::where('id',$order_id)->first();
        $data = OrderItemsModel::where('order_id',$order_id)->get();
        foreach($data as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
            $key->unit = UnitsModel::where('id',$key->unit_id)->first();
        }
        $pdf = PDF::loadView('admin.orders.procurement_officer.product.pdf.product_list', ['data' => $data,'order'=>$order]);
        return $pdf->stream('products.pdf');
    }

    public function search_product_ajax(Request $request){
        $order_id = $request->order_id;
        $order = OrderModel::find($order_id);
        $order_items = OrderItemsModel::where('order_id',$order_id)->get();
        $data = ProductModel::whereIn('id',function ($query) use ($order_id){
            $query->select('product_id')->from('product_supplier')->whereIn('user_id',function ($query) use ($order_id){
                 $query->select('supplier_id')->from('price_offers')->where('price_offers.order_id',$order_id);
            });
        })
        ->whereNotIn('id',OrderItemsModel::select('product_id')->where('order_id',$order_id)->get())
        ->when(!empty($request->search_product),function($query) use ($request){
            $query->where('product_name_ar','like','%'.$request->search_product.'%')->orWhere('product_name_en','like','%'.$request->search_product.'%')->orWhere('barcode','like','%'.$request->search_product.'%')->get();
        })
            ->paginate(10);
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.orders.procurement_officer.product.ajax.search_product',['data'=>$data,'order_items'=>$order_items,'order'=>$order])->render(),
        ]);
    }

    public function create_product_ajax(Request $request){
        $data = new OrderItemsModel();
        $data->order_id = $request->order_id;
        $data->product_id = $request->product_id;
        $data->unit_id = $request->unit_id;
        $data->status = 1;
        if($data->save()){
            return response()->json('true');
        }
    }

    public function order_items_table(Request $request){
        $order = OrderModel::where('id',$request->order_id)->first();
        $data = OrderItemsModel::where('order_id',$request->order_id)->whereIn('product_id',function ($query) use ($request){
            $query->select('id')->from('product')->where('product_name_ar','like','%'.$request->search_order_table.'%')->orWhere('product_name_en','like','%'.$request->search_order_table.'%')->orWhere('barcode','like','%'.$request->search_order_table.'%')->get();
        })->paginate(25);
        $order->user = User::where('id',$order->user_id)->first();
        $order->to_user = User::where('id',$order->to_user)->first();
        foreach ($data as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
        }
        $unit = UnitsModel::get();
        $order_id = $request->order_id;
       $product = ProductModel::with('orderItems')->whereIn('id',function ($query) use ($order_id){
           $query->select('product_id')->from('product_supplier')->whereIn('user_id',function ($query) use ($order_id){
                $query->select('supplier_id')->from('price_offers')->where('price_offers.order_id',$order_id);
           });
       })->get();
       return response()->json([
            'status'=>'true',
            'view' => view('admin.orders.procurement_officer.product.ajax.order_items_table', ['data' => $data,'order'=>$order,'unit'=>$unit,'product'=>$product])->render()
        ]);
    }

    public function add_attachment_for_product(Request $request){
        $data = OrderAttachmentModel::firstOrNew(['order_id'=>$request->order_id]);
        $data->order_id = $request->order_id;
        $data->user_id = auth()->user()->id;
        $data->notes = $request->notes;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->storeAs('attachment', $filename, 'public');
            $data->attachment = $filename;
        }
        $data->notes = $request->notes;
        $data->insert_at = Carbon::now();
        $data->status = 1;
        $data->target = 'order_product';
        if ($data->save()){
            return redirect()->route('procurement_officer.orders.product.index',['order_id'=>$request->order_id])->with(['success'=>'تم حفظ البيانات بنجاح']);
        }
        else{
            return redirect()->route('procurement_officer.orders.product.index',['order_id'=>$request->order_id])->with(['fail'=>'هناك خطا ما لم يتم حفظ البيانات']);
        }
    }

    public function delete_attachment_in_product($id){
        $data = OrderAttachmentModel::where('id',$id)->first();
        $order_id = $data->order_id;
        if ($data->delete()){
            return redirect()->route('procurement_officer.orders.product.index',['order_id'=>$order_id])->with(['success'=>'تم حذف البيانات بنجاح']);
        }
        else{
            return redirect()->route('procurement_officer.orders.product.index',['order_id'=>$order_id])->with(['fail'=>'هناك خلل ما لم يتم حذف البيانات']);
        }
    }

    public function update_product_from_ajax(Request $request){
        $data = ProductModel::where('id',$request->product_id)->first();
        $data->product_name_ar = $request->product_name_ar;
        $data->product_name_en = $request->product_name_en;
        $data->category_id = $request->category_id;
        $data->unit_id = $request->unit_id;
        $data->barcode = $request->barcode;
        if ($data->save()){
            return response()->json([
                'success' => 'true',
                'message'=> 'تم تعديل البيانات بنجاح'
            ]);
        }
    }

    public function upload_image(Request $request){
        $data = ProductModel::where('id',$request->product_id)->first();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('product', $filename, 'public');
            $data->product_photo = $filename;
            if ($data->save()){
                return response()->json([
                    'success'=>'true',
                    'message'=>'تم رفع الصورة بنجاح'
                ]);
            }
            else{
                return response()->json([
                    'success'=>'false',
                    'message'=>'هناك خطا ما في رفع الصورة'
                ]);
            }
        }
        else{
            return response()->json([
                'success'=>'false',
                'message'=>'لم يتم رفع الصورة'
            ]);
        }

    }
    
    public function add_notes_for_product_ajax(Request $request){
        $data = OrderItemsModel::where('id',$request->id)->first();
        $data->notes = $request->notes;
        if($data->save()){
            return response()->json([
                'success' => true,
                'message' => 'تم تعديل الملاحظة بنجاح'
            ]);
        }
    }

}
