<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompositePrimaryKey;

class KompetensiPegawai extends Model
{
    use HasCompositePrimaryKey;
    /**
     * Make model handle kompetensi_pegawai table not kompetensi_pegawais
     * 
     * @var string
     */
    protected $table = 'kompetensi_pegawai';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_kompetensi', 'nip'
    ];

    /**
     * override default primary key to id_kompetensi column
     * 
     * @var string
     */
    protected $primaryKey = ['nip', 'id_kompetensi'];

    /**
     * Menghilangkan default setting for incrementing primary key
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * setting tabel kompetensi tidak ada timestamps
     * (created_at & update_at)
     * 
     *  @var string
     */
    public $timestamps = false;

    /**
     * One to many eloquent with kompetensi table
     * 
     * @return App\Kompetensi
     */
    public function kompetensi()
    {
        return $this->belongsTo('App\Kompetensi', 'id_kompetensi', 'id_kompetensi');
    }

    /**
     * One to many eloquent with pegawai table
     * 
     * @return App\Pegawai
     */
    public function pegawai()
    {
        return $this->belongsTo('App\Pegawai', 'nip', 'nip');
    }
}
