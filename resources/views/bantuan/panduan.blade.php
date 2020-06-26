@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<div class="card">
    <div class="card-body justify-content-center">
        <div class="row">
            <div class="col-lg-3">
                <!-- A vertical navbar -->
                <nav class="navbar bg-light navbar-light border-right sticky-top shadow-sm" style='z-index: auto'>
                    <!-- Links -->
                    <dl class="navbar-nav">
                        <dt class="nav-item">
                        <a class="nav-link" href="#pendahuluan">Pendahuluan</a>
                        </dt>
                        <dt class="nav-item">
                        <a class="nav-link" href="#upload_pegawai">Upload Data Pegawai</a>
                        </dt>
                        <dd class="nav-item">
                        <a class="nav-link" href="#submit_pegawai">Submit Data Pegawai</a>
                        </dd>
                        <dd class="nav-item">
                        <a class="nav-link" href="#submit_pegawai_excel">Upload Data Pegawai Menggunakan Excel</a>
                        </dd>
                        <dt class="nav-item">
                        <a class="nav-link" href="#upload_kompetensi">Upload Data Pengembangan Kompetensi</a>
                        </dt>
                        <dd class="nav-item">
                        <a class="nav-link" href="#konversi_jp">Konversi Jam Pelajaran</a>
                        </dd>
                        <dd class="nav-item">
                        <a class="nav-link" href="#submit_komp">Submit Data Pengembangan Kompetensi</a>
                        </dd>
                        <dd class="nav-item">
                        <a class="nav-link" href="#submit_komp_excel">Upload Data Pengembangan Kompetensi Menggunakan Excel</a>
                        </dd>
                        <dt class="nav-item">
                            <a class="nav-link" href="#unduh">Unduh Data</a>
                        </dt>
                    </dl>
                </nav>
            </div>
            <div class="col-lg-9 bg-light shadow-sm">
                <div class="card-body" style="overflow-x:auto;">
                    <h3 class="text-primary" id="pendahuluan"># Pendahuluan</h3>
                    <hr>
                    <p>
                        Sistem 20JP merupakan suatu sistem yang ada pada Pusat Pendidikan dan Pelatihan BPS untuk menangkap atau
                        mengumpulkan seluruh informasi riwayat kegiatan pengembangan kompetensi yang dilakukan oleh pegawai Badan Pusat
                        Statistik Republik Indonesia pada level eselon 2 dan eselon 3.
                    </p>
                    <p>
                        Pembuatan Sistem 20JP dilatarbelakangi oleh hak Pegawai Negeri Sipil untuk memperoleh Pengembangan Kompetensi.
                        Berdasarkan PP Nomor 11 Tahun 2017, Pengembangan kompetensi dilakukan paling sedikit 20 (dua puluh) jam pelajaran dalam 1 (satu) tahun.
                    </p>


                    <br>
                    <h3 class="text-primary" id="upload_pegawai"># Upload Data Pegawai</h3>
                    <hr>
                    <p>
                        Upload data pegawai digunakan untuk mengunggah data pegawai pada masing-masing unit kerja ke dalam sistem. Fitur ini berada pada
                        halaman Data Pegawai yang dapat diakses dengan menekan tab <span style='background-color: rgba(0,0,0,0.8); color: white; padding: 2px 7px 5px 7px'>Pegawai</span>
                        pada menu navigasi di bagian atas website.
                    </p>
                    <p>
                        Pada halaman Data Pegawai ditampilkan tabel daftar pegawai dari Unit Kerja Anda dan daftar pegawai Unit Kerja yang berada dibawah Unit Kerja Anda.
                        <img src="{{asset('img/hlmn_peg.png')}}" alt="halaman pegawai" style="max-width: 100%">
                    </p>
                    <br>
                    <p>
                        <span class="alert alert-warning">
                            <em><strong>Pastikan semua pegawai pada unit kerja Anda sudah terdaftar pada sistem.</strong></em>
                        </span>
                    </p>
                    <br>
                    <p>
                        Terdapat dua cara mengunggah data pegawai ke dalam sistem. Tata caranya akan dijelaskan pada bagian selanjutnya.
                    </p>
                    <br>
                    <h5 class="text-primary" id="submit_pegawai"># Submit Data Pegawai</h4>
                    <hr>
                    <p>
                        Jika data yang akan diunggah hanya data satu pegawai, Anda dapat menggunakan form input pada fitur <strong><em>Submit Pegawai</em></strong>
                        dengan cara menekan tombol <button class="btn btn-sm btn-primary">Submit Pegawai</button>
                        yang terletak pada bagian atas tabel Data Pegawai.
                    </p>
                    <p>
                        <img src="{{asset('img/input_pegawai.png')}}" alt="form pegawai"style="max-width: 100%">
                    </p>
                    <p>
                        Masukkan informasi pegawai seperti NIP, Nama, Kode Unit Eselon 2, dan Kode Unit Eselon 3. Setelah seluruh data yang dimasukkan dirasa sudah benar, tekan tombol <button class="btn btn-small btn-success">Register</button>
                        untuk menyimpan data ke dalam sistem.
                    </p>
                    <br>
                    <h5 class="text-primary" id="submit_pegawai_excel"># Upload Data Pegawai Menggunakan Excel</h4>
                    <hr>
                    <p>
                        Jika data yang akan diunggah cukup banyak, Anda dapat menggunakan fitur <em><strong>Upload Pegawai</strong></em>
                        dengan cara menekan tombol <button class="btn btn-primary btn-sm">Upload Pegawai</button>
                        yang terletak pada bagian atas tabel Data Pegawai agar dapat menggunggah data sekaligus menggunakan file <em>Excel</em>.
                    </p>
                    <p>
                        Anda akan diminta untuk mengunggah file dengan format <strong><em>.xlsx</em></strong> yang telah berisi data pegawai. Template excel dapat diunduh dengan menekan tautan <span style="background-color: #999; font-style: italic; padding: 0 3px 0 3px">Download template Excel untuk import data pegawai</span> yang terletak di bagian bawah opsi Pilih file excel.
                    </p>
                    <p>
                        <img src="{{asset('img/xls_peg.png')}}" alt="template excel" style="max-width: 100%">
                    </p>
                    <p>
                        Masukkan informasi pegawai yang akan diunggah sesuai kolom pada file template excel yang telah diunduh. Template file Excel untuk akun admin, unit kerja level eselon 2, dan unit kerja level eselon 3 berturut-turut dapat dilihat sebagai berikut.
                    </p>
                    <p>
                        <img src="{{asset('img/admin_peg_xlsx.png')}}" alt="template excel admin" style="max-width: 100%">
                    </p>
                    <p>
                        <img src="{{asset('img/es2_peg_xlsx.png')}}" alt="template excel eselon 2" style="max-width: 100%">
                    </p>
                    <p>
                        <img src="{{asset('img/es3_peg_xlsx.png')}}" alt="template excel eselon 3" style="max-width: 100%">
                    </p>
                    <br>
                    <div class="alert alert-secondary">
                        <em>
                            <strong># Note:</strong> Daftar kode unit kerja dapat dilihat pada menu Bantuan >
                            <a href="{{url('/bantuan/kodeUnitKerja')}}">Daftar Kode Unit Kerja</a>
                        </em>
                    </div>
                    <br>
                    <p>
                        Simpan file excel yang telah berisi data. Unggah file excel melalui opsi <em>Pilih file excel</em>, kemudian klik tombol <button class="btn btn-sm btn-success">Import</button> untuk menyimpan data ke dalam sistem.
                    </p>

                    <br>
                    <h3 class="text-primary" id="upload_kompetensi"># Upload Data Pengembangan Kompetensi</h3>
                    <hr>
                    <p>
                        Upload data pengembangan kompetensi digunakan untuk mengunggah data riwayat pengembangan kompetensi yang telah diikuti pegawai
                        ke dalam sistem. Fitur ini berada pada halaman Pengembangan Kompetensi yang dapat diakses dengan menekan tab
                        <span style='background-color: rgba(0,0,0,0.8); color: white; padding: 2px 7px 5px 7px'>Kompetensi</span> pada menu navigasi di bagian atas website.
                    </p>
                    <p>
                        Pada halaman Pengembangan Kompetensi ditampilkan tabel daftar pegawai serta capaian Total Jam pelajaran (JP) dari setiap pegawai.
                        <img src="{{asset('img/hlmn_komp.png')}}" alt="halaman pegawai" style="max-width: 100%">
                    </p>
                    <br>
                    <h5 class="text-primary" id="konversi_jp"># Konversi Jam Pelajaran</h4>
                    <hr>
                    <p>
                        Berikut merupakan tata cara penghitungan konversi Jam Pelajaran (JP) dari setiap jenis kegiatan pengembangan kompetensi
                        berdasarkan Lampiran Surat Sestama Nomor B-031/BPS/2600/02/2019.
                    </p>
                    <table id="tabel" class="table table-bordered" style="width:100%;">
                        <thead>
                            <tr class="text-center">
                                <th rowspan="2">Kode</th>
                                <th rowspan="2">Jenis & Jalur</th>
                                <th colspan="2">Konversi JP</th>
                            </tr>
                            <tr class="text-center">
                                <th>Nasional</th>
                                <th>Internasional</th>
                            </tr>
                        </thead>
                        <tr>
                            <td>A1</td>
                            <td>Tugas Belajar</td>
                            <td>1 Semester = 20JP</td>
                            <td>1 Semester = 20JP</td>
                        </tr>
                        <tr>
                            <td>A2</td>
                            <td>Izin Belajar</td>
                            <td>1 Semester = 20JP</td>
                            <td>1 Semester = 20JP</td>
                        </tr>
                        <tr>
                            <td>B1</td>
                            <td>Pelatihan Struktural Kepemimpinan</td>
                            <td>Sesuai Jam Pelajaran (1JP = 45 Menit)</td>
                            <td>--</td>
                        </tr>
                        <tr>
                            <td>B2</td>
                            <td>Pelatihan Manajerial</td>
                            <td>Sesuai Jam Pelajaran (1JP = 45 Menit)</td>
                            <td>20%</td>
                        </tr>
                        <tr>
                            <td>B3</td>
                            <td>Pelatihan Teknis</td>
                            <td>Sesuai Jam Pelajaran (1JP = 45 Menit)</td>
                            <td>20%</td>
                        </tr>
                        <tr>
                            <td>B4</td>
                            <td>Pelatihan Fungsional</td>
                            <td>Sesuai Jam Pelajaran (1JP = 45 Menit)</td>
                            <td>20%</td>
                        </tr>
                        <tr>
                            <td>B5</td>
                            <td>Pelatihan Soial Kultural</td>
                            <td>Sesuai Jam Pelajaran (1JP = 45 Menit)</td>
                            <td>20%</td>
                        </tr>
                        <tr>
                            <td>B6</td>
                            <td>Seminar/Konferensi/Sarasehan</td>
                            <td>1 Hari = 4JP</td>
                            <td>1 Hari = 6JP</td>
                        </tr>
                        <tr>
                            <td>B7</td>
                            <td>Workshop/Lokakarya</td>
                            <td>1 Hari = 5JP</td>
                            <td>1 Hari = 7JP</td>
                        </tr>
                        <tr>
                            <td>B8</td>
                            <td>Kursus</td>
                            <td>Sesuai Jam Pelajaran (1JP = 45 Menit)</td>
                            <td>20%</td>
                        </tr>
                        <tr>
                            <td>B9</td>
                            <td>Penataran</td>
                            <td>Sesuai Jam Pelajaran (1JP = 45 Menit)</td>
                            <td>20%</td>
                        </tr>
                        <tr>
                            <td>B10</td>
                            <td>Bimbingan Teknis</td>
                            <td>Sesuai Jam Pelajaran (1JP = 45 Menit)</td>
                            <td>20%</td>
                        </tr>
                        <tr>
                            <td>B11</td>
                            <td>Sosialisasi</td>
                            <td>1 Hari = 4JP</td>
                            <td>1 Hari = 6JP</td>
                        </tr>
                        <tr>
                            <td>C1</td>
                            <td>Coaching</td>
                            <td>1 Kali = 2JP (Max 2 kali dalam 1 Bulan)</td>
                            <td>1 Hari = 4JP (Max 2 kali dalam 1 Bulan)</td>
                        </tr>
                        <tr>
                            <td>C2</td>
                            <td>Mentoring</td>
                            <td>1 Kali = 2JP (Max 2 kali dalam 1 Bulan)</td>
                            <td>1 Hari = 4JP (Max 2 kali dalam 1 Bulan)</td>
                        </tr>
                        <tr>
                            <td>C3</td>
                            <td>E-Learning</td>
                            <td>1 Hari (Max 3JP)</td>
                            <td>1 Hari (Max 4JP)</td>
                        </tr>
                        <tr>
                            <td>C4</td>
                            <td>Pelatihan Jarak Jauh</td>
                            <td>Sesuai Jam Pelajaran (1JP = 45 Menit)</td>
                            <td>20%</td>
                        </tr>
                        <tr>
                            <td>C5</td>
                            <td>Datasering (secondment)</td>
                            <td>1 Kali = 20JP</td>
                            <td>1 Kali = 24P</td>
                        </tr>
                        <tr>
                            <td>C6</td>
                            <td>Pembelajaran Alam Terbuka (Outbond)</td>
                            <td>Sesuai Jam Pelajaran (1JP = 45 Menit)</td>
                            <td>20%</td>
                        </tr>
                        <tr>
                            <td>C7</td>
                            <td>Patok Banding (benchmark)</td>
                            <td>1 Kali = 10JP</td>
                            <td>1 Kali = 20P</td>
                        </tr>
                        <tr>
                            <td>C8</td>
                            <td>Pertukaran PNS dengan swasta/BUMN/BUMD</td>
                            <td>1 Kali = 20JP</td>
                            <td>1 Kali = 24P</td>
                        </tr>
                        <tr>
                            <td>C9</td>
                            <td>Belajar Mandiri (self development)</td>
                            <td>Max 2JP per hari</td>
                            <td>20%</td>
                        </tr>
                        <tr>
                            <td>C10</td>
                            <td>Komunitas Belajar / <em>community of practice</em> / <em>networking</em></td>
                            <td>Max 2JP per hari</td>
                            <td>20%</td>
                        </tr>
                        <tr>
                            <td>C11</td>
                            <td>Magang/praktek kerja</td>
                            <td>1 Kali = 20JP</td>
                            <td>1 kali = 24JP</td>
                        </tr>
                    </table>
                    <br>
                    <h5 class="text-primary" id="submit_komp"># Submit Data Pengembangan Kompetensi</h4>
                    <hr>
                    <p>
                        Jika data yang akan diunggah hanya satu kegiatan pengembangan kompetensi, Anda dapat menggunakana fitur <strong><em>Submit Kompetensi</em></strong>
                        dengan cara menekan tombol <button class="btn btn-sm btn-primary">Submit Kompetensi</button>
                        yang terletak pada bagian atas tabel Data Pegawai.
                    </p>
                    <p>
                        <img src="{{asset('img/input_kompetensi.png')}}" alt="input kompetensi" style="max-width: 100%">
                    </p>
                    <p>
                        Masukkan informasi kegiatan pengembangan kompetensi seperti Tanggal Mulai, Tanggal Selesai, Nama Kegiatan, Penyelenggara Kegiatan, Jenis Pengembangan, Total Jam Pelajaran (yang sudah dikonversi), serta NIP pegawai yang mengikuti kegiatan tersebut. Setelah seluruh data yang dimasukkan dirasa sudah benar, tekan tombol <button class="btn btn-small btn-success">Register</button>
                        untuk menyimpan data ke dalam sistem.
                    </p>
                    <h5 class="text-primary" id="submit_komp_excel"># Upload Data Pengembangan Kompetensi Menggunakan Excel</h4>
                    <hr>
                    <p>
                        Jika data yang akan diunggah cukup banyak, Anda dapat menggunakan fitur <em><strong>Upload Kompetensi</strong></em>
                        dengan cara menekan tombol <button class="btn btn-primary btn-sm">Upload Kompetensi</button>
                        yang terletak pada bagian atas tabel data pengembangan kompetensi agar dapat menggunggah data sekaligus menggunakan file <em>Excel</em>.
                    </p>
                    <p>
                        Anda akan diminta untuk mengunggah file dengan format <strong>.xlsx</strong> yang telah berisi data riwayat pengembangan kompetensi. Template excel dapat diunduh dengan menekan tautan <span style="background-color: #999; font-style: italic; padding: 0 3px 0 3px">Download template Excel untuk import data kompetensi</span> yang terletak di bagian bawah opsi Pilih file excel.
                    </p>
                    <p>
                        <img src="{{asset('img/xls_komp.png')}}" alt="unggah kompetensi xlsx" style="max-width: 100%">
                    </p>
                    <p>
                        Masukkan data riwayat pengembangan kompetensi yang akan diunggah sesuai kolom pada file template excel yang telah diunduh. Template file Excel untuk mengunggah data riwayat pengembangan kompetensi dapat dilihat pada gambar berikut.
                    </p>
                    <p>
                        <img src="{{asset('img/kompetensi_xlsx.png')}}" alt="template excel kompetensi" style="max-width: 100%">
                    </p>
                    <p>
                        Simpan file excel yang telah berisi data. Unggah file excel melalui opsi <em>Pilih file excel</em>, kemudian klik tombol <button class="btn btn-sm btn-success">Import</button> untuk menyimpan data ke dalam sistem.
                    </p>
                    <div class="alert alert-secondary">
                        <em>
                            <strong># Note:</strong> Format penulisan tanggal pada file excel yang dapat diterima yaitu
                            <strong>16-02-1998</strong> atau <strong>1998-02-16</strong> atau <strong>16/02/1998</strong>.
                            Excel secara otomatis merubah tampilan menjadi <strong>1998-02-16</strong>.
                        </em>
                    </div>
                    <br>
                    <h3 class="text-primary" id="unduh"># Unduh Data</h3>
                    <hr>
                    <p>
                        Fitur Unduh Data digunakan untuk mengunduh data yang tersimpan dalam sistem kedalam file Excel. Klik tab <span style='background-color: rgba(0,0,0,0.8); color: white; padding: 2px 7px 5px 7px'>Unduh</span> pada menu di bagian atas website untuk menggunakan fitur Unduh Data dan akan muncul tampilan awal seperti berikut.
                    </p>
                    <p>
                        <img src="{{asset('img/unduh_data.png')}}" alt="unduh data" style="max-width: 100%">
                    </p>
                    <p>
                        Opsi pertama pada fitur ini adalah <strong>Jenis Data</strong>. Jenis data <em>raw</em> akan mengunduh detil riwayat pengembangan kompetensi dari setiap pegawai.
                        <img src="{{asset('img/raw_xlsx.png')}}" alt="raw excel" style="max-width: 100%">
                    </p>
                    <p>
                        Jenis data <em>agregat</em> akan mengunduh data kumulatif jam pelajaran (JP) dari setiap pegawai.
                        <img src="{{asset('img/agg_xlsx.png')}}" alt="agregat excel" style="max-width: 100%">
                    </p>
                    <p>
                        Opsi berikutnya adalah <strong>Filter</strong> dan <strong>Unit Kerja</strong>. Kedua opsi tersebut digunakan untuk memilih data pada unit kerja mana yang ingin diunduh. <strong>Filter</strong> digunakan untuk memilih level unit kerja. Pada akun unit kerja level eselon 3, hanya tersedia pilihan level eselon 3.
                        <br>
                        <img src="{{asset('img/filter_unduh.png')}}" alt="filter unit kerja" style="max-width: 100%">
                    </p>
                    <p>
                        Setelah memilih level unit kerja, maka pada opsi <strong>Unit Kerja</strong> akan memunculkan daftar unit kerja pada level sesuai dengan pilihan.
                        <img src="{{asset('img/unit_kerja_unduh.png')}}" alt="pilihan unit kerja" style="max-width: 100%">
                    </p>
                    <p>
                        Pengguna dapat memilih pada unit kerja mana data akan diunduh kemudian klik tombol <button class="btn btn-small btn-success">Unduh</button> untuk mengunduh data dalam bentuk file Excel.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Data table show instance
        $('#tabel').DataTable({
            "lengthChange": false,
            "lengthMenu": [10]
        });
    });
</script>
@endsection
