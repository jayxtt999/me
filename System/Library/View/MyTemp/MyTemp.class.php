<?php
namespace System\Library\View\MyTemp;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/12/11 0011
 * Time: 上午 10:32
 */

class  Factory{
    public static  $myTemp;
    public static  $taglibcx;

    public static function setMyTemp($class){
        self::$myTemp  =  $class;
    }

    public static function getMyTemp(){
        return self::$myTemp;
    }

    public static function setTagLibCx($class){
        self::$taglibcx  =  $class;
    }

    public static function getTagLibCx(){
        return self::$taglibcx;
    }


}


class MyTemp {

    public $templateFile;
    public $config;
    protected $tVar = array();
    private $literal = array();

    public function init($config){
        $this->config = $config;
        Factory::setMyTemp($this);
        Factory::setMyTemp($this);
        Factory::setTagLibCx(new TagLibCx());
    }


    // 模板变量获取和设置
    public function get($name) {
        if(isset($this->tVar[$name]))
            return $this->tVar[$name];
        else
            return false;
    }

    public function set($name,$value) {
        $this->tVar[$name]= $value;
    }

    public function assign($key, $value){
        if (is_array($key)) {
            $this->tVar = array_merge($this->tVar, $key);
        } else {
            $this->tVar[$key] = $value;
        }
    }


