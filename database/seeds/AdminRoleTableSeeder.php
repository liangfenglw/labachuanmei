<?php

use Illuminate\Database\Seeder;

class AdminRoleTableSeeder extends Seeder
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
            ['id' => 1,'level_name' => '超级管理员', 'remark' => '最高权限'],
            ['id' => 2,'level_name' => '普通管理员', 'remark' => '普通管理员'],
        ];
        DB::table('admin_role')->insert($data);
    }
}
