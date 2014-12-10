<?


class TpTemplate{

    public  $template_dir;
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

    protected $tVar = array();

    public function assign($key, $value){

        if (is_array($key)) {
            $this->tVar = array_merge($this->tVar, $key);
        } else {
            $this->tVar[$key] = $value;
        }


    }


    public function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '')
    {

        $content = $this->fetch($templateFile, $content, $prefix);

        $this->render($content, $charset, $contentType);
    }

    public function fetch($templateFile = '', $content = '', $prefix = '')
    {

        if (empty($content)) {
            $templateFile = $this->parseTemplate($templateFile);
            if (!is_file($templateFile)) throw_exception(L('_TEMPLATE_NOT_EXIST_') . '[' . $templateFile . ']');
        }

        ob_start();
        ob_implicit_flush(0);
        if ('php' == strtolower(C('TMPL_ENGINE_TYPE'))) {
            extract($this->tVar, EXTR_OVERWRITE);
            empty($content) ? include $templateFile : eval('?>' . $content);
        } else {
            $params = array('var' => $this->tVar, 'file' => $templateFile, 'content' => $content, 'prefix' => $prefix);
            tag('view_parse', $params);
        }

        $content = ob_get_clean();
        tag('view_filter', $content);
        return $content;
    }



    public function parseTemplate($template = '')
    {
        $app_name = APP_NAME == basename(dirname($_SERVER['SCRIPT_FILENAME'])) && '' == __APP__ ? '' : APP_NAME . '/';
        if (is_file($template)) {
            $group = defined('GROUP_NAME') ? GROUP_NAME . '/' : '';
            $theme = C('DEFAULT_THEME');
            if (1 == C('APP_GROUP_MODE')) {
                define('THEME_PATH', dirname(BASE_LIB_PATH) . '/' . $group . basename(TMPL_PATH) . '/' . $theme);
                define('APP_TMPL_PATH', __ROOT__ . '/' . $app_name . C('APP_GROUP_PATH') . '/' . $group . basename(TMPL_PATH) . '/' . $theme);
            } else {
                define('THEME_PATH', TMPL_PATH . $group . $theme);
                define('APP_TMPL_PATH', __ROOT__ . '/' . $app_name . basename(TMPL_PATH) . '/' . $group . $theme);
            }
            return $template;
        }
        $depr = C('TMPL_FILE_DEPR');
        $template = str_replace(':', $depr, $template);
        $theme = $this->getTemplateTheme();
        $group = defined('GROUP_NAME') ? GROUP_NAME . '/' : '';
        if (defined('GROUP_NAME') && strpos($template, '@')) {
            list($group, $template) = explode('@', $template);
            $group .= '/';
        }
        if (1 == C('APP_GROUP_MODE')) {
            define('THEME_PATH', dirname(BASE_LIB_PATH) . '/' . $group . basename(TMPL_PATH) . '/' . $theme);
            define('APP_TMPL_PATH', __ROOT__ . '/' . $app_name . C('APP_GROUP_PATH') . '/' . $group . basename(TMPL_PATH) . '/' . $theme);
        } else {
            define('THEME_PATH', TMPL_PATH . $group . $theme);
            define('APP_TMPL_PATH', __ROOT__ . '/' . $app_name . basename(TMPL_PATH) . '/' . $group . $theme);
        }
        if ('' == $template) {
            $template = MODULE_NAME . $depr . ACTION_NAME;
        } elseif (false === strpos($template, '/')) {
            $template = MODULE_NAME . $depr . $template;
        }
        return THEME_PATH . $template . C('TMPL_TEMPLATE_SUFFIX');
    }







}