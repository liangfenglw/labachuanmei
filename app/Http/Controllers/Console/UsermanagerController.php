<?php

namespace App\Http\Controllers\Console;

use Illuminate\Http\Request;
use App\Http\Controllers\Console\CommonController;
// use Request;
use App\Model\CustomerModel;
use App\Model\AdminMenuModel;
use App\Model\AdminRoleModel;
use App\Model\AdminVsRoleModel;
use App\Model\RoleVsMenuModel;
use App\Model\AdUsersModel;
use App\Model\UsersModel;
use App\Model\PlateModel;
use App\Model\SuppUsersModel;
use App\Model\SuppVsAttrModel;
use App\Model\SuppUsersSelfModel;
use App\Model\PlateAttrValueModel;
use App\Model\PlateAttrModel;
use App\User;
use App\Service\Excel\ExcelTools;
use Auth;
use Cache;
use DB;

class UsermanagerController extends CommonController
{
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    public function roleList()
    {
        $role = AdminRoleModel::with(['roleVsMenu'])->get()->toArray();
        return view('console.usermanager.role_list',[
                'role' => $role,
            ]);
    }

    /**
     * 创建角色
     */
    public function addRole()
    {
        $admin_role = new AdminRoleModel;
        $admin_role->level_name = $this->request->input('role_name');
        if ($admin_role->save()) {
            return ['status_code' => '200', 'msg' => '添加成功'];
        } else {
            return ['status_code' => '201', 'msg' => '添加失败'];
        }
    }

    /**
     * 编辑角色
     * @return [type] [description]
     */
    public function editRole($id)
    {
        //获取栏目
        $role_list = AdminMenuModel::with(['admin_menu','admin_menu.admin_menu'])
                    ->where('pid',0)
                    ->get()
                    ->toArray();
        //获取当前角色权限
        $role_lists = RoleVsMenuModel::where('role_id',$id)->select('menu_id')->get()->toArray();
        $role_mes = [];
        foreach($role_lists as $key => $value) {
            $role_mes[] = $value['menu_id'];
        }
        return view('console.usermanager.edit_role',[
                'role_mes'  => $role_mes,
                'role_list' => $role_list,
                'id'        => $id,
            ]);
    }

    /**
     * 更新角色
     * @return [type] [description]
     */
    public function updateRole()
    {
        //删除角色用户的权限
        RoleVsMenuModel::where('role_id',$this->request->input('role_id'))->delete();
        $role_id = $this->request->input('role_id');
        $time = date("Y-m-d H:i:s",time());
        $insert_data = [];
        foreach ($this->request->input('cate_id') as $key => $value) {
            $insert_data[] = ['menu_id' => $value, 'role_id' => $role_id, 'created_at' => $time];
        }
        $res = RoleVsMenuModel::insert($insert_data);
        if ($res) {
            return redirect('/usermanager/role')->with('status', '角色编辑保存成功');
        } else {
            return redirect('/usermanager/editRole/'.$role_id)->with('status', '操作错误');
        }
    }

    /**
     * 后台用户列表
     * @return [type] [description]
     */
    public function adminUserList()
    {
        //获取后台管理人员
        if ($this->request->input('keyword')) {
            $keyword = $this->request->input('keyword');
        }
        $user_list = User::with(['adminRole'=>function($query){
                            $query->select('id','level_name');
                        }])->where('is_show',1)->where('user_type',1);
        if (isset($keyword)) {
            $user_list = $user_list->where('name','like',"%$keyword%");
        }
        $user_list = $user_list->get()->toArray();

        if (\Request::ajax()) {
            $html = "";
            foreach ($user_list as $key => $value) {
                $html .= "<tr><td>".$value['id']."</td>";
                $html .= "<td>".$value['name']."</td>";
                $html .= "<td>".$value['admin_role']['level_name']."</td>";
                $html .= "<td><a class=\"color2\" href=\"/usermanager/adminuser/edit/".$value['id']."\">权限编辑</a></td><a class=\"color2\" href=\"/usermanager/adminuser/user/".$value['id']."\">信息编辑</a></td></tr>";
            }
            return $html;
        }
        return view('console.usermanager.admin_user_list',['user_list' => $user_list]);
    }

    /**
     * 编辑后台管理员用户
     * @return [type] [description]
     */
    public function editAdminUser($id)
    {
        //获取栏目
        $role_list = AdminMenuModel::with(['admin_menu','admin_menu.admin_menu'])
                    ->where('pid',0)
                    ->get()
                    ->toArray();
        $role_mes = [];
        $role_id = User::where('id',$id)->value('role_id');
        if ($role_id == 1) { //拥有全部权限
            $res = AdminMenuModel::select('id')->get()->toArray();
        } else {
            $res = AdminVsRoleModel::where('uid',$id)->select('menu_id as id')->get()->toArray();
        }
        foreach ($res as $key => $value) {
            $role_mes[] = $value['id'];
        }
        return view('console.usermanager.edit_admin_user_role',[
                'role_list' => $role_list,
                'id'        => $id,
                'role_mes'  => $role_mes
            ]);
    }

    /**
     * 用户角色查看
     * @return [type] [description]
     */
    public function adminUserMes($id)
    {
        $user_mes = User::where('id',$id)->first()->toArray();
        $role = AdminRoleModel::get()->toArray();
        return view('console.usermanager.adminuser_info',
            ['user_mes' => $user_mes, 'role' => $role, 'id' => $id]);
    }

    /**
     * 更新或添加用户权限
     * @return [type] [description]
     */
    public function updateUser()
    {
        $user_id = $this->request->input('user_id',0);
        $user    = User::where('id',$user_id)->first();
        if (!$user) {
            $user = new User;
        }
        $user_role_id  = $user->role_id;
        $user->name    = $this->request->input('name');
        $user->role_id = $this->request->input('level_id');
        // $user->email   = 'xxxxx@qq.com';

        $tmp1 = $tmp2 = $tmp3 = true;
        DB::beginTransaction();
        //更新权限表
        //获取之前角色所拥有的权限，进行删除
        $old_menu_arr = RoleVsMenuModel::where('role_id',$user_role_id)->select('menu_id')->get()->toArray();
        if ($old_menu_arr) {
            $old_menu_id = [];
            foreach ($old_menu_arr as $key => $value) {
                $old_menu_id[] = $value['menu_id'];
            }
            AdminVsRoleModel::where('uid',$user_id)->whereIn('menu_id',$old_menu_id)->delete();
        }
        
        //获取新的权限
        $new_menu_arr = RoleVsMenuModel::where('role_id',$this->request->input('level_id'))
                                        ->select('menu_id')
                                        ->get()
                                        ->toArray();//获取新角色权限
        $menu_data = [];
        foreach ($new_menu_arr as $key => $value) {
            $menu_data[] = ['uid' => $user_id, 'menu_id' => $value['menu_id'], 'created_at' => date('Y-m-d',time())];
            $new_menu_id[] = $value['menu_id'];
        }
        $tmp2 = AdminVsRoleModel::insert($menu_data);
        if ($this->request->has('newpwd')) {
            $user->password = bcrypt(trim($this->request->input('newpwd')));
        }
        $tmp3 = $user->save();
        if ($tmp1 && $tmp2 && $tmp3) {
            DB::commit();
            return redirect('/usermanager/adminuser/list')->with('status', '修改成功');
        } else {
            DB::rollBack();
            // TODO: 删除menu_id的补回
            return redirect('/usermanager/adminuser/list')->with('status', '修改失败');
        }
    }

    /**
     * 更新用户的权限
     * @return [type] [description]
     */
    public function updateAdminUser()
    {
        $user_id = $this->request->input('user_id');
        $cate_id = $this->request->input('cate_id');
        //删除权限，重新写入
        AdminVsRoleModel::where('uid',$user_id)->delete();
        $menu_data = [];
        foreach ($cate_id as $key => $value) {
            $menu_data[] = ['uid' => $user_id, 'menu_id' => $value, 'created_at' => date("Y-m-d",time())];
        }
        $res = AdminVsRoleModel::insert($menu_data);
        if ($res) {
            return redirect('/usermanager/adminuser/list')->with('status', '修改成功');
        } else {
            return redirect('/usermanager/adminuser/user/'.$user_id)->with('status', '修改失败');
        }
    }

    /**
     * 删除管理员
     * @return [type] [description]
     */
    public function deleteAdminUser($id)
    {
        $info = User::where('id',$id)->where('role_id',1)->first();
        if ($info) {
            return redirect('/usermanager/adminuser/list')->with('status', '超级管理员禁止删除');
        }
        $res = User::where('id',$id)->delete();
        if ($res) {
            return redirect('/usermanager/adminuser/list')->with('status', '操作成功');
        } else {
            return redirect('/usermanager/adminuser/list')->with('status', '操作失败');
        }
    }

