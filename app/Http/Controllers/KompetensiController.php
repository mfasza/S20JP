<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\KompetensiPegawai;
use App\Kompetensi;
use App\Imports\KompetensiImport;
use App\Pegawai;

class KompetensiController extends Controller
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
     * Show employer's competency achievement
     */
    public function index(){
        function getJp(String $kode){
            $jp = DB::table('pegawai')
                    ->select(DB::raw('pegawai.nip, nama, unit_eselon2, unit_eselon3, sum(jp) as jp'))
                    ->where('pegawai.'.$kode, '=', Auth::user()->kode_satker)
                    ->join('eselon2', 'pegawai.kode_eselon2', 'eselon2.kode_eselon2')
                    ->leftJoin('eselon3', 'pegawai.kode_eselon3', 'eselon3.kode_eselon3')
                    ->leftJoin('kompetensi_pegawai', 'pegawai.nip', 'kompetensi_pegawai.nip')
                    ->leftJoin('kompetensi', 'kompetensi_pegawai.id_kompetensi', 'kompetensi.id_kompetensi')
                    ->groupBy('pegawai.nip', 'nama', 'unit_eselon2', 'unit_eselon3')
                    ->orderByDesc('jp')
                    ->get();
            return $jp;
        }
        switch (Auth::user()->role) {
            case 'eselon2':
                $jp = getJp('kode_eselon2');
                break;
            case 'eselon3':
                $jp = getJp('kode_eselon3');
                break;
            case 'admin':
                $jp = DB::table('pegawai')
                    ->select(DB::raw('pegawai.nip, nama, unit_eselon2, unit_eselon3, sum(jp) as jp'))
                    ->join('eselon2', 'pegawai.kode_eselon2', 'eselon2.kode_eselon2')
                    ->leftJoin('eselon3', 'pegawai.kode_eselon3', 'eselon3.kode_eselon3')
                    ->leftJoin('kompetensi_pegawai', 'pegawai.nip', 'kompetensi_pegawai.nip')
                    ->leftJoin('kompetensi', 'kompetensi_pegawai.id_kompetensi', 'kompetensi.id_kompetensi')
                    ->groupBy('pegawai.nip', 'nama', 'unit_eselon2', 'unit_eselon3')
                    ->orderByDesc('jp')
                    ->get();
                break;
        }
        return view('kompetensi.kompetensi', ['jp' => $jp]);
    }
    /**
     * Show form for competency input
     */
    public function form(){
        $jenis_pengembangan = DB::table('jenis_pengembangan')->get();
        return view('kompetensi.form_kompetensi', ['jenis_pengembangan' => $jenis_pengembangan ]);
    }
    /**
     * Insert competency to database
     */
    public function insert(Request $request){
        function getNIP(String $kode){
            $nip = DB::table('pegawai')
                ->select('nip')
                ->where('pegawai.'.$kode, '=', Auth::user()->kode_satker)
                ->pluck('nip')
                ->toArray();
            return $nip;
        }
        switch (Auth::user()->role) {
            case 'eselon2':
                $nip = getNIP('kode_eselon2');
                break;

            case 'eselon3':
                $nip = getNIP('kode_eselon3');
                break;
            case 'admin':
                $nip = DB::table('pegawai')
                    ->select('nip')
                    ->pluck('nip')
                    ->toArray();
                break;
        }
        $today = date("Y-m-d");
        Validator::make($request->all(),[
            'tgl_start' => ['required', 'date_format:Y-m-d', 'before:'.$today],
            'tgl_end' => ['required', 'date_format:Y-m-d', 'after_or_equal:tgl_start', 'before:'.$today],
            'kode_pengembangan' => ['required', 'alpha_num', 'exists:jenis_pengembangan,kode_pengembangan'],
            'nama_acara' => ['required'],
            'penyelenggara' => ['required'],
            'jp' => ['required','numeric', 'min:1'],
            'nip' => ['required','digits:18','exists:pegawai,nip',Rule::in($nip)]
        ],[
            'nip.exists' => 'NIP tidak tersedia. Periksa apakah pegawai sudah terdaftar.',
            'digits' => 'Masukkan :digits digit NIP dengan benar.',
            'in' => 'Pegawai dengan NIP yang Anda masukkan diluar otoritas Anda.',
            ])->validate();
        $id_komp = Kompetensi::firstOrCreate([
            'tanggal_mulai' => $request->tgl_start,
            'tanggal_selesai' => $request->tgl_end,
            'nama_pengembangan' => $request->nama_acara,
            'penyelenggara' => $request->penyelenggara,
            'jp' => $request->jp,
            'kode_pengembangan' => $request->kode_pengembangan
        ])->id_kompetensi;
        $komp_peg = KompetensiPegawai::firstOrCreate([
            'nip' => $request->nip,
            'id_kompetensi' => $id_komp,
        ]);
        $komp = Kompetensi::where('id_kompetensi', $id_komp)->first();
        $komp->editor = Auth::user()->kode_satker;
        $komp->save();
        $komp_peg->editor = Auth::user()->kode_satker;
        $komp_peg->save();
        Session::flash('sukses', 'Data berhasil ditambahkan.');
        return redirect(route('kompetensi.view'));
    }
    /**
     * Import competencies with excel file
     */
    public function import(Request $request){
        // validate request
        $this->validate($request, [
            'excelFile' => 'required|mimes:xlsx,xls,csv'
        ],[
            'excelFile.mimes' => 'Format dokumen harus berekstensi .xlsx'
        ]);
        $import = new KompetensiImport();
        try {
            $import->import($request->excelFile, 'local');
        } catch (\ErrorException $e) {
            return redirect()->back()->withErrors('(Kolom Tanggal Mulai / Tanggal Selesai): Format penulisan tanggal seharusnya 1998-02-16');
        }
        Session::flash('sukses', 'Seluruh data berhasil ditambahkan.');
        return redirect()->back();
    }
    /**
     * Download template for importing data
     */
    public function downloadExcel(){
        $file = '.\file\kompetensi_input.xlsx';
        return redirect($file);
    }
    /**
     * Show detail of competencies of selected employees
     */
    public function detilKompetensi($nip){
        function getNIP(String $kode){
            $nip = DB::table('pegawai')
                ->select('nip')
                ->where('pegawai.'.$kode, '=', Auth::user()->kode_satker)
                ->pluck('nip')
                ->toArray();
            return $nip;
        }
        function getDetilKompetensi(String $nip, String $kode){
            $kompetensi = DB::table('kompetensi_pegawai')
                    ->select('kompetensi.*')
                    ->where('kompetensi_pegawai.nip', '=', $nip)
                    ->whereIn('kompetensi_pegawai.nip', getNIP($kode))
                    ->join('kompetensi', 'kompetensi_pegawai.id_kompetensi', 'kompetensi.id_kompetensi')
                    ->join('pegawai', 'kompetensi_pegawai.nip', 'pegawai.nip')
                    ->get();
            return $kompetensi;
        }
        $nama = Pegawai::findOrFail($nip);
        switch (Auth::user()->role) {
            case 'eselon2':
                $detil = getDetilKompetensi($nip, 'kode_eselon2');
                break;
            case 'eselon3':
                $detil = getDetilKompetensi($nip, 'kode_eselon3');
                break;
            case 'admin':
                $detil = DB::table('kompetensi_pegawai')
                    ->select('kompetensi.*')
                    ->where('kompetensi_pegawai.nip', '=', $nip)
                    ->join('kompetensi', 'kompetensi_pegawai.id_kompetensi', 'kompetensi.id_kompetensi')
                    ->join('pegawai', 'kompetensi_pegawai.nip', 'pegawai.nip')
                    ->get();
                break;
        }
        return view('kompetensi.detilKompetensi', ['detil' => $detil, 'nama' => $nama, 'nip' => $nip]);
    }
    /**
     * Delete employee's competency data
     */
    public function delete(Request $request){
        $kompetensi = KompetensiPegawai::where('id_kompetensi', $request->id_kompetensi)
                ->where('nip', $request->id_pegawai)
                ->delete();
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
     * Edit Detail Competency of an Employee
     */
    public function edit($nip, $id_komp){
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
        $kompetensi = Kompetensi::findOrFail($id_komp);
        $jenis_pengembangan = DB::table('jenis_pengembangan')->get();
        return view('kompetensi.edit_kompetensi', ['kompetensi' => $kompetensi, 'nip' =>$nip, 'jenis_pengembangan' => $jenis_pengembangan]);
    }
    /**
     * Update detil kompetensi pegawai
     */
    public function update($nip_peg, $id_kompetensi, Request $request){
        function getNIP(String $kode){
            $nip = DB::table('pegawai')
                ->select('nip')
                ->where('pegawai.'.$kode, '=', Auth::user()->kode_satker)
                ->pluck('nip')
                ->toArray();
            return $nip;
        }
        switch (Auth::user()->role) {
            case 'eselon2':
                $nip = getNIP('kode_eselon2');
                break;

            case 'eselon3':
                $nip = getNIP('kode_eselon3');
                break;
            case 'admin':
                $nip = DB::table('pegawai')
                    ->select('nip')
                    ->pluck('nip')
                    ->toArray();
                break;
        }
        $today = date("Y-m-d");
        Validator::make($request->all(),[
            'tgl_start' => ['required', 'date_format:Y-m-d', 'before:'.$today],
            'tgl_end' => ['required', 'date_format:Y-m-d', 'after_or_equal:tgl_start', 'before:'.$today],
            'kode_pengembangan' => ['required', 'alpha_num', 'exists:jenis_pengembangan,kode_pengembangan'],
            'nama_acara' => ['required'],
            'penyelenggara' => ['required'],
            'jp' => ['required','numeric', 'min:1'],
            'nip' => ['required','digits:18','exists:pegawai,nip',Rule::in($nip)]
        ],[
            'nip.exists' => 'NIP tidak tersedia. Periksa apakah pegawai sudah terdaftar.',
            'digits' => 'Masukkan :digits digit NIP dengan benar.',
            'in' => 'Pegawai dengan NIP yang Anda masukkan diluar otoritas Anda.',
        ])->validate();
        $komp_peg = KompetensiPegawai::where('id_kompetensi', $id_kompetensi)->where('nip', $nip_peg)->first();
        $id_komp = Kompetensi::firstOrCreate([
            'tanggal_mulai' => $request->tgl_start,
            'tanggal_selesai' => $request->tgl_end,
            'nama_pengembangan' => $request->nama_acara,
            'penyelenggara' => $request->penyelenggara,
            'jp' => $request->jp,
            'kode_pengembangan' => $request->kode_pengembangan
        ])->id_kompetensi;
        $komp_peg ->nip = $nip_peg;
        $komp_peg->id_kompetensi = $id_komp;
        $komp_peg->editor = Auth::user()->kode_satker;
        try {
            $komp_peg->save();
            $komp = Kompetensi::where('id_kompetensi', $id_komp)->first();
            $komp->editor = Auth::user()->kode_satker;
            $komp->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect(url('/kompetensi/detil', $request->nip))->withErrors('Riwayat pengembangan sudah ada dalam daftar, tidak dapat menambah riwayat yang sama.');
        }
        $trash = Kompetensi::select(DB::raw('kompetensi.id_kompetensi, nip'))
                ->leftJoin('kompetensi_pegawai', 'kompetensi_pegawai.id_kompetensi', 'kompetensi.id_kompetensi')
                ->get();
        foreach ($trash as $t) {
            if ($t->nip == null) {
                Kompetensi::where('id_kompetensi', $t->id_kompetensi)
                ->delete();
            }
        }
        Session::flash('sukses', 'Data berhasil diperbaruhi.');
        return redirect(url('/kompetensi/detil', $request->nip));
    }
}
