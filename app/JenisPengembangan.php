<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisPengembangan extends Model
{
    /**
     * Make model handle jenis_pengembangan table not jenis_pengembangans
     * 
     * @var string
     */
    protected $table = 'jenis_pengembangan';

    /**
     * override default primary key to id_kompetensi column
     * 
     * @var string
     */
    protected $primaryKey = 'kode_pengembangan';

    /**
     * setting tabel kompetensi tidak ada timestamps
     * (created_at & update_at)
     * 
     *  @var string
     */
    public $timestamps = false;

    /**
     * One to one eloquent with kompetensi table
     * 
     * @return App\Kompetensi
     */
    public function kompetensi()
    {
        return $this->hasMany('App\Kompetensi', 'kode_pengembangan', 'kode_pengembangan');
    }
}
