


function fjern_link(page_id, gruppe, link_nr) 
{
     jQuery.ajax({
       url: fjern_link_script.ajaxurl,
       type: 'POST',
       data: ({'action' : 'fjern_link',
       	       'page_id' : page_id,
      	       'gruppe' : gruppe,
      	       'link_nr' : link_nr
             }),
       success: function() {
      	 return false;
       }
     });

    sleep(1000, refresh_afterwords);
}



function move_link_up(page_id, gruppe, link_nr) 
{
     jQuery.ajax({
       url: move_link_up_script.ajaxurl,
       type: 'POST',
       data: ({'action' : 'move_link_up',
               'page_id' : page_id,
               'gruppe' : gruppe,
               'link_nr' : link_nr
             }),
       success: function() {
         return false;
       }
     });

    sleep(1000, refresh_afterwords);
}


function move_link_down(page_id, gruppe, link_nr) 
{
     jQuery.ajax({
       url: move_link_down_script.ajaxurl,
       type: 'POST',
       data: ({'action' : 'move_link_down',
               'page_id' : page_id,
               'gruppe' : gruppe,
               'link_nr' : link_nr
             }),
       success: function() {
         return false;
       }
     });

    sleep(1000, refresh_afterwords);
}

