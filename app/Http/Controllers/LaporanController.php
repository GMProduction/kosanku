<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
  

    public function cetakLaporanTransaksi()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->dataTransaksi())->setPaper('f4', 'potrait');

        return $pdf->stream();
    }

    public function dataTransaksi()
    {
        
        $data   = [
            'data' => "data",
            'start' => "2012-01-01",
            'end' => "2012-01-01",
        ];

        return view('admin/cetaktransaksi')->with($data);
    }

    public function cetakLaporanPemasukan()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->dataPemasukan())->setPaper('f4', 'potrait');

        return $pdf->stream();
    }

    public function dataPemasukan()
    {
        
        $data   = [
            'data' => "data",
            'start' => "2012-01-01",
            'end' => "2012-01-01",
        ];

        return view('admin/cetakpemasukan')->with($data);
    }

}
