<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterKos;
use Illuminate\Http\Request;

class KosController extends Controller
{
    //

    public function index(){
        $data = MasterKos::with(['user' => function($q){
            $q->where('roles','=','mitra');
        }])->paginate(10);
        return view('admin.kos')->with(['data' => $data]);
    }
}
