<?php

namespace App\Http\Controllers\procurement_officer;

use App\Http\Controllers\Controller;
use App\Models\PriceOfferItemsModel;
use App\Models\PriceOffersModel;
use Illuminate\Http\Request;

class PriceOfferItemsController extends Controller
{
    public function create(Request $request)
    {
        $check_if_find = PriceOfferItemsModel::where('order_id',$request->order_id)->where('supplier_id',$request->supplier_id)->where('product_id',$request->product_id)->first();
        if (empty($check_if_find)){
            $data = new PriceOfferItemsModel();
            $data->order_id = $request->order_id;
            $data->supplier_id = $request->supplier_id;
            $data->product_id = $request->product_id;
            $data->price = $request->price;
            $data->qty = $request->qty;
            if ($data->save()){
                return response()->json([
                    'success'=>'true',
                    'msg'=>'تم اضافة البيانات بنجاح'
                ]);
            }
            else{
                return response()->json([
                    'success'=>'false',
                    'msg'=>'هناك خلل ما لم يتم اضافة البيانات'
                ]);
            }
        }
        else{
            $check_if_find->price = $request->price;
            if ($check_if_find->save()){
                return response()->json([
                    'success'=>'true',
                    'msg'=>'تم تعديل البيانات بنجاح'
                ]);
            }
            else{
                return response()->json([
                    'success'=>'false',
                    'msg'=>'هناك خلل ما لم يتم تعديل البيانات'
                ]);
            }
        }
    }

    public function add_or_update_bonus(Request $request){
        $check_if_find = PriceOfferItemsModel::where('order_id',$request->order_id)->where('supplier_id',$request->supplier_id)->where('product_id',$request->product_id)->first();
        if(empty($check_if_find)){
            $data = new PriceOfferItemsModel();
            $data->order_id = $request->order_id;
            $data->supplier_id = $request->supplier_id;
            $data->product_id = $request->product_id;
            $data->bonus = $request->bonus;
            $data->qty = $request->qty;
            if ($data->save()){
                return response()->json([
                    'success'=>'true',
                    'msg'=>'تم اضافة البيانات بنجاح'
                ]);
            }
            else{
                return response()->json([
                    'success'=>'false',
                    'msg'=>'هناك خلل ما لم يتم اضافة البيانات'
                ]);
            }
        }
        else{
            $check_if_find->bonus = $request->bonus;
            if ($check_if_find->save()){
                return response()->json([
                    'success'=>'true',
                    'msg'=>'تم تعديل البيانات بنجاح'
                ]);
            }
            else{
                return response()->json([
                    'success'=>'false',
                    'msg'=>'هناك خلل ما لم يتم تعديل البيانات'
                ]);
            }
        }
    }

    public function add_or_update_discount(Request $request){
        $check_if_find = PriceOfferItemsModel::where('order_id',$request->order_id)->where('supplier_id',$request->supplier_id)->where('product_id',$request->product_id)->first();
        if(empty($check_if_find)){
            $data = new PriceOfferItemsModel();
            $data->order_id = $request->order_id;
            $data->supplier_id = $request->supplier_id;
            $data->product_id = $request->product_id;
            $data->discount_present = $request->discount_present;
            if ($data->save()){
                return response()->json([
                    'success'=>'true',
                    'msg'=>'تم اضافة البيانات بنجاح'
                ]);
            }
            else{
                return response()->json([
                    'success'=>'false',
                    'msg'=>'هناك خلل ما لم يتم اضافة البيانات'
                ]);
            }
        }
        else{
            $check_if_find->discount_present = $request->discount_present;
            if ($check_if_find->save()){
                return response()->json([
                    'success'=>'true',
                    'msg'=>'تم تعديل البيانات بنجاح'
                ]);
            }
            else{
                return response()->json([
                    'success'=>'false',
                    'msg'=>'هناك خلل ما لم يتم تعديل البيانات'
                ]);
            }
        }
    }
}