    public function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '/')
    {
        $content = $this->fetch($templateFile, $content, $prefix);
        $this->render($content, $charset, $contentType);
    }

    public function fetch($templateFile = '', $content = '', $prefix = '')
    {
        if (empty($content)) {
            $templateFile = $this->parseTemplate($templateFile);
            if (!is_file($templateFile)){
                exception("模板文件".$templateFile."不存在");
            }
        }
        ob_start();
        ob_implicit_flush(0);
        if ('php' == strtolower($this->config['tmpl_engine_type'])) {
            extract($this->tVar, EXTR_OVERWRITE);
            empty($content) ? include $templateFile : eval('?>' . $content);
        } else {
            $params = array('var' => $this->tVar, 'file' => $templateFile, 'content' => $content, 'prefix' => $prefix);
            $this->ParseTemplateBehavior($params);
        }

        $content = ob_get_clean();
        $this->ContentReplaceBehavior($content);
        return $content;
    }

    private function render($content, $charset = '', $contentType = '')
    {

        if (empty($charset)) $charset = "utf-8";
        if (empty($contentType)) $contentType = "text/html";
        header('Content-Type:' . $contentType . '; charset=' . $charset);
        header('Cache-control: ' . "private");
        header('X-Powered-By:XTT');
        echo $content;
    }


    //return path
    public function parseTemplate($template = '')
    {
        return $this->config['template_dir']."/".$template.$this->config['template_suffix'];
    }

    function ParseTemplateBehavior($_data){
        $_content = empty($_data['content']) ? $_data['file'] : $_data['content'];
        $_data['prefix'] = !empty($_data['prefix']) ? $_data['prefix'] : '';
        if ((!empty($_data['content']) && $this->checkContentCache($_data['content'], $_data['prefix'])) || $this->checkCache($_data['file'], $_data['prefix'])) {
            extract($_data['var'], EXTR_OVERWRITE);
            include $this->cache_path ."/". $_data['prefix'] . md5($_content) .$this->tmpl_cachfile_suffix;
        } else {
            $this->Myfetch($_content, $_data['var'], $_data['prefix']);
        }
    }

    protected function ContentReplaceBehavior($content)
    {
        $replace = array();
        if (is_array($this->config['tmpl_parse_string'])) $replace = array_merge($replace,$this->config['tmpl_parse_string']);
        $content = str_replace(array_keys($replace), array_values($replace), $content);
        return $content;
    }



    function checkContentCache($tmplContent, $prefix = '')
    {
        if (is_file($this->config['cache_path']. $prefix . md5($tmplContent) .$this->config['tmpl_cachfile_suffix'])) {
            return true;
        } else {
            return false;
        }
    }

    protected function checkCache($tmplTemplateFile, $prefix = '')
    {
        $tmplCacheFile = $this->config['cache_path'] . $prefix . md5($tmplTemplateFile) .$this->config['tmpl_cachfile_suffix'];
        if (!is_file($tmplCacheFile)) {
            return false;
        } elseif (filemtime($tmplTemplateFile) > filemtime($tmplCacheFile)) {
            return false;
        } elseif ($this->config['tmpl_cache_time'] != 0 && time() > filemtime($tmplCacheFile) + $this->config['tmpl_cache_time']) {
            return false;
        }

        return true;
    }


    function  Myfetch($templateFile,$templateVar,$prefix='') {

        $this->tVar         =   $templateVar;
        $templateCacheFile  =   $this->loadTemplate($templateFile,$prefix);
        // 模板阵列变量分解成为独立变量
        extract($templateVar, EXTR_OVERWRITE);
        //载入模版缓存文件
        include $templateCacheFile;
    }



    /**
     * 加载主模板并缓存
     * @access public
     * @param string $tmplTemplateFile 模板文件
     * @param string $prefix 模板标识前缀
     * @return string
     * @throws ThinkExecption
     */
    public function loadTemplate ($tmplTemplateFile,$prefix='') {
        if(is_file($tmplTemplateFile)) {
            $this->templateFile    =  $tmplTemplateFile;
            // 读取模板文件内容
            $tmplContent =  file_get_contents($tmplTemplateFile);
        }else{
            $tmplContent =  $tmplTemplateFile;
        }

        // 根据模版文件名定位缓存文件
        $tmplCacheFile = $this->config['cache_path'].$prefix.md5($tmplTemplateFile).$this->config['cache_suffix'];

        // 编译模板内容
        $tmplContent =  $this->compiler($tmplContent);
        // 检测模板目录
        $dir         =  dirname($tmplCacheFile);
        if(!is_dir($dir))
            mkdir($dir,0755,true);
        //重写Cache文件
        if( false === file_put_contents($tmplCacheFile,trim($tmplContent)))
            die('_CACHE_WRITE_ERROR_'.':'.$tmplCacheFile);

        return $tmplCacheFile;
    }



    /**
     * 模板解析入口
     * 支持普通标签和TagLib解析 支持自定义标签库
     * @access public
     * @param string $content 要解析的模板内容
     * @return string
     */
    public function parse($content) {
        // 内容为空不解析
        if(empty($content)) return '';
        $begin      =   $this->config['taglib_begin'];
        $end        =   $this->config['taglib_end'];
        // 检查include语法
        $content    =   $this->parseInclude($content);
        // 检查PHP语法
        $content    =   $this->parsePhp($content);
        // 首先替换literal标签内容
        //$content    =   preg_replace('/'.$begin.'literal'.$end.'(.*?)'.$begin.'\/literal'.$end.'/eis',"\$this->parseLiteral('\\1')",$content);

        if($this->config['taglib_load']) {
            $this->getIncludeTagLib($content);
            if(!empty($this->tagLib)) {
                // 对导入的TagLib进行解析
                foreach($this->tagLib as $tagLibName) {
                    $this->parseTagLib($tagLibName,$content);
                }
            }
        }

        $this->parseTagLib('cx',$content,true);
        //解析普通模板标签 {tagName}
        $content = preg_replace('/('.$this->config['tmpl_begin'].')([^\d\s'.$this->config['tmpl_begin'].$this->config['tmpl_end'].'].+?)('.$this->config['tmpl_end'].')/eis',"\$this->parseTag('\\2')",$content);
        return $content;
    }

    /**
     * 编译模板文件内容
     * @access protected
     * @param mixed $tmplContent 模板内容
     * @return string
     */

    function compiler($tmplContent) {
        //模板解析
        $tmplContent =  $this->parse($tmplContent);
        // 还原被替换的Literal标签
        $tmplContent =  preg_replace_callback('/<!--###literal(\d+)###-->/',function($r){return $this->restoreLiteral($r[1]);},$tmplContent);
        // 添加安全代码
        $tmplContent =  '<?php if (!defined(\'BLOG_TOKEN\')) exit();?>'.$tmplContent;
        if($this->config['tmpl_strip_space']) {
            /* 去除html空格与换行 */
            $find           = array('~>\s+<~','~>(\s+\n|\r)~');
            $replace        = array('><','>');
            $tmplContent    = preg_replace($find, $replace, $tmplContent);
        }

        // 优化生成的php代码
        $tmplContent = str_replace('?><?php','',$tmplContent);

        return $this->strip_whitespace($tmplContent);
        
    }



    // 解析模板中的include标签
     function parseInclude($content) {
        // 解析继承
        $content    =   $this->parseExtend($content);
        // 解析布局
        //$content    =   $this->parseLayout($content);

        // 读取模板中的include标签
        $find       =   preg_match_all('/'.$this->config['taglib_begin'].'include\s(.+?)\s*?\/'.$this->config['taglib_end'].'/is',$content,$matches);

        if($find) {
            for($i=0;$i<$find;$i++) {
                $include    =   $matches[1][$i];
                $array      =   $this->parseXmlAttrs($include);
                $file       =   $array['file'];
                unset($array['file']);
                $content    =   str_replace($matches[0][$i],$this->parseIncludeItem($file,$array),$content);
            }
        }

        return $content;
    }


    /**
     * 加载公共模板并缓存 和当前模板在同一路径，否则使用相对路径
     * @access private
     * @param string $tmplPublicName  公共模板文件名
     * @param array $vars  要传递的变量列表
     * @return string
     */
    private function parseIncludeItem($tmplPublicName,$vars=array()){
        // 分析模板文件名并读取内容
        $parseStr = $this->parseTemplateName($tmplPublicName);
        // 替换变量
        foreach ($vars as $key=>$val) {
            $parseStr = str_replace('['.$key.']',$val,$parseStr);
        }
        // 再次对包含文件进行模板分析
        return $this->parseInclude($parseStr);
    }


    /**
     * 分析加载的模板文件并读取内容 支持多个模板文件读取
     * @access private
     * @param string $tmplPublicName  模板文件名
     * @return string
     */
    private function parseTemplateName($templateName){
        $array  =   explode(',',$templateName);
        $parseStr   =   '';
        foreach ($array as $templateName){
            if(strpos($templateName,'@')){
                $tempArr = explode("@",$templateName);
                if(count($tempArr)!==3){
                    die("Error");
                }
                $templateName =  $this->config['template_dir']."/".$tempArr[0]."/".$tempArr[1]."_".$tempArr[2].$this->config['template_suffix'];
                $parseStr .= file_get_contents($templateName);
            }else{
                $templateName =  $this->config['template_dir']."/".Route::$routeUrl['module']."/".Route::$routeUrl['controller']."_".$templateName.$this->config['template_suffix'];
                $parseStr .= file_get_contents($templateName);
            }
        }
        return $parseStr;
    }

    /**
     * 分析XML属性
     * @access private
     * @param string $attrs  XML属性字符串
     * @return array
     */
    private function parseXmlAttrs($attrs) {
        $xml        =   '<tpl><tag '.$attrs.' /></tpl>';
        $xml        =   simplexml_load_string($xml);
        if(!$xml)
            throw_exception(L('_XML_TAG_ERROR_'));
        $xml        =   (array)($xml->tag->attributes());
        $array      =   array_change_key_case($xml['@attributes']);
        return $array;
    }

    // 解析模板中的extend标签
     function parseExtend($content) {
        $begin      =   $this->config['taglib_begin'];
        $end        =   $this->config['taglib_end'];

        // 读取模板中的继承标签
        $find       =   preg_match('/'.$begin.'extend\s(.+?)\s*?\/'.$end.'/is',$content,$matches);
        if($find) {
            //替换extend标签
            $content    =   str_replace($matches[0],'',$content);
            // 记录页面中的block标签
            preg_replace('/'.$begin.'block\sname=(.+?)\s*?'.$end.'(.*?)'.$begin.'\/block'.$end.'/eis',"\$this->parseBlock('\\1','\\2')",$content);
            // 读取继承模板
            $array      =   $this->parseXmlAttrs($matches[1]);
            $content    =   $this->parseTemplateName($array['name']);
            // 替换block标签
            $content    =   preg_replace('/'.$begin.'block\sname=(.+?)\s*?'.$end.'(.*?)'.$begin.'\/block'.$end.'/eis',"\$this->replaceBlock('\\1','\\2')",$content);
        }else{
            //$content    =   preg_replace('/'.$begin.'block\sname=(.+?)\s*?'.$end.'(.*?)'.$begin.'\/block'.$end.'/eis',"stripslashes('\\2')",$content);
            $content    =   preg_replace_callback('/'.$begin.'block\sname=[\'"](.+?)[\'"]\s*?'.$end.'(.*?)'.$begin.'\/block'.$end.'/is', function($match){return stripslashes($match[2]);}, $content);
        }
        return $content;
    }


    // 检查PHP语法
    protected function parsePhp($content) {
        if(ini_get('short_open_tag')){
            // 开启短标签的情况要将<?标签用echo方式输出 否则无法正常输出xml标识
            $content = preg_replace('/(<\?(?!php|=|$))/i', '<?php echo \'\\1\'; ?>'."\n", $content );
        }
        // PHP语法检查
        if($this->config['tmpl_deny_php'] && false !== strpos($content,'<?php')) {
            die('_NOT_ALLOW_PHP_');
        }
        return $content;
    }


    /**
     * 模板标签解析
     * 格式： {TagName:args [|content] }
     * @access public
     * @param string $tagStr 标签内容
     * @return string
     */
    protected function parseTag($tagStr){
        $tagStr = stripslashes($tagStr);
        if(preg_match('/^[\s|\d]/is',$tagStr))
            //过滤空格和数字打头的标签
            return $this->config['tmpl_l_delim'] . $tagStr .$this->config['tmpl_r_delim'];
        $flag   =  substr($tagStr,0,1);
        $flag2  =  substr($tagStr,1,1);
        $name   = substr($tagStr,1);
        if('$' == $flag && '.' != $flag2 && '(' != $flag2){ //解析模板变量 格式 {$varName}
            return $this->parseVar($name);
        }elseif('-' == $flag || '+'== $flag){ // 输出计算
            return  '<?php echo '.$flag.$name.';?>';
        }elseif(':' == $flag){ // 输出某个函数的结果
            return  '<?php echo '.$name.';?>';
        }elseif('~' == $flag){ // 执行某个函数
            return  '<?php '.$name.';?>';
        }elseif(substr($tagStr,0,2)=='//' || (substr($tagStr,0,2)=='/*' && substr($tagStr,-2)=='*/')){
            //注释标签
            return '';
        }
        // 未识别的标签直接返回
        return  $this->config['tmpl_l_delim'] . $tagStr .$this->config['tmpl_r_delim'];
    }



    /**
     * 去除代码中的空白和注释
     * @param string $content 代码内容
     * @return string
     */
    function strip_whitespace($content) {
        $stripStr   = '';
        //分析php源码
        $tokens     = token_get_all($content);
        $last_space = false;
        for ($i = 0, $j = count($tokens); $i < $j; $i++) {
            if (is_string($tokens[$i])) {
                $last_space = false;
                $stripStr  .= $tokens[$i];
            } else {
                switch ($tokens[$i][0]) {
                    //过滤各种PHP注释
                    case T_COMMENT:
                    case T_DOC_COMMENT:
                        break;
                    //过滤空格
                    case T_WHITESPACE:
                        if (!$last_space) {
                            $stripStr  .= ' ';
                            $last_space = true;
                        }
                        break;
                    case T_START_HEREDOC:
                        $stripStr .= "<<<THINK\n";
                        break;
                    case T_END_HEREDOC:
                        $stripStr .= "THINK;\n";
                        for($k = $i+1; $k < $j; $k++) {
                            if(is_string($tokens[$k]) && $tokens[$k] == ';') {
                                $i = $k;
                                break;
                            } else if($tokens[$k][0] == T_CLOSE_TAG) {
                                break;
                            }
                        }
                        break;
                    default:
                        $last_space = false;
                        $stripStr  .= $tokens[$i][1];
                }
            }
        }
        return $stripStr;
    }



    /**
     * 模板变量解析,支持使用函数
     * 格式： {$varname|function1|function2=arg1,arg2}
     * @access public
     * @param string $varStr 变量数据
     * @return string
     */
    public function parseVar($varStr){
        $varStr     =   trim($varStr);
        static $_varParseList = array();
        //如果已经解析过该变量字串，则直接返回变量值
        if(isset($_varParseList[$varStr])) return $_varParseList[$varStr];

        $parseStr   =   '';
        $varExists  =   true;
        if(!empty($varStr)){
            $varArray = explode('|',$varStr);
            //取得变量名称
            $var = array_shift($varArray);
            if('Think.' == substr($var,0,6)){
                // 所有以Think.打头的以特殊变量对待 无需模板赋值就可以输出
                $name = $this->parseThinkVar($var);
            }elseif( false !== strpos($var,'.')) {
                //支持 {$var.property}
                $vars = explode('.',$var);
                $var  =  array_shift($vars);
                switch(strtolower($this->config['tmpl_var_identify'])) {
                    case 'array': // 识别为数组
                        $name = '$'.$var;
                        foreach ($vars as $key=>$val)
                            $name .= '["'.$val.'"]';
                        break;
                    case 'obj':  // 识别为对象
                        $name = '$'.$var;
                        foreach ($vars as $key=>$val)
                            $name .= '->'.$val;
                        break;
                    default:  // 自动判断数组或对象 只支持二维
                        $name = 'is_array($'.$var.')?$'.$var.'["'.$vars[0].'"]:$'.$var.'->'.$vars[0];
                }
            }elseif(false !== strpos($var,'[')) {
                //支持 {$var['key']} 方式输出数组
                $name = "$".$var;
                preg_match('/(.+?)\[(.+?)\]/is',$var,$match);
                $var = $match[1];
            }elseif(false !==strpos($var,':') && false ===strpos($var,'(') && false ===strpos($var,'::') && false ===strpos($var,'?')){
                //支持 {$var:property} 方式输出对象的属性
                $vars = explode(':',$var);
                $var  =  str_replace(':','->',$var);
                $name = "$".$var;
                $var  = $vars[0];
            }else {
                $name = "$$var";
            }
            //对变量使用函数
            if(count($varArray)>0)
                $name = $this->parseVarFunction($name,$varArray);
            $parseStr = '<?php echo ('.$name.'); ?>';

        }
        $_varParseList[$varStr] = $parseStr;
        return $parseStr;
    }

    /**
     * 替换页面中的literal标签
     * @access private
     * @param string $content  模板内容
     * @return string|false
     */
    private function parseLiteral($content) {
        if(trim($content)=='')  return '';
        $content            =   stripslashes($content);
        $i                  =   count($this->literal);
        $parseStr           =   "<!--###literal{$i}###-->";
        $this->literal[$i]  =   $content;
        return $parseStr;
    }

    /**
     * 还原被替换的literal标签
     * @access private
     * @param string $tag  literal标签序号
     * @return string|false
     */
    private function restoreLiteral($tag) {
        // 还原literal标签
        $parseStr   =  $this->literal[$tag];
        // 销毁literal记录
        unset($this->literal[$tag]);
        return $parseStr;
    }


    /**
     * 搜索模板页面中包含的TagLib库
     * 并返回列表
     * @access public
     * @param string $content  模板内容
     * @return string|false
     */
    public function getIncludeTagLib(& $content) {
        //搜索是否有TagLib标签
        $find = preg_match('/'.$this->config['taglib_begin'].'taglib\s(.+?)(\s*?)\/'.$this->config['taglib_end'].'\W/is',$content,$matches);
        if($find) {
            //替换TagLib标签
            $content        = str_replace($matches[0],'',$content);
            //解析TagLib标签
            $array          =   $this->parseXmlAttrs($matches[1]);
            $this->tagLib   = explode(',',$array['name']);
        }
        return;
    }




    public function parseTagLib($tagLib,&$content,$hide=false) {
        $begin = $this->config['taglib_begin'];
        $end        =   $this->config['taglib_end'];
        $end = $this->config['taglib_end'];
        $tLib = new TagLibCx();
        $that = $this;
        foreach ($tLib->getTags() as $name=>$val){

            $tags = array($name);
            if(isset($val['alias'])) {// 别名设置
                $tags       = explode(',',$val['alias']);
                $tags[]     =  $name;
            }
            $level      =   isset($val['level'])?$val['level']:1;
            $closeTag   =   isset($val['close'])?$val['close']:true;
            foreach ($tags as $tag){
                $parseTag = !$hide? $tagLib.':'.$tag: $tag;// 实际要解析的标签名称
                if(!method_exists($tLib,'_'.$tag)) {
                    // 别名可以无需定义解析方法
                    $tag  =  $name;
                }
                $n1 = empty($val['attr'])?'(\s*?)':'\s([^'.$end.']*)';
                if (!$closeTag){
                    $patterns       = '/'.$begin.$parseTag.$n1.'\/(\s*?)'.$end.'/eis';
                    $replacement    = "\$this->parseXmlTag('$tagLib','$tag','$1','')";
                    $content        = preg_replace($patterns, $replacement,$content);
                }else{
                    $patterns       = '/'.$begin.$parseTag.$n1.$end.'(.*?)'.$begin.'\/'.$parseTag.'(\s*?)'.$end.'/eis';

                    $replacement    = "\$this->parseXmlTag('$tagLib','$tag','$1','$2')";
                    for($i=0;$i<$level;$i++){
                        $content=preg_replace($patterns,$replacement,$content);
                    }
                }
            }
        }
    }




    /**
     * 解析标签库的标签
     * 需要调用对应的标签库文件解析类
     * @access public
     * @param string $tagLib  标签库名称
     * @param string $tag  标签名
     * @param string $attr  标签属性
     * @param string $content  标签内容
     * @return string|false
     */
    public function parseXmlTag($tagLib,$tag,$attr,$content) {
        //if (MAGIC_QUOTES_GPC) {
        $attr   = stripslashes($attr);
        $content= stripslashes($content);
        //}
        if(ini_get('magic_quotes_sybase'))
            $attr   =  str_replace('\"','\'',$attr);

        $tLib = Factory::getTagLibCx();
        $parse      = '_'.$tag;
        $content    = trim($content);
        return $tLib->$parse($attr,$content);
    }


}


