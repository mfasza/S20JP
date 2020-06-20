<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Pegawai;
use App\Kompetensi;
use Illuminate\Support\Facades\Session;
use App\Imports\AdminImport_p;
use App\Imports\Eselon2Import_p;
use App\Imports\Eselon3Import_p;
use \Maatwebsite\Excel\Validators\ValidationException as Excel;

class PegawaiController extends Controller
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
    /**
     * Show Employers data base on privilege
     */
    public function index(Request $request){
        function getPegawai(String $kode){
            $pegawai = DB::table('pegawai')
                ->select('nip', 'nama', 'unit_eselon2', 'unit_eselon3')
                ->where('pegawai.'.$kode, '=', Auth::user()->kode_satker)
                ->join('eselon2', 'pegawai.kode_eselon2', 'eselon2.kode_eselon2')
                ->leftJoin('eselon3', 'pegawai.kode_eselon3', 'eselon3.kode_eselon3')
                ->get();
            return $pegawai;
        }
        switch (Auth::user()->role) {
            case 'eselon2':
                $pegawai = getPegawai('kode_eselon2');
                break;

            case 'eselon3':
                $pegawai = getPegawai('kode_eselon3');
                break;
            case 'admin':
                $pegawai = DB::table('pegawai')
                    ->select('nip', 'nama', 'unit_eselon2', 'unit_eselon3')
                    ->join('eselon2', 'pegawai.kode_eselon2', 'eselon2.kode_eselon2')
                    ->leftJoin('eselon3', 'pegawai.kode_eselon3', 'eselon3.kode_eselon3')
                    ->get();
                break;
        }
        return view('pegawai.pegawai', ['pegawai'=>$pegawai]);
    }
    /**
     * Show input form
     */
    public function form(){
        function getSatker(String $kode){
            $satker = DB::table('eselon2')
                ->select('unit_eselon2', 'eselon3.*')
                ->where('eselon3.'.$kode, '=', Auth::user()->kode_satker)
                ->join('eselon3','eselon3.kode_eselon2', 'eselon2.kode_eselon2')
                ->get();
            return $satker;
        }
        switch (Auth::user()->role) {
            case 'eselon2':
                $satker = getSatker('kode_eselon2');
                break;

            case 'eselon3':
                $satker = getSatker('kode_eselon3');
                break;

            case 'admin':
                $satker = DB::table('eselon2')->get();
                break;
        }
        return view('pegawai.form_pegawai', ['satker' => $satker]);
    }
    /**
     * autofill eselon 3 input form
     */
    public function fill(Request $request){
        $select = $request->select;
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = DB::table('eselon3')
            ->where($select, $value)
            ->get();
        $output = '<option value="">Pilih Unit Eselon 3</option>';
        foreach ($data as $row) {
            $output .= '<option value="'.$row->kode_eselon3.'">'.$row->kode_eselon3.' - '.$row->unit_eselon3.'</option>';
        }
        echo $output;
    }
    /**
     * Insert new employer data to database
     */
    public function insert(Request $request){
        // validate request
        $this->validate($request,[
            'nip' => 'required|digits:18|unique:pegawai,nip',
            'nama' => 'required|string|regex:/^[a-zA-Z .\']+$/u',
            'eselon2' => 'required|numeric'
        ],[
            'digits' => 'Masukkan :digits digit NIP dengan benar.',
            'unique' => 'NIP sudah terdaftar di database. Mohon periksa kembali.',
            'nama.regex' => 'Kolom Nama hanya dapat diisi dengan huruf.'
        ]);
        Pegawai::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'kode_eselon2' => $request->eselon2,
            'kode_eselon3' => $request->eselon3,
            'editor' => Auth::user()->kode_satker
        ]);
        Session::flash('sukses', 'Data berhasil ditambahkan.');
        return redirect(route('pegawai.view'));
    }
    /**
     * Download template for importing data
     */
    public function downloadExcel(){
        $user = Auth::user()->role;
        switch ($user) {
            case 'admin':
                $file = '.\file\admin_pegawai_input.xlsx';
                break;
            case 'eselon2':
                $file = '.\file\eselon2_pegawai_input.xlsx';
                break;
            case 'eselon3':
                $file = '.\file\eselon3_pegawai_input.xlsx';
                break;
        }
        return redirect($file);
    }
    /**
     * Import new employer with excel file
     */
    public function import(Request $request){
        // validate request
        $this->validate($request, [
            'excelFile' => 'required|mimes:xlsx,xls,csv'
        ],[
            'excelFile.mimes' => 'Format dokumen tidak sesuai.'
        ]);
        switch (Auth::user()->role) {
            case 'admin':
                $import = new AdminImport_p();
                break;
            case 'eselon2':
                $import = new Eselon2Import_p();
                break;
            case 'eselon3':
                $import = new Eselon3Import_p();
                break;
        }
        try {
            $import->import($request->excelFile, 'local');
        } catch (Excel $e) {
            $failures = $e->failures();
            return redirect()->back()->withError($failures);
        }
        Session::flash('sukses', 'Seluruh data berhasil ditambahkan.');
        return redirect()->back();
    }
    /**
     * Delete employer data
     */
    public function delete(Request $request){
        $pegawai = Pegawai::findOrFail($request->pegawai_id);
        $pegawai->delete();
        $trash = Kompetensi::select(DB::raw('kompetensi.id_kompetensi, nip'))
                ->leftJoin('kompetensi_pegawai', 'kompetensi_pegawai.id_kompetensi', 'kompetensi.id_kompetensi')
                ->get();
        foreach ($trash as $t) {
            if ($t->nip == null) {
                Kompetensi::where('id_kompetensi', $t->id_kompetensi)
                ->delete();
            }
        }
        Session::flash('sukses', 'Data berhasil dihapus.');
        return redirect()->back();
    }
    /**
     * Edit employer data
     */
    public function edit($nip){
        function getNIP(String $kode){
            $nip = DB::table('pegawai')
                ->select('nip')
                ->where('pegawai.'.$kode, '=', Auth::user()->kode_satker)
                ->pluck('nip')
                ->toArray();
            return $nip;
        }
        function getPegawai(String $nip, String $kode){
            $pegawai = Pegawai::whereIn('nip', getNIP($kode))->findOrFail($nip);
            return $pegawai;
        }
        switch (Auth::user()->role) {
            case 'eselon2':
                $pegawai = getPegawai($nip, 'kode_eselon2');
                break;
            case 'eselon3':
                $pegawai = getPegawai($nip, 'kode_eselon3');
                break;
            case 'admin':
                $pegawai = Pegawai::findOrFail($nip);
                break;
        }
        $satker = DB::table('eselon2')->get();
        $es3 = DB::table('eselon3')
            ->where('kode_eselon2', $pegawai->kode_eselon2)
            ->get();
        return view('pegawai.edit_pegawai', ['pegawai' => $pegawai, 'satker' => $satker, 'es3' => $es3]);
    }
    /**
     * Update employer data
     */
    public function update(Request $request, $nip){
        // validate request
        $this->validate($request,[
            'nip' => 'required|digits:18|unique:pegawai,nip,'.$nip.',nip',
            'nama' => 'required|string|regex:/^[a-zA-Z ]+$/u',
            'eselon2' => 'required|numeric'
        ],[
            'nama.regex' => 'Kolom Nama hanya dapat diisi dengan huruf.'
        ]);
        $pegawai = Pegawai::findOrFail($nip);
        $pegawai->nip = $request->nip;
        $pegawai->nama = $request->nama;
        $pegawai->kode_eselon2 = $request->eselon2;
        $pegawai->kode_eselon3 = $request->eselon3;
        $pegawai->editor = Auth::user()->kode_satker;
        $pegawai->save();
        Session::flash('sukses', 'Data berhasil diubah.');
        return redirect(route('pegawai.view'));
    }
}
