<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserContoller extends Controller
{
    //

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(){
        $user = User::paginate(10);
        return view('admin.user')->with(['data' => $user]);
    }

    public function delete($id){
        $user = User::find($id);
        $user->delete();
        return 'berhasil';
    }

    public function trash(){
        $user = User::onlyTrashed()->get();
        return $user;
    }

    public function restore($id){
        $user = User::onlyTrashed()->find($id);
        $user->restore();
        return $user;
    }


}
