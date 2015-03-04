<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/3 0003
 * Time: ���� 4:54
 */

namespace Admin\Config\Type;


class Avatar extends \System\Library\statusGateway
{

    const FILE_SIZE_LIMIT = 2048;//�������ϴ����ļ����������
    const FILE_OBJ_NAME = 'avatar';//�ļ��ϴ������nameֵ Ĭ���ǣ�Filedata , PHP������� $_FILES['Filedata']
    const FILE_TYPE_EXTS = '*.gif;*.jpg;*.png;*.jpeg';//�����ϴ�����չ��  ���ļ�������ڣ���ֻ��ʾ��Щ��չ���ļ�,�û�����ֱ�������ļ������ƹ�˼�飬php����˻���Ҫ���
    const REMOVE_TIMEOUT = 1; //�ϴ���ɺ��Զ��ر�ʱ��
    const UPLOAD_LIMIT = 999; //�������ϴ����ļ����������
    const QUEUE_SIZE_LIMIT = 5; //���г�������
    const MULTI = 'false';//һ��ѡ�����ļ���Ĭ��true
    const AUTO = 'true';//ѡ���ļ����Զ��ϴ�

}