<?

function getlines( $title_id , $parent, $level ){
	
	$title_id = intval($title_id);
	$parent = intval($parent);
	
	$res = mysql_query( "select * from chat_lines where  parent='$parent' and title_id = '$title_id' order by id desc  ");
    
	while($line = mysql_fetch_array($res) ){
		
		$id = $line['id'];
		$data = $line['data'];
		$user_id = $line['user_id'];
		
		$res1 = mysql_query( "select * from users where  id='$user_id' ");
		$user_row = mysql_fetch_array($res1);
		$user = $user_row['login'];
		
		$parent = $id; 
		
		$data = substr($data, 0, 120);
		
		echo '
		
			 <tr class="data_line" height="18px;" id="'.$id.'">
				  <td class="first_tab" width="15px" ><div>&nbsp;</div></td>
				 
				  <td align="left" valign="middle"  class="theme_data" >
	    ';
		
		$i = 0;
		for($i = 0; $i <= $level; $i++ ){	  
				  
				echo   '<div  class="tab" >&nbsp;</div>';
				  
		}
		
		$data = substr($data, 0, 120 - $i*5);
		
		
		echo '
					'.$data.' 
				  <a href="" id="'.$user_id.'" class="user" > :'.$user.'</a>
				 
				  </td>
			 </tr>
		 
		';
		
		
		getlines( $title_id , $parent, $level+1 );
		
		
		
	}
		
		
}





function print_insert_form($title_id, $parent_id){
	
	$a = round(rand(0,9));
	$b = round(rand(0,9));
	$ans = $a+$b;
	
    echo '
	
	<tr >
				  <td class="first_tab" width="15px" ><div>&nbsp;</div></td>
				 
				  <td align="left" valign="middle"  class="form_td" >
	
						<form action="php/db_chat_big_insert.php" method="post" name="big_insert" id="big_insert" enctype="multipart/form-data" >
							  
							  <input name="parent" type="hidden" value="'.$parent_id.'" />
							  <input name="title_id" type="hidden" value="'.$title_id.'" />
							  <input name="ansver" type="hidden" value="'.$ans.'" />
							  <input name="user_id" type="hidden" value="" />
				              
							  
							  <br>
							  <label>Заголовок</label><br>
							  <input name="data" type="text" style="width:500px;" maxlength="200" /><br><br>
							  <label>Текст сообшения</label><br>
							  <textarea name="inner_data"  ></textarea><br><br>
							  
							  <label>'.$a.'_+_'.$b.' : </label><input name="check" type="text" size="2" />
							  
							  
							  <div> 
							  <ul id="uploaded_files" style="list-style:none;">
							  </ul>
							     
								 <label id="upload_file_button">Прикрепить файл</label>
								 
							  </div>
							  <br><br>
							  <input name="sub_chat_insert" id="sub_chat_insert" type="button" value="Отправить" /><br>
						
						</form>
	
			     </td>
	</tr>
		
	
	';
	
}






function print_attached_files($id, $db_table){
	
	if($db_table == "titles") $db_table = 1;
	if($db_table == "chat_lines") $db_table = 0;
	
	$res4 = mysql_query( "select * from  attached_files where line_id='$id' and db_table='$db_table' ");
	
	
	while($file_row = mysql_fetch_array($res4)){
	
			$file_id = $file_row['id'];
			$file_src = $file_row['src'];
			$file_name = $file_row['name'];
			$file_type = $file_row['type'];
			if($file_type == 1) $file_type = "txt";
			if($file_type == 2) $file_type = "word";
			if($file_type == 3) $file_type = "pdf";
			if($file_type == 4) $file_type = "xl";
			if($file_type == 5) $file_type = "ppt";
			if($file_type == 6) $file_type = "music";
			if($file_type == 7) $file_type = "flash";
			if($file_type == 8) $file_type = "avi"; 
			$file_link = " attached_files/".$file_src;
			
			
			echo'
					 <div class="attached_file">
					  <a href="'.$file_link.'">
						<img src="img/icons/'.$file_type.'.png" width="16" height="16"  />
						<font>'.$file_name.'</font>
					   </a>
					 </div>
					 
					
			';
	}
}




?>




