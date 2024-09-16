<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\RoleLevelModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        return view('admin.users.index');
    }

    public function updateStatus(Request $request){
        $data = User::find($request->id);
        if ($request->user_status == 'true'){
            $data->user_status = 1;
        }
        else if($request->user_status == 'false'){
            $data->user_status = 0;
        }
        if ($data->save()){
            return response()->json([
                'message'=>'success'
            ]);
        }
    }
}
