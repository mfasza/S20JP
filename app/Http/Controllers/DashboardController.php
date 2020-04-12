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
        switch (Auth::user()->role) {
            case 'admin':
                // PILIHAN
                $eselon2 = DB::table('eselon2')->select('unit_eselon2')->get()->toArray(); //mengambil seluruh unit eselon 2
                // PROGRESS
                // mengambil capaian jp seluruh pegawai BPS RI
                $tmp = DB::table('kompetensi_pegawai')
                        ->select(DB::raw('nip, SUM(jp) as jp'))
                        ->join('kompetensi', 'kompetensi_pegawai.id_kompetensi', 'kompetensi.id_kompetensi')
                        ->groupBy('nip');
                // menghitung jumlah pegawai dengan capaian jp lebih besar dari 20
                $jp = DB::table(DB::raw("({$tmp->toSql()}) as tabel_jp"))
                        ->mergeBindings($tmp)
                        ->where('jp', '>=', '20')
                        ->count();
                // menghitung jumlah seluruh pegawai BPS pada database
                $jml_peg = DB::table('pegawai')
                        ->select(DB::raw('count(nip) as jml_peg'))
                        ->first();
                // menghitung persentasi capaian 20 jp Indonesia
                $obj = new \stdClass();
                $obj->tot_jp = round($jp / $jml_peg->jml_peg * 100, 2);
                $obj->unit_kerja = 'Indonesia';
                $satkers = [json_decode(json_encode($obj))];
                // PROGRESS PER SATUAN KERJA
                // mengambil capaian jp per unit eselon 2 per pegawai
                $jp_es2 = DB::table('eselon2')
                        ->select(DB::raw('unit_eselon2, pegawai.nip, sum(jp) as tot_jp'))
                        ->leftJoin('pegawai', 'eselon2.kode_eselon2', 'pegawai.kode_eselon2')
                        ->leftJoin('kompetensi_pegawai', 'pegawai.nip', 'kompetensi_pegawai.nip')
                        ->leftJoin('kompetensi', 'kompetensi_pegawai.id_kompetensi', 'kompetensi.id_kompetensi')
                        ->groupBy('unit_eselon2', 'pegawai.nip');
                // menghitung jumlah pegawai dengan capaian jp lebih besar dari 20 per unit eselon 2
                $jml_peg_20jp = DB::table(DB::raw("({$jp_es2->toSql()}) as jp_es2"))
                        ->mergeBindings($jp_es2)
                        ->select(DB::raw("unit_eselon2, COUNT(nip) as tot_jp"))
                        ->where("tot_jp", ">=", "20")
                        ->groupBy("unit_eselon2");
                // menghitung jumlah seluruh pegawai BPS pada database per unit eselon 2 dan left join dengan tabel jml_peg_20jp
                $jml_peg_es2 = DB::table('eselon2')
                        ->select(DB::raw('eselon2.unit_eselon2, count(nip) as jml_peg, tot_jp'))
                        ->leftJoin('pegawai', 'eselon2.kode_eselon2', 'pegawai.kode_eselon2')
                        ->leftJoinSub($jml_peg_20jp, 'jml_peg_20jp', function($join){
                            $join->on('eselon2.unit_eselon2','=','jml_peg_20jp.unit_eselon2');
                        })
                        ->groupBy('eselon2.unit_eselon2')
                        ->get();
                // menghitung persentasi capaian 20 jp per unit eselon 2
                foreach ($jml_peg_es2 as $key => $value) {
                    $value->tot_jp = ($value->jml_peg == 0) ? $value->tot_jp : round($value->tot_jp / $value->jml_peg * 100, 2);
                }
                // KOMPOSISI PEGEMBANGAN KOMPETENSI
                $jenis_jp = DB::table('kompetensi_pegawai') // menghitung jumlah pelatihan per jenis pengembangan kompetensi
                        ->select(DB::raw('jenis_pengembangan, count(jenis_pengembangan) as jml'))
                        ->join('kompetensi', 'kompetensi_pegawai.id_kompetensi', 'kompetensi.id_kompetensi')
                        ->join('jenis_pengembangan', 'kompetensi.kode_pengembangan', 'jenis_pengembangan.kode_pengembangan')
                        ->groupBy('jenis_pengembangan')
                        ->get();
                $tot_jenis_jp = 0;
                // menghitung total kegiatan pengembangan kompetensi
                foreach ($jenis_jp as $j) {
                    $tot_jenis_jp += $j->jml;
                }
                foreach ($jenis_jp as $j) {
                    $j->jml = round($j->jml/$tot_jenis_jp*100,2);
                }
                return view('dashboard.admin', compact(['eselon2', 'satkers', 'jml_peg_es2', 'jenis_jp']));
                break;
            
            case 'eselon2':
                return view('dashboard.eselon2');
                break;

            case 'eselon3':
                return view('dashboard.eselon3');
                break;
        }
    }
    
    /**
     * Ajax request progress eselon 2 terpilih
     */
    public function progressEselon2(Request $request)
    {
        // mengambil capaian jp unit eselon 2 terpilih per pegawai
        $jp_es2 = DB::table('eselon2')
                ->select(DB::raw('unit_eselon2, pegawai.nip, sum(jp) as tot_jp'))
                ->leftJoin('pegawai', 'eselon2.kode_eselon2', 'pegawai.kode_eselon2')
                ->leftJoin('kompetensi_pegawai', 'pegawai.nip', 'kompetensi_pegawai.nip')
                ->leftJoin('kompetensi', 'kompetensi_pegawai.id_kompetensi', 'kompetensi.id_kompetensi')
                ->where('unit_eselon2', $request->value)
                ->groupBy('unit_eselon2', 'pegawai.nip');
        // menghitung jumlah pegawai unit eselon 2 terpilih dengan capaian jp lebih besar dari 20
        $jml_peg_20jp = DB::table(DB::raw("({$jp_es2->toSql()}) as jp_es2"))
                ->mergeBindings($jp_es2)
                ->where("tot_jp", ">=", "20")
                ->count();
        // menghitung jumlah seluruh pegawai unit eselon 2 terpilih pada database
        $jml_peg = DB::table('pegawai')
                ->select(DB::raw('count(nip) as jml_peg'))
                ->where('unit_eselon2', $request->value)
                ->join('eselon2', 'pegawai.kode_eselon2', 'eselon2.kode_eselon2')
                ->first();
        // menghitung persentasi capaian 20 jp unit eselon 2 terpilih
        $obj = new \stdClass();
        $obj->tot_jp = ($jml_peg->jml_peg != 0) ? round($jml_peg_20jp / $jml_peg->jml_peg * 100, 2) : 0;
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
        // mengambil capaian jp per unit eselon 3 dari unit eselon 2 terpilih
        $jp_es3 = DB::table('eselon3')
                    ->select(DB::raw('unit_eselon3, pegawai.nip, sum(jp) as tot_jp'))
                    ->leftJoin('eselon2', 'eselon2.kode_eselon2', 'eselon3.kode_eselon2')
                    ->leftJoin('pegawai', 'pegawai.kode_eselon3', 'eselon3.kode_eselon3')
                    ->leftJoin('kompetensi_pegawai', 'kompetensi_pegawai.nip', 'pegawai.nip')
                    ->leftJoin('kompetensi', 'kompetensi.id_kompetensi', 'kompetensi_pegawai.id_kompetensi')
                    ->where('unit_eselon2', $request->value)
                    ->groupBy('unit_eselon3', 'pegawai.nip');
        $jml_peg_20jp = DB::table(DB::raw("({$jp_es3->toSql()}) as jp_es3"))
                    ->mergeBindings($jp_es3)
                    ->select(DB::raw('unit_eselon3, count(nip) as tot_jp'))
                    ->where('tot_jp', '>=', '20')
                    ->groupBy('unit_eselon3');
        $jml_peg_es3 = DB::table('eselon3')
                    ->select(DB::raw("eselon3.unit_eselon3, count(nip) as jml_peg, tot_jp"))
                    ->leftJoin('eselon2', 'eselon2.kode_eselon2', 'eselon3.kode_eselon2')
                    ->leftJoin('pegawai', 'pegawai.kode_eselon3', 'eselon3.kode_eselon3')
                    ->leftJoinSub($jml_peg_20jp, 'jml_peg_20jp', function($join){
                        $join->on('eselon3.unit_eselon3', '=', 'jml_peg_20jp.unit_eselon3');
                    })
                    ->where('unit_eselon2', $request->value)
                    ->groupBy('eselon3.unit_eselon3')
                    ->get();
        foreach ($jml_peg_es3 as $key => $value) {
            $value->tot_jp = ($value->jml_peg == 0) ? 0 : round($value->tot_jp / $value->jml_peg * 100, 2);
        }
        $html = '<ul class="unstyled">';
        foreach ($jml_peg_es3 as $key => $s) {
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
        // menghitung total kegaitan pengembangan kompetensi
        foreach ($jenis_jp as $j) {
            $tot_jenis_jp += $j->jml;
        }
        // menghitung proporsi jenis pengembangan
        foreach ($jenis_jp as $j) {
            $j->jml = round($j->jml/$tot_jenis_jp*100,2);
        }
        return $jenis_jp;
    }
}