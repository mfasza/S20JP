<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'satker', 'password', 'role'
    ];

    /**
     * change laravel default primary key to username column
     * @var string
     */
    
    public $primaryKey = 'username';

    /**
     * setting tabel users tidak ada timestamps
     * (created_at & update_at)
     * 
     *  @var string
     */
    public $timestamps = false;

    /**
     * override laravel default setting of incrementing primarykey
     * because user primary key is username
     * 
     * @var string
     */
    public $incrementing = false;

     /**
     * Overrides the method to ignore the remember token.
     */
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute)
        {
        parent::setAttribute($key, $value);
        }
    }
}
