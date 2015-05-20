<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/5 0005
 * Time: 下午 4:39
 */

namespace Admin\Controller;


class plugController extends abstractController
{

    public function indexAction()
    {

        $plugNewAll = array();
        $plugModel = new \Admin\Model\plugModel();
        $plugLocAll = $plugModel->getPlugins();
        $plugDb = db()->table('plugs')->getAll()->done();

        foreach ($plugDb as $k => $v) {
            $plugAll[$v['name']] = $v;
            $plugAll[$v['name']]['isInstall'] = true;
        }

        $arr = array_diff_assoc($plugLocAll, $plugAll);

        if ($arr) {
            $plugAll = array_merge($plugAll, $arr);
        }
        $config = new \Admin\Model\webConfigModel();
        $data = array(
            'plugAll' => $plugAll,
            'plugHooKConfig' => C("plugs_hook"),
        );

        $this->getView()->assign($data);

        return $this->getView()->display();

    }

    /**
     * 安装插件
     */
    public function installAction()
    {

        $name = post("val", "txt");
        //检查插件是否存在
        $class = getPlugClass($name);
        if (!class_exists($class)) {
            JsonObject(array('status' => false, 'msg' => '插件不存在'));
        }
        //检查插件是否完整
        $plug = new $class;
        $info = $plug->info;
        if (!$info || !$plug->checkInfo()) {
            //检测信息的正确性
            JsonObject(array('status' => false, 'msg' => '插件信息缺失'));
        }
        //预安装，有些插件需要操作数据库..
        $install_flag = $plug->install();
        if (!$install_flag) {
            JsonObject(array('status' => false, 'msg' => '插件预安装操作失败'));
        }
        //保存插件信息 && 更新钩子
        try {
            db()->beginTransaction();
            //获取插件配置信息
            $config = $plug->getConfig() ? serialize(array('config' => json_encode($plug->getConfig()))) : "";
            $info['name'] = strtolower($info['name']);
            $info['config'] = $config;
            $info['crate_time'] = date("Y-m-d H:i:s");
            db()->table('plugs')->insert($info)->done();
            $hookModel = new \Admin\Model\hookModel();
            $r = $hookModel->updateHooks($name);
            if ($r) {
                db()->commit();
                JsonObject(array('status' => true, 'msg' => "安装成功"));
            } else {
                db()->rollBack();
                JsonObject(array('status' => false, 'msg' => "安装失败"));
            }
            //更新钩子信息


        } catch (\Exception $e) {
            db()->rollBack();
        }

    }


    /**
     * 卸载插件
     */
    public function uninstallAction()
    {

        $id = post("val", "int");
        $row = db()->table("plugs")->getRow(array("id" => $id))->done();
        $hookModel = new \Admin\Model\hookModel();
        if (!$row) {
            JsonObject(array('status' => false, 'msg' => "插件不存在"));
        }
        $class = getPlugClass($row['name']);
        if (!class_exists($class)) {
            JsonObject(array('status' => false, 'msg' => '插件文件缺失,卸载失败'));
        }
        $plugs = new $class;
        $uninstall_flag = $plugs->uninstall();
        if (!$uninstall_flag) {
            JsonObject(array('status' => false, 'msg' => '执行插件预卸载操作失败'));
        }
        db()->beginTransaction();
        $r1 = db()->table("plugs")->delete(array("id" => $id))->done();
        $r2 = $hookModel->removeHooks($row['name']);
        if ($r1 && $r2) {
            $this->deletePlugDir($row['name']);
            //db()->commit();
            JsonObject(array('status' => true, 'msg' => '卸载成功'));

        } else {
            db()->rollBack();
            JsonObject(array('status' => false, 'msg' => '卸载失败'));
        }
    }

    /**
     * 删除插件文件
     * @param $name
     * @return bool
     */
    public function deletePlugDir($name)
    {
        $dir = PLUGIN_PATH . ucfirst(trim($name));
        return deletePlugDir($dir);
    }

    /**
     * 禁用插件
     */
    public function unableAction()
    {

        $id = post("val", "int");
        $row = db()->table("plugs")->getRow(array('id' => $id))->done();
        if (!$row) {
            JsonObject(array('status' => false, 'msg' => "禁用失败,插件不存在"));
        }
        if ($row['status'] == \Admin\Plug\Type\Status::STATUS_UNABLE) {
            JsonObject(array('status' => true, 'msg' => "已禁用"));
        }
        $r = db()->table("plugs")->upDate(array('status' => \Admin\Plug\Type\Status::STATUS_UNABLE), array('id' => $id))->done();
        $hookModel = new \Admin\Model\hookModel();
        JsonObject(array('status' => true, 'msg' => "已禁用"));
    }

