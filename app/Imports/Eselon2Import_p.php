<?php

namespace App\Imports;

use App\Pegawai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\Failure;

class Eselon2Import_p implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Pegawai([
            'nip' => $row['NIP'],
            'nama' => $row['Nama'],
            'kode_eselon2' => Auth::user()->kode_satker,
            'kode_eselon3' => $row['Kode Unit Eselon 3']
        ]);
    }
    /**
     * Set input validation
     * @return array
     */
    public function rules():array
    {
        $list_es3 = DB::table('eselon3')->where('kode_eselon2', '=', Auth::user()->kode_satker)->pluck('kode_eselon3')->toArray();
        return [
            '*.NIP' => 'required|digits:18|unique:pegawai,nip',
            '*.Nama' => 'required|string|regex:/^[a-zA-Z .\']+$/u',
            '*.Kode Unit Eselon 3' => ['nullable','numeric', 'exists:eselon3,kode_eselon3', Rule::in($list_es3)]
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
            '*.Kode Unit Eselon 3.in' => ':attribute yang Anda masukkan tidak berada dibawah unit kerja Anda.',
            '*.Kode Unit Eselon 3.exists' => ':attribute yang Anda masukkan salah. Lihat daftar master unit kerja.',
            '*.numeric' => 'Kolom :attribute hanya dapat diisi dengan angka.',
            '*.required' => 'Kolom :attribute tidak boleh kosong.'
        ];
    }
}