class TagLib {

    /**
     * 标签库定义XML文件
     * @var string
     * @access protected
     */
    protected $xml      = '';
    protected $tags     = array();// 标签定义
    /**
     * 标签库名称
     * @var string
     * @access protected
     */
    protected $tagLib   ='';

    /**
     * 标签库标签列表
     * @var string
     * @access protected
     */
    protected $tagList  = array();

    /**
     * 标签库分析数组
     * @var string
     * @access protected
     */
    protected $parse    = array();

    /**
     * 标签库是否有效
     * @var string
     * @access protected
     */
    protected $valid    = false;

    /**
     * 当前模板对象
     * @var object
     * @access protected
     */
    protected $tpl;

    protected $comparison = array(' nheq '=>' !== ',' heq '=>' === ',' neq '=>' != ',' eq '=>' == ',' egt '=>' >= ',' gt '=>' > ',' elt '=>' <= ',' lt '=>' < ');

    /**
     * 架构函数
     * @access public
     */
    public function __construct() {
        $this->tagLib  = strtolower(substr(get_class($this),6));
        $this->tpl     = Factory::getMyTemp();
    }

    /**
     * TagLib标签属性分析 返回标签属性数组
     * @access public
     * @param string $tagStr 标签内容
     * @return array
     */
    public function parseXmlAttr($attr,$tag) {
        //XML解析安全过滤
        $attr   =   str_replace('&','___', $attr);
        $xml    =   '<tpl><tag '.$attr.' /></tpl>';
        $xml    =   simplexml_load_string($xml);
        if(!$xml) {
            throw_exception(L('_XML_TAG_ERROR_').' : '.$attr);
        }
        $xml    =   (array)($xml->tag->attributes());
        $array  =   array_change_key_case($xml['@attributes']);
        if($array) {
            $attrs  = explode(',',$this->tags[strtolower($tag)]['attr']);
            if(isset($this->tags[strtolower($tag)]['must'])){
                $must   =   explode(',',$this->tags[strtolower($tag)]['must']);
            }else{
                $must   =   array();
            }
            foreach($attrs as $name) {
                if( isset($array[$name])) {
                    $array[$name] = str_replace('___','&',$array[$name]);
                }elseif(false !== array_search($name,$must)){
                    throw_exception(L('_PARAM_ERROR_').':'.$name);
                }
            }
            return $array;
        }
    }

