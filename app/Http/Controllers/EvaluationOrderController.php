<?php

namespace App\Http\Controllers;

use App\Models\CriteriaModel;
use App\Models\EvaluationAttachmentModel;
use App\Models\EvaluationCriteriaModel;
use App\Models\EvaluationModel;
use App\Models\OrderModel;
use App\Models\OrderStatusModel;
use App\Models\PriceOffersModel;
use App\Models\ShippingPriceOfferModel;
use App\Models\User;
use App\Models\UserCategoryModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use PDF;

class EvaluationOrderController extends Controller
{
//Cache::forget('order_table_data');
//Cache::forget('order_table_request');
//$order_status = OrderStatusModel::get();
//$supplierId = $request->supplier_id;
//$referenceNumber = $request->reference_number;
//$from = $request->from;
//$to = $request->to;
//
//$data = OrderModel::query()
//->when(!empty($supplierId), function ($query) use ($supplierId) {
//                $query->whereIn('id', function ($query) use ($supplierId) {
//                    $query->select('order_id')
//                        ->from('price_offers')
//                        ->where('supplier_id', $supplierId);
//                });
//})
//->when(!empty($referenceNumber), function ($query) use ($referenceNumber) {
//    $query->where('reference_number','like','%'. $referenceNumber. '%');
//})
//    ->when(!empty($request->order_status), function ($query) use ($request) {
//        $query->where('order_status', $request->order_status);
//    })
//    ->where(function ($query) use ($from, $to) {
//        $query->whereBetween('inserted_at', [$from, $to])
//            ->orWhereNull('inserted_at');
//    })
//    ->when(!empty($request->to_user),function ($query) use ($request){
//        $query->where('to_user','like','%'.$request->to_user.'%');
//    })
//    ->when(!empty($request->user_category), function ($query) use ($request) {
//        $query->whereIn('id', function ($query) use ($request) {
//            $query->select('order_id')
//                ->from('price_offers')
//                ->whereIn('supplier_id', function ($query) use ($request){
//                    $query->select('id')->from('users')->whereJsonContains('user_category',$request->user_category)->get();
//                });
//        });
//    })
//    ->when(!empty($request->supplier_type), function ($query) use ($request) {
//        $query->whereIn('id', function ($query) use ($request) {
//            $query->select('order_id')
//                ->from('price_offers')
//                ->whereIn('supplier_id', function ($query) use ($request){
//                    $query->select('id')->from('users')->where('potential_suppliers',$request->supplier_type)->get();
//                });
//        });
//    })
//    ->where('order_status', '!=', -1)->where('order_status', '!=', 0)->where('order_status','!=',10)
//    ->where('delete_status',0)
//    ->orderBy('id','desc')
//    ->paginate(20);
//
//foreach ($data as $key) {
//    $key->order_status_color = OrderStatusModel::find($key->order_status);
//    $key->user = User::find($key->user_id);
//    $key->to_user = User::where('id', $key->to_user)->first();
//    $key->supplier = PriceOffersModel::where('order_id', $key->id)->get();
//    $key->expected_arrival_date = ShippingPriceOfferModel::where('order_id',$key->id)->where('award_status',1)->first()->expected_arrival_date ?? '';
//    foreach ($key->supplier as $child) {
//        $child->name = User::find($child->supplier_id);
//        $userCategoryIds = json_decode($child->name->user_category, true);
//        if (is_array($userCategoryIds) && count($userCategoryIds) > 0) {
//            $child->user_categories = UserCategoryModel::whereIn('id', $userCategoryIds)->pluck('name')->toArray();
//        } else {
//            $child->user_categories = [];
//        }
//    }
//}
//$users = User::where('user_role',1)->orWhere('user_role',2)->orWhere('user_role',3)->orWhere('user_role',9)->get();
//$requestData = $request->all();
//Cache::put('order_table_data',$data);
//Cache::put('order_table_request',$requestData);
//return response()->view('admin.orders.procurement_officer.ajax.order_table', ['data' => $data,'order_status'=>$order_status,'users'=>$users,'view'=>'admin']);

public function index(){
    $users = User::whereIn('user_role',[1,2,3])->orWhere('id',1)->get();
    $supplier = User::where('user_role', 4)->get();
    $user_category = UserCategoryModel::get();
    $order_status = OrderStatusModel::orderBy('id','desc')->get();
    return view('admin.evaluation_orders.index' , ['supplier'=>$supplier , 'users'=>$users , 'user_category'=>$user_category , 'order_status'=>$order_status]);
    }

