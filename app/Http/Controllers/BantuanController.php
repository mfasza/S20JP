<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
        switch (Auth::user()->role) {
            case 'eselon2':
                $list_es3 = DB::table('eselon3')
                        ->select('unit_eselon3', 'kode_eselon3')
                        ->where('kode_eselon2', Auth::user()->kode_satker)
                        ->get();
                $list_es2 = DB::table('eselon2')
                        ->select('unit_eselon2', 'kode_eselon2')
                        ->where('kode_eselon2', Auth::user()->kode_satker)
                        ->get();
                break;

            case 'eselon3':
                $list = DB::table('eselon3')
                        ->leftJoin('eselon2', 'eselon2.kode_eselon2', 'eselon3.kode_eselon2')
                        ->where('kode_eselon3', Auth::user()->kode_satker);
                $list_es2 = $list
                        ->select('unit_eselon2', 'eselon2.kode_eselon2')
                        ->get();
                $list_es3 = $list
                        ->select('unit_eselon3', 'kode_eselon3')
                        ->get();
                break;

            case 'admin':
                $list_es3 = DB::table('eselon3')
                        ->select('unit_eselon3', 'kode_eselon3')
                        ->get();
                $list_es2 = DB::table('eselon2')
                        ->select('unit_eselon2', 'kode_eselon2')
                        ->get();
                break;
        }

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
