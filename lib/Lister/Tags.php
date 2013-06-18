<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadym
 * Date: 1/10/13
 * Time: 4:32 PM
 * To change this template use File | Settings | File Templates.
 */
namespace x_tags;

class Lister_Tags extends \CompleteLister {
    public $form;
    public $con_form_trigger_js='';
    function init() {
        parent::init();

        if ($this->form && $this->form->connected_form){
            $this->con_form_trigger_js = $this->js(true,array($this->form->connected_form->js()->trigger('get_tags')));
        }
    }
    function formatRow() {
        parent::formatRow();

        if ($this->form) {
            $form_js = $this->js()->x_tags()->removeTagId($this->form->tags_list->name,$this->current_row['id']);
        } else {
            $form_js = '';
        }

        if ($this->form && $this->form->connected_form){
            $b = $this->add('View','edit_b_'.$this->current_row['id'])->set('X')->addClass('delete_tag')->addClass('ui-corner-all');
            $b->js('click',array(
                $b->js()->closest('li')->remove(),
                $this->con_form_trigger_js,
                $form_js,
            ));
            $this->current_row_html['edit_button']=$b->getHTML();
        }

        if ($this->form) {
            $this->current_row['form_id']=$this->form->name;
        }
    }
    function render(){
   		$this->js(true)
   			->_load('x_tags')
   			->_css('x_tags');

   		return parent::render();
   	}
    function defaultTemplate() {
		// add add-on locations to pathfinder
		$l = $this->api->locate('addons',__NAMESPACE__,'location');
		$addon_location = $this->api->locate('addons',__NAMESPACE__);
		$this->api->pathfinder->addLocation($addon_location,array(
			'js'=>'templates/js',
			'css'=>'templates/css',
            'template'=>'templates',
		))->setParent($l);

        return array('view/lister/tags');
    }
}