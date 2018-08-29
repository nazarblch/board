<?
include("php/chat.php");
	
?>
<link media="screen" rel="stylesheet" href="css/content_style.css" />
<script type="text/javascript" src="js/cookie.js" ></script>
<script type="text/javascript" src="js/chat_lines.js" ></script>
<script type="text/javascript">
   $(document).ready(function(){
	    
       var time = get_server_time();    
	      
	   
	   setCookie('enter_time', time, '', '/');
	   
	  // setInterval("check_new_lines(1)", 5000);   // активная
	   
	   var user_id = getCookie('user_id');
	  
	   if( getCookie('online') != null && getCookie('online').length > 0 ){
		   // alert(getCookie('online'));
            var line_id;		   
		    var cookies = getCookie('online').split('_');
			for(var i = 0; i < cookies.length; i++){
				line_id = cookies[i];
				if( !is_int(line_id) ) continue;
				_online_arr[line_id] = setInterval("check_new_lines("+line_id+")", 5000);
				$("table[id=t__"+line_id+"]").find(".online").css({"color":"#5BA655","visibility":"visible"});
			}
	   }
	   
	   $("#content").find("a#"+user_id).each(function(ind, oelem)
					{	
					    $(this).removeClass('user');
						$(this).addClass('self');						
					}
		);
	   
	   
	    $('.user_info_class').each(function(ind, oelem)
					{	
					    $(this).hide();	
						
					}
		);
	  
	   
   });
</script>
<table width="100%" height="" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" >
  
  <tr>
   
    
    
    <td  bgcolor="#FFFFFF" align="left" valign="top" id="content" > <!-- content -->    
		<? 
		    if ( !isset($_GET['page_id']) && !isset($_GET['user_id']) ){
				 include("main_content.php");
			}
				
		    if ( isset($_GET['user_id']) && !isset($_GET['page_id']) ){
				include_once("my_page.php");
			}
				     
					 
			if ( isset($_GET['page_id']) ){
				     
                switch ($_GET['page_id']) {
					case 1:
						include("main_content.php");
						break;
					case 2:
						include("books.php");
						break;
					case 3:
						include("shpargalky.php");
						break;
					case 4:
						echo include("invite.php");
						break;
					case 6:
						include("my_page.php");
						break;
					case 7:
						include("news.php");
						break;
					case 8:
						include("search.php");
						break;
					case 9:
						include("support.php");
						break;
					case 10:
						include("settings.php");
						break;
					case 11:
						include("user_blocks/info.php");
						break;
					case 12:
						include("user_blocks/friends.php");
						break;
					case 13:
						include("user_blocks/wall.php");
						break;
					case 14:
						include("user_blocks/user_photos.php");
						break;
					case 15:
						include("user_blocks/user_video.php");
						break;
					case 16:
						include("user_blocks/user_articles.php");
						break;													
					case 17:
						include("user_blocks/favorites.php");
						break;
					case 18:
						include("user_blocks/messages.php");
						break;
					case 19:
					    include("user_blocks/dialog.php");
						break; 		
					
					default:
						include("main_content.php");
				}      			
				 
			}
		
		
	    ?>
   </td> <!-- end content -->
    
    
 
    
  </tr>
  
 
  
</table>
