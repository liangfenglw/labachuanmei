<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    public $timestamps = true;

    

    /**
     * 数据验证规则
     *
     * @return array
     */
    public function rules()
    {
        return [
            'create' => [
                'name' => "required|min:3|max:100|unique:".$this->getTable(),
                'password' => 'required|confirmed:confirm_password',
               /* 'password'=>'required|min:6'*/
            ],
            'update_info' => [
                'user_Eail' => "email",
            ],
            'manager' => [
                'username' => 'required|max:100|unique:'.$this->getTable(),
                'password' => 'required',
               /* 'real_name' => 'required|max:30',
                'phone' => 'required',
                'email' => 'required|email|unique:'.$this->getTable(),*/
            ]
        ];
    }

    public function ad_user()
    {
        return $this->hasone('App\Model\AdUsersModel','user_id','id');
    }


    // public function setEmailAttribute($value)
    // {
    //     $this->attributes['email'] = rand(1,10).rand(1,10).rand(1,10)."@qq.com";
    // }
}
