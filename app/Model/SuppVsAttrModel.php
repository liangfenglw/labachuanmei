<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class SuppVsAttrModel extends Model
{
    protected $table = 'supp_vs_attr';
    public $timestamps = true;

    public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function value()
    {
        return $this->hasOne('App\Model\PlateAttrValueModel','id','attr_value_id');
    }
}
