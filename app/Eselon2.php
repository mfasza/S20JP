<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eselon2 extends Model
{
    /**
     * Make model handle eselon2 table not eselon2s
     * 
     * @var string
     */
    protected $table = 'eselon2';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_eselon2', 'unit_eselon2'
    ];

    /**
     * override default primary key to eselon2_id column
     * 
     * @var string
     */
    protected $primaryKey = 'kode_eselon2';

    /**
     * One to many eloquent with eselon3 table
     * 
     * @return App\Eselon3
     */
    public function eselon3()
    {
        return $this->hasMany('App\Eselon3', 'kode_eselon2', 'kode_eselon2');
    }

    /**
     * One to many eloquent with pegawai table
     * @return App\Pegawai
     */
    public function pegawai()
    {
        return $this->hasMany('App\Pegawai', 'kode_eselon2', 'kode_eselon2');
    }
}
