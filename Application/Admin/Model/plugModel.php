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
        $pluginPath = ROOT_PATH . '/content/plugins';
        $pluginDir = @dir($pluginPath);
        if ($pluginDir) {
            while(($file = $pluginDir->read()) !== false) {
                if (preg_match('|^\.+$|', $file)) {
                    continue;
                }
                if (is_dir($pluginPath . '/' . $file)) {
                    $pluginsSubDir = @ dir($pluginPath . '/' . $file);
                    if ($pluginsSubDir) {
                        while(($subFile = $pluginsSubDir->read()) !== false) {
                            if (preg_match('|^\.+$|', $subFile)) {
                                continue;
                            }
                            if (strtolower($subFile) == strtolower($file.'plugin.class.php')) {
                                $pluginFiles[strtolower($file)] = "\\Content\\Plugins\\".$file."\\".$file."Plugin";
                            }
                        }
                    }
                }
            }
        }else{
            return array();
        }
        foreach ($pluginFiles as $k=>$class) {
            $pluginData = $this->getPluginData($class);
            if (empty($pluginData['name'])) {
                continue;
            }
            $pluginsAll[$k] = $pluginData;
        }
        return $pluginsAll;


    }

    /**
     * 获取插件信息
     * @param $pluginClassName
     * @return mixed
     */
    public function getPluginData($pluginClassName){

        $plug = new $pluginClassName;
        return $plug->info;

    }



} 