    /**
     * 添加管理员模板渲染
     */
    public function add()
    {
        $role = AdminRoleModel::where('id','>',1)->get()->toArray();
        return view('console.usermanager.add_admin_user',[
                'role' => $role
            ]);
    }

    public function addUser()
    {
        $name = User::where('name',$this->request->input('name'))->first();
        if ($name) {
            return redirect('/usermanager/adminuser/add')->with('status', '用户名重名了奥');
        }
        $user = new User;
        $user->name    = $this->request->input('name');
        $user->role_id  = $this->request->input('level_id');
        $user->password = bcrypt(trim($this->request->input('newpwd')));
        // $user->email    = rand(1,100).rand(1,100).'@qq.com';
        $user_id = $user->save();
        //获取权限
        $menu_id = RoleVsMenuModel::where('role_id',$this->request->input('level_id'))
                                        ->select('menu_id')
                                        ->get()
                                        ->toArray();
        $admin_menu = [];
        foreach ($menu_id as $key => $value) {
            $admin_menu[] = ['uid' => $user->id, 'menu_id' => $value['menu_id'], 'created_at' => date("Y-m-d H:i:s",time())];
        }
        $res = AdminVsRoleModel::insert($admin_menu);
        if ($res) {
            return redirect('/usermanager/adminuser/list')->with('status', '添加成功');
        } else {
            return redirect('/usermanager/adminuser/add')->with('status', '添加失败');
        }
    }

    /**
     * 供应商管理(列表)
     * @return [type] [description]
     */
    public function adsList(Request $request)
    {
        $lists = [];
        $type = 1;
        //获取供应商列表
        $lists = SuppUsersModel::withCount(['childUser','orderNetwork'])
                    ->with(['user'])
                    ->leftJoin('users','users.id','=','supp_users.user_id')
                    ->where('parent_id', '=', 0);
        if ($request->input('start')) {
            $lists = $lists->where('users.created_at','>=',$request->input('start'));
        }
        if (!empty($request->input('end'))) {
            $lists = $lists->where('users.updated_at','<=',$request->input('end'));
        }
        if ($request->input('keyword')) {
            $lists = $lists->where("users.name",'like',"%".$request->input('keyword')."%");
        }
        $lists = $lists->get()->toArray();
        if ($request->input('get_excel') == 1) {
            $this->getSuppListExcel($lists,$type);
        }
        return view('console.usermanager.ads_list',[
            'lists' => $lists,'plate_list' => getSearchMediaSelect()]);
    }

    /**
     * 资源管理(列表)
     * @return [type] [description]
     */
    public function resourcesList(Request $request)
    {
		$lists = [];
        $type = 1;

        //获取供应商列表
        $lists = SuppUsersModel::with(['plate', 'childPlate'])
                    ->leftJoin('users','users.id','=','supp_users.user_id')
                    ->leftJoin('plate','supp_users.plate_id','=','plate.id')
                    ->where('supp_users.belong','=',$request->input('pid'));

        if ($request->input('start')) {
            $lists = $lists->where('users.created_at','>=',$request->input('start'));
        }
        if (!empty($request->input('end'))) {
            $lists = $lists->where('users.updated_at','<=',$request->input('end'));
        }
        if ($request->input('username')) {
            $plate_tid = $request->input('plate_id');
            $username = $request->input('username');
            $lists = $lists->where(
                function($query)use($username,$plate_tid){
                    $query->where("supp_users.media_name",'like',"%".$username."%")
                        ->orWhereIn('supp_users.plate_id', function($q)use($username,$plate_tid){
                            $q->from('plate')
                                        ->where('plate_name', 'like', '%'.$username.'%')
                                        ->whereIn('id', explode(',', $plate_tid))
                                        ->select('id');}
                        );
                });
        }
        $lists = $lists->get()->toArray();
        // dd($lists);
        if ($request->input('get_excel') == 1) {
            $this->getSuppListExcel($lists,2);
        }
		return view('console.usermanager.resources_list',[
            'lists' => $lists, 
            'media_select' => getSearchMediaSelect()]);
	}

	/**
     * 资源管理详细信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function resourceInfo(Request $request)
    {
        $id = $request->input('id');
        $info = User::where('id',$id)->with('supp_user')->first();
        if (!$info['supp_user']) {
                return back()->with('status', '用户数据残缺');
        }

        $info = $info->toArray();
        $plate = PlateModel::where('pid',0)
                            ->with(['childPlate' => function($query)use($info){
                                $query->where('id', $info['supp_user']['plate_id'])->first();
                            }])
                            ->where('id',$info['supp_user']['plate_tid'])
                            ->first()
                            ->toArray();
        // dd($plate);
        //获取供应商的属性
        $all_id = SuppVsAttrModel::where('user_id',$id)
                            ->where('attr_value_id',0)
                            ->pluck('attr_id')
                            ->toArray();
        $attr_id_arr = SuppVsAttrModel::where('user_id',$id)
                            ->where('attr_value_id','>',0)
                            ->pluck('attr_value_id')
                            ->toArray();
        $parent_name = '';
        if ($info['supp_user']['belong'] > 0){
            $parent_name = SuppUsersModel::where('user_id',$info['supp_user']['belong'])->first()->name;
        }
        //获取他的分类并且选中
        $spec_vs_val = PlateModel::with(['plateVsAttr','plateVsAttr.attrVsVal'])
                        ->where('id',$info['supp_user']['plate_id'])
                        ->first();
            // dd($spec_vs_val);
        // dd($lists);

        $class_html = getAttrValue($info['supp_user']['plate_id'],true,$attr_id_arr,$all_id);
        return view('console.usermanager.supp_resource_info',['info' => $info, 
                                                      'plate' => $plate, 
                                                      'class_html' => $class_html,
                                                      'parent_name' => $parent_name,
                                                      'spec_vs_val' => $spec_vs_val,
                                                      'user_vs_attr_ids' => $attr_id_arr]);

    }

	
    function getSuppListExcel($data,$type=1)
    {
        if ($type == 1) { // 供应商
            $cell_data[] = ['序号', '用户名','创建时间', '订单数', '媒体资源','账户余额', '状态', '负责人', '联系电话', '电子邮箱', '联系QQ', '联系地址', '邮编'];
        } else {
            $cell_data[] = ['序号', '资源名称', '资源类型', '创建时间', '订单数', '代理价', '状态'];
        }
        
        foreach ($data as $key => $value) {
            if ($type == 1) {
                $cell_data[] = [
                    $value['user_id'], 
                    $value['name'], 
                    $value['created_at'], 
                    $value['order_count'], 
                    $value['child_user_count'],
                    $value['user_money'],
                    getSuppUserType($value['is_state']),
                    $value['media_contact'],
                    $value['contact_phone'],
                    $value['email'],
                    $value['qq'],
                    $value['address'],
                    $value['zip_code'],
                ];
            } else {
                $cell_data[] = [
                    $value['user_id'], 
                    $value['media_name'], 
                    $value['plate']['plate_name'], 
                    $value['created_at'], 
                    $value['order_count'], 
                    // $value['user_money'],
                    $value['proxy_price'],
                    getSuppUserType($value['is_state']),
                ];
            }
        }
        $msg = $type == 1 ? '供应商用户列表' : '供应商资源列表';
        getExcel($msg, $msg, $cell_data);
        exit();
    }

    /**
     * 添加供应商模板渲染
     */
    public function addAds()
    {
        //获取媒体类型
        $plate_list = PlateModel::where('pid',0)->where('is_show',1)->with('childPlate')->get();
        if ($this->request->input('is_ajax') == 'get_attr') {
            $pid = $this->request->input('pid');
            $attr_id = $this->request->input('attr_id');
            //遍历节点
            return getAttrValue($attr_id,true);
        }
        if ($this->request->input('is_ajax') == 'get_child') {
            $pid = $this->request->input('pid');
            $lists = PlateModel::where('pid',$pid)->get()->toArray();
            return ['lists' => $lists, 'status_code' => 200];
        }
        $lists = PlateModel::with(['plateVsAttr','plateVsAttr.attrVsVal'])
                        ->where('pid',35)
                        ->get()
                        ->toArray();
        return view('console.usermanager.add_ads',['plate_list' => $plate_list]);
    }

