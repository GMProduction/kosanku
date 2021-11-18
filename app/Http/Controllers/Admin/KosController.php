<?php

namespace App\Http\Controllers\Admin;

use App\Helper\CustomController;
use App\Http\Controllers\Controller;
use App\Models\MasterKos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class KosController extends CustomController
{
    //

    public function index()
    {
        if (\request()->isMethod('POST')) {
            return $this->store();
        }
        $data = MasterKos::with(
            [
                'user' => function ($q) {
                    $q->where('roles', '=', 'mitra');
                },
            ]
        )->paginate(10);
        $user = User::where('roles', '=', 'mitra')->get();
        return view('admin.kos')->with(['data' => $data,'user' => $user]);
    }

    public function store()
    {
        \request()->validate(
            [
                'nama'       => 'required',
                'keterangan' => 'required',
                'peruntukan' => 'required',
                'harga'      => 'required',
                'alamat'     => 'required',
                'user_id'    => 'required',
                'latitude'   => 'required',
                'longtitude' => 'required',
            ]
        );
        $field = \request()->all();

//        Arr::set($field,'user_id', auth()->id());
        if (\request('id')) {
            $kos = MasterKos::find(\request('id'));
            if (\request()->hasFile('foto')) {
                if ($kos->foto) {
                    $this->unlinkFile($kos, 'foto');
                }
                $textImg = $this->generateImageName('foto');
                $string  = '/images/kos/'.$textImg;
                $this->uploadImage('foto', $textImg, 'kos');
                Arr::set($field, 'foto', $string);
            }
            $kos->update($field);
        } else {
            if (\request()->hasFile('foto')) {
                $textImg = $this->generateImageName('foto');
                $string  = '/images/kos/'.$textImg;
                $this->uploadImage('foto', $textImg, 'kos');
                Arr::set($field, 'foto', $string);
            }
            MasterKos::create($field);
        }

        return $field;
    }


    public function delete($id){
        $kos = MasterKos::find($id);
        $kos->delete();
        return 'berhasil';
    }

    public function getDataById($id){
        $data = MasterKos::where('user_id',$id)->get();
        return $data;
    }

    public function getTrashById($id){
        $data = MasterKos::onlyTrashed()->where('user_id',$id)->get();
        return $data;
    }

    public function restore($id){
        $kos = MasterKos::onlyTrashed()->find($id);
        $kos->restore();
        return $kos;
    }

    public function trash(){
        $kos = MasterKos::onlyTrashed()->with(
            [
                'user' => function ($q) {
                    $q->where('roles', '=', 'mitra');
                },
            ]
        )->whereHas('user', function ($q){
            $q->where('deleted_at',null);
        })->get();
        return $kos;
    }
}
