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

    const FILE_SIZE_LIMIT = 2048;// 文件大小
    const FILE_OBJ_NAME = 'avatar';//
    const FILE_TYPE_EXTS = '*.gif;*.jpg;*.png;*.jpeg';
    const REMOVE_TIMEOUT = 1; //
    const UPLOAD_LIMIT = 999; //
    const QUEUE_SIZE_LIMIT = 5; //
    const MULTI = 'false';//
    const AUTO = 'true';//

}