    /**
     * 写入(创建)供应商
     * @return [type] [description]
     */
    public function createAds(Request $request)
    {
        // dd($this->request->all());
        \DB::beginTransaction();
        $info = User::where('name', $request->input('name'))->first();
        if ($info) {
            return back()->with('status', '登录用户名已存在')->withInput();
        }
        try {
            $user = new User;
            $user->name = $request->input('name');
            $user->password = bcrypt(env('pwd'));
            $user->role_id = 1;
            $user->head_pic = '';
            $user->user_type = 3;
            $user->save();

            //传图
            $media_logo = $request->file('media_logo');
            $index_logo = $request->file('index_logo');
            $media_check_file = $request->file('media_check_file');
            if (!$request->file('media_logo')->isValid() || 
                !$request->file('index_logo')->isValid() || 
                !$request->file('media_check_file')->isValid()) {
                return redirect('/usermanager/add_ads')->with('status', '文件上传出错！');
            }

            //保存图
            $media_logo = $request->media_logo->store('supp_user');
            $index_logo = $request->index_logo->store('supp_user');
            $media_check_file = $request->media_check_file->store('supp_user');

            $parent_media = $request->input('parent_media');
            if ($parent_media) {
                $parent_uid = SuppUsersModel::where('name',$parent_media)->value('user_id');
            }
            if (!empty($parent_uid)) {
                $return_url = "/usermanager/resources_list?pid=".$parent_uid;
            } else {
                $parent_uid = 0;
                $return_url = "/usermanager/ads_list";
            }

            $supp_model = new SuppUsersModel;
            $supp_model->user_id = $user->id;
            $supp_model->name = $request->input('name');
            $supp_model->belong = $parent_uid;//所属推荐人
            $supp_model->parent_id = $parent_uid;
            $supp_model->plate_tid = 0; //$request->input('plate_tid');
            $supp_model->plate_id = 0; //$request->input('plate_id');
            $supp_model->media_name = $request->input('media_name');
            $supp_model->media_logo = '/uploads/'.$media_logo;
            $supp_model->index_logo = '/uploads/'.$index_logo;
            // $supp_model->proxy_price = $request->input('proxy_price');
            // $supp_model->platform_price = $request->input('platform_price',0);
            $supp_model->media_contact = $request->input('media_contact');
            $supp_model->contact_phone = $request->input('contact_phone');
            $supp_model->email = $request->input('email');
            $supp_model->qq = $request->input('qq');
            $supp_model->address = $request->input('address');
            $supp_model->zip_code = $request->input('zip_code');
            $supp_model->media_check = $request->input('media_check');
            $supp_model->media_check_file = '/uploads/'.$media_check_file;//认证图
            $supp_model->breif = $request->input('breif');
            $supp_model->remark = $request->input('remark');
            $supp_model->is_state = $request->input('is_state');
            // $supp_model->vip_rate = $request->input('vip_rate');
            // $supp_model->plate_rate = $request->input('plate_rate');
            // $supp_model->plate_price = $request->input('plate_price');
            // $supp_model->vip_price = $request->input('vip_price');
            // $supp_model->order_count = 0;
            $supp_model->save();
            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
            return redirect('/usermanager/ads_list')->with('error', '创建失败');
        }
        return redirect($return_url)->with('error', '创建成功');
    }

    /**
     * 更新供应商媒体
     * @return [type] [description]
     */
    public function updateInfo($id,Request $request)
    {
        $user = User::where('id',$id)->with('supp_user')->first();
        $return_url = '/usermanager/supps/'.$id;
        \DB::beginTransaction();
        //更新users表
        $user->name = !empty($request->input('name')) ? $request->input('name') : $user->name;
        $tmp = $user->save();
        //更新属性分类关联表
        // SuppVsAttrModel::where('user_id',$id)->delete();
        // $spec = $request->spec;
        // if (!$spec) {
        //     return back()->with('status','分类属性必须选择');
        // }
        // $supp_vs_attr_data = [];
        // foreach ($spec as $key => $value) {
        //     $supp_vs_attr_data[] = [
        //             'user_id' => $user->id, 
        //             'attr_value_id' => $value,
        //             'attr_id' => $key,
        //             'created_at' => date("Y-m-d H:i:s",time())];
        // }
        // $tmp2 = SuppVsAttrModel::insert($supp_vs_attr_data);
        //更新supp_users表
        //传图
        $media_logo = $request->file('media_logo');
        $index_logo = $request->file('index_logo');
        if ($media_logo) {
            if (!$request->file('media_logo')->isValid()) {
                return redirect($return_url)->with('status', '文件上传出错！');
            }
            $media_logo = $request->media_logo->store('supp_user');
        }
        if ($index_logo) {
            if (!$request->file('index_logo')->isValid()) {
                return redirect($return_url)->with('status', '文件上传出错！');
            }
            $index_logo = $request->index_logo->store('supp_user');
        }

        $supp_model = SuppUsersModel::where('user_id',$id)->first();
        $supp_model->name = $user->name;
        // $supp_model->parent_id = $request->input('belong');//所属推荐人
        // $supp_model->plate_tid = !empty($request->input('plate_tid')) ? $request->input('plate_tid') : $supp_model->plate_tid;
        // $supp_model->plate_id = !empty($request->input('plate_id')) ? $request->input('plate_id') : $supp_model->plate_id;
        $supp_model->media_name = !empty($request->input('media_name')) ? $request->input('media_name') : $supp_model->media_name;
        // $supp_model->web_contact = !empty($request->input('web_contact')) ? $request->web_contact : $supp_model->web_contact;

        
        if (!empty($media_logo)) {
            $supp_model->media_logo = '/uploads/'.$media_logo;
        }
        if (!empty($index_logo)) {
            $supp_model->index_logo = '/uploads/'.$index_logo;
        }

        // if (!empty($request->input('proxy_price'))) {
        //     $supp_model->proxy_price = $request->input('proxy_price');
        // }
        // if (!empty($request->input('vip_price'))) {
        //     $supp_model->vip_price = $request->input('vip_price');
        // }
        // if (!empty($request->input('plate_price'))) {
        //     $supp_model->plate_price = $request->input('plate_price');
        // }
        // if (!empty($request->input('plate_rate'))) {
        //     $supp_model->plate_rate = $request->input('plate_rate');
        // }
        // if (!empty($request->input('vip_rate'))) {
        //     $supp_model->vip_rate = $request->input('vip_rate');
        // }
        // if (!empty($request->input('platform_price'))) {
        //     $supp_model->platform_price = $request->input('platform_price');
        // }
        if (!empty($request->input('media_contact'))) {
            $supp_model->media_contact = $request->input('media_contact');
        }
        if (!empty($request->input('contact_phone'))) {
            $supp_model->contact_phone = $request->input('contact_phone');
        }
        if (!empty($request->input('email'))) {
            $supp_model->email = $request->input('email');
        }
        if (!empty($request->input('qq'))) {
            $supp_model->qq = $request->input('qq');
        }
        if (!empty($request->input('address'))) {
            $supp_model->address = $request->input('address');
        }
        if (!empty($request->input('zip_code'))) {
            $supp_model->zip_code = $request->input('zip_code');
        }
        // if (!empty($request->input('media_check'))) {
        //     $supp_model->media_check = $request->input('media_check');
        // }
        if (!empty($request->input('breif'))) {
            $supp_model->breif = $request->input('breif');
        }
        if (!empty($request->input('remark'))) {
            $supp_model->remark = $request->input('remark');
        }
        if (!empty($request->input('is_state'))) {
            $supp_model->is_state = $request->input('is_state');
        }
        $tmp2 = $supp_model->save();
        if ($tmp && $tmp2) {
            \DB::commit();
            return redirect($return_url)->with('status', '更新成功');
        } else {
            \DB::rollBack();
            return redirect($return_url)->with('status', '更新失败');
        }
    }

