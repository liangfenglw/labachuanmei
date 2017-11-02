<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PlateAttrModel extends Model
{
    protected $table = 'plate_attr';
    public $timestamps = true;

    public function attrVsVal()
    {
        return $this->hasMany('App\Model\PlateAttrValueModel','attr_id','id');
    }

}
