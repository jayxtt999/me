<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/3 0003
 * Time: 下午 4:54
 */

namespace Admin\Config\Type;


class Avatar extends \System\Library\statusGateway
{

    const FILE_SIZE_LIMIT = 2048;//允许您上传的文件的最大数量
    const FILE_OBJ_NAME = 'avatar';//文件上传对象的name值 默认是：Filedata , PHP服务端用 $_FILES['Filedata']
    const FILE_TYPE_EXTS = '*.gif; *.jpg; *.png; *.jpeg';//允许上传的扩展名  在文件浏览窗口，将只显示这些扩展名文件,用户可以直接输入文件，来绕过此检查，php服务端还需要检查
    const REMOVE_TIMEOUT = 1; //上传完成后自动关闭时间
    const UPLOAD_LIMIT = 999; //允许您上传的文件的最大数量
    const QUEUE_SIZE_LIMIT = 5; //队列长度限制
    const MULTI = 'false';//一次选择多个文件，默认true
    const AUTO = 'true';//选择文件后自动上传

}