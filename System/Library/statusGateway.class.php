<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/12 0012
 * Time: ���� 11:12
 */

namespace System\Library;


class statusGateway {

    private $data = array();

    protected function init() {}

    /**
     * @param array $data
     */
    public function __construct($data = array())
    {
        if($data) {
            $this->data = $data;
        }
        $this->init();
    }

    /**
     * @param $id
     * @return null
     */
    public function getById($id){

        if(isset($this->data[$id]))
        {
            return (arrayToObject($this->data[$id]));
        }
        return null;

    }

    /**
     * @param $key
     * @return null
     */
    public function getByKey($key){

        foreach ($this->data as $val) {
            if($val['key'] == $key) {
                return arrayToObject($val['key']);
            }
        }

        return null;

    }

    /**
     * @param $name
     * @return null
     */
    public function getByName($name){

        foreach ($this->data as $val) {
            if($val['name'] == $name) {
                return arrayToObject($val['name']);
            }
        }
        return null;

    }

    /**
     * ��������
     *
     * @param int|string $id
     * @param string $key
     * @param $name
     */
    protected function set($id, $key = null, $name = null)
    {
        if(is_null($key) && is_null($name)) {
            exception('�������ȷ״̬������');
        }
        $this->data[$id] = array(
            'id' => $id,
            'key' => $key,
            'name' => $name
        );
    }




} 