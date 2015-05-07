<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/5 0005
 * Time: 下午 4:41
 */

namespace Admin\Model;


class plugModel  extends \System\Core\Model{

    /**
     * 获取文件夹插件列表
     * @return array
     */
    public function getPlugins(){
        $pluginFiles = array();
        $pluginDir = @dir(PLUGIN_PATH);
        if ($pluginDir) {
            while(($file = $pluginDir->read()) !== false) {
                if (preg_match('|^\.+$|', $file)) {
                    continue;
                }
                if (is_dir(PLUGIN_PATH . '/' . $file)) {
                    $pluginsSubDir = @ dir(PLUGIN_PATH . '/' . $file);
                    if ($pluginsSubDir) {
                        while(($subFile = $pluginsSubDir->read()) !== false) {
                            if (preg_match('|^\.+$|', $subFile)) {
                                continue;
                            }
                            if (strtolower($subFile) == strtolower($file.'plugin.class.php')) {
                                $pluginFiles[] = strtolower($file);
                            }
                        }
                    }
                }
            }
        }else{
            return array();
        }
        foreach ($pluginFiles as $k=>$v) {
            $pluginData = getPluginData($v);
            if (empty($pluginData['name'])) {
                continue;
            }
            $pluginsAll[$v] = $pluginData;
        }
        return $pluginsAll;


    }






} 