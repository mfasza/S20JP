<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DownloadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // memunculukan pilihan unit kerja
    public function selection(Request $request)
    {
        switch ($request->get('value')) {
            case 'eselon2':
                switch (Auth::user()->role) {
                    case 'admin':
                        $data = DB::table('eselon2')->select('unit_eselon2', 'kode_eselon2')->get();
                        break;
                    case 'eselon2':
                        $data = DB::table('eselon2')->select('unit_eselon2', 'kode_eselon2')->where('kode_eselon2', Auth::user()->kode_satker)->get();
                        break;
                    case 'eselon3':
                        $data = DB::table('eselon2')->select('unit_eselon2', 'kode_eselon2')->get();
                        break;
                }
                $output =
                "<div style='width: 100%; height: 200px; overflow: auto; border: 1px solid #999; padding: 15px;'>
                    <div class='form-check'>
                        <input class='form-check-input' type='checkbox' onClick='toggle(this)' id='all'>
                        <label class='form-check-label' for='all'>
                            Pilih Semua
                        </label>
                    </div>";
                foreach ($data as $i => $row) {
                    $output .=
                    "<div class='form-check'>
                        <input class='form-check-input' type='checkbox' value='$row->kode_eselon2' id='checkbox$i' name='check[]'>
                        <label class='form-check-label' for='checkbox$i'>
                            $row->unit_eselon2
                        </label>
                    </div>";
                }
                $output .= "</div>";
                return $output;
                break;

            case 'eselon3':
                switch (Auth::user()->role) {
                    case 'admin':
                        $data = DB::table('eselon3')->select('unit_eselon3', 'kode_eselon3')->get();
                        break;
                    case 'eselon2':
                        $data = DB::table('eselon3')->select('unit_eselon3', 'kode_eselon3')->where('kode_eselon2', Auth::user()->kode_satker)->get();
                        break;
                    case 'eselon3':
                        $data = DB::table('eselon3')->select('unit_eselon3', 'kode_eselon3')->where('kode_eselon3', Auth::user()->kode_satker)->get();
                        break;
                }
                $output =
                "<div style='width: 100%; height: 200px; overflow: auto; border: 1px solid #999; padding: 15px;'>
                    <div class='form-check'>
                        <input class='form-check-input' type='checkbox' onClick='toggle(this)' id='all'>
                        <label class='form-check-label' for='all'>
                            Pilih Semua
                        </label>
                    </div>";
                foreach ($data as $i => $row) {
                    $output .=
                    "<div class='form-check'>
                        <input class='form-check-input' type='checkbox' value='$row->kode_eselon3' id='checkbox$i' name='check[]'>
                        <label class='form-check-label' for='checkbox$i'>
                            $row->unit_eselon3
                        </label>
                    </div>";
                }
                $output .= "</div>";
                return $output;
                break;
        }
    }

    //download
    public function export(Request $request) {
        $jenis_data = $request->jenis_data;
        $level_unit_kerja = $request->filter;
        $unit_kerja = $request->check;

        switch ($jenis_data) {
            case 'raw':
                $filename = 'Report_raw.xlsx';
                break;
            case 'agregat':
                $filename = 'Report_ag.xlsx';
                break;
        }

        return Excel::download(new ReportExport($jenis_data, $level_unit_kerja, $unit_kerja), $filename);
    }
}
