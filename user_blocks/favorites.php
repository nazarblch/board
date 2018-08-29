<?

$res0 = mysql_query( "select * from favorites where user_id='$user_global_id' ");
if( mysql_num_rows($res0) == 0 ){
	echo "<div class='tab' style=' width: 15px; height:30px;'></div>&nbsp;Закладок с данными параметрами не найдено ";
}


while($favorite_line = mysql_fetch_array($res0)){

	$title_id = $favorite_line['title_id'];

    $res4 = mysql_query( "select * from titles where id='$title_id' ");
	$title_line = mysql_fetch_array($res4);
	
					     $id = $title_line['id'];
						 $data = $title_line['data'];
						 $time = substr($title_line['time'], 5, 11);
						 $user_id = $title_line['user_id'];
						 $theme_id = $title_line['theme_id'];				 
						 
						 $res3 = mysql_query( "select * from users where  id='$user_id' ");
						 $user_row = mysql_fetch_array($res3);
						 $user = $user_row['login'];
						 
						 
						 $res4 = mysql_query( "select * from themes where  id='$theme_id' ");
						 $theme_row = mysql_fetch_array($res4);
						 $theme_img = $theme_row['img'];
						 $theme_name = $theme_row['name']; 
						 
						 echo '
						       <table width="100%"  border="0" cellspacing="0" cellpadding="0" id="t__'.$id.'"  >
							      <tr height="3px">
										<td width="15px" style="border-right:1px #ece9d8 solid;"><div style=" width: 15px;" ></div></td>
										<td></td>
										<td></td>
										<td></td>
										</tr>
									 
									  <tr class="title_line" id="t_'.$id.'">
									  
										  <td width="15px" style="border-right:1px #ece9d8 solid;"><div style=" width: 15px;" >&nbsp;</div></td>
										  <td align="center" valign="middle" width="29px;" style="background-color:#f5f5f5;">
										  <img align="middle" alt="'.$theme_name.'" title="'.$theme_name.'" src="img/theme/'.$theme_img.'" width="22" height="22">
										  </td>
										  
										  <td align="left" valign="middle"  class="theme_title" >
										  '.$data.'
										  <a href="" id="'.$user_id.'" class="user" > :'.$user.'</a>
										   <div class="delete" title="удалить из закладок">&nbsp;</div>
										   <div class="online" title="включить автообновление">&nbsp;</div>
										  </td>
						
										<td align="center" width="100px;" style="background-color:#f5f5f5;"><font color="#999999">'.$time.'</font></td>
										  
									  </tr>
									  
									   <tr height="5px">
										<td width="15px" style="border-right:1px #ece9d8 solid;"><div style=" width: 15px;" ></div></td>
										<td></td>
										<td></td>
										<td></td>
										</tr>
									 
									  <tr>
									  
							   </table> 
								 
						 
						 ';
						 
						 
						 echo '<table width="100%"   border="0" cellspacing="0" cellpadding="0" id="tt_'.$id.'" >';
						 
						 getlines( $id , $first_element, 0 ); 
						 
						 echo '</table>';	 
				   

}



?>