    /**
     * 解析条件表达式
     * @access public
     * @param string $condition 表达式标签内容
     * @return array
     */
    public function parseCondition($condition) {
        $condition = str_ireplace(array_keys($this->comparison),array_values($this->comparison),$condition);
        $condition = preg_replace('/\$(\w+):(\w+)\s/is','$\\1->\\2 ',$condition);
        switch('array') {
            case 'array': // 识别为数组
                $condition  =   preg_replace('/\$(\w+)\.(\w+)\s/is','$\\1["\\2"] ',$condition);
                break;
            case 'obj':  // 识别为对象
                $condition  =   preg_replace('/\$(\w+)\.(\w+)\s/is','$\\1->\\2 ',$condition);
                break;
            default:  // 自动判断数组或对象 只支持二维
                $condition  =   preg_replace('/\$(\w+)\.(\w+)\s/is','(is_array($\\1)?$\\1["\\2"]:$\\1->\\2) ',$condition);
        }
        if(false !== strpos($condition, '$Think'))
            $condition      =   preg_replace('/(\$Think.*?)\s/ies',"\$this->parseThinkVar('\\1');" , $condition);
        return $condition;
    }

    /**
     * 自动识别构建变量
     * @access public
     * @param string $name 变量描述
     * @return string
     */
    public function autoBuildVar($name) {
        if('Think.' == substr($name,0,6)){
            // 特殊变量
            return $this->parseThinkVar($name);
        }elseif(strpos($name,'.')) {
            $vars = explode('.',$name);
            $var  =  array_shift($vars);
            switch(strtolower(C('TMPL_VAR_IDENTIFY'))) {
                case 'array': // 识别为数组
                    $name = '$'.$var;
                    foreach ($vars as $key=>$val){
                        if(0===strpos($val,'$')) {
                            $name .= '["{'.$val.'}"]';
                        }else{
                            $name .= '["'.$val.'"]';
                        }
                    }
                    break;
                case 'obj':  // 识别为对象
                    $name = '$'.$var;
                    foreach ($vars as $key=>$val)
                        $name .= '->'.$val;
                    break;
                default:  // 自动判断数组或对象 只支持二维
                    $name = 'is_array($'.$var.')?$'.$var.'["'.$vars[0].'"]:$'.$var.'->'.$vars[0];
            }
        }elseif(strpos($name,':')){
            // 额外的对象方式支持
            $name   =   '$'.str_replace(':','->',$name);
        }elseif(!defined($name)) {
            $name = '$'.$name;
        }
        return $name;
    }

