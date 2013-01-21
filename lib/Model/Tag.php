<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadym
 * Date: 1/7/13
 * Time: 8:09 PM
 * To change this template use File | Settings | File Templates.
 */
namespace x_tags;
class Model_Tag extends \Model_Table {
    public $table='tag';
    function init(){
        parent::init();//$this->debug();
        $this->addField('value')->length(20)->mandatory($this->api->tvs->getMandatoryMessage());
        $this->hasOne('User');

        $this->addField('name','value');
    }
}