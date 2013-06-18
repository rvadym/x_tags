/**
 * Created with JetBrains PhpStorm.
 * User: vadym
 * Date: 1/10/13
 * Time: 11:33 PM
 * To change this template use File | Settings | File Templates.
 */

(function($){

$.x_tags=function(){
	return $.x_tags;
}

$.fn.extend({x_tags:function(){
	var u=new $.x_tags;
	u.jquery=this;
	return u;
}});


$.x_tags._import=function(name,fn){
	$.x_tags[name]=function(){
		var ret=fn.apply($.x_tags,arguments);
		return ret?ret:$.x_tags;
	}
}

$.each({


    removeTagId: function(field_id,id){
        field = $('#'+field_id);
        var obj = $.parseJSON(field.val());

        for(i in obj){
            if (i == id) delete obj[i];
        }

        field.val($.univ.toJSON(obj));
    },

    addTag: function(field_id,tag_obj){
        field = $('#'+field_id);
        var obj = $.parseJSON(field.val());

        for(i in tag_obj){
            obj[i] = tag_obj[i];
        }

        field.val($.univ.toJSON(obj));
    }

},$.x_tags._import);

})(jQuery);