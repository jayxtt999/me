<?
namespace System\Library\View\TpTemplate;
/**
 * 扒自tp 模板引擎
 * Class TpTemplate
 */
class TpTemplate{
    //便于smarty 引擎切换
    public $template_dir;
    public $cache_path;
    public $template_suffix;
    public $cache_suffix;
    public $tmpl_cache;
    public $cache_time;
    public $taglib_begin;
    public $taglib_end;
    public $tmpl_end;
    public $default_tmpl;
    public $layout_item;
    public $tmpl_engine_type;
    public $tmpl_cachfile_suffix;
    public $tmpl_deny_php;
    public $tmpl_l_delim;
    public $tmpl_r_delim;
    public $tmpl_strip_space;

    public $config;
    protected $tVar = array();

    function __construct(){

        $this->config =array(
            'cache_path'=>$this->cache_path,
            'cache_suffix'=>$this->cache_suffix,
            'cache_path'=>$this->cache_path,
            'taglib_begin'=>$this->taglib_begin,
            'taglib_end'=>$this->taglib_end,
            'template_suffix'=>$this->template_suffix,
            'taglib_begin'=>$this->taglib_begin,
            'tmpl_deny_php'=>$this->tmpl_deny_php,
            'tmpl_begin'=>$this->tmpl_l_delim,
            'tmpl_end'=>$this->tmpl_r_delim,
            'tmpl_strip_space'=>$this->tmpl_strip_space,
        );
    }

    public function assign($key, $value){
        if (is_array($key)) {
            $this->tVar = array_merge($this->tVar, $key);
        } else {
            $this->tVar[$key] = $value;
        }


    }


    public function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '')
    {
        $content = $this->fetch($templateFile.$this->template_suffix, $content, $prefix);
        $this->render($content, $charset, $contentType);
    }
    public function fetch($templateFile = '', $content = '', $prefix = '')
    {
        if (empty($content)) {
            $templateFile = $this->parseTemplate($templateFile);
            if (!is_file($templateFile)){
                die("模板文件".$templateFile."不存在");
            }
        }
        ob_start();
        ob_implicit_flush(0);
        if ('php' == strtolower($this->tmpl_engine_type)) {
            extract($this->tVar, EXTR_OVERWRITE);
            empty($content) ? include $templateFile : eval('?>' . $content);
        } else {
            $params = array('var' => $this->tVar, 'file' => $templateFile, 'content' => $content, 'prefix' => $prefix);
            $this->ParseTemplateBehavior($params);
        }

        $content = ob_get_clean();
        tag('view_filter', $content);
        return $content;
    }
    //return path
    public function parseTemplate($template = '')
    {
       return $this->template_dir."/".$template;
    }

    function ParseTemplateBehavior($_data){
        $_content = empty($_data['content']) ? $_data['file'] : $_data['content'];
        $_data['prefix'] = !empty($_data['prefix']) ? $_data['prefix'] : '';
        if ((!empty($_data['content']) && $this->checkContentCache($_data['content'], $_data['prefix'])) || $this->checkCache($_data['file'], $_data['prefix'])) {
            extract($_data['var'], EXTR_OVERWRITE);
            include $this->cache_path ."/". $_data['prefix'] . md5($_content) .$this->tmpl_cachfile_suffix;
        } else {
            require_once 'ThinkTemplate/ThinkTemplate.class.php';
            $tpl = new ThinkTemplate();
            $tpl->config = $this->config;
            $tpl->fetch($_content, $_data['var'], $_data['prefix']);
        }
    }

    function checkContentCache($tmplContent, $prefix = '')
    {
        if (is_file($this->cache_path. $prefix . md5($tmplContent) .$this->tmpl_cachfile_suffix)) {
            return true;
        } else {
            return false;
        }
    }

    protected function checkCache($tmplTemplateFile, $prefix = '')
    {
        $tmplCacheFile = $this->cache_path . $prefix . md5($tmplTemplateFile) .$this->tmpl_cachfile_suffix;
        if (!is_file($tmplCacheFile)) {
            return false;
        } elseif (filemtime($tmplTemplateFile) > filemtime($tmplCacheFile)) {
            return false;
        } elseif ($this->tmpl_cache_time != 0 && time() > filemtime($tmplCacheFile) + $this->tmpl_cache_time) {
            return false;
        }

        return true;
    }


}



