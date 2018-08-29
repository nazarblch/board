<table width="100%" border="0" cellspacing="0" cellpadding="0">
<? 


if( !isset($user_cookie_id) ) exit("Security error: user id hasn't been found in cookies");

if(  $user_global_page != "self" ){
     $resf = mysql_query(" select * from friend_edges where (uid1='$user_global_id' or uid2='$user_global_id') and status='1' ");
	 
}else{
	
	 $resf = mysql_query("select * from friend_edges where uid2='$user_cookie_id' and status='0' union  select * from friend_edges where (uid1='$user_global_id' or uid2='$user_global_id') and status='1' ");
}

while( $friends_row = mysql_fetch_array($resf) ){
	 $user_id = $friends_row['uid1'];
	 if( $user_id == $user_global_id )  $user_id = $friends_row['uid2'];
	 
	  $res3 = mysql_query( "select * from users where  id='$user_id' ");
	  $user_row = mysql_fetch_array($res3);
	  $login = $user_row['login'];
	  $name = $user_row['name'];
	  $img = $user_row['img'];
	  
	  echo "<tr id='e_".$friends_row['id']."'>
				<td align='center' width='100'><img src='img/users/avatar/".$img."'  style='max-height:80px; max-width:80px' /></td>
				<td align='left' valign='top'>
				   <div><a class='friend_link' href='index.php?user_id=".$user_id."'>".$login.": ".$name."</a></div>";
	if($friends_row['status'] == 0) echo "<div><font class='friend_confirm' id='uid".$user_id."'>добавить в друзья</font>   
	                              <font  class='friend_del' id='uid". $user_id."'>отклонить заявку</font></div>";
	else                          echo "<div>
	                                       <font  class='send_msg' id='uid". $user_id."'>Отправить сообщение </font>
	                                      <font  class='friend_del' id='uid". $user_id."'>Удадить из друзей</font>
										  </div>";						  
	echo "      </td>
          </tr>";
}

?>

</table>

  