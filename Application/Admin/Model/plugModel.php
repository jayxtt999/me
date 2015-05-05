<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/5 0005
 * Time: 下午 4:41
 */

namespace Admin\Model;


class plugModel  extends \System\Core\Model{


    public function getPlugins(){

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
                            if ($subFile == $file.'.php') {
                                $pluginFiles[] = "$file/$subFile";
                            }
                        }
                    }
                }
            }
        }else{
            return array();
        }
        sort($pluginFiles);

        var_dump($pluginFiles);exit;

        foreach ($pluginFiles as $pluginFile) {

            $pluginData = $this->getPluginData("$pluginPath/$pluginFile");
            if (empty($pluginData['Name'])) {
                continue;
            }
            $pluginsAll[$pluginFile] = $pluginData;
        }
        return $pluginsAll;


    }

    public function getPluginData($pluginFile){

        echo 111;exit;
        $pluginData = implode('', file($pluginFile));
        preg_match("/Plugin Name:(.*)/i", $pluginData, $plugin_name);
        preg_match("/Version:(.*)/i", $pluginData, $version);
        preg_match("/Plugin URL:(.*)/i", $pluginData, $plugin_url);
        preg_match("/Description:(.*)/i", $pluginData, $description);
        preg_match("/Author:(.*)/i", $pluginData, $author_name);
        preg_match("/Author URL:(.*)/i", $pluginData, $author_url);

        $plugin_name = isset($plugin_name[1]) ? trim($plugin_name[1]) : '';
        $version = isset($version[1]) ? $version[1] : '';
        $description = isset($description[1]) ? $description[1] : '';
        $plugin_url = isset($plugin_url[1]) ? trim($plugin_url[1]) : '';
        $author = isset($author_name[1]) ? trim($author_name[1]) : '';
        $author_url = isset($author_url[1]) ? trim($author_url[1]) : '';

        return array(
            'Name' => $plugin_name,
            'Version' => $version,
            'Description' => $description,
            'Url' => $plugin_url,
            'Author' => $author,
            'AuthorUrl' => $author_url,
        );


        
    }



} 