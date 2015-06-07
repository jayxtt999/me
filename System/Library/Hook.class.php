<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/8 0008
 * Time: 下午 3:38
 */

namespace System\Library;


class Hook
{

    static private $tags = array();


    public static function setTags($tags)
    {
        self::$tags = $tags;
    }

    /**
     * 监听标签的插件
     * @param string $tag 标签名称
     * @param mixed $params 传入参数
     * @return void
     */
    public static function listen($tag, &$params = NULL)
    {
        if (isset(self::$tags[$tag])) {
            if (APP_DEBUG) {
                G($tag . 'Start');
                \System\Core\Error::trace('[ ' . $tag . ' ] --START--', '', 'INFO');
            }
            foreach (self::$tags[$tag] as $name) {


                APP_DEBUG && G($name . '_start');
                $result = self::exec($name, $tag, $params);
                if (APP_DEBUG) {
                    G($name . '_end');
                    \System\Core\Error::trace('Run ' . $name . ' [ RunTime:' . G($name . '_start', $name . '_end', 6) . 's ]', '', 'INFO');
                }
                if (false === $result) {
                    // 如果返回false 则中断插件执行
                    return;
                }
            }
            if (APP_DEBUG) { // 记录行为的执行日志
                \System\Core\Error::trace('[ ' . $tag . ' ] --END-- [ RunTime:' . G($tag . 'Start', $tag . 'End', 6) . 's ]', '', 'INFO');
            }
        }

        return;
    }


    /**
     * 执行某个插件
     * @param string $name 插件名称
     * @param string $tag 方法名（标签名）
     * @param Mixed $params 传入的参数
     * @return void
     */
    static public function exec($name, $tag, &$params = NULL)
    {
        //$s = new \Content\Plugins\Trace\TracePlugin();
        //$s->appBegin();exit;
        $plugClass = "\\Content\\Plugins\\".ucfirst($name)."\\".ucfirst($name)."Plugin";
        $plug = new $plugClass();
        return $plug->$tag($params);
    }

}