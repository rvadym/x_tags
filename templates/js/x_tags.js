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

    removeTagId: function(field_id,id,separator){
        field = $('#'+field_id);
        arr = field.val().split(separator);

        for (i=0;i<arr.length; i++) {
            if (arr[i]==id) {
                cut = (i==0)? 1 : i;
                arr.splice(i,cut);
            }
        }

        j = arr.join(separator);
        field.val(j);
    }

},$.x_tags._import);

})(jQuery);