<?php

namespace App\Imports;

use App\Pegawai;
use Illuminate\Support\Facades\Auth;
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
    private $baris = 2;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $kode_es2 = $row['Kode Unit Eselon 2'];
        $list_es3 = DB::table('eselon3')->where('kode_eselon2', '=', $kode_es2)->pluck('kode_eselon3')->toArray();

        Validator::make($row, [
            'Kode Unit Eselon 3' => [Rule::in($list_es3)]
        ], [
            'Kode Unit Eselon 3.in' => '(Baris '.$this->baris.':Kolom Kode Unit Eselon 3): Kode Unit Eselon 3 yang Anda masukkan tidak sesuai dengan Kode Unit Eselon 2 yang Anda masukkan.'
        ])->validate();

        $this->baris += 1;

        return new Pegawai([
            'nip' => $row['NIP'],
            'nama' => $row['Nama'],
            'kode_eselon2' => $row['Kode Unit Eselon 2'],
            'kode_eselon3' => $row['Kode Unit Eselon 3'],
            'editor' => Auth::user()->kode_satker
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
            '*.Nama' => 'required|string|regex:/^[a-zA-Z .\']+$/u',
            '*.Kode Unit Eselon 2' => 'required|numeric|exists:eselon2,kode_eselon2',
            '*.Kode Unit Eselon 3' => ['nullable','numeric', 'exists:eselon3,kode_eselon3']
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
            '*.Kode Unit Eselon 3.in' => '',
            '*.Kode Unit Eselon 3.exists' => ':attribute yang Anda masukkan salah. Lihat daftar kode unit kerja.',
            '*.numeric' => 'Kolom :attribute hanya dapat diisi dengan angka.',
            '*.string' => 'Kolom :attribute hanya dapat diisi dengan huruf.',
            '*.required' => 'Kolom :attribute tidak boleh kosong.'
        ];
    }
}