    /**
     * 用于标签属性里面的特殊模板变量解析
     * 格式 以 Think. 打头的变量属于特殊模板变量
     * @access public
     * @param string $varStr  变量字符串
     * @return string
     */
    public function parseThinkVar($varStr){
        $vars       = explode('.',$varStr);
        $vars[1]    = strtoupper(trim($vars[1]));
        $parseStr   = '';
        if(count($vars)>=3){
            $vars[2] = trim($vars[2]);
            switch($vars[1]){
                case 'SERVER':    $parseStr = '$_SERVER[\''.$vars[2].'\']';break;
                case 'GET':         $parseStr = '$_GET[\''.$vars[2].'\']';break;
                case 'POST':       $parseStr = '$_POST[\''.$vars[2].'\']';break;
                case 'COOKIE':
                    if(isset($vars[3])) {
                        $parseStr = '$_COOKIE[\''.$vars[2].'\'][\''.$vars[3].'\']';
                    }elseif(C('COOKIE_PREFIX')){
                        $parseStr = '$_COOKIE[\''.C('COOKIE_PREFIX').$vars[2].'\']';
                    }else{
                        $parseStr = '$_COOKIE[\''.$vars[2].'\']';
                    }
                    break;
                case 'SESSION':
                    if(isset($vars[3])) {
                        $parseStr = '$_SESSION[\''.$vars[2].'\'][\''.$vars[3].'\']';
                    }elseif(C('SESSION_PREFIX')){
                        $parseStr = '$_SESSION[\''.C('SESSION_PREFIX').'\'][\''.$vars[2].'\']';
                    }else{
                        $parseStr = '$_SESSION[\''.$vars[2].'\']';
                    }
                    break;
                case 'ENV':         $parseStr = '$_ENV[\''.$vars[2].'\']';break;
                case 'REQUEST':  $parseStr = '$_REQUEST[\''.$vars[2].'\']';break;
                case 'CONST':     $parseStr = strtoupper($vars[2]);break;
                case 'LANG':       $parseStr = 'L("'.$vars[2].'")';break;
                case 'CONFIG':    $parseStr = 'C("'.$vars[2].'")';break;
            }
        }else if(count($vars)==2){
            switch($vars[1]){
                case 'NOW':       $parseStr = "date('Y-m-d g:i a',time())";break;
                case 'VERSION':  $parseStr = 'THINK_VERSION';break;
                case 'TEMPLATE':$parseStr = 'C("TEMPLATE_NAME")';break;
                case 'LDELIM':    $parseStr = 'C("TMPL_L_DELIM")';break;
                case 'RDELIM':    $parseStr = 'C("TMPL_R_DELIM")';break;
                default:  if(defined($vars[1])) $parseStr = $vars[1];
            }
        }
        return $parseStr;
    }

    // 获取标签定义
    public function getTags(){
        return $this->tags;
    }
}


class TagLibCx extends TagLib {

    // 标签定义
    protected $tags   =  array(
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'php'       =>  array(),
        'volist'    =>  array('attr'=>'name,id,offset,length,key,mod','level'=>3,'alias'=>'iterate'),
        'foreach'   =>  array('attr'=>'name,item,key','level'=>3),
        'if'        =>  array('attr'=>'condition','level'=>2),
        'elseif'    =>  array('attr'=>'condition','close'=>0),
        'else'      =>  array('attr'=>'','close'=>0),
        'switch'    =>  array('attr'=>'name','level'=>2),
        'case'      =>  array('attr'=>'value,break'),
        'default'   =>  array('attr'=>'','close'=>0),
        'compare'   =>  array('attr'=>'name,value,type','level'=>3,'alias'=>'eq,equal,notequal,neq,gt,lt,egt,elt,heq,nheq'),
        'range'     =>  array('attr'=>'name,value,type','level'=>3,'alias'=>'in,notin,between,notbetween'),
        'empty'     =>  array('attr'=>'name','level'=>3),
        'notempty'  =>  array('attr'=>'name','level'=>3),
        'present'   =>  array('attr'=>'name','level'=>3),
        'notpresent'=>  array('attr'=>'name','level'=>3),
        'defined'   =>  array('attr'=>'name','level'=>3),
        'notdefined'=>  array('attr'=>'name','level'=>3),
        'import'    =>  array('attr'=>'file,href,type,value,basepath','close'=>0,'alias'=>'load,css,js'),
        'assign'    =>  array('attr'=>'name,value','close'=>0),
        'define'    =>  array('attr'=>'name,value','close'=>0),
        'for'       =>  array('attr'=>'start,end,name,comparison,step', 'level'=>3),
    );

    /**
     * php标签解析
     * @access public
     * @param string $attr 标签属性
     * @param string $content  标签内容
     * @return string
     */
    public function _php($attr,$content) {
        $parseStr = '<?php '.$content.' ?>';
        return $parseStr;
    }

