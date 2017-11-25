<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class SuppUsersModel extends Model
{
    protected $table = 'supp_users';
    public $timestamps = true;

    public function attr_value_id()
    {
        return $this->hasMany('App\Model\SuppVsAttrModel','user_id','user_id');
    }

    public function attrValue()
    {
        return $this->hasMany('App\Model\SuppVsAttrModel','user_id','id');
    }

    public function value()
    {
        return $this->hasOne('App\Model\PlateAttrValueModel','id','attr_value_id');
    }

    public function plate()
    {
        return $this->hasOne('App\Model\PlateModel','id','plate_tid');
    }

    public function childPlate()
    {
        return $this->hasOne('App\Model\PlateModel','id','plate_id');
    }

    public function childUser()
    {
        return $this->hasMany('App\Model\SuppUsersModel','belong','user_id');
    }

    public function parentUser()
    {
        return $this->belongsTo('App\Model\SuppUsersModel','parent_id','user_id');
    }

    public function orderNetwork()
    {
        return $this->hasMany('App\Model\OrderNetworkModel','supp_user_id','parent_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\UsersModel','user_id','id');
    }

}
