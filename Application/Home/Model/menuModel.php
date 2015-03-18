<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/17 0017
 * Time: ���� 5:00
 */
namespace Home\Model;

class menuModel  extends \System\Core\Model{

    private $array = array();

    /**
     * ��ȡnav
     * @return mixed
     */
    public function getNav(){

        $db = parent::getDb();
        $res = $db->table('common_menu')->getAll(array('is_admin'=>0,'is_display'=>1))->order('sort desc')->done();
        return $res;
    }



    /**
     * ��ȡ��ǰ·����Ϣ
     * @return mixed
     */
    public function getRouteInfo()
    {
        if(!$this->array){
            $this->getSequence();
        }
        $ro = \Application::$appLib['route'];
        $routeUrl = $ro::$routeUrl;
        foreach ($this->array as $v) {
            if ($v['m'] == $routeUrl['module'] && $v['c'] == $routeUrl['controller'] && $v['a'] == $routeUrl['action']) {
                return $this->array[$v['id']];
            }
        }
    }


    /**
     * ��ȡ��Ŀ���У���Ϊ·����Ϣ������Ŀ�˵����ڹ���������Щ�ط� ��ע�ᣬ��½����Щ���ܲ���Ҫ��Ŀ���ݣ����Զ�������
     */
    public function getSequence(){
        $db = parent::getDb();
        //��ȡ�˵�����
        $Menu =  $db->table('common_menu')->getAll(array('is_admin'=>0,'is_display'=>1))->order('parent_id')->done();
        //����
        foreach ($Menu as $k => $v) {
            $this->array[$v['id']] = array('id' => $v['id'], 'pid' => $v['parent_id'], 'name' => $v['name'],'is_display' => $v['is_display'], 'ico' => $v['icon'], 'desc' => $v['desc'], 'sort' => $v['sort'], 'm' => $v['module_name'], 'c' => $v['controller_name'], 'a' => $v['action_name']);
        }
    }



} 