    public function updateResourceInfo(Request $request)
    {
        $id = $request->user_id;
        $user = User::where('id',$id)->with('supp_user')->first();
        if (empty($user)) {
            return back()->with('status', '不存在此用户');
        }
        $return_url = '/usermanager/resources_list?pid='.$user['supp_user']['parent_id'];
        \DB::beginTransaction();
        //更新users表
        $user->name = !empty($request->media_name) ? $request->media_name : $user->name;
        $tmp = $user->save();
        //更新属性分类关联表
        $spec = $request->spec;
        if (!$spec) {
            return back()->with('status','分类属性必须选择');
        }
        foreach ($spec as $key => $value) {
            SuppVsAttrModel::where('user_id', $user->id)
                            ->where('attr_id', $key)
                            ->update(['attr_value_id' => $value]);
        }
        //更新supp_users表
        //传图
        $media_logo = $request->file('media_logo');
        $index_logo = $request->file('index_logo');
        if ($media_logo) {
            if (!$request->file('media_logo')->isValid()) {
                return redirect($return_url)->with('status', '文件上传出错！');
            }
            $media_logo = $request->media_logo->store('supp_user');
        }
        if ($index_logo) {
            if (!$request->file('index_logo')->isValid()) {
                return redirect($return_url)->with('status', '文件上传出错！');
            }
            $index_logo = $request->index_logo->store('supp_user');
        }

        $supp_model = SuppUsersModel::where('user_id',$id)->first();
        $supp_model->name = $user->name;
        // $supp_model->parent_id = $request->input('belong');//所属推荐人
        // $supp_model->plate_tid = !empty($request->input('plate_tid')) ? $request->input('plate_tid') : $supp_model->plate_tid;
        // $supp_model->plate_id = !empty($request->input('plate_id')) ? $request->input('plate_id') : $supp_model->plate_id;
        $supp_model->media_name = !empty($request->input('media_name')) ? $request->input('media_name') : $supp_model->media_name;
        $supp_model->web_contact = !empty($request->web_contact) ? $request->web_contact : $supp_model->web_contact;
        if (!empty($media_logo)) {
            $supp_model->media_logo = '/uploads/'.$media_logo;
        }
        if (!empty($index_logo)) {
            $supp_model->index_logo = '/uploads/'.$index_logo;
        }

        if (!empty($request->input('proxy_price'))) {
            $supp_model->proxy_price = $request->input('proxy_price');
        }
        if (!empty($request->input('vip_price'))) {
            $supp_model->vip_price = $request->input('vip_price');
        }
        if (!empty($request->input('plate_price'))) {
            $supp_model->plate_price = $request->input('plate_price');
        }
        if (!empty($request->input('plate_rate'))) {
            $supp_model->plate_rate = $request->input('plate_rate');
        }
        if (!empty($request->input('vip_rate'))) {
            $supp_model->vip_rate = $request->input('vip_rate');
        }
        // if (!empty($request->input('platform_price'))) {
        //     $supp_model->platform_price = $request->input('platform_price');
        // }
        if (!empty($request->input('media_contact'))) {
            $supp_model->media_contact = $request->input('media_contact');
        }
        if (!empty($request->input('contact_phone'))) {
            $supp_model->contact_phone = $request->input('contact_phone');
        }
        if (!empty($request->input('email'))) {
            $supp_model->email = $request->input('email');
        }
        if (!empty($request->input('qq'))) {
            $supp_model->qq = $request->input('qq');
        }
        if (!empty($request->input('address'))) {
            $supp_model->address = $request->input('address');
        }
        if (!empty($request->input('zip_code'))) {
            $supp_model->zip_code = $request->input('zip_code');
        }
        if (!empty($request->input('remark'))) {
            $supp_model->remark = $request->input('remark');
        }
        if (!empty($request->input('is_state'))) {
            $supp_model->is_state = $request->input('is_state');
        }
        $tmp2 = $supp_model->save();
        if ($tmp && $tmp2) {
            \DB::commit();
            return redirect($return_url)->with('status', '更新成功');
        } else {
            \DB::rollBack();
            return redirect($return_url)->with('status', '更新失败');
        }
    }

