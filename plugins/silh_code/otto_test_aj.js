function toggle_showhide(page_id, var_name, default_value) 
{
     jQuery.ajax({
       url: my_ajax_script.ajaxurl,
       type: 'POST',
       data: ({'action' : 'get_otto_t',
       	       'page_id' : page_id,
       	       'var_name' : var_name,
       	       'default_value' : default_value
              }),
       success: function() {
       	 return false;
       }
     });
     location.reload(true);
}