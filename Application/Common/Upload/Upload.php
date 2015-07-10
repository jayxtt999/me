<?php
/**
 * Created by PhpStorm.
 * User: xiett
 * Date: 15-7-8
 * Time: ����9:28
 */

namespace Common\Upload;


class  Upload
{

    private $uploader;
    private $driver;
    private $driverConfig;
    private $error = ''; //�ϴ�������Ϣ

    /*   private $error = array( //�ϴ�״̬ӳ������ʻ��û��迼�Ǵ˴����ݵĹ��ʻ�
            "SUCCESS", //�ϴ��ɹ���ǣ���UEditor���ڲ��ɸı䣬����flash�жϻ����
            "�ļ���С���� upload_max_filesize ����",
            "�ļ���С���� MAX_FILE_SIZE ����",
            "�ļ�δ�������ϴ�",
            "û���ļ����ϴ�",
            "�ϴ��ļ�Ϊ��",
            "ERROR_TMP_FILE" => "��ʱ�ļ�����",
            "ERROR_TMP_FILE_NOT_FOUND" => "�Ҳ�����ʱ�ļ�",
            "ERROR_TMPFILE" => "�ϴ��쳣��POST",
            "ERROR_SIZE_EXCEED" => "�ļ���С������վ����",
            "ERROR_TYPE_NOT_ALLOWED" => "�ļ����Ͳ�����",
            "ERROR_CREATE_DIR" => "Ŀ¼����ʧ��",
            "ERROR_DIR_NOT_WRITEABLE" => "Ŀ¼û��дȨ��",
            "ERROR_FILE_MOVE" => "�ļ�����ʱ����",
            "ERROR_FILE_NOT_FOUND" => "�Ҳ����ϴ��ļ�",
            "ERROR_WRITE_CONTENT" => "д���ļ����ݴ���",
            "ERROR_UNKNOWN" => "δ֪����",
            "ERROR_DEAD_LINK" => "���Ӳ�����",
            "ERROR_HTTP_LINK" => "���Ӳ���http����",
            "ERROR_HTTP_CONTENTTYPE" => "����contentType����ȷ"
        );*/

    private $uploadMethodsConfig = array();