    /**
     * volist标签解析 循环输出数据集
     * 格式：
     * <volist name="userList" id="user" empty="" >
     * {user.username}
     * {user.email}
     * </volist>
     * @access public
     * @param string $attr 标签属性
     * @param string $content  标签内容
     * @return string|void
     */
    public function _volist($attr,$content) {
        static $_iterateParseCache = array();
        //如果已经解析过，则直接返回变量值
        $cacheIterateId = md5($attr.$content);
        if(isset($_iterateParseCache[$cacheIterateId]))
            return $_iterateParseCache[$cacheIterateId];
        $tag   =    $this->parseXmlAttr($attr,'volist');
        $name  =    $tag['name'];
        $id    =    $tag['id'];
        $empty =    isset($tag['empty'])?$tag['empty']:'';
        $key   =    !empty($tag['key'])?$tag['key']:'i';
        $mod   =    isset($tag['mod'])?$tag['mod']:'2';
        // 允许使用函数设定数据集 <volist name=":fun('arg')" id="vo">{$vo.name}</volist>
        $parseStr   =  '<?php ';
        if(0===strpos($name,':')) {
            $parseStr   .= '$_result='.substr($name,1).';';
            $name   = '$_result';
        }else{
            $name   = $this->autoBuildVar($name);
        }
        $parseStr  .=  'if(is_array('.$name.')): $'.$key.' = 0;';
        if(isset($tag['length']) && '' !=$tag['length'] ) {
            $parseStr  .= ' $__LIST__ = array_slice('.$name.','.$tag['offset'].','.$tag['length'].',true);';
        }elseif(isset($tag['offset'])  && '' !=$tag['offset']){
            $parseStr  .= ' $__LIST__ = array_slice('.$name.','.$tag['offset'].',null,true);';
        }else{
            $parseStr .= ' $__LIST__ = '.$name.';';
        }
        $parseStr .= 'if( count($__LIST__)==0 ) : echo "'.$empty.'" ;';
        $parseStr .= 'else: ';
        $parseStr .= 'foreach($__LIST__ as $key=>$'.$id.'): ';
        $parseStr .= '$mod = ($'.$key.' % '.$mod.' );';
        $parseStr .= '++$'.$key.';?>';
        $parseStr .= $this->tpl->parse($content);
        $parseStr .= '<?php endforeach; endif; else: echo "'.$empty.'" ;endif; ?>';
        $_iterateParseCache[$cacheIterateId] = $parseStr;

        if(!empty($parseStr)) {
            return $parseStr;
        }
        return ;
    }

    /**
     * foreach标签解析 循环输出数据集
     * @access public
     * @param string $attr 标签属性
     * @param string $content  标签内容
     * @return string|void
     */
    public function _foreach($attr,$content) {
        static $_iterateParseCache = array();
        //如果已经解析过，则直接返回变量值
        $cacheIterateId = md5($attr.$content);
        if(isset($_iterateParseCache[$cacheIterateId]))
            return $_iterateParseCache[$cacheIterateId];
        $tag        =   $this->parseXmlAttr($attr,'foreach');
        $name       =   $tag['name'];
        $item       =   $tag['item'];
        $key        =   !empty($tag['key'])?$tag['key']:'key';
        $name       =   $this->autoBuildVar($name);
        $parseStr   =   '<?php if(is_array('.$name.')): foreach('.$name.' as $'.$key.'=>$'.$item.'): ?>';
        $parseStr  .=   $this->tpl->parse($content);
        $parseStr  .=   '<?php endforeach; endif; ?>';
        $_iterateParseCache[$cacheIterateId] = $parseStr;
        if(!empty($parseStr)) {
            return $parseStr;
        }
        return ;
    }

    /**
     * if标签解析
     * 格式：
     * <if condition=" $a eq 1" >
     * <elseif condition="$a eq 2" />
     * <else />
     * </if>
     * 表达式支持 eq neq gt egt lt elt == > >= < <= or and || &&
     * @access public
     * @param string $attr 标签属性
     * @param string $content  标签内容
     * @return string
     */
    public function _if($attr,$content) {
        $tag        =   $this->parseXmlAttr($attr,'if');
        $condition  =   $this->parseCondition($tag['condition']);
        $parseStr   =   '<?php if('.$condition.'): ?>'.$content.'<?php endif; ?>';
        return $parseStr;
    }

    /**
     * else标签解析
     * 格式：见if标签
     * @access public
     * @param string $attr 标签属性
     * @param string $content  标签内容
     * @return string
     */
    public function _elseif($attr,$content) {
        $tag        =   $this->parseXmlAttr($attr,'elseif');
        $condition  =   $this->parseCondition($tag['condition']);
        $parseStr   =   '<?php elseif('.$condition.'): ?>';
        return $parseStr;
    }

    /**
     * else标签解析
     * @access public
     * @param string $attr 标签属性
     * @return string
     */
    public function _else($attr) {
        $parseStr = '<?php else: ?>';
        return $parseStr;
    }

    /**
     * switch标签解析
     * 格式：
     * <switch name="a.name" >
     * <case value="1" break="false">1</case>
     * <case value="2" >2</case>
     * <default />other
     * </switch>
     * @access public
     * @param string $attr 标签属性
     * @param string $content  标签内容
     * @return string
     */
    public function _switch($attr,$content) {
        $tag        =   $this->parseXmlAttr($attr,'switch');
        $name       =   $tag['name'];
        $varArray   =   explode('|',$name);
        $name       =   array_shift($varArray);
        $name       =   $this->autoBuildVar($name);
        if(count($varArray)>0)
            $name   =   $this->tpl->parseVarFunction($name,$varArray);
        $parseStr   =   '<?php switch('.$name.'): ?>'.$content.'<?php endswitch;?>';
        return $parseStr;
    }

    /**
     * case标签解析 需要配合switch才有效
     * @access public
     * @param string $attr 标签属性
     * @param string $content  标签内容
     * @return string
     */
    public function _case($attr,$content) {
        $tag    = $this->parseXmlAttr($attr,'case');
        $value  = $tag['value'];
        if('$' == substr($value,0,1)) {
            $varArray   =   explode('|',$value);
            $value	    =	array_shift($varArray);
            $value      =   $this->autoBuildVar(substr($value,1));
            if(count($varArray)>0)
                $value  =   $this->tpl->parseVarFunction($value,$varArray);
            $value      =   'case '.$value.': ';
        }elseif(strpos($value,'|')){
            $values     =   explode('|',$value);
            $value      =   '';
            foreach ($values as $val){
                $value   .=  'case "'.addslashes($val).'": ';
            }
        }else{
            $value	=	'case "'.$value.'": ';
        }
        $parseStr = '<?php '.$value.' ?>'.$content;
        $isBreak  = isset($tag['break']) ? $tag['break'] : '';
        if('' ==$isBreak || $isBreak) {
            $parseStr .= '<?php break;?>';
        }
        return $parseStr;
    }

    /**
     * default标签解析 需要配合switch才有效
     * 使用： <default />ddfdf
     * @access public
     * @param string $attr 标签属性
     * @param string $content  标签内容
     * @return string
     */
    public function _default($attr) {
        $parseStr = '<?php default: ?>';
        return $parseStr;
    }