    /** 
     * 同类媒体
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function sameTypeMedia(Request $request)
    {
        $id = $request->id;
        $users = User::where('id', $id)->first();
        if ($users->user_type == 4) {
            $supp_info = SuppUsersSelfModel::where('user_id', $id)->first();
        } else {
            $supp_info = SuppUsersModel::where('user_id', $id)->first();
        }
        if (empty($supp_info)) {
            return back()->with('status', '媒体资源不存在');
        }
        $plate_tid = $supp_info->plate_tid;
        $plate_id = $supp_info->plate_id;
        $keyword = $request->keyword;
        
        $attr_value_id = SuppVsAttrModel::where('user_id', $id)->pluck('attr_value_id')->toArray();

        $attr_count = count($attr_value_id);
        $users_ids_self = SuppUsersSelfModel::where('plate_tid', $plate_tid);
        $users_ids_supp = SuppUsersModel::where('plate_tid', $plate_tid);
        if (!empty($keyword)) {
            $users_ids_self = $users_ids_self->where('media_name', 'like', '%'.$keyword.'%');
            $users_ids_supp = $users_ids_supp->where('media_name', 'like', '%'.$keyword.'%');
        }
        $users_ids_self = $users_ids_self->where('plate_id', $plate_id)
                ->select('user_id')
                ->get()->toArray();
        $users_ids_supp = $users_ids_supp->where('plate_id', $plate_id)
                ->where('parent_id', '<>', 0)
                ->select('user_id')
                ->get()->toArray();
        $user_ids = array_merge($users_ids_supp, $users_ids_self);

        // 获取同类的uid
        $user_ids = SuppVsAttrModel::whereIn('user_id', $user_ids)->whereIn('attr_value_id', $attr_value_id);
        if ($supp_info->success_order != 1) {
            $user_ids = $user_ids->where('user_id','<>',$supp_info->user_id);
        }
        if (!empty($request->start)) {
            $user_ids = $user_ids->where('created_at', '>=', $request->start." 00:00:00");
        }
        if (!empty($request->end)) {
            $user_ids = $user_ids->where('created_at', '<=', $request->end." 23:59:59");
        }
        $user_ids = $user_ids
                        ->groupBy('user_id')
                        ->havingRaw("count(user_id) = $attr_count")
                        ->pluck('user_id')
                        ->toArray();
        if (!$user_ids) {
            return back()->with('status', '没有同类媒体资源');
        }

        $lists_supp = SuppUsersModel::with(['plate','childPlate','parentUser'])
                    ->whereIn('user_id', $user_ids)
                    ->get()
                    ->toArray();
        $lists_self = SuppUsersSelfModel::with(['plate','childPlate','parentUser'])
                    ->whereIn('user_id', $user_ids)
                    ->get()
                    ->toArray();
        if ($users->user_type == 4) {
            $user_info = SuppUsersSelfModel::with(['plate','childPlate','parentUser'])
                        ->where('user_id', $supp_info->user_id)
                        ->first();
        } else {
            $user_info = SuppUsersModel::with(['plate','childPlate','parentUser'])
                        ->where('user_id', $supp_info->user_id)
                        ->first();
        }
        $lists = array_merge($lists_self, $lists_supp);
        $media_list = PlateModel::where('pid', $plate_tid)->get()->toArray();
        $lists = array_values(array_sort($lists, function($value)
        {
            return $value['success_order'];
        }));
        // dd($lists);
        return view('console.supp.same_type_media_list', [
                'lists' => $lists,
                'media_list' => $media_list,
                'user_info' => $user_info
            ]);
    }

    /**
     * 供应商详细信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function suppsInfo($id)
    {
        // $id = SuppUsersModel::where('id',$id)->value('user_id');
        $info = User::where('id',$id)->with('supp_user')->first()->toArray();
        // dd($info);die;
        $plate_list = PlateModel::where('pid',0)->where('is_show',1)->with('childPlate')->get();
        //获取供应商的属性
        $all_id = SuppVsAttrModel::where('user_id',$id)
                            ->where('attr_value_id',0)
                            ->pluck('attr_id')
                            ->toArray();
        $attr_id_arr = SuppVsAttrModel::where('user_id',$id)
                            ->where('attr_value_id','>',0)
                            ->pluck('attr_value_id')->toArray();
                            // ->toArray();
        // dd($attr_id_arr);
        $parent_name = '';
        if ($info['supp_user']['parent_id'] > 0){
            $parent_name = SuppUsersModel::where('user_id',$info['supp_user']['parent_id'])->first()->name;
        }        
        //获取他的分类并且选中
        $class_html = getAttrValue($info['supp_user']['plate_id'],true,$attr_id_arr,$all_id);
        // dd($info);
        return view('console.usermanager.supps_info',['info' => $info, 
                                                      'plate_list' => $plate_list, 
                                                      'class_html' => $class_html,
                                                      'parent_name' => $parent_name]);
    }

    public function delRole($id)
    {
        if ($id == 1) {
            return back()->with('status','禁止删除超级管理员');
        }
        $userCount = UsersModel::where('role_id',$id)->count();
        if ($userCount > 0) {
            return back()->with('status','该角色下还存在有对应的用户，不能删除');
        }
        $res = AdminRoleModel::where('id',$id)->delete();
        if ($res) {
            return back()->with('status','删除成功');
        }
        return back()->with('status','删除失败');
    }

    /**
     * 设置允许接单
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateSet(Request $request)
    {
        $user_id = $request->input('user_id');
        $val = $request->input('val');
        if ($val == 1) { // 设置接单
            $info = SuppUsersModel::where('user_id', $user_id)->first();
            if (!$info) {
                return ['status_code' => 201, 'msg' => '不存在此媒体'];
            }
            $attr_value_id = SuppVsAttrModel::where('user_id', $user_id)
                                    ->pluck('attr_value_id')
                                    ->toArray();

            $attr_count = count($attr_value_id);

            $plate_id = $info['plate_id'];
            $plate_tid = $info['plate_tid'];

            $user_ids = SuppVsAttrModel::whereIn('user_id', function($query) use($plate_tid, $plate_id) {
                $query->from('supp_users')
                    ->where('plate_tid', $plate_tid)
                    ->where('plate_id', $plate_id)
                        ->where('parent_id', '<>', 0)
                        ->select('user_id')
                        ->get();
            })->whereIn('attr_value_id', $attr_value_id)
                ->groupBy('user_id')
                ->havingRaw("count(user_id) = $attr_count")
                ->pluck('user_id')
                ->toArray();
            // 全部更新为2
            SuppUsersModel::whereIn('user_id', $user_ids)->update(['success_order' => 2]);
            SuppUsersModel::where('user_id', $user_id)->update(['success_order' => 1]);
        } else {
            SuppUsersModel::where('user_id', $user_id)->update(['success_order' => 2]);
        }
        return ['status_code' => 200];
    }

    /**
     * 供应商媒体列表
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function suppMediaList(Request $request)
    {
        $list = SuppUsersModel::with(['childPlate', 'parentUser'])->where('parent_id','<>','0');
        if ($request->start) {
            $list = $list->where('created_at', '>=', $request->start);
        }
        if ($request->end) {
            $list = $list->where('created_at', '<=', $request->end);
        }
        if ($request->input('plate_id')) {
            $list = $list->where('plate_tid', $request->plate_id);
        }
        if (!empty($request->keyword)) {
            $list = $list->where(function($query)use($request){
                $query->where('media_name', 'like', '%'.$request->keyword.'%')
                    ->orWhereIn('plate_id',function($query)use($request){
                        if (!empty($request->plate_id)) {
                            $query->from('plate')
                                    ->where('pid','=', $request->plate_id)
                                    ->where('plate_name', 'like', '%'.$request->keyword.'%')
                                    ->select('id')
                                    ->get();
                        } else {
                            $query->from('plate')
                                    ->where('pid','<>', 0)
                                    ->where('plate_name', 'like', '%'.$request->keyword.'%')
                                    ->select('id')
                                    ->get();
                        }
                    });
            });
        }
        $list = $list->get()->toArray();
        if ($request->get_excel == 1) {
            $this->getSuppMediaList($list);
        }
        $plate_list = getSearchMediaSelect();
        return view('console.supp.supp_media_list', [
                'list' => $list,
                'plate_list' => $plate_list
            ]);
    }

    public function selfMediaList(Request $request)
    {
        $lists = SuppUsersSelfModel::with(['childPlate', 'parentUser']);
        if ($request->start) {
            $lists = $lists->where('created_at', '>=', $request->start);
        }
        if ($request->end) {
            $lists = $lists->where('created_at', '<=', $request->end);
        }
        if ($request->input('plate_id')) {
            $lists = $lists->where('plate_tid', $request->plate_id);
        }
        if (!empty($request->keyword)) {
            $lists = $lists->where(function($query)use($request){
                $query->where('media_name', 'like', '%'.$request->keyword.'%')
                    ->orWhereIn('plate_id',function($query)use($request){
                        if (!empty($request->plate_id)) {
                            $query->from('plate')
                                    ->where('pid','=', $request->plate_id)
                                    ->where('plate_name', 'like', '%'.$request->keyword.'%')
                                    ->select('id')
                                    ->get();
                        } else {
                            $query->from('plate')
                                    ->where('pid','<>', 0)
                                    ->where('plate_name', 'like', '%'.$request->keyword.'%')
                                    ->select('id')
                                    ->get();
                        }
                    });
            });
        }
        $lists = $lists->get()->toArray();
        if ($request->get_excel == 1) {
            $this->getSelfMediaList($lists);
        }
        $plate_list = getSearchMediaSelect();
        return view('console.supp.self_media_list', [
            'lists' => $lists,
            'plate_list' => $plate_list
        ]);
    }

    public function getSelfMediaList($data)
    {
        $cell_data = [];
        $cell_data[] = ['序号','媒体名称','媒体类型','创建时间','订单数','价格','平台价','会员价','状态'];
        foreach ($data as $key => $val) {
            $cell_data[] = [
                $val['user_id'],
                $val['media_name'],
                $val['child_plate']['plate_name'],
                $val['created_at'],
                $val['order_count'],
                $val['proxy_price'],
                $val['plate_price'],
                $val['vip_price'],
                getSuppUserType($val['is_state']),
            ];
        }
        getExcel('自营媒体列表_'.date('Y-m-d',time()),'自营媒体列表_'.date('Y-m-d',time()),$cell_data);
    }

    public function getSuppMediaList($data)
    {
        $cell_data = [];
        $cell_data[] = ['序号','媒体名称','媒体类型','供应商','创建时间','订单数','价格','状态'];
        foreach ($data as $key => $val) {
            $cell_data[] = [
                $val['user_id'],
                $val['media_name'],
                $val['child_plate']['plate_name'],
                $val['parent_user']['name'],
                $val['created_at'],
                $val['order_count'],
                $val['proxy_price'],
                getSuppUserType($val['is_state']),
            ];
        }
        getExcel('供应商媒体列表_'.date('Y-m-d',time()),'供应商媒体列表_'.date('Y-m-d',time()),$cell_data);
    }

    public function getSelectOrderMediaMediaList($data)
    {
        $cell_data = [];
        $cell_data[] = ['序号','媒体名称','媒体类型','供应商','创建时间','订单数','价格','状态'];
        foreach ($data as $key => $val) {
            $cell_data[] = [
                $val['user_id'],
                $val['media_name'],
                $val['child_plate']['plate_name'],
                $val['parent_user']['name'],
                $val['created_at'],
                $val['order_count'],
                $val['proxy_price'],
                getSuppUserType($val['is_state']),
            ];
        }
        getExcel('已选接单媒体资源列表_'.date('Y-m-d',time()),'已选接单媒体资源列表_'.date('Y-m-d',time()),$cell_data);
    }

    public function addSuppMedia(Request $request)
    {
        $plate_list = PlateModel::with(['childPlate','childPlate.plateVsAttr.attrVsVal'])
                                ->where('pid',0)
                                ->get()
                                ->toArray();
        return view('console.supp.add_supp_media',
            [
             'plate_list' => $plate_list,
             'active' => 'resource',
             ]);
    }

    public function ajaxCheckSupp(Request $request)
    {
        $supp_name = $request->input('supp_name');
        $info = SuppUsersModel::where('name',$supp_name)->first();
        if (!$info) {
            return ['status_code' => 201, 'msg' => '没找到这个供应商，请检查是否输入正确'];
        }
        return ['status_code' => 200];
    }

    /**
     * 创建供应商媒体
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function saveSuppMedia(Request $request)
    {
        $media_name = $request->media_name;
        $belong = $request->belong;
        $belong = SuppUsersModel::where('name', $belong)->first();
        if (!$belong) {
            return back()->with('status', '供应商不存在');
        }
        $file = parent::uploadFile(['media_logo' => $request->media_logo, 'index_logo' => $request->index_logo]);
        if ($file['status_code'] == 201) {
            return back()->with('status', '文件上传错误');
        }
        // 用户规格
        $spec = $request->spec;
        $spec = explode(',', $spec);
        if (empty($spec)) {
            return back()->with('status','分类属性必须选择');
        }
        DB::beginTransaction();
        $user = new User;
        $info = User::where('name',$media_name)->first();
        if ($info) {
            $user->name = $media_name.'_'.date('His',time()).rand(1,1000);
        } else {
            $user->name = $media_name;
        }
        // 处理图片
        $user->password = bcrypt(env('pwd'));
        $user->role_id = 1;
        $user->head_pic = '';
        $user->user_type = 3;
        $tmp = $user->save();
        $supp = new SuppUsersModel;
        $supp->user_id = $user->id;
        $supp->name = $media_name;
        $supp->belong = $belong->user_id;
        $supp->parent_id = $belong->user_id;
        $supp->plate_tid = $request->plate_tid;
        $supp->plate_id = $request->plate_id[$request->plate_tid];
        $supp->media_name = $request->media_name;
        $supp->index_logo = $file['data']['index_logo'];
        $supp->media_logo = $file['data']['media_logo'];
        $supp->proxy_price = $request->proxy_price;
        $supp->media_contact = $request->media_contact;
        $supp->contact_phone = $request->contact_phone;
        $supp->email = $request->email;
        $supp->qq = $request->qq;
        $supp->address = $request->address;
        $supp->zip_code = $request->zip_code;
        $supp->web_contact = $request->web_contact;
        // $supp->media_check_file = '';
        $supp->remark = $request->remark;
        $supp->is_state = $request->is_state;
        $supp->order_count = 0;
        // $supp->vip_price = $request->vip_price;
        // $supp->plate_price = $request->plate_price;
        // $supp->vip_rate = $request->vip_rate;
        // $supp->plate_rate = $request->plate_rate;
        $tmp2 = $supp->save();
        $supp_vs_attr_data = [];
        foreach ($spec as $key => $value) {
            $tmp_k = explode('_', $value);
            $supp_vs_attr_data[] = [
                    'user_id' => $user->id, 
                    'attr_value_id' => $tmp_k['1'],
                    'attr_id' => $tmp_k['0'],
                    'created_at' => date("Y-m-d H:i:s",time())];
        }
        $tmp3 = SuppVsAttrModel::insert($supp_vs_attr_data);
        if ($tmp && $tmp2 && $tmp3) {
            DB::commit();
            return redirect('/usermanager/suppMediaList')->with('status', '创建成功');
        } else {
            DB::rollBack();
            return back()->with('status', '添加错误');
        }
    }

    public function addSelfMedia()
    {
        $plate_list = PlateModel::with(['childPlate','childPlate.plateVsAttr.attrVsVal'])
                                ->where('pid',0)
                                ->get()
                                ->toArray();
        return view('console.supp.add_self_media', [
             'plate_list' => $plate_list,
             'active' => 'resource',
             ]);
    }

    public function saveSelfMedia(Request $request)
    {
        $media_name = $request->media_name;
        $file = parent::uploadFile(['media_logo' => $request->media_logo, 'index_logo' => $request->index_logo]);
        if ($file['status_code'] == 201) {
            return back()->with('status', '文件上传错误');
        }
        // 用户规格
        $spec = $request->spec;
        $spec = array_filter(explode(',', $spec));
        if (empty($spec)) {
            return back()->with('status','分类属性必须选择');
        }
        DB::beginTransaction();
        $user = new User;
        $user->name = $media_name.'_'.date('His',time()).rand(1,1000);
        // 处理图片
        $user->password = bcrypt(env('pwd'));
        $user->role_id = 1;
        $user->head_pic = '';
        $user->user_type = 4;
        $user->is_login = 2;
        $tmp = $user->save();
        $supp = new SuppUsersSelfModel;
        $supp->user_id = $user->id;
        $supp->name = $media_name;
        // $supp->belong = 0;
        $supp->parent_id = 0;
        $supp->plate_tid = $request->plate_tid;
        $supp->plate_id = $request->plate_id[$request->plate_tid];
        $supp->media_name = $request->media_name;
        $supp->index_logo = $file['data']['index_logo'];
        $supp->media_logo = $file['data']['media_logo'];
        $supp->proxy_price = $request->proxy_price;
        $supp->media_contact = $request->media_contact;
        $supp->contact_phone = $request->contact_phone;
        $supp->email = $request->email;
        $supp->qq = $request->qq;
        $supp->address = $request->address;
        $supp->zip_code = $request->zip_code;
        $supp->web_contact = $request->web_contact;
        // $supp->media_check_file = '';
        $supp->remark = $request->remark;
        $supp->is_state = $request->is_state;
        $supp->order_count = 0;
        $supp->vip_price = $request->vip_price;
        $supp->plate_price = $request->plate_price;
        $supp->vip_rate = $request->vip_rate;
        $supp->plate_rate = $request->plate_rate;
        $tmp2 = $supp->save();
        $supp_vs_attr_data = [];
        foreach ($spec as $key => $value) {
            $tmp_k = explode('_', $value);
            $supp_vs_attr_data[] = [
                    'user_id' => $user->id, 
                    'attr_value_id' => $tmp_k['1'],
                    'attr_id' => $tmp_k['0'],
                    'created_at' => date("Y-m-d H:i:s",time())];
        }
        $tmp3 = SuppVsAttrModel::insert($supp_vs_attr_data);
        if ($tmp && $tmp2 && $tmp3) {
            DB::commit();
            return redirect('/usermanager/selfMediaList')->with('status', '创建成功');
        } else {
            DB::rollBack();
            return back()->with('status', '添加错误');
        }
    }

    public function selfMedia(Request $request)
    {
        $user_id = $request->id;
        $info = User::where('id',$user_id)->with('suppUserSelf')->first()->toArray();
        $plate = PlateModel::where('pid',0)
                            ->with(['childPlate' => function($query)use($info){
                                $query->where('id', $info['supp_user_self']['plate_id'])->first();
                            }])
                            ->where('id',$info['supp_user_self']['plate_tid'])
                            ->first()
                            ->toArray();
        //获取供应商的属性
        $all_id = SuppVsAttrModel::where('user_id',$user_id)
                            ->where('attr_value_id',0)
                            ->pluck('attr_id')
                            ->toArray();
        $attr_id_arr = SuppVsAttrModel::where('user_id',$user_id)
                            ->where('attr_value_id','>',0)
                            ->pluck('attr_value_id')
                            ->toArray();
        
        //获取他的分类并且选中
        $spec_vs_val = PlateModel::with(['plateVsAttr','plateVsAttr.attrVsVal'])
                        ->where('id',$info['supp_user_self']['plate_id'])
                        ->first();
            // dd($spec_vs_val);
        // dd($lists);

        $class_html = getAttrValue($info['supp_user_self']['plate_id'],true,$attr_id_arr,$all_id);
        return view('console.usermanager.self_media_info',['info' => $info, 
                                                      'plate' => $plate, 
                                                      'class_html' => $class_html,
                                                      'spec_vs_val' => $spec_vs_val,
                                                      'user_vs_attr_ids' => $attr_id_arr]);

    }

    public function selfMediaInfo(Request $request)
    {
        $id = $request->user_id;
        $user = User::where('id',$id)->with('suppUserSelf')->first();
        if (empty($user)) {
            return back()->with('status', '不存在此用户');
        }
        \DB::beginTransaction();
        //更新属性分类关联表
        $spec = $request->spec;
        if (!$spec) {
            return back()->with('status','分类属性必须选择');
        }
        foreach ($spec as $key => $value) {
            SuppVsAttrModel::where('user_id', $user->id)
                            ->where('attr_id', $key)
                            ->update(['attr_value_id' => $value]);
        }
        //更新supp_users表
        //传图
        $media_logo = $request->file('media_logo');
        $index_logo = $request->file('index_logo');
        if ($media_logo) {
            if (!$request->file('media_logo')->isValid()) {
                return back()->with('status', '文件上传出错！');
            }
            $media_logo = $request->media_logo->store('supp_user');
        }
        if ($index_logo) {
            if (!$request->file('index_logo')->isValid()) {
                return back()->with('status', '文件上传出错！');
            }
            $index_logo = $request->index_logo->store('supp_user');
        }

        $supp_model = SuppUsersSelfModel::where('user_id',$id)->first();
        $supp_model->name = $user->name;
        $supp_model->media_name = !empty($request->input('media_name')) ? $request->input('media_name') : $supp_model->media_name;
        $supp_model->web_contact = !empty($request->web_contact) ? $request->web_contact : $supp_model->web_contact;
        if (!empty($media_logo)) {
            $supp_model->media_logo = '/uploads/'.$media_logo;
        }
        if (!empty($index_logo)) {
            $supp_model->index_logo = '/uploads/'.$index_logo;
        }

        if (!empty($request->input('proxy_price'))) {
            $supp_model->proxy_price = $request->input('proxy_price');
        }
        if (!empty($request->input('vip_price'))) {
            $supp_model->vip_price = $request->input('vip_price');
        }
        if (!empty($request->input('plate_price'))) {
            $supp_model->plate_price = $request->input('plate_price');
        }
        if (!empty($request->input('plate_rate'))) {
            $supp_model->plate_rate = $request->input('plate_rate');
        }
        if (!empty($request->input('vip_rate'))) {
            $supp_model->vip_rate = $request->input('vip_rate');
        }
        if (!empty($request->input('media_contact'))) {
            $supp_model->media_contact = $request->input('media_contact');
        }
        if (!empty($request->input('contact_phone'))) {
            $supp_model->contact_phone = $request->input('contact_phone');
        }
        if (!empty($request->input('email'))) {
            $supp_model->email = $request->input('email');
        }
        if (!empty($request->input('qq'))) {
            $supp_model->qq = $request->input('qq');
        }
        if (!empty($request->input('address'))) {
            $supp_model->address = $request->input('address');
        }
        if (!empty($request->input('zip_code'))) {
            $supp_model->zip_code = $request->input('zip_code');
        }
        if (!empty($request->input('remark'))) {
            $supp_model->remark = $request->input('remark');
        }
        if (!empty($request->input('is_state'))) {
            $supp_model->is_state = $request->input('is_state');
        }
        $tmp = $supp_model->save();
        if ($tmp) {
            \DB::commit();
            return redirect('/usermanager/selfMediaList')->with('status', '更新成功');
        } else {
            \DB::rollBack();
            return redirect('/usermanager/selfMediaList')->with('status', '更新失败');
        }
    }

    /**
     * 已选接单媒体列表
     * @return [type] [description]
     */
    public function selectOrderMedia(Request $request) {
        DB::enableQueryLog();
        $lists = SuppUsersModel::with(['childPlate', 'parentUser', 'user'])
                    ->leftJoin('order_network', 'order_network.supp_user_id', '=', 'supp_users.user_id')
                    ->where('supp_users.success_order', 1);
        if (!empty($request->keyword)) {
            $lists = $lists->where(function($query)use($request){
                $query->where('media_name', 'like', '%'.$request->keyword.'%')
                    ->orWhereIn('plate_id',function($query)use($request){
                        if (!empty($request->plate_id)) {
                            $query->from('plate')
                                    ->where('pid','=', $request->plate_id)
                                    ->where('plate_name', 'like', '%'.$request->keyword.'%')
                                    ->select('id')
                                    ->get();
                        } else {
                            $query->from('plate')
                                    ->where('pid','<>', 0)
                                    ->where('plate_name', 'like', '%'.$request->keyword.'%')
                                    ->select('id')
                                    ->get();
                        }
                    });
            });
        }
        if (!empty($request->start)) {
            $lists = $lists->where('supp_users.created_at', '>=', $request->start);
        }
        if (!empty($request->end)) {
            $lists = $lists->where('supp_users.created_at', '<=', $request->end);
        }
        if ($request->input('plate_id')) {
            $lists = $lists->where('plate_tid', $request->plate_id);
        }
        $plate_list = getSearchMediaSelect();

        $lists = $lists->select('*',DB::raw('count(order_network.id) as order_count'))
                    ->groupBy('supp_users.user_id')
                    ->get()
                    ->toArray();
        if ($request->get_excel == 1) {
            $this->getSelectOrderMediaMediaList($lists);
        }
        // dd(DB::getQueryLog());
        // dd($lists);
        return view('console.manager.select_order_media_list', [
                'lists' => $lists,
                'plate_list' => $plate_list
            ]);
    }
    
