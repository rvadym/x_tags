<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadym
 * Date: 1/7/13
 * Time: 8:11 PM
 * To change this template use File | Settings | File Templates.
 */
namespace x_tags;
class Model_Tag_My extends Model_Tag {
    function init(){
        parent::init();
        $this->addCondition('user_id',$this->api->auth->model->id);
    }
}