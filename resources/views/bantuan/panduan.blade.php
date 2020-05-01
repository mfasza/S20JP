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
                    </dl>
                </nav>
            </div>
            <div class="col-lg-9 bg-light shadow-sm">
                <div class="card-body">
                    <h3 class="text-primary" id="pendahuluan"># Pendahuluan</h3>
                    <hr>
                    <p>
                        Sistem 20JP merupakan suatu sistem yang ada pada Pusat Pendidikan dan Pelatihan BPS untuk menangkap atau
                        mengumpulkan seluruh informasi kegiatan pengembangan kompetensi yang dilakukan oleh pegawai Badan Pusat
                        Statistik Republik Indonesia pada level eselon 2 dan eselon 3.
                    </p>
                    <br>
                    <h3 class="text-primary" id="upload_pegawai"># Upload Data Pegawai</h3>
                    <hr>
                    <p>
                        Upload data pegawai digunakan untuk mengunggah data pegawai pada masing-masing unit kerja kedalam sistem. Fitur ini berada pada
                        halaman Data Pegawai yang dapat diakses dengan menekan tab <button disabled="disabled" class="btn btn-sm btn-dark">Pegawai</button>
                        pada menu navigasi di bagian atas website.
                    </p>
                    <p>
                        Pada halaman Data Pegawai ditampilkan tabel daftar pegawai dari Unit Kerja Anda dan daftar pegawai Unit Kerja yang berada dibawah Unit Kerja Anda.
                    </p>
                    <br>
                    <p>
                        <span class="alert alert-warning">
                            <em><strong>Pastikan semua pegawai pada unit kerja Anda sudah terdaftar pada sistem.</strong></em>
                        </span>
                    </p>
                    <br>
                    <p>
                        Terdapat dua cara mengunggah data pegawai kedalam sistem. Tata caranya akan dijelaskan pada bagian berikut.
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
                                # Note: Daftar kode unit kerja dapat dilihat pada menu tab Bantuan >
                                <a href="{{url('\bantuan\kodeUnitKerja')}}">Daftar Kode Unit Kerja</a>
                            </em>
                        </span>
                    </p>
                    <br>
                    <p>
                        Setelah seluruh data yang dimasukkan sudah dirasa benar, tekan tombol <button class="btn btn-small btn-success" disabled>Register</button>
                        untuk menyimpan data kedalam sistem.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