    /**
     * compare标签解析
     * 用于值的比较 支持 eq neq gt lt egt elt heq nheq 默认是eq
     * 格式： <compare name="" type="eq" value="" >content</compare>
     * @access public
     * @param string $attr 标签属性
     * @param string $content  标签内容
     * @return string
     */
    public function _compare($attr,$content,$type='eq') {
        $tag        =   $this->parseXmlAttr($attr,'compare');
        $name       =   $tag['name'];
        $value      =   $tag['value'];
        $type       =   isset($tag['type'])?$tag['type']:$type;
        $type       =   $this->parseCondition(' '.$type.' ');
        $varArray   =   explode('|',$name);
        $name       =   array_shift($varArray);
        $name       =   $this->autoBuildVar($name);
        if(count($varArray)>0)
            $name = $this->tpl->parseVarFunction($name,$varArray);
        if('$' == substr($value,0,1)) {
            $value  =  $this->autoBuildVar(substr($value,1));
        }else {
            $value  =   '"'.$value.'"';
        }
        $parseStr   =   '<?php if(('.$name.') '.$type.' '.$value.'): ?>'.$content.'<?php endif; ?>';
        return $parseStr;
    }

    public function _eq($attr,$content) {
        return $this->_compare($attr,$content,'eq');
    }

    public function _equal($attr,$content) {
        return $this->_compare($attr,$content,'eq');
    }

    public function _neq($attr,$content) {
        return $this->_compare($attr,$content,'neq');
    }

    public function _notequal($attr,$content) {
        return $this->_compare($attr,$content,'neq');
    }

    public function _gt($attr,$content) {
        return $this->_compare($attr,$content,'gt');
    }

    public function _lt($attr,$content) {
        return $this->_compare($attr,$content,'lt');
    }

    public function _egt($attr,$content) {
        return $this->_compare($attr,$content,'egt');
    }

    public function _elt($attr,$content) {
        return $this->_compare($attr,$content,'elt');
    }

    public function _heq($attr,$content) {
        return $this->_compare($attr,$content,'heq');
    }

    public function _nheq($attr,$content) {
        return $this->_compare($attr,$content,'nheq');
    }

    /**
     * range标签解析
     * 如果某个变量存在于某个范围 则输出内容 type= in 表示在范围内 否则表示在范围外
     * 格式： <range name="var|function"  value="val" type='in|notin' >content</range>
     * example: <range name="a"  value="1,2,3" type='in' >content</range>
     * @access public
     * @param string $attr 标签属性
     * @param string $content  标签内容
     * @param string $type  比较类型
     * @return string
     */
    public function _range($attr,$content,$type='in') {
        $tag        =   $this->parseXmlAttr($attr,'range');
        $name       =   $tag['name'];
        $value      =   $tag['value'];
        $varArray   =   explode('|',$name);
        $name       =   array_shift($varArray);
        $name       =   $this->autoBuildVar($name);
        if(count($varArray)>0)
            $name   =   $this->tpl->parseVarFunction($name,$varArray);

        $type       =   isset($tag['type'])?$tag['type']:$type;

        if('$' == substr($value,0,1)) {
            $value  =   $this->autoBuildVar(substr($value,1));
            $str    =   'is_array('.$value.')?'.$value.':explode(\',\','.$value.')';
        }else{
            $value  =   '"'.$value.'"';
            $str    =   'explode(\',\','.$value.')';
        }
        if($type=='between') {
            $parseStr = '<?php $_RANGE_VAR_='.$str.';if('.$name.'>= $_RANGE_VAR_[0] && '.$name.'<= $_RANGE_VAR_[1]):?>'.$content.'<?php endif; ?>';
        }elseif($type=='notbetween'){
            $parseStr = '<?php $_RANGE_VAR_='.$str.';if('.$name.'<$_RANGE_VAR_[0] || '.$name.'>$_RANGE_VAR_[1]):?>'.$content.'<?php endif; ?>';
        }else{
            $fun        =  ($type == 'in')? 'in_array'    :   '!in_array';
            $parseStr   = '<?php if('.$fun.'(('.$name.'), '.$str.')): ?>'.$content.'<?php endif; ?>';
        }
        return $parseStr;
    }

    // range标签的别名 用于in判断
    public function _in($attr,$content) {
        return $this->_range($attr,$content,'in');
    }

    // range标签的别名 用于notin判断
    public function _notin($attr,$content) {
        return $this->_range($attr,$content,'notin');
    }

    public function _between($attr,$content){
        return $this->_range($attr,$content,'between');
    }

    public function _notbetween($attr,$content){
        return $this->_range($attr,$content,'notbetween');
    }

    /**
     * present标签解析
     * 如果某个变量已经设置 则输出内容
     * 格式： <present name="" >content</present>
     * @access public
     * @param string $attr 标签属性
     * @param string $content  标签内容
     * @return string
     */
    public function _present($attr,$content) {
        $tag        =   $this->parseXmlAttr($attr,'present');
        $name       =   $tag['name'];
        $name       =   $this->autoBuildVar($name);
        $parseStr   =   '<?php if(isset('.$name.')): ?>'.$content.'<?php endif; ?>';
        return $parseStr;
    }

    /**
     * notpresent标签解析
     * 如果某个变量没有设置，则输出内容
     * 格式： <notpresent name="" >content</notpresent>
     * @access public
     * @param string $attr 标签属性
     * @param string $content  标签内容
     * @return string
     */
    public function _notpresent($attr,$content) {
        $tag        =   $this->parseXmlAttr($attr,'notpresent');
        $name       =   $tag['name'];
        $name       =   $this->autoBuildVar($name);
        $parseStr   =   '<?php if(!isset('.$name.')): ?>'.$content.'<?php endif; ?>';
        return $parseStr;
    }

    /**
     * empty标签解析
     * 如果某个变量为empty 则输出内容
     * 格式： <empty name="" >content</empty>
     * @access public
     * @param string $attr 标签属性
     * @param string $content  标签内容
     * @return string
     */
    public function _empty($attr,$content) {
        $tag        =   $this->parseXmlAttr($attr,'empty');
        $name       =   $tag['name'];
        $name       =   $this->autoBuildVar($name);
        $parseStr   =   '<?php if(empty('.$name.')): ?>'.$content.'<?php endif; ?>';
        return $parseStr;
    }

    public function _notempty($attr,$content) {
        $tag        =   $this->parseXmlAttr($attr,'notempty');
        $name       =   $tag['name'];
        $name       =   $this->autoBuildVar($name);
        $parseStr   =   '<?php if(!empty('.$name.')): ?>'.$content.'<?php endif; ?>';
        return $parseStr;
    }

    /**
     * 判断是否已经定义了该常量
     * <defined name='TXT'>已定义</defined>
     * @param <type> $attr
     * @param <type> $content
     * @return string
     */
    public function _defined($attr,$content) {
        $tag        =   $this->parseXmlAttr($attr,'defined');
        $name       =   $tag['name'];
        $parseStr   =   '<?php if(defined("'.$name.'")): ?>'.$content.'<?php endif; ?>';
        return $parseStr;
    }

