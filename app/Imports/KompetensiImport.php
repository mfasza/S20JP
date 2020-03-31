<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\KompetensiPegawai;
use App\Kompetensi;
use \PhpOffice\PhpSpreadsheet\Shared\Date as tgl;

class KompetensiImport implements ToCollection, WithHeadingRow
{
    use Importable;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
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
        $today = date('Y-m-d');
        $data = $collection;
        foreach ($data as $d) {
            $d['Tanggal Mulai'] = ($d['Tanggal Mulai'] != null) ? tgl::excelToDateTimeObject($d['Tanggal Mulai']) : $d['Tanggal Mulai'];
            $d['Tanggal Selesai'] = ($d['Tanggal Selesai'] != null) ? tgl::excelToDateTimeObject($d['Tanggal Selesai']) : $d['Tanggal Selesai'];
        }
        Validator::make($data->toArray(),[
            '*.Tanggal Mulai' => ['required', 'before:'.$today],
            '*.Tanggal Selesai' => ['required', 'after_or_equal:*.Tanggal Mulai', 'before:'.$today],
            '*.Kode Jenis Pengembangan' => ['required', 'alpha_num', 'exists:jenis_pengembangan,kode_pengembangan'],
            '*.Nama Kegiatan' => ['required'],
            '*.Penyelenggara Kegiatan' => ['required'],
            '*.Total Jam Pelajaran' => ['required', 'numeric', 'min:1'],
            '*.NIP Peserta' => ['required', 'digits:18', 'exists:pegawai,nip', Rule::in($nip)]
        ],[
            '*.Tanggal Mulai.required' => '(:attribute): Tanggal Mulai tidak boleh kosong.', '*.Tanggal Mulai.before' => '(:attribute): Tanggal Mulai harus sebelum :date.',
            '*.Tanggal Selesai.required' => '(:attribute): Tanggal Selesai tidak boleh kosong.', '*.Tanggal Selesai.after_or_equal' => '(:attribute): Tanggal Selesai harus setelah atau sama seperti Tanggal Mulai.', '*.Tanggal Selesai.before' => '(:attribute): Tanggal Selesai harus sebelum :date.',
            '*.Kode Jenis Pengembangan.required' => '(:attribute): Kode Jenis Pengembangan tidak boleh kosong.', '*.Kode Jenis Pengembangan.alpha_num' => '(:attribute): Kode Jenis Pengembangan hanya dapat berisi huruf atau angka.','*.Kode Jenis Pengembangan.exists' => '(:attribute): Kode Jenis Pengembangan tidak tersedia.',
            '*.Nama Kegiatan.required' => '(:attribute): Nama Kegiatan tidak boleh kosong.',
            '*.Penyelenggara Kegiatan.required' => '(:attribute): Penyelenggara Kegiatan tidak boleh kosong.',
            '*.Total Jam Pelajaran.required' => '(:attribute): Total Jam Pelajaran tidak boleh kosong.', '*.Total Jam Pelajaran.numeric' => '(:attribute): Total Jam Pelajaran hanya dapat diisi dengan angka.', '*.Total Jam Pelajaran.min' => '(:attribute): Total Jam Pelajaran harus lebih besar dari 0.',
            '*.NIP Peserta.required' => '(:attribute): NIP Peserta tidak boleh kosong.', '*.NIP Peserta.digits' => '(:attribute): Masukkan :digits digit NIP dengan benar.', '*.NIP Peserta.exists' => '(:attribute): NIP tidak tersedia. Periksa apakah pegawai sudah terdaftar.', '*.NIP Peserta.in' => '(:attribute): Pegawai dengan NIP yang Anda masukkan diluar otoritas Anda.',
        ])->validate();
        foreach ($data as $row) {
            KompetensiPegawai::firstOrCreate([
                'nip' => $row['NIP Peserta'],
                'id_kompetensi' => 
                Kompetensi::firstOrCreate([
                    'tanggal_mulai' => $row['Tanggal Mulai'],
                    'tanggal_selesai' => $row['Tanggal Selesai'],
                    'nama_pengembangan' => $row['Nama Kegiatan'],
                    'penyelenggara' => $row['Penyelenggara Kegiatan'],
                    'jp' => $row['Total Jam Pelajaran'],
                    'kode_pengembangan' => $row['Kode Jenis Pengembangan'],
                ])->id_kompetensi
            ]);
        }
    }
}
