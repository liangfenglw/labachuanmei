<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ArticleModel extends Model
{
    protected $table = 'article';
    public $timestamps = true;

    public function category()
    {
        return $this->belongsTo('App\Model\CategoryModel','category_id','id');
    }
}
