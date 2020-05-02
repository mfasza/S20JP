@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body justify-content-center">
        <div class="row">
            <div class="col-lg-3">
                <!-- A vertical navbar -->
                <nav class="navbar justify-content-center align-content-start bg-light navbar-light border-right sticky-top shadow-sm">
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
                        <a class="nav-link" href="#submit_pegawai_excel">Submit Data Pegawai Menggunakan Excel</a>
                        </dd>
                        <dt class="nav-item">
                        <a class="nav-link" href="#upload_kompetensi">Upload Data Pengembangan Kompetensi</a>
                        </dt>
                        <dd class="nav-item">
                        <a class="nav-link" href="#konversi_jp">Konversi Jam Pelajaran</a>
                        </dd>
                    </dl>
                </nav>
            </div>
            <div class="col-lg-9 bg-light shadow-sm">
                <div class="card-body">
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
                        halaman Data Pegawai yang dapat diakses dengan menekan tab <button disabled="disabled" class="btn btn-sm btn-dark">Pegawai</button>
                        pada menu navigasi di bagian atas website.
                    </p>
                    <p>
                        Pada halaman Data Pegawai ditampilkan tabel daftar pegawai dari Unit Kerja Anda dan daftar pegawai Unit Kerja yang berada dibawah Unit Kerja Anda.
                        <img src="{{asset('\img\hlmn_peg.png')}}" alt="halaman pegawai" style="max-width: 100%">
                    </p>
                    <br>
                    <p>
                        <span class="alert alert-warning">
                            <em><strong>Pastikan semua pegawai pada unit kerja Anda sudah terdaftar pada sistem.</strong></em>
                        </span>
                    </p>
                    <br>
                    <p>
                        Terdapat dua cara mengunggah data pegawai ke dalam sistem. Tata caranya akan dijelaskan pada bagian berikut.
                    </p>
                    <br>
                    <h5 class="text-primary" id="submit_pegawai"># Submit Data Pegawai</h4>
                    <hr>
                    <p>
                        Jika data yang akan diunggah hanya data satu pegawai, Anda dapat menggunakana fitur <strong><em>Submit Pegawai</em></strong>
                        dengan cara menekan tombol <button disabled="disabled" class="btn btn-sm btn-primary">Submit Pegawai</button>
                        yang terletak pada bagian atas tabel Data Pegawai.
                    </p>
                    <br>
                    <p>
                        <span class="alert alert-secondary">
                            <em>
                                <strong># Note:</strong> Daftar kode unit kerja dapat dilihat pada menu tab Bantuan >
                                <a href="{{url('\bantuan\kodeUnitKerja')}}">Daftar Kode Unit Kerja</a>
                            </em>
                        </span>
                    </p>
                    <br>
                    <p>
                        Setelah seluruh data yang dimasukkan dirasa sudah benar, tekan tombol <button class="btn btn-small btn-success" disabled>Register</button>
                        untuk menyimpan data ke dalam sistem.
                    </p>
                    <br>
                    <h5 class="text-primary" id="submit_pegawai_excel"># Submit Data Pegawai Menggunakan Excel</h4>
                    <hr>
                    <p>
                        Jika data yang akan diunggah cukup banyak, Anda dapat menggunakan fitur <em><strong>Upload Pegawai</strong></em>
                        dengan cara menekan tombol <button disabled="disabled" class="btn btn-primary btn-sm">Upload Pegawai</button>
                        yang terletak pada bagian atas tabel Data Pegawai agar dapat menggunggah data sekaligus.
                    </p>
                    <p>
                        Anda akan diminta untuk mengunggah file dengan format <strong>.xls</strong> yang telah berisi data pegawai.
                        Template excel dapat diunduh dengan menekan tautan yang terletak di bagian bawah opsi Pilih file excel.
                        <img src="{{asset('img\xls_peg.png')}}" alt="template excel" style="max-width: 100%">
                    </p>
                    <p>
                        Isi data pegawai yang akan diunggah pada file template excel yang telah diunduh. Simpan file excel yang telah berisi data.
                        pilih file melalui opsi <em>Pilih file excel</em>, kemudian tekan tombol <button disabled="disabled" class="btn btn-sm btn-success">Import</button>
                        untuk menyimpan data ke dalam sistem.
                    </p>

                    <br>
                    <h3 class="text-primary" id="upload_kompetensi"># Upload Data Pengembangan Kompetensi</h3>
                    <hr>
                    <p>
                        Upload data pengembangan kompetensi digunakan untuk mengunggah data riwayat pengembangan kompetensi yang telah diikuti pegawai
                        ke dalam sistem. Fitur ini berada pada halaman Pengembangan Kompetensi yang dapat diakses dengan menekan tab
                        <button disabled="disabled" class="btn btn-sm btn-dark">Kompetensi</button> pada menu navigasi di bagian atas website.
                    </p>
                    <p>
                        Pada halaman Pengembangan Kompetensi ditampilkan tabel daftar pegawai serta capaian Total Jam pelajaran (JP) dari setiap pegawai.
                        <img src="{{asset('\img\hlmn_komp.png')}}" alt="halaman pegawai" style="max-width: 100%">
                    </p>
                    <br>
                    <h5 class="text-primary" id="konversi_jp"># Konversi Jam Pelajaran</h4>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
