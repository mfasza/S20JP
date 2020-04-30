<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

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
        $list_es3 = DB::table('eselon3')
                ->select('unit_eselon3', 'kode_eselon3')
                ->get();
        $list_es2 = DB::table('eselon2')
                ->select('unit_eselon2', 'kode_eselon2')
                ->get();

        return view('bantuan.kodeUnitKerja', compact('list_es2', 'list_es3'));
    }
    /**
     * Menampilkan halaman panduan
     */
    public function panduan()
    {
        return view('bantuan.panduan');
    }
}
