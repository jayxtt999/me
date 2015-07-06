<?php
/**
 * Created by PhpStorm.
 * User: xiett
 * Date: 15-7-6
 * Time: ����10:09
 */
namespace System\Library\Upload\Local;

class Local {

    protected $fileField; //�ļ�����
    protected $file; //�ļ��ϴ�����
    protected $base64; //�ļ��ϴ�����
    protected  $config; //������Ϣ
    protected $oriName; //ԭʼ�ļ���
    protected $fileName; //���ļ���
    protected $fullName; //�����ļ���,���ӵ�ǰ����Ŀ¼��ʼ��URL
    protected $filePath; //�����ļ���,���ӵ�ǰ����Ŀ¼��ʼ��URL
    protected $fileSize; //�ļ���С
    protected $fileType; //�ļ�����
    protected $stateInfo; //�ϴ�״̬��Ϣ,
    protected $stateMap = array( //�ϴ�״̬ӳ������ʻ��û��迼�Ǵ˴����ݵĹ��ʻ�
        "SUCCESS", //�ϴ��ɹ���ǣ���UEditor���ڲ��ɸı䣬����flash�жϻ����
        "�ļ���С���� upload_max_filesize ����",
        "�ļ���С���� MAX_FILE_SIZE ����",
        "�ļ�δ�������ϴ�",
        "û���ļ����ϴ�",
        "�ϴ��ļ�Ϊ��",
        "ERROR_TMP_FILE" => "��ʱ�ļ�����",
        "ERROR_TMP_FILE_NOT_FOUND" => "�Ҳ�����ʱ�ļ�",
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
    );


    public function getConfig(){

        return \System\Library\Upload\Local\Config::getConfig();
    }




} 