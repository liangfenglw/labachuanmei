<?php

namespace App;

use Illuminate\Notifications\Notifiable;
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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function adminRole()
    {
        return $this->hasOne('App\Model\AdminRoleModel','id','role_id');
    }

    public function supp_user()
    {
        return $this->belongsTo('App\Model\SuppUsersModel','id','user_id');
    }

    public function suppUserSelf()
    {
        return $this->belongsTo('App\Model\SuppUsersSelfModel','id','user_id');
    }

    public function attrValue()
    {
        return $this->hasMany('App\Model\SuppVsAttrModel','user_id','id');
    }

    public function user_mes()
    {
        $info = $this->belongsTo('App\Model\AdUsersModel','id','user_id');
        if(is_null($info)) {
            $info = $this->belongsTo('App\Model\SuppUsersModel','id','user_id');
        }
        return $info ? $info : '';
    }


}
