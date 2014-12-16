<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/12/16 0016
 * Time: ���� 1:55
 */

class traceHook {

    // ��Ϊ��������
    protected $options   =  array(
        'SHOW_PAGE_TRACE'   => false,   // ��ʾҳ��Trace��Ϣ
        'TRACE_PAGE_TABS'   => array('BASE'=>'����','FILE'=>'�ļ�','INFO'=>'����','ERR|NOTIC'=>'����','SQL'=>'SQL','DEBUG'=>'����'), // ҳ��Trace�ɶ��Ƶ�ѡ�
        'PAGE_TRACE_SAVE'   => false,
    );


    public function run($params = null){

        echo 1111;exit;
        if(!IS_AJAX && C('SHOW_PAGE_TRACE')) {
            echo $this->showTrace();
        }

    }

    /**
     * ��ʾҳ��Trace��Ϣ
     * @access private
     */
    private function showTrace() {
        // ϵͳĬ����ʾ��Ϣ
        $files  =  get_included_files();
        $info   =   array();
        foreach ($files as $key=>$file){
            $info[] = $file.' ( '.number_format(filesize($file)/1024,2).' KB )';
        }
        $trace  =   array();
        $base   =   array(
            '������Ϣ'  =>  date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']).' '.$_SERVER['SERVER_PROTOCOL'].' '.$_SERVER['REQUEST_METHOD'].' : '.__SELF__,
            '����ʱ��'  =>  $this->showTime(),
            '������'	=>	number_format(1/G('beginTime','viewEndTime'),2).'req/s',
            '�ڴ濪��'  =>  MEMORY_LIMIT_ON?number_format((memory_get_usage() - $GLOBALS['_startUseMems'])/1024,2).' kb':'��֧��',
            '��ѯ��Ϣ'  =>  N('db_query').' queries '.N('db_write').' writes ',
            '�ļ�����'  =>  count(get_included_files()),
            '������Ϣ'  =>  N('cache_read').' gets '.N('cache_write').' writes ',
            '���ü���'  =>  count(c()),
            '�Ự��Ϣ'  =>  'SESSION_ID='.session_id(),
        );
        // ��ȡ��Ŀ�����Trace�ļ�
        $traceFile  =   CONF_PATH.'trace.php';
        if(is_file($traceFile)) {
            $base   =   array_merge($base,include $traceFile);
        }
        $debug  =   trace();
        $tabs   =   C('TRACE_PAGE_TABS');
        foreach ($tabs as $name=>$title){
            switch(strtoupper($name)) {
                case 'BASE':// ������Ϣ
                    $trace[$title]  =   $base;
                    break;
                case 'FILE': // �ļ���Ϣ
                    $trace[$title]  =   $info;
                    break;
                default:// ������Ϣ
                    $name       =   strtoupper($name);
                    if(strpos($name,'|')) {// ������Ϣ
                        $array  =   explode('|',$name);
                        $result =   array();
                        foreach($array as $name){
                            $result   +=   isset($debug[$name])?$debug[$name]:array();
                        }
                        $trace[$title]  =   $result;
                    }else{
                        $trace[$title]  =   isset($debug[$name])?$debug[$name]:'';
                    }
            }
        }
        if($save = C('debug:page_trace_save')) { // ����ҳ��Trace��־
            if(is_array($save)) {// ѡ��ѡ�����
                $tabs   =   C('TRACE_PAGE_TABS');
                $array  =   array();
                foreach ($save as $tab){
                    $array[] =   $tabs[$tab];
                }
            }
            $content    =   date('[ c ]').' '.get_client_ip().' '.$_SERVER['REQUEST_URI']."\r\n";
            foreach ($trace as $key=>$val){
                if(!isset($array) || in_array($key,$array)) {
                    $content    .=  '[ '.$key." ]\r\n";
                    if(is_array($val)) {
                        foreach ($val as $k=>$v){
                            $content .= (!is_numeric($k)?$k.':':'').print_r($v,true)."\r\n";
                        }
                    }else{
                        $content .= print_r($val,true)."\r\n";
                    }
                    $content .= "\r\n";
                }
            }
            error_log(str_replace('<br/>',"\r\n",$content), Log::FILE,C("log:log_path").date('y_m_d').'_trace.log');
        }
        unset($files,$info,$base);
        // ����Traceҳ��ģ��
        ob_start();
        include C('debug:tmpl_trace_file')?C('debug:tmpl_trace_file'):APP_TEMP_PATH.'/trace.tpl';
        return ob_get_clean();
    }


    /**
     * ��ȡ����ʱ��
     */
    private function showTime() {
        // ��ʾ����ʱ��
        G('beginTime',$GLOBALS['_beginTime']);
        G('viewEndTime');
        // ��ʾ��ϸ����ʱ��
        return G('beginTime','viewEndTime').'s ( Load:'.G('beginTime','loadTime').'s Init:'.G('loadTime','initTime').'s Exec:'.G('initTime','viewStartTime').'s Template:'.G('viewStartTime','viewEndTime').'s )';
    }



} 