    public function _notdefined($attr,$content) {
        $tag        =   $this->parseXmlAttr($attr,'_notdefined');
        $name       =   $tag['name'];
        $parseStr   =   '<?php if(!defined("'.$name.'")): ?>'.$content.'<?php endif; ?>';
        return $parseStr;
    }

    /**
     * import 标签解析 <import file="Js.Base" />
     * <import file="Css.Base" type="css" />
     * @access public
     * @param string $attr 标签属性
     * @param string $content  标签内容
     * @param boolean $isFile  是否文件方式
     * @param string $type  类型
     * @return string
     */
    public function _import($attr,$content,$isFile=false,$type='') {
        $tag        =   $this->parseXmlAttr($attr,'import');
        $file       =   isset($tag['file'])?$tag['file']:$tag['href'];
        $parseStr   =   '';
        $endStr     =   '';
        // 判断是否存在加载条件 允许使用函数判断(默认为isset)
        if (isset($tag['value'])) {
            $varArray  =    explode('|',$tag['value']);
            $name      =    array_shift($varArray);
            $name      =    $this->autoBuildVar($name);
            if (!empty($varArray))
                $name  =    $this->tpl->parseVarFunction($name,$varArray);
            else
                $name  =    'isset('.$name.')';
            $parseStr .=    '<?php if('.$name.'): ?>';
            $endStr    =    '<?php endif; ?>';
        }
        if($isFile) {
            // 根据文件名后缀自动识别
            $type  = $type?$type:(!empty($tag['type'])?strtolower($tag['type']):null);
            // 文件方式导入
            $array =  explode(',',$file);
            foreach ($array as $val){
                if (!$type || isset($reset)) {
                    $type = $reset = strtolower(substr(strrchr($val, '.'),1));
                }
                switch($type) {
                    case 'js':
                        $parseStr .= '<script type="text/javascript" src="'.$val.'"></script>';
                        break;
                    case 'css':
                        $parseStr .= '<link rel="stylesheet" type="text/css" href="'.$val.'" />';
                        break;
                    case 'php':
                        $parseStr .= '<?php require_cache("'.$val.'"); ?>';
                        break;
                }
            }
        }else{
            // 命名空间导入模式 默认是js
            $type       =   $type?$type:(!empty($tag['type'])?strtolower($tag['type']):'js');
            $basepath   =   !empty($tag['basepath'])?$tag['basepath']:__ROOT__.'/Public';
            // 命名空间方式导入外部文件
            $array      =   explode(',',$file);
            foreach ($array as $val){
                list($val,$version) =   explode('?',$val);
                switch($type) {
                    case 'js':
                        $parseStr .= '<script type="text/javascript" src="'.$basepath.'/'.str_replace(array('.','#'), array('/','.'),$val).'.js'.($version?'?'.$version:'').'"></script>';
                        break;
                    case 'css':
                        $parseStr .= '<link rel="stylesheet" type="text/css" href="'.$basepath.'/'.str_replace(array('.','#'), array('/','.'),$val).'.css'.($version?'?'.$version:'').'" />';
                        break;
                    case 'php':
                        $parseStr .= '<?php import("'.$val.'"); ?>';
                        break;
                }
            }
        }
        return $parseStr.$endStr;
    }

    // import别名 采用文件方式加载(要使用命名空间必须用import) 例如 <load file="__PUBLIC__/Js/Base.js" />
    public function _load($attr,$content) {
        return $this->_import($attr,$content,true);
    }

    // import别名使用 导入css文件 <css file="__PUBLIC__/Css/Base.css" />
    public function _css($attr,$content) {
        return $this->_import($attr,$content,true,'css');
    }

    // import别名使用 导入js文件 <js file="__PUBLIC__/Js/Base.js" />
    public function _js($attr,$content) {
        return $this->_import($attr,$content,true,'js');
    }

    /**
     * assign标签解析
     * 在模板中给某个变量赋值 支持变量赋值
     * 格式： <assign name="" value="" />
     * @access public
     * @param string $attr 标签属性
     * @param string $content  标签内容
     * @return string
     */
    public function _assign($attr,$content) {
        $tag        =   $this->parseXmlAttr($attr,'assign');
        $name       =   $this->autoBuildVar($tag['name']);
        if('$'==substr($tag['value'],0,1)) {
            $value  =   $this->autoBuildVar(substr($tag['value'],1));
        }else{
            $value  =   '\''.$tag['value']. '\'';
        }
        $parseStr   =   '<?php '.$name.' = '.$value.'; ?>';
        return $parseStr;
    }

    /**
     * define标签解析
     * 在模板中定义常量 支持变量赋值
     * 格式： <define name="" value="" />
     * @access public
     * @param string $attr 标签属性
     * @param string $content  标签内容
     * @return string
     */
    public function _define($attr,$content) {
        $tag        =   $this->parseXmlAttr($attr,'define');
        $name       =   '\''.$tag['name']. '\'';
        if('$'==substr($tag['value'],0,1)) {
            $value  =   $this->autoBuildVar(substr($tag['value'],1));
        }else{
            $value  =   '\''.$tag['value']. '\'';
        }
        $parseStr   =   '<?php define('.$name.', '.$value.'); ?>';
        return $parseStr;
    }

    /**
     * for标签解析
     * 格式： <for start="" end="" comparison="" step="" name="" />
     * @access public
     * @param string $attr 标签属性
     * @param string $content  标签内容
     * @return string
     */
    public function _for($attr, $content){
        //设置默认值
        $start 		= 0;
        $end   		= 0;
        $step 		= 1;
        $comparison = 'lt';
        $name		= 'i';
        $rand       = rand(); //添加随机数，防止嵌套变量冲突
        //获取属性
        foreach ($this->parseXmlAttr($attr, 'for') as $key => $value){
            $value = trim($value);
            if(':'==substr($value,0,1))
                $value = substr($value,1);
            elseif('$'==substr($value,0,1))
                $value = $this->autoBuildVar(substr($value,1));
            switch ($key){
                case 'start':
                    $start      = $value; break;
                case 'end' :
                    $end        = $value; break;
                case 'step':
                    $step       = $value; break;
                case 'comparison':
                    $comparison = $value; break;
                case 'name':
                    $name       = $value; break;
            }
        }

        $parseStr   = '<?php $__FOR_START_'.$rand.'__='.$start.';$__FOR_END_'.$rand.'__='.$end.';';
        $parseStr  .= 'for($'.$name.'=$__FOR_START_'.$rand.'__;'.$this->parseCondition('$'.$name.' '.$comparison.' $__FOR_END_'.$rand.'__').';$'.$name.'+='.$step.'){ ?>';
        $parseStr  .= $content;
        $parseStr  .= '<?php } ?>';
        return $parseStr;
    }

}