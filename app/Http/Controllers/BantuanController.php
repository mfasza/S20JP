<?php

namespace App\Http\Controllers;

class BantuanController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan halaman kode unit kerja.
     */
    public function kodeUnitKerja()
    {
        return view('bantuan.kodeUnitKerja');
    }
    /**
     * Menampilkan halaman panduan
     */
    public function panduan()
    {
        return view('bantuan.panduan');
    }
}