    public function details($id){
        $criteria = CriteriaModel::get();
        $order = OrderModel::where('id',$id)->first();
        if(auth()->user()->user_role == 1){
            $data = EvaluationModel::with('evaluation_criteria','evaluation_criteria.criteria' , 'evaluation_criteria.evaluation' , 'evaluation_criteria.evaluation.user' , 'evaluation_criteria.evaluation.user.role')->where('order_id',$id)->get();
            foreach($data as $key){
                $key->evaluation_value = EvaluationCriteriaModel::where('evaluation_id' , $key->id)->sum('value');
                foreach($key->evaluation_criteria as $key2){
                    $key->criteria_sum_mark = ($key->criteria_sum_mark + $key2->criteria->mark) ?? '100';
                }
            }
            return view('admin.evaluation_orders.details',['data'=>$data,'criteria'=>$criteria , 'order'=>$order]);
        }
        else{
            $data = EvaluationModel::with('evaluation_criteria','evaluation_criteria.criteria' , 'evaluation_criteria.evaluation' , 'evaluation_criteria.evaluation.user' , 'evaluation_criteria.evaluation.user.role')->where('order_id',$id)->where('user_id',auth()->user()->id)->get();
            foreach($data as $key){
                $key->evaluation_value = EvaluationCriteriaModel::where('evaluation_id' , $key->id)->sum('value');
                foreach($key->evaluation_criteria as $key2){
                    $key->criteria_sum_mark = ($key->criteria_sum_mark + $key2->criteria->mark) ?? '100';
                }
            }
            return view('admin.evaluation_orders.details',['data'=>$data,'criteria'=>$criteria , 'order'=>$order]);
        }
    }

    public function orders_list(Request $request)
    {
            Cache::forget('order_table_data');
            Cache::forget('order_table_request');
            $order_status = OrderStatusModel::get();
            $supplierId = $request->supplier_id;
            $referenceNumber = $request->reference_number;
            $from = $request->from;
            $to = $request->to;

            $data = OrderModel::query()
                ->when(!empty($supplierId), function ($query) use ($supplierId) {
                    $query->whereIn('id', function ($query) use ($supplierId) {
                        $query->select('order_id')
                            ->from('price_offers')
                            ->where('supplier_id', $supplierId);
                    });
                })
                ->when(!empty($referenceNumber), function ($query) use ($referenceNumber) {
                    $query->where('reference_number','like','%'. $referenceNumber. '%');
                })
                ->where(function ($query) use ($from, $to) {
                    $query->whereBetween('inserted_at', [$from, $to])
                        ->orWhereNull('inserted_at');
                })
                ->when(!empty($request->to_user),function ($query) use ($request){
                    $query->where('to_user','like','%'.$request->to_user.'%');
                })
                ->when(!empty($request->user_category), function ($query) use ($request) {
                    $query->whereIn('id', function ($query) use ($request) {
                        $query->select('order_id')
                            ->from('price_offers')
                            ->whereIn('supplier_id', function ($query) use ($request){
                                $query->select('id')->from('users')->whereJsonContains('user_category',$request->user_category)->get();
                        });
                    });
                })
                ->when(!empty($request->supplier_type), function ($query) use ($request) {
                    $query->whereIn('id', function ($query) use ($request) {
                        $query->select('order_id')
                            ->from('price_offers')
                            ->whereIn('supplier_id', function ($query) use ($request){
                                $query->select('id')->from('users')->where('potential_suppliers',$request->supplier_type)->get();
                            });
                    });
                })
                ->where('order_status',10)
                ->where('delete_status',0)
                ->orderBy('id','desc')
                ->paginate(20);
    
            foreach ($data as $key) {
                $key->order_status_color = OrderStatusModel::find($key->order_status);
                $key->user = User::find($key->user_id);
                $key->to_user = User::where('id', $key->to_user)->first();
                $key->supplier = PriceOffersModel::where('order_id', $key->id)->get();
                $key->expected_arrival_date = ShippingPriceOfferModel::where('order_id',$key->id)->first()->expected_arrival_date ?? '';
                foreach ($key->supplier as $child) {
                    $child->name = User::find($child->supplier_id);
                    $userCategoryIds = json_decode($child->name->user_category, true);
                    if (is_array($userCategoryIds) && count($userCategoryIds) > 0) {
                        $child->user_categories = UserCategoryModel::whereIn('id', $userCategoryIds)->pluck('name')->toArray();
                    } else {
                        $child->user_categories = [];
                    }
                }
            }
            $users = User::where('user_role',1)->orWhere('user_role',2)->orWhere('user_role',3)->orWhere('user_role',9)->get();
            $requestData = $request->all();
            Cache::put('order_table_data',$data);
            Cache::put('order_table_request',$requestData);
            return response()->view('admin.evaluation_orders.ajax.orders_list', ['data' => $data,'order_status'=>$order_status,'users'=>$users,'view'=>'admin']);
    }

