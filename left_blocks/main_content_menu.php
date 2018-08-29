  
  <tr>
    <td valign="top" >
    
        <script type="text/javascript">
		
		     $("div.button").live('click', function(event){
			
					var button_id = $(this).attr('id');
					if(button_id != 0 && button_id != "0")
					     document.location.href = "http://localhost/board/index.php?theme_id=" + button_id;
					else
			             document.location.href = "http://localhost/board/index.php";
	         });	
		
		</script>
        
            <div class="button" id="0" style="background-image:url(img/buttons/menubg.png);" >Все темы</div>
			<div class="separator"></div>
    
		<?
		    if( isset($_GET['theme_id']) ){
				  $get_theme_id = intval($_GET['theme_id']);
			}else{
				if( isset($_GET['line_id']) ){
					
				    $get_line_id = intval($_GET['line_id']);
					$res4 = mysql_query( "select title_id from chat_lines where id='$get_line_id' ");
			        $line_row = mysql_fetch_array($res4);
		            $title_id = $line_row['title_id'];
					$res4 = mysql_query( "select theme_id from titles where id='$title_id' ");
			        $line_row = mysql_fetch_array($res4);
					$get_theme_id = $line_row['theme_id'];
				
				}else{
					
				    $get_theme_id = 0;
				}
			}
			
		    $res4 = mysql_query( "select * from themes where parent='$get_theme_id' ");
			$theme_row = mysql_fetch_array($res4);
			
			
			if( mysql_num_rows($res4) == 0 ){
			     $res4 = mysql_query( "select * from themes where id='$get_theme_id' ");
			     $theme_row = mysql_fetch_array($res4);
				 $theme_parent = $theme_row['parent'];
				
				 $res4 = mysql_query( "select * from themes where parent='$theme_parent' ");
				 $theme_row = mysql_fetch_array($res4);
			}
	        
			do{
				
				$theme_id = $theme_row['id'];
				//$theme_img = $theme_row['img'];
				$theme_name = $theme_row['name'];
				
				echo '<div class="button" id="'.$theme_id.'">'.$theme_name.'</div>';
				echo '<div class="separator"></div>';
				 
			}while($theme_row = mysql_fetch_array($res4));
			
			
		
        ?>
        
       
    
    </td>
 </tr>   
 
 <tr>   
    <td >
    	<div class="news">
        <div  class="news_header"><a href="index.php?page_id=7">Последние новости</a></div>
            <div class="news_content">
            
                <?
				
				$res4 = mysql_query( "select * from news order by time desc LIMIT 5");
			    
				
				while( $new_row = mysql_fetch_array($res4) ){
					
                      $new_title = substr($new_row['title'], 0, 25);
					  $new_data = substr($new_row['data'], 0, 100);
					  
					  echo '
					        <a href="index.php?page_id=7" class="news_title">'.$new_title.'</a>
                            <div class="news_text">'.$new_data.'...</div>
					  ';  					
					
				}
				
				
			
                
				?>
            
               
            </div>
    	</div>
        
        
        
        
    </td>
    
  </tr>