    /**
     * 开启插件
     */
    public function enableAction()
    {

        $id = post("val", "int");
        $row = db()->table("plugs")->getRow(array('id' => $id))->done();
        if (!$row) {
            JsonObject(array('status' => false, 'msg' => "开启失败,插件不存在"));
        }
        if ($row['status'] == \Admin\Plug\Type\Status::STATUS_ENABLE) {
            JsonObject(array('status' => true, 'msg' => "已开启"));
        }
        $r = db()->table("plugs")->upDate(array('status' => \Admin\Plug\Type\Status::STATUS_ENABLE), array('id' => $id))->done();
        $hookModel = new \Admin\Model\hookModel();

        JsonObject(array('status' => true, 'msg' => "已开启"));
    }

    /**
     * 插件设置
     */
    public function settingAction()
    {
        $id = get("id", "int");
        if (!$id) {
            return $this->link()->error("参数错误");
        }
        $plug = db()->table("plugs")->getRow(array('id' => $id))->done();
        if (!$plug) {
            return $this->link()->error("插件未安装");
        }
        $plugClass = getPlugClass($plug['name']);
        if (!class_exists($plugClass)) {
            trace("插件{$plug['name']}无法实例化,", 'ADDONS', 'ERR');
        }
        $data = new $plugClass;
        $dbConfig = $plug['config'];
        $plug['config'] = include $data->config_file;
        if ($dbConfig) {
            $dbConfig = json_decode($dbConfig, true);
            foreach ($plug['config'] as $key => $value) {
                if ($value['type'] != 'group') {
                    $plug['config'][$key]['value'] = $dbConfig[$key];
                } else {
                    foreach ($value['options'] as $gourp => $options) {
                        foreach ($options['options'] as $gkey => $value) {
                            $plug['config'][$key]['options'][$gourp]['options'][$gkey]['value'] = $dbConfig[$gkey];
                        }
                    }
                }
            }
        }
        $this->getView()->assign(array('data' => $plug, 'id' => $id));
        $this->getView()->display();
    }


    /**
     * 保存设置
     */
    public function settingSaveAction()
    {
        $id = post("id", "int");
        $config = post("config", "txt");
        $flag = db()->table('plugs')->upDate(array('config' => json_encode($config)), array('id' => $id))->done();
        if ($flag !== false) {
            return $this->link()->success('/index.php?m=admin&c=plug&a=index', "保存成功");
        } else {
            return $this->link()->error("保存失败");
        }
    }


    public function addAction()
    {

        $form = new \Admin\Plug\Form\addForm(); //获取表单
        $form->start('plugAdd'); //开始渲染

        $this->getView()->assign(array('form' => $form));
        return $this->getView()->display();

    }


    public function previewAction()
    {


        $name = post("name", "txt");
        $title = post("title", "txt");
        $version = post("version", "txt");
        $author = post("author", "txt");
        $description = post("description", "txt");
        $enable = post("enable", "txt") == "info" ? 1 : 0;
        $isConfigVal = post("isConfig", "txt") == "info" ? trim(post("isConfigVal", "txt")) : "";
        $isAdminList = post("isAdminList", "txt") == "info" ? trim(post("isAdminListVal", "txt")) : "";
        $hookName = post("hookName", "txt");
        $tpl = <<<str
&#60;?php
    /*
     *@plugin 示例插件
     *@author 无名氏
     */
    namespace Content\Plugins\{$name};
    use \Admin\Plug\Plugin as Plugin;
    class {$name}Plugin extends Plugin{

         public \$info = array(
            'name'=>'{$name}',
            'title'=>'{$title}',
            'description'=>'{$description}',
            'status'=>{$enable},
            'author'=>'{$author}',
            'version'=>'{$version}'

        );

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }
str;
        foreach($hookName as $v){
            $tpl .= <<<str

        //实现的{$v}钩子方法
        public function {$v}(\$param)
        {

        }
str;
        }

        $tpl .= <<<str
        //实现后台管理方法
        public function adminList(){

            {$isAdminList}

        }
str;
        $tpl.=<<<str

    }
str;

          exit("<pre style='background-color:black;color:white'>".$tpl."</pre>");

    }


}