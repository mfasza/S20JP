<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kompetensi extends Model
{
    /**
     * Make model handle kompetensi table not kompetensis
     *
     * @var string
     */
    protected $table = 'kompetensi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_kompetensi', 'tanggal_mulai', 'tanggal_selesai', 'nama_pengembangan',
        'penyelenggara', 'jp', 'kode_pengembangan', 'editor'
    ];

    /**
     * override default primary key to id_kompetensi column
     *
     * @var string
     */
    protected $primaryKey = 'id_kompetensi';

    /**
     * setting tabel kompetensi tidak ada timestamps
     * (created_at & update_at)
     *
     *  @var string
     */
    // public $timestamps = false;

    /**
     * One to many eloquent with kompetensi_pegawai table
     *
     * @return App\KompetensiPegawai
     */
    public function kompetensi_pegawai()
    {
        return $this->hasMany('App\KompetensiPegawai', 'id_kompetensi', 'id_kompetensi');
    }

    /**
     * One to one eloquent with jenis_pengembangan table
     *
     * @return App\KompetensiPegawai
     */
    public function jenis_pengembangan()
    {
        return $this->belongsTo('App\JenisPegembangan', 'kode_pengembangan', 'kode_pengembangan');
    }
}
