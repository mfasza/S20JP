<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    /**
     * Make model handle eselon2 table not eselon2s
     * 
     * @var string
     */
    protected $table = 'pegawai';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'nip', 'kode_eselon2', 'kode_eselon3'
    ];

    /**
     * override default primary key to nip column
     * 
     * @var string
     */
    protected $primaryKey = 'nip';

    /**
     * setting tabel pegawai tidak ada timestamps
     * (created_at & update_at)
     * 
     *  @var string
     */
    public $timestamps = false;

    /**
     * One to many eloquent with eselon2 table
     * 
     * @return App\Eselon2
     */
    public function eselon2()
    {
        return $this->belongsTo('App\Eselon2', 'kode_eselon2', 'kode_eselon2');
    }

    /**
     * One to many eloquent with eselon3 table
     * 
     * @return App\Eselon3
     */
    public function eselon3()
    {
        return $this->belongsTo('App\Eselon3', 'kode_eselon3', 'kode_eselon3');
    }

    /**
     * One to many eloquent with kompetensi_pegawai table
     * 
     * @return App\KompetensiPegawai
     */
    public function kompetensi_pegawai()
    {
        return $this->hasMany('App\KompetensiPegawai', 'nip', 'nip');
    }
    
}
