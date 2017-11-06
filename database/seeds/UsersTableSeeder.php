<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //默认填充数据
        $data = [
            ['name' => '黑蜂程序猿', 'role_id' => 1, 'password' => bcrypt('blackbee')],
            ['name' => '黑蜂设计师', 'role_id' => 2, 'password' => bcrypt('blackbee')],
            ['name' => '黑蜂测试员', 'role_id' => 1, 'password' => bcrypt('blackbee')],
            ['name' => '黑蜂高级管理','role_id' => 1,'password' => bcrypt('blackbee')],
            ['name' => 'blackbee',  'role_id' => 1, 'password' => bcrypt('blackbee')],
            ['name' => 'testHack',  'role_id' => 1, 'password' => bcrypt('test123456')],
        ];
        DB::table('users')->insert($data);
    }
}
