<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $eselon2 = DB::table('eselon2')->select('unit_eselon2')->get()->toArray(); //mengambil seluruh unit eselon 2
        $tmp = DB::table('kompetensi_pegawai')
                ->select(DB::raw('nip, SUM(jp) as jp'))
                ->join('kompetensi', 'kompetensi_pegawai.id_kompetensi', 'kompetensi.id_kompetensi')
                ->groupBy('nip');
        $jp = DB::table(DB::raw("({$tmp->toSql()}) as tabel_jp"))
                ->mergeBindings($tmp)
                ->where('jp', '>=', '20')
                ->count();
        $jml_peg = DB::table('pegawai') // menghitung jumlah seluruh pegawai BPS pada database
                ->select(DB::raw('count(nip) as jml_peg'))
                ->first();
        $obj = new \stdClass();
        $obj->tot_jp = round($jp / $jml_peg->jml_peg * 100, 2); // menghitung persentasi capaian 20 jp Indonesia
        $obj->unit_kerja = 'Indonesia';
        $satkers = [json_decode(json_encode($obj))];
        
        $jp_es2 = DB::table('eselon2') // mengambil capaian jp per unit eselon 2
                ->select(DB::raw('unit_eselon2, sum(jp) as tot_jp'))
                ->leftJoin('pegawai', 'eselon2.kode_eselon2', 'pegawai.kode_eselon2')
                ->leftJoin('kompetensi_pegawai', 'pegawai.nip', 'kompetensi_pegawai.nip')
                ->leftJoin('kompetensi', 'kompetensi_pegawai.id_kompetensi', 'kompetensi.id_kompetensi')
                ->groupBy('unit_eselon2')
                ->get();
        $jml_peg_es2 = DB::table('eselon2') //menghitung jumlah seluruh pegawai BPS pada database per eselon 2
                ->select(DB::raw('unit_eselon2, count(nip) as jml_peg'))
                ->leftJoin('pegawai', 'eselon2.kode_eselon2', 'pegawai.kode_eselon2')
                ->groupBy('unit_eselon2')
                ->get();
        foreach ($jp_es2 as $key => $value) { // merubah jp setiap unit eselon 2 dalam bentuk persentasi
            $value->tot_jp = ($jml_peg_es2[$key]->jml_peg == 0) ? $value->tot_jp : round($value->tot_jp / (20 * $jml_peg_es2[$key]->jml_peg) * 100, 2);
        }

        $jenis_jp = DB::table('kompetensi_pegawai') // menghitung jumlah pelatihan per jenis pengembangan kompetensi
                ->select(DB::raw('jenis_pengembangan, count(jenis_pengembangan) as jml'))
                ->join('kompetensi', 'kompetensi_pegawai.id_kompetensi', 'kompetensi.id_kompetensi')
                ->join('jenis_pengembangan', 'kompetensi.kode_pengembangan', 'jenis_pengembangan.kode_pengembangan')
                ->groupBy('jenis_pengembangan')
                ->get();
        $tot_jenis_jp = 0;
        foreach ($jenis_jp as $j) { // menghitung total kegaitan pengembangan kompetensi
            $tot_jenis_jp += $j->jml;
        }
        foreach ($jenis_jp as $j) {
            $j->jml = round($j->jml/$tot_jenis_jp*100,2);
        }
        return view('dashboard.dashboard', compact(['eselon2', 'satkers', 'jp_es2', 'jenis_jp']));
    }

    public function progressEselon2(Request $request)
    {
        $jp = DB::table('pegawai')
                ->select(DB::raw('unit_eselon2 as unit_kerja, sum(jp) as tot_jp'))
                ->where('unit_eselon2', $request->value)
                ->join('eselon2', 'pegawai.kode_eselon2', 'eselon2.kode_eselon2')
                ->leftJoin('kompetensi_pegawai', 'pegawai.nip', 'kompetensi_pegawai.nip')
                ->leftJoin('kompetensi', 'kompetensi_pegawai.id_kompetensi', 'kompetensi.id_kompetensi')
                ->groupBy('unit_eselon2')
                ->first();
        $jml_peg = DB::table('pegawai')
                ->select(DB::raw('count(nip) as jml_peg'))
                ->where('unit_eselon2', $request->value)
                ->join('eselon2', 'pegawai.kode_eselon2', 'eselon2.kode_eselon2')
                ->first();
        $obj = new \stdClass();
        $obj->tot_jp = ($jml_peg->jml_peg != 0) ? round($jp->tot_jp / (20 * $jml_peg->jml_peg) * 100, 2) : 0; // menghitung persentasi capaian 20 jp Indonesia
        $obj->unit_kerja = $request->value;
        $satkers = [json_decode(json_encode($obj))];
        $html = '<ul class="unstyled">';
        foreach($satkers as $s)
        {
            if($s->tot_jp <= 10) {
                $jenisProgresbar='progress-danger';
            } elseif ($s->tot_jp <= 30) {
                $jenisProgresbar='progress-warning';
            } elseif ($s->tot_jp >= 90) {
                $jenisProgresbar='progress-success';
            };
            $html .= "<li>".
                        $s->unit_kerja.
                        "<span class='pull-right strong'>".$s->tot_jp."%</span>
                        <div class='progress progress-striped ".$jenisProgresbar."'>
                            <div style='width:".$s->tot_jp."%' class='bar'></div>
                        </div>
                    </li>";
        }
        $html .= "</ul>";
        return $html;
    }
    
    public function progressPerUnit(Request $request)
    {
        $jp_es3 = DB::table('eselon3') // mengambil capaian jp per unit eselon 3
                ->select(DB::raw('unit_eselon3, sum(jp) as tot_jp'))
                ->leftJoin('eselon2', 'eselon3.kode_eselon2', 'eselon2.kode_eselon2')
                ->leftJoin('pegawai', 'eselon3.kode_eselon3', 'pegawai.kode_eselon3')
                ->leftJoin('kompetensi_pegawai', 'pegawai.nip', 'kompetensi_pegawai.nip')
                ->leftJoin('kompetensi', 'kompetensi_pegawai.id_kompetensi', 'kompetensi.id_kompetensi')
                ->where('unit_eselon2', $request->value)
                ->groupBy('unit_eselon3')
                ->get();
        $jml_peg_es3 = DB::table('eselon3') //menghitung jumlah seluruh pegawai BPS pada database per eselon 3
                ->select(DB::raw('unit_eselon3, count(nip) as jml_peg'))
                ->leftJoin('eselon2', 'eselon3.kode_eselon2', 'eselon2.kode_eselon2')
                ->leftJoin('pegawai', 'eselon3.kode_eselon3', 'pegawai.kode_eselon3')
                ->where('unit_eselon2', $request->value)
                ->groupBy('unit_eselon3')
                ->get();
        foreach ($jp_es3 as $key => $value) { // merubah jp setiap unit eselon 2 dalam bentuk persentasi
            $value->tot_jp = ($jml_peg_es3[$key]->jml_peg == 0) ? 0 : round($value->tot_jp / (20 * $jml_peg_es3[$key]->jml_peg) * 100, 2);
        }
        $html = '<ul class="unstyled">';
        foreach ($jp_es3 as $key => $s) {
            if($s->tot_jp <= 10) {
                $jenisProgresbar='progress-danger';
            } elseif ($s->tot_jp <= 30) {
                $jenisProgresbar='progress-warning';
            } elseif ($s->tot_jp >= 90) {
                $jenisProgresbar='progress-success';
            };
            $html .= "<li>".
                        $s->unit_eselon3.
                        "<span class='pull-right strong'>".$s->tot_jp."%</span>
                        <div class='progress progress-striped ".$jenisProgresbar."'>
                            <div style='width:".$s->tot_jp."%' class='bar'></div>
                        </div>
                    </li>";
        }
        $html .= "</ul>";
        return $html;
    }

    public function komposisiJP(Request $request){
        $jenis_jp = DB::table('eselon2')
                ->select(DB::raw('jenis_pengembangan, count(jenis_pengembangan) as jml'))
                ->join('pegawai', 'eselon2.kode_eselon2', 'pegawai.kode_eselon2')
                ->join('kompetensi_pegawai', 'pegawai.nip', 'kompetensi_pegawai.nip')
                ->join('kompetensi', 'kompetensi_pegawai.id_kompetensi', 'kompetensi.id_kompetensi')
                ->join('jenis_pengembangan', 'jenis_pengembangan.kode_pengembangan', 'kompetensi.kode_pengembangan')
                ->where('unit_eselon2', $request->value)
                ->groupBy('jenis_pengembangan')
                ->get();
        $tot_jenis_jp = 0;
        foreach ($jenis_jp as $j) { // menghitung total kegaitan pengembangan kompetensi
            $tot_jenis_jp += $j->jml;
        }
        foreach ($jenis_jp as $j) { // menghitung proporsi jenis pengembangan
            $j->jml = round($j->jml/$tot_jenis_jp*100,2);
        }
        return $jenis_jp;
    }
}