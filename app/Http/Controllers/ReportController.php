<?php

namespace App\Http\Controllers;

use App\Models\BankModel;
use App\Models\CashPaymentsModel;
use App\Models\CurrencyModel;
use App\Models\LetterBankModel;
use App\Models\OrderItemsModel;
use App\Models\OrderModel;
use App\Models\OrderStatusModel;
use App\Models\PriceOfferItemsModel;
use App\Models\PriceOffersModel;
use App\Models\ProductModel;
use App\Models\ProductSupplierModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    public function index()
    {
        $supplier = User::where('user_role', 4)->get();
        $order_status = OrderStatusModel::get();
        return view('admin.reports.index', ['supplier' => $supplier,'order_status'=>$order_status]);
    }

    public function suppliers_report()
    {
        $data = User::where('user_role', 4)->where('user_status',1)
            ->select('users.*')
            ->selectSub(function ($query) {
                $query->from('price_offers')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('supplier_id', 'users.id');
            }, 'count')
            ->orderBy('count','desc')
            ->get();
//        foreach ($data as $key) {
//            $key->count = PriceOffersModel::where('supplier_id', $key->id)->count();
//        }
        $pdf = PDF::loadView('admin.reports.supplier_report.index', ['data' => $data]);
        return $pdf->stream('suppliers_report.pdf');
    }

    public function supplier_report(Request $request)
    {
        $supplier = User::where('id', $request->supplier_id)->first();
        $data = OrderModel::join('price_offers', 'price_offers.order_id', '=', 'orders.id')->where('price_offers.supplier_id', $request->supplier_id)->whereBetween('orders.inserted_at', [$request->from, $request->to])->get();
        $pdf = PDF::loadView('admin.reports.supplier_report.supplier_report', ['data' => $data, 'supplier' => $supplier]);
        return $pdf->stream('supplier_report.pdf');
    }

    public function details_supplier_report(Request $request)
    {
        $supplier = User::where('id', $request->supplier_id)->first();
        $data = OrderModel::join('price_offers', 'price_offers.order_id', '=', 'orders.id')->where('price_offers.supplier_id', $request->supplier_id)->whereBetween('orders.inserted_at', [$request->from, $request->to])->where(function ($query) use ($request){
            if ($request->order_status != ''){
                $query->where('orders.order_status',$request->order_status);
            }
        })
            ->get();
        foreach ($data as $key) {
            $key->product = PriceOfferItemsModel::join('product', 'product.id', '=', 'price_offer_items.product_id')->where('price_offer_items.order_id', $key->order_id)->where('price_offer_items.supplier_id', $key->supplier_id)->get();
        }
        $pdf = PDF::loadView('admin.reports.supplier_report.details_supplier_report', ['data' => $data, 'supplier' => $supplier]);

        return $pdf->stream('details_supplier_report.pdf');
    }

    public function products_report()
    {
        $data = ProductModel::get();
        $pdf = PDF::loadView('admin.reports.product_report.products_report', ['data' => $data]);
        return $pdf->stream('products.pdf');
    }

    public function products_to_the_company_report(Request $request)
    {
        $supplier = User::where('id', $request->user_id)->first();
        $data = ProductSupplierModel::select('product.id as product_id', 'product.product_name_ar', 'product.product_name_en' , 'product.barcode' , 'product_supplier.*')->join('product', 'product.id', '=', 'product_supplier.product_id')->where('user_id', $request->user_id)->get();
        $pdf = PDF::loadView('admin.reports.product_report.products_to_the_company_report', ['data' => $data, 'supplier' => $supplier]);
        return $pdf->stream('products.pdf');
    }

    public function order_index()
    {
        $supplier = User::where('user_role', 4)->get();
        return view('admin.reports.orders.index', ['supplier' => $supplier]);
    }

    public function order_table(Request $request)
    {
//        $data = OrderModel::where('order_status', 1)->where('id', 'like', '%' . $request->search_order_number . '%')->orWhere('reference_number', 'like', '%' . $request->search_order_number . '%')->take(10)->orderBy('id', 'desc')->get();
//        $price_offier = PriceOffersModel::where()
        $from = $request->from;
        $to = $request->to;
        $data = OrderModel::join('price_offers', 'price_offers.order_id', '=', 'orders.id')
            ->where('orders.order_status', 1)
            ->where('price_offers.supplier_id', 'like', '%' . $request->supplier_id . '%')
            ->where(function ($query) use ($request) {
                if ($request->has('reference_number')) {
                    $query->where('orders.reference_number', 'like', '%' . $request->reference_number . '%');
                }
//                else {
//                    // Include records with null reference_number
//                    $query->orWhereNull('orders.reference_number');
//                }
            })
            ->whereBetween('orders.inserted_at', [($request->from) ?? Carbon::now()->startOfYear(), ($request->to) ?? Carbon::now()]) // Adjust the date range as needed
            ->take(10)
            ->orderBy('orders.id', 'desc')
            ->get();

        foreach ($data as $key) {
            $key->user = User::where('id', $key->user_id)->first();
            $key->supplier = PriceOffersModel::where('order_id', $key->order_id)->get();
            foreach ($key->supplier as $child) {
                $child->name = User::select('name')->where('id', $child->supplier_id)->first();
            }
        }
        return response()->view('admin.reports.ajax.order_table', ['data' => $data]);
    }

    public function financial_report_index(){
        $suppliers = User::where('user_role',4)->get();
        $users = User::where('user_role',2)->get();
        return view('admin.reports.financial_report.index',['suppliers'=>$suppliers,'users'=>$users]);
    }

    public function financial_report_data_filter_ajax(Request $request){
        $cash_payment = '';
        $letter_bank = '';
        $cash_payment_sum = 0;
        $letter_bank_sum = 0;
        $letter_bank_currency = '';
        $cash_payment_currency = '';
        $from = $request->from_date;
        $to = Carbon::parse($request->to_date)->addDay(1);
        if ($request->report_type == 'financial' || $request->report_type == 'all'){
            $cash_payment = CashPaymentsModel::whereIn('order_id',function ($query) use ($request){
                $query->select('order_id')->from('price_offers')->where('supplier_id','like','%'.$request->supplier_id.'%')->get();
            })
                ->where(function ($query) use ($from, $to) {
                    $query->from('cash_payments')->whereBetween('insert_at', [$from, $to])
                        ->orWhereNull('insert_at');
                })
                ->where('payment_status','like','%'.$request->payment_status.'%')
                ->when($request->filled('insert_by'),function ($query) use ($request){
                    $query->where('user_id',$request->insert_by);
                })
//                ->where(function ($query) use ($request){
//                    if (!empty($request->payment_status)){
//                        $query->where('payment_status',$request->payment_status);
//                    }
//                })
//                ->when(!empty($request->payment_status),function ($query) use ($request){
//                    $query->where('payment_status',$request->payment_status);
//                })
                ->orderBy($request->order_by??'id',$request->order_by_type??'desc')->get();

            foreach ($cash_payment as $key){
                $key->currency = CurrencyModel::where('id',$key->currency_id)->first();
                $key->inserrt_by = User::where('id',$key->user_id)->first();
            }

            $cash_payment_currency = CurrencyModel::whereIn('id',function ($query) use ($request){
                $query->select('currency_id')->from('cash_payments')->whereIn('order_id',function ($query) use ($request){
                    $query->select('order_id')->from('price_offers')->where('supplier_id','like','%'.$request->supplier_id.'%')->get();
                });
            })->get();

            foreach ($cash_payment_currency as $key){
                $key->sum = CashPaymentsModel::where('currency_id',$key->id)->whereIn('order_id',function ($query) use ($request){
                    $query->select('order_id')->from('price_offers')->where('supplier_id','like','%'.$request->supplier_id.'%')->get();
                })
                    ->where(function ($query) use ($from, $to) {
                        $query->from('cash_payments')->whereBetween('insert_at', [$from, $to])
                            ->orWhereNull('insert_at');
                    })
                    ->where('payment_status','like','%'.$request->payment_status.'%')
                    ->when($request->filled('insert_by'),function ($query) use ($request){
                        $query->where('user_id',$request->insert_by);
                    })

                    ->sum('amount');
            }

            $cash_payment_sum = CashPaymentsModel::whereIn('order_id', function ($query) use ($request) {
                $query->select('order_id')
                    ->from('price_offers')
                    ->where('supplier_id', 'like', '%' . $request->supplier_id . '%')
                    ->when($request->filled('insert_by'),function ($query) use ($request){
                        $query->where('user_id',$request->insert_by);
                    })
                    ->get();
            })
                ->where(function ($query) use ($from, $to) {
                    $query->whereBetween('insert_at', [$from, $to])
                        ->orWhereNull('insert_at');
                })
                ->where('payment_status','like','%'.$request->payment_status.'%')
                ->when($request->filled('insert_by'),function ($query) use ($request){
                    $query->where('user_id',$request->insert_by);
                })
                ->sum('amount');
        }
        if($request->report_type == 'letter_bank' || $request->report_type == 'all'){
            $letter_bank = LetterBankModel::whereIn('order_id',function ($query) use ($request){
                $query->select('order_id')->from('price_offers')->where('supplier_id','like','%'.$request->supplier_id.'%')->get();
            })
                ->where(function ($query) use ($from, $to) {
                    $query->from('letter_bank')->whereBetween('created_at', [$from, $to])
                        ->orWhereNull('created_at');
                })
                ->where('status','like','%'.$request->payment_status.'%')
                ->when($request->filled('insert_by'),function ($query) use ($request){
                    $query->where('user_id',$request->insert_by);
                })
                ->orderBy($request->order_by??'id',$request->order_by_type??'desc')->get();

            $letter_bank_sum = LetterBankModel::whereIn('order_id',function ($query) use ($request){
                $query->select('order_id')->from('price_offers')->where('supplier_id','like','%'.$request->supplier_id.'%')->get();
            })
                ->where(function ($query) use ($from, $to) {
                    $query->from('letter_bank')->whereBetween('created_at', [$from, $to])
                        ->orWhereNull('created_at');
                })
                ->where('status','like','%'.$request->payment_status.'%')
                ->when($request->filled('insert_by'),function ($query) use ($request){
                    $query->where('user_id',$request->insert_by);
                })
                ->sum('letter_value');
            foreach($letter_bank as $key){
                $key->bank = BankModel::where('id',$key->bank_id)->first();
                $key->currency = CurrencyModel::where('id',$key->currency_id)->first();
                $key->insert_by = User::where('id',$key->user_id)->first();
            }

            $letter_bank_currency = CurrencyModel::whereIn('id',function ($query) use ($request,$from,$to){
                $query->select('currency_id')->from('letter_bank')->whereIn('order_id',function ($query) use ($request){
                    $query->select('order_id')->from('price_offers')->where('supplier_id','like','%'.$request->supplier_id.'%')->get();
                })
                    ->where(function ($query) use ($from, $to) {
                        $query->from('letter_bank')->whereBetween('created_at', [$from, $to])
                            ->orWhereNull('created_at');
                    })
                    ->when($request->filled('insert_by'),function ($query) use ($request){
                        $query->where('user_id',$request->insert_by);
                    });
            })->get();

            foreach ($letter_bank_currency as $key){
                $key->sum = LetterBankModel::where('currency_id',$key->id)->whereIn('order_id',function ($query) use ($request){
                    $query->select('order_id')->from('price_offers')->where('supplier_id','like','%'.$request->supplier_id.'%')->get();
                })
                    ->where(function ($query) use ($from, $to) {
                        $query->from('letter_bank')->whereBetween('created_at', [$from, $to])
                            ->orWhereNull('created_at');
                    })
                    ->when($request->filled('insert_by'),function ($query) use ($request){
                        $query->where('user_id',$request->insert_by);
                    })
                    ->where('status','like','%'.$request->payment_status.'%')->sum('letter_value');
            }
        }

        return response()->json([
            'success'=>'true',
            'view'=>view('admin.reports.financial_report.ajax.data_table',['cash_payment'=>$cash_payment,'letter_bank'=>$letter_bank,'cash_payment_sum'=>$cash_payment_sum,'letter_bank_sum'=>$letter_bank_sum,'request'=>$request,'cash_payment_currency'=>$cash_payment_currency,'letter_bank_currency'=>$letter_bank_currency])->render(),
        ]);
    }

    public function financial_report_PDF(Request $request){
        $cash_payment = '';
        $letter_bank = '';
        $from = $request->from;
        $to = Carbon::parse($request->to)->addDay(1);

        if ($request->report_type == 'financial' || $request->report_type == 'all'){
            $cash_payment = CashPaymentsModel::whereIn('order_id',function ($query) use ($request){
                $query->select('order_id')->from('price_offers')->where('supplier_id','like','%'.$request->supplier_id.'%')->get();
            })
                ->where(function ($query) use ($from, $to) {
                    $query->from('cash_payments')->whereBetween('insert_at', [$from, $to])
                        ->orWhereNull('insert_at');
                })
                ->get();
        }
        if($request->report_type == 'letter_bank' || $request->report_type == 'all'){
            $letter_bank = LetterBankModel::whereIn('order_id',function ($query) use ($request){
                $query->select('order_id')->from('price_offers')->where('supplier_id','like','%'.$request->supplier_id.'%')->get();
            })
                ->where(function ($query) use ($from, $to) {
                    $query->from('cash_payments')->whereBetween('created_at', [$from, $to])
                        ->orWhereNull('created_at');
                })
                ->get();
            foreach($letter_bank as $key){
                $key->bank = BankModel::where('id',$key->bank_id)->first();
            }
        }
        $user = User::where('id',$request->supplier_id)->value('name');
        $pdf = PDF::loadView('admin.reports.financial_report.financial_report_pdf', ['cash_payment' => $cash_payment, 'letter_bank' => $letter_bank,'user'=>$user]);
        return $pdf->stream('financial_report.pdf');
    }

    public function order_by(Request $request){

    }
}
