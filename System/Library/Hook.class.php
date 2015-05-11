<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/8 0008
 * Time: ���� 3:38
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
     * ������ǩ�Ĳ��
     * @param string $tag ��ǩ����
     * @param mixed $params �������
     * @return void
     */
    public static function listen($tag, &$params = NULL)
    {
        if (isset(self::$tags[$tag])) {
            if (APP_DEBUG) {
                G($tag . 'Start');
                trace('[ ' . $tag . ' ] --START--', '', 'INFO');
            }
            foreach (self::$tags[$tag] as $name) {
                APP_DEBUG && G($name . '_start');
                $result = self::exec($name, $tag, $params);
                if (APP_DEBUG) {
                    G($name . '_end');
                    trace('Run ' . $name . ' [ RunTime:' . G($name . '_start', $name . '_end', 6) . 's ]', '', 'INFO');
                }
                if (false === $result) {
                    // �������false ���жϲ��ִ��
                    return;
                }
            }
            if (APP_DEBUG) { // ��¼��Ϊ��ִ����־
                trace('[ ' . $tag . ' ] --END-- [ RunTime:' . G($tag . 'Start', $tag . 'End', 6) . 's ]', '', 'INFO');
            }
        }

        return;
    }


    /**
     * ִ��ĳ�����
     * @param string $name �������
     * @param string $tag ����������ǩ����
     * @param Mixed $params ����Ĳ���
     * @return void
     */
    static public function exec($name, $tag, &$params = NULL)
    {
        //$s = new \Content\Plugins\Trace\TracePlugin();
        //$s->appBegin();exit;
        $plugClass = "\\Content\\Plugins\\Trace\\".$name."Plugin";
        $plug = new $plugClass();
        return $plug->$tag($params);
    }

}