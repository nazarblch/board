<link media="screen" rel="stylesheet" href="css/left_style.css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-image:url(img/back/lefttd.jpg); background-repeat:repeat-x; background-color:#d6d6d6;">
  <tr>
    <td  height="10px"></td>
  </tr>

  
    <?
	
	        if ( !isset($_GET['page_id']) && !isset($_GET['user_id']) ){
				  include("left_blocks/main_content_menu.php");
			}
				
		    if ( isset($_GET['user_id']) && !isset($_GET['page_id']) ){
				include_once("left_blocks/my_page.php");
			}
				     
			if ( isset($_GET['page_id']) ){
				     
                switch ($_GET['page_id']) {
					case 1:
						include("left_blocks/main_content_menu.php");
						break;
					case 2:
						include("left_blocks/books_list.php");
						break;
					case 3:
						include("left_blocks/shpargalky.php");
						break;
					case 7:	
						include("left_blocks/news.php");
						break;
					case 8:
						include("left_blocks/search.php");
						break;
					case 9:
						 include("left_blocks/support.php");
						break;
					case 6:	
					case 11:
					case 12:
					case 13:
					case 14:
					case 15:
					case 16:												
					case 17:
					case 18:
					case 19:
						include("left_blocks/my_page.php");
						break;
					
					default:
						include("left_blocks/main_content_menu.php");
				}      
                      
			}
	
   ?>
       
  
</table>
