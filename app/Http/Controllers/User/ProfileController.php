<?php

namespace App\Http\Controllers\User;

use App\Helper\CustomController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends CustomController
{
    //

    public function index(){
        if (\request()->isMethod('POST')){
            return $this->store();
        }
        $user = User::find(auth()->id());
        return $user;
    }

    public function store()
    {
        $field = \request()->validate(
            [
                'username' => 'required',
                'password' => 'required|confirmed',
                'nama'     => 'required',
                'alamat' => 'required',
                'no_hp'  => 'required',
            ]
        );
        $username       = User::where([['username', '=', $field['username']], ['id', '!=', Auth::id()]])->first();
        if ($username) {
            return response()->json(
                [
                    "msg" => "The username has already been taken.",
                ],
                '201'
            );
        }
        Arr::forget($field, 'password');
        if (strpos(request('password'), '*') === false) {
            Arr::set($field, 'password', Hash::make(request('password')));
        }

        $user = User::find(Auth::id());
        $user->update($field);

        return User::find(Auth::id());
    }

    public function avatar(){
        \request()->validate([
            'avatar' => 'required|image'
        ]);
       $user = User::find(\auth()->id());
       if ($user->avatar){
           $this->unlinkFile($user,'avatar');
       }
        $textImg  = $this->generateImageName('avatar');
        $string   = '/images/avatar/'.$textImg;
        $this->uploadImage('avatar', $textImg, 'avatar');
        $user->update(['avatar' => $string]);
        return $user;
    }
}
