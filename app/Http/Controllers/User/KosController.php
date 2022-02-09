<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MasterKos;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class KosController extends Controller
{
    //
    public function index()
    {
        $kos = MasterKos::all();

        return $kos;
    }

    public function search($nama)
    {
        if($nama == null || $nama == ""){
            $kos = MasterKos::all();
        }else{
            $kos = MasterKos::where('nama', 'like', '%'.$nama.'%')->get();
        }

        return $kos;
    }



    public function detail($id)
    {
        $kos = MasterKos::with(['user','rating'])->find($id);

        return $kos;
    }

    public function rating($id)
    {
        $field = \request()->validate(
            [
                'rate'     => 'required',
                'komentar' => 'required',
            ]
        );

        if (\request('isAnonym')) {
            Arr::set($field, 'isAnonym', \request('isAnonym'));
        }
        Arr::set($field, 'user_id', \auth()->id());
        Arr::set($field, 'kos_id', $id);

        Rating::create($field);
        return 'berhasil';
    }
}
