<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-30
 * Time: 上午11:01
 */
namespace System\Core;
class View
{

    public static $view;
    public static $error;
    public static $config;
    public static $assignData = array();
    public static $routeUrl;

    /**
     * 初始化
     * @param $type
     */
    public static function init($type)
    {
        if (self::$view) {
            return self::$view;
        }
        if (!empty($type)) {
            $types = "\\System\\Library\\View\\" . ucfirst($type) . "\\" . ucfirst($type);
            self::$view = new $types;
            self::$config = \Application::$appConfig['view'][$type];
            $ro = \Application::$appLib['route'];
            self::$routeUrl = $ro::$routeUrl;
            if (self::$routeUrl['module'] == "admin") {
                self::$config['template_dir'] = APP_TEMP_PATH . "/system";
            }
            self::$view->init(self::$config);

        } else {
            return exception("模版解析模式不能为空！");
        }
    }

    /**
     * 模板变量
     * @param $data
     * @return $this
     */
    public function assign($data)
    {
        self::$assignData = array_merge(self::$assignData, $data);
    }

    /**
     * 加载模板
     * @param null $template
     */
    public function display($template = null, $isPath = false)
    {
        //$template = isset($template)?self::$routeUrl['module']."/".self::$routeUrl['controller']."_".$template.'.html':self::$routeUrl['module']."_".self::$routeUrl['controller'].'.html';
        //m:c:a or index
        if (is_array(self::$assignData)) {
            foreach (self::$assignData as $key => $value) {
                self::$view->assign($key, $value);
            }
        }
        //如果直接 ：分割 传入路径 不解析模型 应用于common
        if ($isPath) {
            self::$view->display($template);
            exit;
        }
        if (isset($template)) {
            $pos = strpos($template, ":");
            if ($pos) {
                $tArr = explode(":", $template);
                if (count($tArr) == 3) {
                    $template = $tArr[0] . "/" . $tArr[1] . "_" . $tArr[2];
                } else {
                    return exception($template . "格式错误，必须为 M:C:A！");
                }
            } else {
                $template = self::$routeUrl['module'] . "/" . self::$routeUrl['controller'] . "_" . $template;
            }
        } else {
            $template = self::$routeUrl['module'] . "/" . self::$routeUrl['controller'] . "_" . self::$routeUrl['action'];
        }
        self::$view->display($template);
    }


    // 模板变量获取和设置
    public function get($name) {
        return self::$assignData[$name];
    }

    public function set($name,$value) {
        self::$assignData[$name] = $value;
    }

    public function log($id){

        return "/index.php?m=home&c=blog&a=show&id=".$id;
    }

}