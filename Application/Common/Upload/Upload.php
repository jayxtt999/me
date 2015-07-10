<?php
/**
 * Created by PhpStorm.
 * User: xiett
 * Date: 15-7-8
 * Time: 下午9:28
 */

namespace Common\Upload;


class  Upload
{

    private $uploader;
    private $driver;
    private $driverConfig;
    private $error = ''; //上传错误信息

    /*   private $error = array( //上传状态映射表，国际化用户需考虑此处数据的国际化
            "SUCCESS", //上传成功标记，在UEditor中内不可改变，否则flash判断会出错
            "文件大小超出 upload_max_filesize 限制",
            "文件大小超出 MAX_FILE_SIZE 限制",
            "文件未被完整上传",
            "没有文件被上传",
            "上传文件为空",
            "ERROR_TMP_FILE" => "临时文件错误",
            "ERROR_TMP_FILE_NOT_FOUND" => "找不到临时文件",
            "ERROR_TMPFILE" => "上传异常非POST",
            "ERROR_SIZE_EXCEED" => "文件大小超出网站限制",
            "ERROR_TYPE_NOT_ALLOWED" => "文件类型不允许",
            "ERROR_CREATE_DIR" => "目录创建失败",
            "ERROR_DIR_NOT_WRITEABLE" => "目录没有写权限",
            "ERROR_FILE_MOVE" => "文件保存时出错",
            "ERROR_FILE_NOT_FOUND" => "找不到上传文件",
            "ERROR_WRITE_CONTENT" => "写入文件内容错误",
            "ERROR_UNKNOWN" => "未知错误",
            "ERROR_DEAD_LINK" => "链接不可用",
            "ERROR_HTTP_LINK" => "链接不是http链接",
            "ERROR_HTTP_CONTENTTYPE" => "链接contentType不正确"
        );*/

    private $uploadMethodsConfig = array();