    public function mediaExcel()
    {
        $list = PlateModel::with('childPlate')->where('pid',0)->get()->toArray();
        // dd($list);
        return view('console.manager.media_excel', ['list' => $list]);
    }

    public function uploadSelfExcel(Request $request)
    {
        // 文件的上传处理
        $data = parent::uploadExcel($request->file);
        if ($data['status_code'] != 200) {
            return back()->with('status', '上传失败');
        }
        $file = $data['data']; // excel文件路径
        if ($request->upload_type == 1) { // 媒体
            $plate_tid = $request->plate_tid;
            $plate_id = $request->media_type[$plate_tid];
            // 规格的title整理
            $list = PlateAttrModel::with('attrVsVal')->where('plate_id', $plate_id)->get()->toArray();
            if (empty($list)) {
                return back()->with('status', '分类错误');
            }
            $attr = [];
            foreach ($list as $key => $spec) {
                $tmp = [];
                foreach ($spec['attr_vs_val'] as $kk => $val) {
                    $tmp[$val['attr_value']] = [$val['id'], $val['attr_id']];
                }
                $attr[$spec['attr_name']] = $tmp;
            }
            if ($request->media_ref == 1) { // 自营
                $res = $this->selfMediaExelSave($file, $attr, $plate_tid, $plate_id);
            } elseif ($request->media_ref == 2) { // 供应商
                $res = $this->suppMediaExelSave($file, $attr, $plate_tid, $plate_id);
            }
        } elseif ($request->upload_type == 2) { // 供应商
            $res = $this->suppExelSave($file);
        }
        if ($res['status_code'] == 200) {
            return redirect('/usermanager/mediaExcel')->with('status', '上传成功');
        } else {
            return back()->with('status', $res['msg']);
        }
    }

