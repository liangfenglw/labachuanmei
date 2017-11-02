<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdUsersModel extends Model
{
    protected $table = 'ad_users';
    public $timestamps = true;

    public function level()
    {
        return $this->hasOne('App\Model\UserLevelModel','id','level_id');
    }

    public function parentUser()
    {
        return $this->hasOne('App\Model\AdUsersModel','user_id','belong');
    }

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }
    

}
