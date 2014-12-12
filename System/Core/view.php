<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-30
 * Time: 上午11:01
 */

class View {

    public static $view;
    public static $error;
    public static $config;
    public static $assignData = array();
    public static  $routeUrl;

    /**
     * 初始化
     * @param $type
     */
    public static  function init($type) {
        if(self::$view){
            return self::$view;
        }
        if(!empty($type)){
            require_once SYS_LIB_PATH.'/View/'.ucfirst($type).'/'.ucfirst($type).'.class.php';
            $types = ucfirst($type);
            self::$view =  new $types;
            self::$config = Application::$appConfig['view'][$type];
            $ro = Application::$appLib['route'];
            self::$routeUrl = $ro::$routeUrl;
            if(self::$routeUrl['module'] == "admin"){
                self::$config['template_dir'] = APP_TEMP_PATH."/system";
            }
            //smarty
            /*foreach(self::$config as $key=>$value){
                self::$view -> $key = $value;
            }*/
            //mytemp
            self::$view->init(self::$config);

        }else{
            self::$error->show("模版解析模式不能为空！");
        }
    }

    /**
     * 模板变量
     * @param $data
     * @return $this
     */
    public  function assign($data){
        self::$assignData  = array_merge(self::$assignData,$data);
        return $this;
    }

    /**
     * 加载模板
     * @param null $template
     */
    public  function display($template=null){
        //$template = isset($template)?self::$routeUrl['module']."/".self::$routeUrl['controller']."_".$template.'.html':self::$routeUrl['module']."_".self::$routeUrl['controller'].'.html';
        //m:c:a or index
        if(isset($template)){
            $pos = strpos($template,":");
            if($pos){
                $tArr = explode(":",$template);
                if(count($tArr)==3){
                    $template = $tArr[0]."/".$tArr[1]."_".$tArr[2];
                }else{
                    self::$error->show($template."格式错误，必须为 M:C:A");
                }
            }else{

                $template = self::$routeUrl['module']."/".self::$routeUrl['controller']."_".$template;
                echo $template;exit;

            }
        }else{

                $template = self::$routeUrl['module']."/".self::$routeUrl['controller']."_".self::$routeUrl['action'];
        }
        if(is_array(self::$assignData)){
            foreach(self::$assignData as $key=>$value){
                self::$view->assign($key, $value);
            }
        }
        self::$view->display($template);
    }



}