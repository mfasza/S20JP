<?php

namespace App\Exports;

use App\Pegawai;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithEvents
{
    use Exportable;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(String $jenis_data, String $level_unit_kerja, Array $unit_kerja)
    {
        $this->jenis_data = $jenis_data;
        $this->level_unit_kerja = $level_unit_kerja;
        $this->unit_kerja = $unit_kerja;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        switch ($this->jenis_data) {
            case 'raw':
                $pegawai = Pegawai::join('eselon2', 'pegawai.kode_eselon2', 'eselon2.kode_eselon2')
                ->leftJoin('eselon3', 'pegawai.kode_eselon3', 'eselon3.kode_eselon3')
                ->leftJoin('kompetensi_pegawai', 'pegawai.nip', 'kompetensi_pegawai.nip')
                ->leftJoin('kompetensi', 'kompetensi_pegawai.id_kompetensi', 'kompetensi.id_kompetensi')
                ->leftJoin('jenis_pengembangan', 'kompetensi.kode_pengembangan', 'jenis_pengembangan.kode_pengembangan')
                ->select('pegawai.nip', 'nama', 'unit_eselon2', 'unit_eselon3', 'jenis_pengembangan.kode_pengembangan', 'jenis_pengembangan', 'kompetensi.penyelenggara', 'jp')
                ->whereIn('eselon3.kode_'.$this->level_unit_kerja, $this->unit_kerja)
                ->orderBy('nama', 'asc')
                ->get();

                $data = [];
                foreach ($pegawai as $i => $pgw) {
                    $data[$i]['nip'] = $pgw->nip.' ';
                    $data[$i]['nama'] = $pgw->nama;
                    $data[$i]['kode_eselon2'] = $pgw->unit_eselon2;
                    $data[$i]['kode_eselon3'] = $pgw->unit_eselon3;
                    $data[$i]['kode_pengembangan'] = ($pgw->kode_pengembangan == null) ? '-' : $pgw->kode_pengembangan ;
                    $data[$i]['jenis_pengembangan'] = ($pgw->jenis_pengembangan == null) ? '-' : $pgw->jenis_pengembangan ;
                    $data[$i]['penyelenggara'] = ($pgw->penyelenggara == null) ? '-' : $pgw->penyelenggara ;
                    $data[$i]['jp'] = ($pgw->jp == null) ? '-' : $pgw->jp;
                }
                break;

            case 'agregat':
                $pegawai = Pegawai::join('eselon2', 'pegawai.kode_eselon2', 'eselon2.kode_eselon2')
                ->leftJoin('eselon3', 'pegawai.kode_eselon3', 'eselon3.kode_eselon3')
                ->leftJoin('kompetensi_pegawai', 'pegawai.nip', 'kompetensi_pegawai.nip')
                ->leftJoin('kompetensi', 'kompetensi_pegawai.id_kompetensi', 'kompetensi.id_kompetensi')
                ->select(DB::raw('pegawai.nip, nama, unit_eselon2, unit_eselon3, sum(jp) as total_jp'))
                ->whereIn('eselon3.kode_'.$this->level_unit_kerja, $this->unit_kerja)
                ->groupBy('pegawai.nip')
                ->orderBy('nama', 'asc')
                ->get();

                $data = [];
                foreach ($pegawai as $i => $pgw) {
                    $data[$i]['nip'] = $pgw->nip.' ';
                    $data[$i]['nama'] = $pgw->nama;
                    $data[$i]['kode_eselon2'] = $pgw->unit_eselon2;
                    $data[$i]['kode_eselon3'] = $pgw->unit_eselon3;
                    $data[$i]['total_jp'] = ($pgw->total_jp == null) ? '-' : $pgw->total_jp;
                }
                break;
        }

        return collect([$data]);
    }

    /**
     * adding Header
     */
    public function headings(): array
    {
        switch ($this->jenis_data) {
            case 'raw':
                $heading = [
                    'NIP',
                    'Nama',
                    'Unit Kerja Eselon 2',
                    'Unit Kerja Eselon 3',
                    'Kode Pengembangan',
                    'Jenis/Jalur Pengembangan',
                    'Penyelenggara',
                    'JP'
                ];
                break;

            case 'agregat':
                $heading = [
                    'NIP',
                    'Nama',
                    'Unit Kerja Eselon 2',
                    'Unit Kerja Eselon 3',
                    'Total JP'
                ];
                break;
        }

        return $heading;
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        switch ($this->jenis_data) {
            case 'raw':
                $column_format = [
                    'A' => NumberFormat::FORMAT_TEXT,
                    'G' => NumberFormat::FORMAT_NUMBER
                ];
                break;

            case 'agregat':
                $column_format = [
                    'A' => NumberFormat::FORMAT_TEXT,
                    'E' => NumberFormat::FORMAT_NUMBER
                ];
                break;
        }

        return $column_format;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                $styleArray = array(
                    'font' => array(
                        'bold' => true
                    ),
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ),
                );

                switch ($this->jenis_data) {
                    case 'raw':
                        $cellRange = 'A1:G1'; // All headers
                        break;

                    case 'agregat':
                        $cellRange = 'A1:E1'; // All headers
                        break;
                }

                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
            },
        ];
    }
}
