    <a href="index.php" class="top_sec_menu" onclick="hs.width=1000;hs.height=500;return hs.htmlExpand(this, { headingText: 'Новое сообщение' })">
	    Новое сообщение
    </a>
    
    <div class="highslide-maincontent" >
    
         <?
    
         $a = round(rand()/10000);
	     $b = round(rand()/1000);
	     $ans = $a+$b;
	
         ?>
    
    
         <form action="php/db_chat_insert_title.php" method="post" name="chat_insert_title" id="chat_insert_title" enctype="multipart/form-data" >
							  
							  <input name="ansver" type="hidden" value="<? echo $ans; ?>" />
							  <input name="user_id" type="hidden" value="" />
				              
							  
							  <br>
							  <label style="padding-right:180px;">Тема</label><label>Заголовок</label><br>
							  
							  <select name="theme_id" style="width:200px;">
                              
                                 <?
								    $res4 = mysql_query( "select id,name from themes ");
			                        
									
									while($theme_row = mysql_fetch_array($res4) ){
									
										$theme_id = $theme_row['id'];
										//$theme_img = $theme_row['img'];
										$theme_name = $theme_row['name'];
										
										$selected = "";
										if( $_GET['theme_id'] == $theme_id) $selected = "selected";
 										
										echo '<option value="'.$theme_id.'" '.$selected.'>'.$theme_name.'</option>';
									
									}
								   
							     ?>
							     
							  </select>
							  
							  <input name="data" type="text" style="width:500px;" maxlength="200" /><br><br>
							  <label>Текст сообшения</label><br>
							  <textarea name="inner_data" style="width:993px; height: 250px;"></textarea><br><br>
							  
							  <label><? echo $a."_+_".$b; ?> : </label><input name="check" type="text" size="2" />
							  
							  
							  <div style="float:right;"> 
							     
								 <label>Прикрепить файл</label>
								 
							  </div>
							  <br><br>
							  <input name="sub_chat_insert_title" id="sub_chat_insert_title" type="button" value="Отправить" /><br>
						
		 </form>
         

    </div>
    
    
    <a href="index.php" class="top_sec_menu" onclick="hs.width=500;hs.height=200;return hs.htmlExpand(this, { headingText: 'Добавить тему' })">
	    Добавить тему
    </a>
    
    <div class="highslide-maincontent" >
    
         <?
    
         $a = round(rand()/10000);
	     $b = round(rand()/1000);
	     $ans = $a+$b;
	
         ?>          
    
         <form action="php/db_chat_add_theme.php" method="post" name="chat_add_theme" id="chat_add_theme" enctype="multipart/form-data"  >
							  
							  <input name="ansver" type="hidden" value="<? echo $ans; ?>" />
							  <input name="user_id" type="hidden" value="" />
				              
							  <br>
							  <label style="padding-right:160px;">Тема-отец</label><label>Название темы</label><br>
							  
							  <select name="parent" style="width:200px;">
                              
                                 <?
								    $res4 = mysql_query( "select id,name from themes ");
			                        
									
									while($theme_row = mysql_fetch_array($res4) ){
									
										$theme_id = $theme_row['id'];
										//$theme_img = $theme_row['img'];
										$theme_name = $theme_row['name'];
										
										$selected = "";
										if( $_GET['theme_id'] == $theme_id) $selected = "selected";
 										
										echo '<option value="'.$theme_id.'" '.$selected.'>'.$theme_name.'</option>';
									
									}
								   
							     ?>
							     
							  </select>
							  
							  <input name="data" type="text" style="width:200px;" maxlength="50" /><br><br>
							  
							  <label><? echo $a."_+_".$b; ?> : </label><input name="check" type="text" size="2" />
							  
							  <br><br>
							  <input name="sub_chat_add_theme" id="sub_chat_add_theme" type="button" value="Отправить" /><br>
						
		 </form>
         

    </div>
    
   
    
    <a href="index.php?page_id=10&sub_page=<? if( !isset($_GET['page_id']) ) echo "1"; else echo $_GET['page_id'];  ?>" class="top_sec_menu" >
	    Настройки
    </a>
    
    
    