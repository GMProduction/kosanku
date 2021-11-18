<?php

use App\Http\Controllers\Admin\BanerController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\User\DikemasController;
use App\Http\Controllers\User\KeranjangController;
use App\Http\Controllers\User\MenungguController;
use App\Http\Controllers\User\PembayaranController;
use App\Http\Controllers\User\PengirimanController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SelesaiController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('')->middleware('auth')->group(function (){

    Route::get('/', function () {
        return view('admin.dashboard');
    });

    Route::get('/admin', function () {
        return view('admin');
    });

    Route::prefix('user')->group(function (){
        Route::get('', [\App\Http\Controllers\Admin\UserContoller::class,'index']);
        Route::post('register', [AuthController::class,'register']);
        Route::get('delete/{id}', [\App\Http\Controllers\Admin\UserContoller::class,'delete']);
        Route::get('{id}/kos', [\App\Http\Controllers\Admin\KosController::class,'getDataById']);
        Route::get('{id}/trash', [\App\Http\Controllers\Admin\KosController::class,'getTrashById']);
        Route::get('delete-kos/{id}',[\App\Http\Controllers\Admin\KosController::class, 'delete']);
        Route::post('restore-kos/{id}',[\App\Http\Controllers\Admin\KosController::class, 'restore']);
        Route::get('trash',[\App\Http\Controllers\Admin\UserContoller::class,'trash']);
        Route::post('restore/{id}', [\App\Http\Controllers\Admin\UserContoller::class,'restore']);
    });

    Route::prefix('kos')->group(function (){
        Route::match(['POST','GET'],'', [\App\Http\Controllers\Admin\KosController::class,'index']);
        Route::get('delete/{id}', [\App\Http\Controllers\Admin\KosController::class,'delete']);
        Route::get('trash', [\App\Http\Controllers\Admin\KosController::class,'trash']);
        Route::post('restore/{id}', [\App\Http\Controllers\Admin\KosController::class,'restore']);
    });

});


Route::match(['GET','POST'],'/login', [AuthController::class, 'loginWeb'])->name('login');
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/register-member', [AuthController::class, 'registerMember']);