    public function create_evaluation(Request $request)
{
    // البحث عن التقييم أو إنشائه
    $data = EvaluationModel::firstOrCreate(
        [
            'order_id' => $request->order_id,
            'user_id' => auth()->user()->id,
        ],
        [
            'notes' => $request->notes,
            'insert_at' => Carbon::now(),
            'status' => 'rated',
        ]
    );

    // معالجة الملفات المتعددة
    if ($request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . uniqid() . '.' . $extension;
            $file->storeAs('evaluation_file', $filename, 'public');
            // حفظ اسم الملف في قاعدة البيانات
            EvaluationAttachmentModel::create([
                'evaluation_id' => $data->id,
                'attachment' => $filename,
                'user_id' => auth()->user()->id
            ]);
        }
    }

    // تحديث أو إنشاء المعايير التقييمية
    foreach ($request->criteria as $key => $value) {
        EvaluationCriteriaModel::updateOrCreate(
            [
                'evaluation_id' => $data->id,
                'criteria_id' => $key,
            ],
            [
                'value' => $value,
            ]
        );
    }

    return redirect()->back()->with(['success' => 'تم إضافة البيانات بنجاح']);
}

    public function update_evaluation_status_ajax(Request $request){
        $data = EvaluationModel::where('id',$request->id)->first();
        $data->status = $request->status;
        if($data->save()){
            return response()->json([
                'success' => 'true',
                'message' => 'تم تعديل البيانات بنجاح',
            ]);
        }else{
            return response()->json([
                'success' => 'true',
                'message' => 'تعذر تعديل البيانات',
            ]);
        }
    }

    public function update_notes_ajax(Request $request){
        $data = EvaluationModel::where('id',$request->id)->first();
        $data->notes = $request->notes;
        if($data->save()){
            return response()->json([
                'success' => 'true',
                'message' => 'تم تعديل البيانات بنجاح',
            ]);
        }else{
            return response()->json([
                'success' => 'true',
                'message' => 'تعذر تعديل البيانات',
            ]);
        }
    }

    public function evaluation_order_pdf($id){
        $criteria = CriteriaModel::get();
        $order = OrderModel::where('id',$id)->first();
        if(auth()->user()->user_role == 1){
            $data = EvaluationModel::with('evaluation_criteria','evaluation_criteria.criteria' , 'evaluation_criteria.evaluation' , 'evaluation_criteria.evaluation.user' , 'evaluation_criteria.evaluation.user.role')->where('order_id',$id)->get();
            foreach($data as $key){
                $key->evaluation_value = EvaluationCriteriaModel::where('evaluation_id' , $key->id)->sum('value');
                foreach($key->evaluation_criteria as $key2){
                    $key->criteria_sum_mark = ($key->criteria_sum_mark + $key2->criteria->mark) ?? '100';
                }
            }
        }
        else{
            $data = EvaluationModel::with('evaluation_criteria','evaluation_criteria.criteria' , 'evaluation_criteria.evaluation' , 'evaluation_criteria.evaluation.user' , 'evaluation_criteria.evaluation.user.priceOffer' , 'evaluation_criteria.evaluation.user.role')->where('order_id',$id)->where('user_id',auth()->user()->id)->get();
            foreach($data as $key){
                $key->evaluation_value = EvaluationCriteriaModel::where('evaluation_id' , $key->id)->sum('value');
                foreach($key->evaluation_criteria as $key2){
                    $key->criteria_sum_mark = ($key->criteria_sum_mark + $key2->criteria->mark) ?? '100';
                }
            }
        }
        $pdf = PDF::loadView('admin.evaluation_orders.pdf.evalatuion_order_pdf', ['data'=>$data,'criteria'=>$criteria , 'order'=>$order]);

        return $pdf->stream('document.pdf');
    }

    public function delete_image(Request $request)
{
    $file = EvaluationAttachmentModel::find($request->id);
    if ($file) {
        // حذف الملف من التخزين
        Storage::disk('public')->delete('evaluation_file/' . $file->attachment);

        // حذف السجل من قاعدة البيانات
        $file->delete();

        return response()->json(['success' => 'تم حذف الصورة بنجاح']);
    }

    return response()->json(['error' => 'الصورة غير موجودة'], 404);
}
}
