<?php

namespace App\Imports;

use App\Pegawai;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class AdminImport_p implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;
    private $kode_es2 = '';
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $this->kode_es2 = $row['Kode Unit Eselon 2'];

        return new Pegawai([
            'nip' => $row['NIP'],
            'nama' => $row['Nama'],
            'kode_eselon2' => $row['Kode Unit Eselon 2'],
            'kode_eselon3' => $row['Kode Unit Eselon 3']
        ]);
    }
    /**
     * Set input validation
     * @return array
     */
    public function rules():array
    {
        $list_es3 = DB::table('eselon3')->where('kode_eselon2', '=', $this->kode_es2)->pluck('kode_eselon3')->toArray();

        return [
            '*.NIP' => 'required|digits:18|unique:pegawai,nip',
            '*.Nama' => 'required|string|regex:/^[a-zA-Z .\']+$/u',
            '*.Kode Unit Eselon 2' => 'required|numeric|exists:eselon2,kode_eselon2',
            '*.Kode Unit Eselon 3' => ['nullable','numeric', 'exists:eselon3,kode_eselon3', 'bail', Rule::in($list_es3)]
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
            '*.Kode Unit Eselon 2.exists' => ':attribute yang Anda masukkan salah. Lihat daftar master unit kerja.',
            '*.Kode Unit Eselon 3.in' => ':attribute yang Anda masukkan tidak sesuai dengan Kode Unit Eselon 2 yang Anda masukkan.',
            '*.Kode Unit Eselon 3.exists' => ':attribute yang Anda masukkan salah. Lihat daftar kode unit kerja.',
            '*.numeric' => 'Kolom :attribute hanya dapat diisi dengan angka.',
            '*.string' => 'Kolom :attribute hanya dapat diisi dengan huruf.',
            '*.required' => 'Kolom :attribute tidak boleh kosong.'
        ];
    }
}
