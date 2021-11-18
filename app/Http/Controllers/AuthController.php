<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    //
    public function isAuth($credentials = [])
    {
        if (count($credentials) > 0 && Auth::attempt($credentials)) {
            return true;
        }

        return false;
    }

    public function register()
    {
        $field = \request()->validate(
            [
                'username' => 'required',
                'nama'     => 'required',
                'password' => 'required|confirmed',
                'alamat'   => 'required',
                'no_hp'    => 'required',
                'roles'    => 'required',
            ]
        );
        if (! \request('id')){
            $user1 = User::where('username', '=', $field['username'])->first();
            if ($user1) {
                return response()->json(
                    [
                        'msg' => 'Username sudah digunakan',
                    ],
                    201
                );
            }
            Arr::set($field, 'password', Hash::make($field['password']));
            $user  = User::create($field);
            if ($field['roles'] != 'admin'){
                $token = $user->createToken($field['roles'],['member:'.$field['roles']])->plainTextToken;
                $user->update(['token' => $token]);
                return response()->json(
                    [
                        'status' => 200,
                        'data'   => [
                            'token' => $token,
                            'roles' => $user->roles,
                        ],
                    ]
                );
            }
            return 'berhasil';
        }



        Arr::forget($field,'password');
        if (strpos(request('password'), '*') === false) {
            Arr::set($field, 'password', Hash::make(request('password')));
        }
        $user = User::find(\request('id'));
        $user->update($field);

        return 'berhasil';


    }

    public function login()
    {
        $field = \request()->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ]
        );

        $user = User::where('username', '=', $field['username'])->first();
        if ( ! $user || ! Hash::check($field['password'], $user->password) || ! $user->roles) {
            return response()->json(
                [
                    'msg' => 'Login gagal',
                ],
                401
            );
        }

        $user->tokens()->delete();
        $token = $user->createToken($user->roles,[$user->roles])->plainTextToken;
        $user->update(
            [
                'token' => $token,
            ]
        );

        return response()->json(
            [
                'status' => 200,
                'data'   => [
                    'token' => $token,
                    'roles' => $user->roles,
                ],
            ]
        );
    }


    public function loginWeb()
    {
        if (\request()->isMethod('GET')){
            return view('login');
        }
        $credentials = [
            'username' => \request('username'),
            'password' => \request('password'),
        ];
        if ($this->isAuth($credentials)) {
            $redirect = '/login';
            if (Auth::user()->roles === 'admin') {
                return redirect('/');
            }

            return Redirect::back()->withErrors(['failed', 'Maaf anda bukan admin']);
        }

        return Redirect::back()->withErrors(['failed', 'Periksa Kembali Username dan Password Anda']);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}
