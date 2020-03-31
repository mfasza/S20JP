<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eselon3 extends Model
{
    /**
     * Make model handle eselon3 table not eselon3s
     * 
     * @var string
     */
    protected $table = 'eselon3';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_eselon3', 'unit_eselon3', 'kode_eselon2'
    ];

    /**
     * override default primary key to kode_eselon3 column
     * 
     * @var string
     */
    protected $primaryKey = 'kode_eselon3';

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
     * One to many eloquent with pegawai table
     * 
     * @return App\Pegawai
     */
    public function pegawai()
    {
        return $this->hasMany('App\Pegawai', 'kode_eselon3', 'kode_eselon3');
    }
}