    private $config = array(

        'rootPath' => '/Data/upload', //保存根路径
        /* 上传图片配置项 */
        "imageActionName" => "uploadimage", /* 执行上传图片的action名称 */
        "imageMaxSize" => 2048000, /* 上传大小限制，单位B */
        "imageAllowFiles" => array(".png", ".jpg", ".jpeg", ".gif", ".bmp"), /* 上传图片格式显示 */
        "imageCompressEnable" => true, /* 是否压缩图片,默认是true */
        "imageCompressBorder" => 1600, /* 图片压缩最长边限制 */
        "imageInsertAlign" => "none", /* 插入的图片浮动方式 */
        "imageUrlPrefix" => "", /* 图片访问路径前缀 */
        "imagePathFormat" => "/Data/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
        /* {filename} 会替换成原文件名,配置这项需要注意中文乱码问题 */
        /* {rand:6} 会替换成随机数,后面的数字是随机数的位数 */
        /* {time} 会替换成时间戳 */
        /* {yyyy} 会替换成四位年份 */
        /* {yy} 会替换成两位年份 */
        /* {mm} 会替换成两位月份 */
        /* {dd} 会替换成两位日期 */
        /* {hh} 会替换成两位小时 */
        /* {ii} 会替换成两位分钟 */
        /* {ss} 会替换成两位秒 */
        /* 非法字符 \ => * ? " < > | */

        /* base64编码上传配置项 */
        "scrawlActionName" => "uploadscrawl", /* 执行上传涂鸦的action名称 */
        "scrawlPathFormat" => "/Data/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "scrawlMaxSize" => 2048000, /* 上传大小限制，单位B */
        "scrawlUrlPrefix" => "", /* 图片访问路径前缀 */
        "scrawlInsertAlign" => "none",

        /* 抓取远程图片配置 */
        "catcherLocalDomain" => array("127.0.0.1", "localhost", "img.baidu.com"),
        "catcherActionName" => "catchimage", /* 执行抓取远程图片的action名称 */
        "catcherFieldName" => "source", /* 提交的图片列表表单名称 */
        "catcherPathFormat" => "/Data/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "catcherUrlPrefix" => "", /* 图片访问路径前缀 */
        "catcherMaxSize" => 2048000, /* 上传大小限制，单位B */
        "catcherAllowFiles" => array(".png", ".jpg", ".jpeg", ".gif", ".bmp"), /* 抓取图片格式显示 */


        /* 上传视频配置 */
        "videoActionName" => "uploadvideo", /* 执行上传视频的action名称 */
        "videoPathFormat" => "/Data/upload/video/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "videoUrlPrefix" => "", /* 视频访问路径前缀 */
        "videoMaxSize" => 102400000, /* 上传大小限制，单位B，默认100MB */
        "videoAllowFiles" => array(
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid"), /* 上传视频格式显示 */

        /* 上传文件配置 */
        "fileActionName" => "uploadfile", /* controller里,执行上传视频的action名称 */
        "filePathFormat" => "/Data/upload/file/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
        "fileUrlPrefix" => "", /* 文件访问路径前缀 */
        "fileMaxSize" => 51200000, /* 上传大小限制，单位B，默认50MB */
        "fileAllowFiles" => array(
            ".png", ".jpg", ".jpeg", ".gif", ".bmp",
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
            ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso",
            ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml"
        ), /* 上传文件格式显示 */



        /*'mimes' => array(), //允许上传的文件MiMe类型
        'maxSize' => 0, //上传的文件大小限制 (0-不做限制)
        'exts' => array(), //允许上传的文件后缀
        'autoSub' => true, //自动子目录保存文件
        'subName' => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => './Uploads/', //保存根路径
        'savePath' => '', //保存路径
        'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt' => '', //文件保存后缀，空则使用原后缀
        'replace' => false, //存在同名是否覆盖
        'hash' => true, //是否生成hash编码
        'callback' => false, //检测文件是否存在回调，如果存在返回文件信息数组
        'driver' => '', // 文件上传驱动
        'driverConfig' => array(), // 上传驱动配置*/
    );


    /**
     * 构造方法，用于构造上传实例
     * @param array $config 配置
     * @param string $driver 要使用的上传驱动 LOCAL-本地上传驱动，FTP-FTP上传驱动
     */
    public function __construct($config = array(), $driver = '', $driverConfig = null)
    {
        //$Upload = new \Think\Upload($setting);
        //$info = $Upload->upload($_FILES);
        /* 设置上传驱动 */
        $driver = $driver ? $driver : C("upload_type");
        $this->config = array_merge($this->config, $config);
        $this->setDriver($driver, $driverConfig);
    }

    /**
     * 使用 $this->name 获取配置
     * @param  string $name 配置名称
     * @return multitype    配置值
     */
    public function __get($name)
    {
        return $this->config[$name];
    }

    public function __set($name, $value)
    {
        if (isset($this->config[$name])) {
            $this->config[$name] = $value;
            if ($name == 'driverConfig') {
                //改变驱动配置后重置上传驱动
                //注意：必须选改变驱动然后再改变驱动配置
                $this->setDriver();
            }
        }
    }

    public function __isset($name)
    {
        return isset($this->config[$name]);
    }

    /**
     * 设置上传驱动
     * @param string $driver 驱动名称
     * @param array $config 驱动配置
     */
    private function setDriver($driver = null, $driverConfig = array())
    {
        $this->driver = $driver;
        $this->driverConfig = $driverConfig;
        $className = "\\System\\Library\\Upload\\" . ucfirst($driver) . "\\" . ucfirst($driver);
        $this->uploader = new $className($driverConfig);
        if (!$this->uploader) {
            E("不存在上传驱动：$className");
        }
    }


    public function upload($files = '',$type="",$uploadType="uploadfile")
    {
        switch ($uploadType) {
            case 'uploadimage':
                $this->uploadMethodsConfig = array(
                    "pathFormat" => $this->config['imagePathFormat'],
                    "maxSize" => $this->config['imageMaxSize'],
                    "allowFiles" => $this->config['imageAllowFiles']
                );
                break;
            case 'uploadscrawl':
                $this->uploadMethodsConfig = array(
                    "pathFormat" => $this->config['scrawlPathFormat'],
                    "maxSize" => $this->config['scrawlMaxSize'],
                    "allowFiles" => $this->config['scrawlAllowFiles'],
                    "oriName" => "scrawl.png"
                );
                break;
            case 'uploadvideo':
                $this->uploadMethodsConfig = array(
                    "pathFormat" => $this->config['videoPathFormat'],
                    "maxSize" => $this->config['videoMaxSize'],
                    "allowFiles" => $this->config['videoAllowFiles']
                );
                break;
            case 'uploadfile':
            default:
            $this->uploadMethodsConfig = array(
                    "pathFormat" => $this->config['filePathFormat'],
                    "maxSize" => $this->config['fileMaxSize'],
                    "allowFiles" => $this->config['fileAllowFiles']
                );
                break;
        }
        if ("" === $files) {
            $files = $_FILES;
        }
        if (empty($files)) {
            $this->error = '找不到上传文件！';
            return false;
        }

        /*找不到上传根目录*/
        if(!$this->checkRootPath($this->config['rootPath'])){
            $this->error = "找不到上传根目录".$this->config['rootPath'].",请新建后重试";
            return false;
        }


        /* 检查上传目录 */
        preg_match("/\(/.*?\){/",$this->uploadMethodsConfig['pathFormat'],$results);
        if($results[0]){
            $this->savePath = ROOT_PATH.$results[0];
        }else{
            $this->error = "上传目录未被设置";
        }

        if(!$this->uploader->checkSavePath($this->savePath)){
            $this->error = $this->uploader->getError();
            return false;
        }

        /* 逐个检测并上传文件 */
        $info    =  array();
        if(function_exists('finfo_open')){
            $finfo   =  finfo_open ( FILEINFO_MIME_TYPE );
        }
        // 对上传文件数组信息处理
        $files   =  $this->dealFiles($files);
        foreach ($files as $key => $file) {





        }



      /*  if ($type == "remote") {
            $this->saveRemote($files);
        } else if($type == "base64") {
            $this->upBase64($files);
        } else {
            $this->upFile($files);
        }

        $this->error = '文件类型不允许！';
        return;*/

    }


    public function upFile($files){




    }


    /**
     * 验证上传根目录是否存在
     * @param $rooPath
     * @return mixed
     */
    public function checkRootPath($rooPath){

        return $this->uploader->checkRootPath($rooPath);

    }




}