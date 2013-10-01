<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadym
 * Date: 1/10/13
 * Time: 4:29 PM
 * To change this template use File | Settings | File Templates.
 */
namespace x_tags;

class Form_Tags extends \Form {
    public $connected_form;
    function init() {
        parent::init();

        /*
         *
         */
        if (!$this->connected_form->hasElement('tags')) throw $this->exception('Main (connected) form must have "tags" field!');
        $this->tags_name_list = $this->connected_form->getElement('tags');
        $this->tags_name_list->js(true)->closest('.atk-form-row')->hide();
        $this->connected_form->js('get_tags',array(
            $this->js(null,
                " $('#".$this->tags_name_list->name."').val('');
                $('.main-tag-lister .".$this->name."').each( function(i,el) {
                    if (i==0) {comma = ''} else {comma = ','};
                    $('#".$this->tags_name_list->name."').val(
                        $('#".$this->tags_name_list->name."').val() + comma + $(this).text()
                    );
               })"),
        ));

        $this->tags_list = $this->addField('hidden','tags');

        $tag_f = $this->addField('x_tags/createnew','add_tag');
        $tag_f->setModel('x_tags/Tag_MyAndCommon');

        $this->addSubmit('Add Tag');

        if (!$this->owner->template->hasTag('tags_lister')) throw $this->exception('Add tag "tags_lister" to view');
        $this->l = $this->owner->add('x_tags\Lister_Tags',array('form'=>$this),'tags_lister');

        /*
         *  Mark this lister as an important one.
         *  Should be only one lister with this class on a page
         *  js will work with this class
         */
        $this->l->addClass('main-tag-lister');

        // if form was submitted
        if ($_GET['tags_list']!='') {
            $t_m = $this->add('x_tags/Model_Tag_My');//->debug();
            $tag_arr = explode('-',$_GET['tags_list']);
            $where = array();
            foreach ($tag_arr as $ta) {
                $where[] = array('id',$ta);
            }
            $t_m->_dsql()->where($where);
            $this->l->setModel($t_m);
        }
        // if this is edit form
        else if ($this->tags_name_list->get() != '') {
            $temp_tag_arr = explode(',',$this->tags_name_list->get());
            $tag_arr = array();
            $tag_id_arr = array();
            $count=0;
            foreach ($temp_tag_arr as $tag) {
                $test_m = $this->findOrCreateTag($tag);
                $tag_arr[$count]['id'] = $test_m->id;
                $tag_arr[$count]['value'] = $tag;
                $tag_id_arr[] = $test_m->id;
                $count++;
            }
            $this->l->setSource($tag_arr,'value');
            $this->tags_list->set(implode('-',$tag_id_arr));
        }
        // just a new form
        else {
            $this->l->setSource(array());
        }
        $this->l->js('reload')->_fn('atk4_reload',array(
            $this->api->url(null,array('cut_object'=>$this->l->name)),
            array('tags_list'=>$this->tags_list->js()->val()),
            null
        ));

        $this->onSubmit(array($this,'checkFormSubmit'));
    }
    function checkFormSubmit() {//var_dump($this->get());//exit('<hr>');
        /*
         *  All tags in database will be separated by comma,
         *  so we will not let users to use comma in tag name.
         */
        $this->set('add_tag_hidden',str_replace(',','',trim($this->get('add_tag_hidden'))));

        $this->return_js = array();
        if ($this->get('add_tag')!='') {
            $new_value = ($this->tags_list->get()=='')?$this->get('add_tag'):$this->tags_list->get().'-'.$this->get('add_tag');
        } else if ($this->get('add_tag')=='' && $this->get('add_tag_hidden')!='') {
            $test_m = $this->findOrCreateTag($this->get('add_tag_hidden'));
            $new_value = ($this->tags_list->get()=='')?$test_m->get('id'):$this->tags_list->get().'-'.$test_m->get('id');
        } else {
            $new_value = $this->tags_list->get();
        }

        $this->return_js[] = $this->js()->atk4_form('setFieldValue',$this->tags_list->short_name,$this->string_unique($new_value,'-'));
        $this->return_js[] = $this->l->js()->trigger('reload');
        $this->js(null,$this->return_js)->execute();
    }
    private function findOrCreateTag($tag) {
        $test_m = $this->add('x_tags/Model_Tag_My');
        $test_m->addCondition('value',$tag);
        $test_m->tryLoadAny();
        if (!$test_m->loaded()) {
            $test_m
                ->set('value',$tag)
                ->set('user_id',$this->api->auth->model->id)
            ->save();
            //$this->return_js[] = $this->js()->univ()->successMessage('Tag was added to your personal set of tags');
        }
        return $test_m;
    }
    private function string_unique($str,$separator) {
        /*
         *  Just to avoid duplicated tags
         */
        return implode($separator,array_unique(explode($separator,$str)));
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

        return parent::defaultTemplate();
    }
}

class Form_Field_createnew extends \autocomplete\Form_Field_Basic {
	function init(){
		parent::init();
        $name = preg_replace('/_id$/','',$this->short_name);
        $this->other_hidden_field = $this->owner->addField('hidden',$name.'_hidden');
        $this->other_field->js('change',$this->other_hidden_field->js()->val($this->other_field->js()->val()));
        $this->owner->js('submit',$this->other_hidden_field->js()->val(''));
	}
}