    /**
     * 自营媒体的excel处理
     * @param  [type] $file excel文件
     * @param  [type] $attr 规格title
     * @return [type]       [description]
     */
    public function selfMediaExelSave($file, $attr, $plate_tid, $plate_id)
    {
        $excel_data = \Excel::load('.'.$file, function($reader) {
            return $data = $reader->get();
        })->toArray();
        $pic = array_values(ExcelTools::excelFilePic($file));
        if (empty($pic)) {
            return ['status_code' => 201, 'msg' => '请添加对应图片资料'];
        }
        $excel_data = $excel_data['0'];
        $user_data = $spec_val = [];
        $i = -1;
        $j = 1;
        $is_state = ['在线' => 1, '下架' => '2', '审核' => 3];
        DB::enableQueryLog();
        try {
            foreach ($pic as $key => $value) {
                if (count($pic) < ($j * 2)) { // 2
                    break;
                }
                $tmp = ++$i;
                $tmp2 = ++$i;
                ++$j;
                if (empty($excel_data[$key]['媒体名称'])) {
                    break;
                }
                if (empty($excel_data[$key]['媒体名称']) || 
                    empty($excel_data[$key]['价格']) || 
                    empty($excel_data[$key]['平台价率']) || 
                    empty($excel_data[$key]['负责人']) || 
                    empty($excel_data[$key]['联系电话']) ||
                    empty($excel_data[$key]['电子邮箱']) || 
                    empty($excel_data[$key]['联系qq']) ||
                    empty($excel_data[$key]['联系地址']) || 
                    empty($excel_data[$key]['邮编']) ||
                    empty($excel_data[$key]['网站微博']) || 
                    empty($excel_data[$key]['媒体优势']) || 
                    empty($excel_data[$key]['会员价率'])
                    ) {
                    DB::rollBack();
                    return ['status_code' => 201, 'msg' => '个人资料的数据填写不齐全'];
                }
                if (empty($pic[$tmp]) || empty($pic[$tmp2])) {
                    DB::rollBack();
                    return ['status_code' => 201, 'msg' => '图片数据不齐全'];
                }
                
                if (empty($is_state[$excel_data[$key]['状态']])) {
                    DB::rollBack();
                    return ['status_code' => 201, 'msg' => '状态的数据填写错误'];
                }
                // dd($excel_data);
                // 写入到user表
                
                $user_id = DB::table('users')->insertGetId(
                    ['name' => $excel_data[$key]['媒体名称'].uniqid(),
                     'password' => bcrypt(env('pwd')),
                     'is_login' => 2, 
                     'is_show' => 1, 
                     'role_id' => 1, 'user_type' => 4,
                     'created_at' => date("Y-m-d H:i:s", time())]);
                \Log::info(['user_id_bin' => $user_id]);
                $user_data[] = [
                    'user_id' => $user_id,
                    'name' => $excel_data[$key]['媒体名称'],
                    'plate_tid' => $plate_tid,
                    'plate_id' => $plate_id,
                    'media_name' => $excel_data[$key]['媒体名称'],
                    'media_logo' => $pic[$tmp],
                    'index_logo' => $pic[$tmp2],
                    'proxy_price' => $excel_data[$key]['价格'],
                    'platform_price' => ($excel_data[$key]['平台价率'] / 100) * $excel_data[$key]['价格'] + $excel_data[$key]['价格'],
                    'media_contact' => $excel_data[$key]['负责人'],
                    'contact_phone' => $excel_data[$key]['联系电话'],
                    'email' => $excel_data[$key]['电子邮箱'],
                    'qq' => $excel_data[$key]['联系qq'],
                    'address' => $excel_data[$key]['联系地址'],
                    'zip_code' => $excel_data[$key]['邮编'],
                    'web_contact' => $excel_data[$key]['网站微博'],
                    'remark' => $excel_data[$key]['媒体优势'],
                    'is_state' => $is_state[$excel_data[$key]['状态']],
                    'created_at' => date('Y-m-d H:i:s', time()),
                    // 'company_name'
                    'vip_price' => ($excel_data[$key]['会员价率'] / 100) * $excel_data[$key]['价格'] + $excel_data[$key]['价格'],
                    'plate_price' => ($excel_data[$key]['平台价率'] / 100) * $excel_data[$key]['价格'] + $excel_data[$key]['价格'],
                    'vip_rate' => $excel_data[$key]['会员价率'],
                    'plate_rate' => $excel_data[$key]['平台价率'],
                    'created_at' => date("Y-m-d H:i:s", time())
                ];
                foreach ($attr as $attr_name => $value) {
                    if (empty($excel_data[$key][$attr_name])) {
                        DB::rollBack();
                        return ['status_code' => 201, 'msg' => '存在缺少的数据'];
                    }
                    if (empty($value[$excel_data[$key][$attr_name]]['0'])) {
                        DB::rollBack();
                        return ['status_code' => 201, 'msg' => '不存在该分类属性值'];
                    }
                    $spec_val[] = [
                        'user_id' => $user_id,
                        'attr_value_id' => $value[$excel_data[$key][$attr_name]]['0'],
                        'created_at' => date('Y-m-d H:i:s', time()),
                        'attr_id' => $value[$excel_data[$key][$attr_name]]['1'],
                        'created_at' => date("Y-m-d H:i:s", time()),
                    ];
                }
            }
        } catch (Exception $e) {
            return ['status_code' => 201, 'msg' => '错误'];
        }
        $tmp1 = SuppUsersSelfModel::insert($user_data);
        $tmp2 = SuppVsAttrModel::insert($spec_val);
        if ($tmp1 && $tmp2) {
            DB::commit();
            return ['status_code' => 200];
        } else {
            DB::rollBack();
            return ['status_code' => 201, 'msg' => '写入失败'];
        }

    }

