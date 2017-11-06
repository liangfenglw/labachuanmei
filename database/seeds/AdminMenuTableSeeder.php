<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
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
            ['id' => 1, 'pid' => '0', 'level_id' => 1, 'type' => '1', 'menu' => '开发者管理', 'route' => ''],
            ['id' => 2, 'pid' => '1', 'level_id' => 2, 'type' => '2', 'menu' => '菜单列表', 'route' => '/manager/menuList'],
            ['id' => 3, 'pid' => '1', 'level_id' => 2, 'type' => '2', 'menu' => '添加菜单', 'route' => '/manager/addMenu'],
        ];
        DB::table('admin_menu')->insert($data);
    }
}
