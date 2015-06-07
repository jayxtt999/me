<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/3 0003
 * Time: ���� 4:54
 */

namespace Admin\Config\Type;


class Images extends \System\Library\statusGateway
{

    const FILE_SIZE_LIMIT = 2048;
    const FILE_OBJ_NAME = 'thumbnail';//
    const FILE_TYPE_EXTS = '*.gif;*.jpg;*.png;*.jpeg';

}