    public function suppMediaExelSave($file, $attr, $plate_tid, $plate_id)
    {
        $excel_data = \Excel::load('.'.$file, function($reader) {
            return $data = $reader->get();
        })->toArray();
        $pic = array_values(ExcelTools::excelFilePic($file));
        $excel_data = $excel_data['0'];
        $user_data = $spec_val = [];
        $i = -1;
        $j = 1;
        $is_state = ['在线' => 1, '下架' => '2', '审核' => 3];
        DB::enableQueryLog();
        foreach ($pic as $key => $value) {
            if (count($pic) < ($j * 2)) { // 2
                    break;
            }
            ++$j;
            // $info = SuppUsersModel::where('name', $excel_data[$key]['供应商'])->first();
            $info = User::where('name', $excel_data[$key]['供应商'])->first();
            if (empty($info)) {
                DB::rollBack();
                return ['status_code' => 201, 'msg' => '存在不正确的供应商数据'];
            }
            $tmp = ++$i;
            $tmp2 = ++$i;
            if (empty($excel_data[$key]['媒体名称'])) {
                break;
            }
            if (empty($excel_data[$key]['媒体名称'])  || 
                empty($excel_data[$key]['价格']) || 
                empty($excel_data[$key]['负责人']) || empty($excel_data[$key]['联系电话']) ||
                empty($excel_data[$key]['电子邮箱']) || empty($excel_data[$key]['联系qq']) ||
                empty($excel_data[$key]['联系地址']) || empty($excel_data[$key]['邮编']) ||
                empty($excel_data[$key]['网站微博']) || empty($excel_data[$key]['媒体优势'])) {
                DB::rollBack();
                return ['status_code' => 201, 'msg' => '个人资料的数据填写不齐全'];
            }
            if (empty($is_state[$excel_data[$key]['状态']])) {
                DB::rollBack();
                return ['status_code' => 201, 'msg' => '状态的数据填写错误'];
            }
            if (empty($pic[$tmp]) || empty($pic[$tmp2])) {
                DB::rollBack();
                return ['status_code' => 201, 'msg' => '图片数据不齐全'];
            }
            // 写入到user表
            $user_id = DB::table('users')->insertGetId(
                ['name' => $excel_data[$key]['媒体名称'].uniqid(),
                 'password' => bcrypt(env('pwd')),
                 'is_login' => 2, 
                 'is_show' => 1, 
                 'role_id' => 1, 
                 'user_type' => 3,
                 'created_at' => date("Y-m-d H:i:s", time())]);
                
            $user_data[] = [
                'user_id' => $user_id,
                'name' => $excel_data[$key]['媒体名称'],
                'plate_tid' => $plate_tid,
                'plate_id' => $plate_id,
                'parent_id' => $info->id,
                'belong' => $info->id,
                'media_name' => $excel_data[$key]['媒体名称'],
                'media_logo' => $pic[$tmp],
                'index_logo' => $pic[$tmp2],
                'proxy_price' => $excel_data[$key]['价格'],
                'media_contact' => $excel_data[$key]['负责人'],
                'contact_phone' => $excel_data[$key]['联系电话'],
                'email' => $excel_data[$key]['电子邮箱'],
                'qq' => $excel_data[$key]['联系qq'],
                'address' => $excel_data[$key]['联系地址'],
                'zip_code' => $excel_data[$key]['邮编'],
                'web_contact' => $excel_data[$key]['网站微博'],
                'remark' => $excel_data[$key]['媒体优势'],
                'is_state' => $is_state[$excel_data[$key]['状态']],
                'created_at' => date('Y-m-d H:i:s', time()),
            ];
            foreach ($attr as $attr_name => $value) {
                if (empty($excel_data[$key][$attr_name])) {
                    DB::rollBack();
                    return ['status_code' => 201, 'msg' => '存在缺少的数据'];
                }
                if (empty($value[$excel_data[$key][$attr_name]]['0'])) {
                    DB::rollBack();
                    return ['status_code' => 201, 'msg' => '不存在该分类属性值'];
                }
                $spec_val[] = [
                    'user_id' => $user_id,
                    'attr_value_id' => $value[$excel_data[$key][$attr_name]]['0'],
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'attr_id' => $value[$excel_data[$key][$attr_name]]['1'],
                    'created_at' => date("Y-m-d H:i:s", time())
                ];
            }

        }
        $tmp1 = SuppUsersModel::insert($user_data);
        $tmp2 = SuppVsAttrModel::insert($spec_val);
        if ($tmp1 && $tmp2) {
            DB::commit();
            return ['status_code' => 200];
        } else {
            DB::rollBack();
            return ['status_code' => 201, 'msg' => '写入失败'];
        }
    }

    public function suppExelSave($file)
    {
        $excel_data = \Excel::load('.'.$file, function($reader) {
            return $data = $reader->get();
        })->toArray();
        $pic = array_values(ExcelTools::excelFilePic($file));
        $excel_data = $excel_data['0'];
        $user_data = [];
        $i = -1;
        $is_state = ['在线' => 1, '下架' => '2', '审核' => 3];
        DB::enableQueryLog();
        $pic_num = count($pic);
        foreach ($pic as $key => $value) {
            if ($i >= ($pic_num / 3)) {
                break;
            }
            $name = $excel_data[$key]['登录用户名'];
            $info = User::where('name', $name)->first();
            if (!empty($info)) {
                $info = User::where('name', $excel_data[$key]['联系电话'])->first();
                if (!empty($info)) {
                    $name = $name.uniqid();
                } else {
                    $name = $excel_data[$key]['联系电话'];
                }
            }
            // 写入到user表
            $user_id = DB::table('users')->insertGetId(
                ['name' => $name.uniqid(),
                 'password' => bcrypt(env('pwd')),
                 'is_login' => 1, 
                 'is_show' => 1, 
                 'role_id' => 1, 
                 'user_type' => 3,
                 'created_at' => date("Y-m-d H:i:s", time())]);
                
            $user_data[] = [
                'user_id' => $user_id,
                'name' => $excel_data[$key]['供应商名称'],
                'plate_tid' => 0,
                'plate_id' => 0,
                'parent_id' => 0,
                'media_name' => $excel_data[$key]['供应商名称'],
                'media_logo' => $pic[++$i],
                'index_logo' => $pic[++$i],
                'media_check_file' => $pic[++$i],
                'proxy_price' => 0,
                'media_contact' => $excel_data[$key]['负责人'],
                'contact_phone' => $excel_data[$key]['联系电话'],
                'email' => $excel_data[$key]['电子邮箱'],
                'qq' => $excel_data[$key]['联系qq'],
                'address' => $excel_data[$key]['联系地址'],
                'zip_code' => $excel_data[$key]['邮编'],
                'breif' => $excel_data[$key]['供应商简介'],
                'remark' => $excel_data[$key]['备注'],
                'is_state' => $is_state[$excel_data[$key]['状态']],
                'created_at' => date('Y-m-d H:i:s', time()),
            ];
        }
        $tmp1 = SuppUsersModel::insert($user_data);
        if ($tmp1) {
            DB::commit();
            return ['status_code' => 200];
        } else {
            DB::rollBack();
            return ['status_code' => 201, 'msg' => '写入失败'];
        }
    }
}





