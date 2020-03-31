<?php

namespace App\Imports;

use App\Pegawai;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Failure;

class Eselon3Import_p implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $es2 = DB::table('eselon3')->where('kode_eselon3', '=', Auth::user()->kode_satker)->pluck('kode_eselon2')->first();
        return new Pegawai([
            'nip' => $row['NIP'],
            'nama' => $row['Nama'],
            'kode_eselon2' => $es2,
            'kode_eselon3' => Auth::user()->kode_satker
        ]);
    }
    /**
     * Set input validation
     * @return array
     */
    public function rules():array
    {
        return [
            '*.NIP' => 'required|digits:18|unique:pegawai,nip',
            '*.Nama' => 'required|string|regex:/^[a-zA-Z .\']+$/u'
        ];
    }
    /**
     * Custom validation messages
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            '*.NIP.digits' => 'Masukkan :digits digit NIP dengan benar.',
            '*.NIP.unique' => 'NIP sudah terdaftar di database. Mohon periksa kembali.',
            '*.Nama.regex' => 'Kolom Nama hanya dapat diisi dengan huruf.',
            '*.required' => 'Kolom :attribute tidak boleh kosong.'
        ];
    }
}