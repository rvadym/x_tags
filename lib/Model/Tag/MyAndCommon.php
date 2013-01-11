<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadym
 * Date: 1/7/13
 * Time: 8:13 PM
 * To change this template use File | Settings | File Templates.
 */
namespace x_tags;
class Model_Tag_MyAndCommon extends Model_Tag {
    function init(){
        parent::init();
        $this->addCondition('user_id',$this->api->auth->model->id);
        $this->_dsql()->where(array(
            array('user_id',$this->api->auth->model->id),
            array('user_id',null),
        ));
    }
}