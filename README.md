# x_tags

* * *

tags plugin for atk4

Requires: 
[git@github.com:atk4/autocomplete.git](https://github.com/atk4/autocomplete)

This plugin allows you to add tags to any Model. 

## Instalation:

Just clone to addons dirrectory of your atk4 project

## Usage:

### Add Tags:

Add form (I suggest set id of form manually by passing second parameter to add())

    $f=$this->add('Form','bform','form');
    
Set Model for Form which has 'tags' Field (->type('text'))

    $f->setModel('Model_Article',array('title','text','tags'));
    
Add Form_Tags and connect to your Form

    $this->add('x_tags/Form_Tags',array('connected_form'=>$f));
    
Form_Tag will add Lister to your page and it requires <?$tags_lister?> Tag in page template.

![Screenshot](https://raw.github.com/rvadym/x_tags/master/docs/add.png)


### Show Tags:

You can use Lister_Tag to show tags with no Form_Tags as well. 
This is exanple how to use it with Grid

    
    function formatRow(){
        parent::formatRow();

            // tag cloud
            if ($this->current_row['tags']) {
                $t = $this->add('x_tags/Lister_Tags','tags_cl_'.$this->current_row['id'],'content');
                $temp_tag_arr = explode(',',$this->current_row['tags']);
                $tag_arr = array();
                $count = 0;
                foreach ($temp_tag_arr as $tag) {
                    $tag_arr[$count++]['value'] = $tag;
                }
                $t->setSource($tag_arr,'value');
                $this->current_row_html['tag_cloud']=$t->getHTML();
            } else {
                $this->current_row_html['tag_cloud'] = '';
            }
    }
    
    
![Screenshot](https://raw.github.com/rvadym/x_tags/master/docs/show.png)
    
Same for CompleteLister
    
    class Lister_Notes extends CompleteLister {
        function formatRow(){
            // tag cloud
            if ($this->current_row['tags']) {
                $t = $this->add('x_tags/Lister_Tags','tags_cl_'.$this->current_row['id']);
                $temp_tag_arr = explode(',',$this->current_row['tags']);
                $tag_arr = array();
                $count = 0;
                foreach ($temp_tag_arr as $tag) {
                    $tag_arr[$count++]['value'] = $tag;
                }
                $t->setSource($tag_arr,'value');
                $this->current_row_html['tag_cloud']=$t->getHTML();
            } else {
                $this->current_row_html['tag_cloud'] = '';
            }
        }
    }
    
### Edit Tags:

    
    $f=$this->add('Form','bform','form');    
    $f->setModel('Model_Article',array('title','text','tags'));    
    $f->addSubmit('Update');
    $this->add('x_tags/Form_Tags',array('connected_form'=>$f));
    
    
    
    
* * *
github README.md formating
http://daringfireball.net/projects/markdown/syntax#html
