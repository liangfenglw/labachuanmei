<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PlateAttrValueModel extends Model
{
    protected $table = 'plate_attr_value';
    public $timestamps = true;

    public function childPlate()
    {
        // return $this->hasMany('App\Model\PlateAttrModel','pid','id');
    }

}
