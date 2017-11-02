<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InvoModel extends Model
{
    protected $table = 'invo';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    // public function 

    

    
}