    private $config = array(

        'rootPath' => '/Data/upload', //�����·��
        /* �ϴ�ͼƬ������ */
        "imageActionName" => "uploadimage", /* ִ���ϴ�ͼƬ��action���� */
        "imageMaxSize" => 2048000, /* �ϴ���С���ƣ���λB */
        "imageAllowFiles" => array(".png", ".jpg", ".jpeg", ".gif", ".bmp"), /* �ϴ�ͼƬ��ʽ��ʾ */
        "imageCompressEnable" => true, /* �Ƿ�ѹ��ͼƬ,Ĭ����true */
        "imageCompressBorder" => 1600, /* ͼƬѹ��������� */
        "imageInsertAlign" => "none", /* �����ͼƬ������ʽ */
        "imageUrlPrefix" => "", /* ͼƬ����·��ǰ׺ */
        "imagePathFormat" => "/Data/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* �ϴ�����·��,�����Զ��屣��·�����ļ�����ʽ */
        /* {filename} ���滻��ԭ�ļ���,����������Ҫע�������������� */
        /* {rand:6} ���滻�������,������������������λ�� */
        /* {time} ���滻��ʱ��� */
        /* {yyyy} ���滻����λ��� */
        /* {yy} ���滻����λ��� */
        /* {mm} ���滻����λ�·� */
        /* {dd} ���滻����λ���� */
        /* {hh} ���滻����λСʱ */
        /* {ii} ���滻����λ���� */
        /* {ss} ���滻����λ�� */
        /* �Ƿ��ַ� \ => * ? " < > | */

        /* base64�����ϴ������� */
        "scrawlActionName" => "uploadscrawl", /* ִ���ϴ�Ϳѻ��action���� */
        "scrawlPathFormat" => "/Data/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* �ϴ�����·��,�����Զ��屣��·�����ļ�����ʽ */
        "scrawlMaxSize" => 2048000, /* �ϴ���С���ƣ���λB */
        "scrawlUrlPrefix" => "", /* ͼƬ����·��ǰ׺ */
        "scrawlInsertAlign" => "none",

        /* ץȡԶ��ͼƬ���� */
        "catcherLocalDomain" => array("127.0.0.1", "localhost", "img.baidu.com"),
        "catcherActionName" => "catchimage", /* ִ��ץȡԶ��ͼƬ��action���� */
        "catcherFieldName" => "source", /* �ύ��ͼƬ�б������ */
        "catcherPathFormat" => "/Data/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* �ϴ�����·��,�����Զ��屣��·�����ļ�����ʽ */
        "catcherUrlPrefix" => "", /* ͼƬ����·��ǰ׺ */
        "catcherMaxSize" => 2048000, /* �ϴ���С���ƣ���λB */
        "catcherAllowFiles" => array(".png", ".jpg", ".jpeg", ".gif", ".bmp"), /* ץȡͼƬ��ʽ��ʾ */


        /* �ϴ���Ƶ���� */
        "videoActionName" => "uploadvideo", /* ִ���ϴ���Ƶ��action���� */
        "videoPathFormat" => "/Data/upload/video/{yyyy}{mm}{dd}/{time}{rand:6}", /* �ϴ�����·��,�����Զ��屣��·�����ļ�����ʽ */
        "videoUrlPrefix" => "", /* ��Ƶ����·��ǰ׺ */
        "videoMaxSize" => 102400000, /* �ϴ���С���ƣ���λB��Ĭ��100MB */
        "videoAllowFiles" => array(
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid"), /* �ϴ���Ƶ��ʽ��ʾ */

        /* �ϴ��ļ����� */
        "fileActionName" => "uploadfile", /* controller��,ִ���ϴ���Ƶ��action���� */
        "filePathFormat" => "/Data/upload/file/{yyyy}{mm}{dd}/{time}{rand:6}", /* �ϴ�����·��,�����Զ��屣��·�����ļ�����ʽ */
        "fileUrlPrefix" => "", /* �ļ�����·��ǰ׺ */
        "fileMaxSize" => 51200000, /* �ϴ���С���ƣ���λB��Ĭ��50MB */
        "fileAllowFiles" => array(
            ".png", ".jpg", ".jpeg", ".gif", ".bmp",
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
            ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso",
            ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml"
        ), /* �ϴ��ļ���ʽ��ʾ */



        /*'mimes' => array(), //�����ϴ����ļ�MiMe����
        'maxSize' => 0, //�ϴ����ļ���С���� (0-��������)
        'exts' => array(), //�����ϴ����ļ���׺
        'autoSub' => true, //�Զ���Ŀ¼�����ļ�
        'subName' => array('date', 'Y-m-d'), //��Ŀ¼������ʽ��[0]-��������[1]-�������������ʹ������
        'rootPath' => './Uploads/', //�����·��
        'savePath' => '', //����·��
        'saveName' => array('uniqid', ''), //�ϴ��ļ���������[0]-��������[1]-�������������ʹ������
        'saveExt' => '', //�ļ������׺������ʹ��ԭ��׺
        'replace' => false, //����ͬ���Ƿ񸲸�
        'hash' => true, //�Ƿ�����hash����
        'callback' => false, //����ļ��Ƿ���ڻص���������ڷ����ļ���Ϣ����
        'driver' => '', // �ļ��ϴ�����
        'driverConfig' => array(), // �ϴ���������*/
    );


    /**
     * ���췽�������ڹ����ϴ�ʵ��
     * @param array $config ����
     * @param string $driver Ҫʹ�õ��ϴ����� LOCAL-�����ϴ�������FTP-FTP�ϴ�����
     */
    public function __construct($config = array(), $driver = '', $driverConfig = null)
    {
        //$Upload = new \Think\Upload($setting);
        //$info = $Upload->upload($_FILES);
        /* �����ϴ����� */
        $driver = $driver ? $driver : C("upload_type");
        $this->config = array_merge($this->config, $config);
        $this->setDriver($driver, $driverConfig);
    }

    /**
     * ʹ�� $this->name ��ȡ����
     * @param  string $name ��������
     * @return multitype    ����ֵ
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
                //�ı��������ú������ϴ�����
                //ע�⣺����ѡ�ı�����Ȼ���ٸı���������
                $this->setDriver();
            }
        }
    }

    public function __isset($name)
    {
        return isset($this->config[$name]);
    }

    /**
     * �����ϴ�����
     * @param string $driver ��������
     * @param array $config ��������
     */
    private function setDriver($driver = null, $driverConfig = array())
    {
        $this->driver = $driver;
        $this->driverConfig = $driverConfig;
        $className = "\\System\\Library\\Upload\\" . ucfirst($driver) . "\\" . ucfirst($driver);
        $this->uploader = new $className($driverConfig);
        if (!$this->uploader) {
            E("�������ϴ�������$className");
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
            $this->error = '�Ҳ����ϴ��ļ���';
            return false;
        }

        /*�Ҳ����ϴ���Ŀ¼*/
        if(!$this->checkRootPath($this->config['rootPath'])){
            $this->error = "�Ҳ����ϴ���Ŀ¼".$this->config['rootPath'].",���½�������";
            return false;
        }


        /* ����ϴ�Ŀ¼ */
        preg_match("/\(/.*?\){/",$this->uploadMethodsConfig['pathFormat'],$results);
        if($results[0]){
            $this->savePath = ROOT_PATH.$results[0];
        }else{
            $this->error = "�ϴ�Ŀ¼δ������";
        }

        if(!$this->uploader->checkSavePath($this->savePath)){
            $this->error = $this->uploader->getError();
            return false;
        }

        /* �����Ⲣ�ϴ��ļ� */
        $info    =  array();
        if(function_exists('finfo_open')){
            $finfo   =  finfo_open ( FILEINFO_MIME_TYPE );
        }
        // ���ϴ��ļ�������Ϣ����
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

        $this->error = '�ļ����Ͳ�����';
        return;*/

    }


    public function upFile($files){




    }


    /**
     * ��֤�ϴ���Ŀ¼�Ƿ����
     * @param $rooPath
     * @return mixed
     */
    public function checkRootPath($rooPath){

        return $this->uploader->checkRootPath($rooPath);

    }




}