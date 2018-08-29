<style>
.wall_line{
	padding:5px;
	margin-top:10px;
	border-bottom:#CCC 1px solid;
	border-top:#CCC 1px solid;
}
</style>

<?
if(!isset($user_global_id) && !isset($_COOKIE["user_id"])) exit(" User id hasn't been defined ");
  
  if(!isset($user_global_id) && isset($_COOKIE["user_id"])){
       $u_wall_res = mysql_query( "select * from wall_lines where user_id='$user_cookie_id' order by id desc ");
  }else{
	   $u_wall_res = mysql_query( "select * from wall_lines where user_id='$user_global_id' order by id desc ");
  }
  
  if( $user_global_page == "self"){
	 //add line
  }
  
  if(mysql_num_rows($u_wall_res) == 0)exit("Wall is empty");
  
  while( $u_wall_row = mysql_fetch_array($u_wall_res) ){
	  
	  $user_from_id = $u_wall_row['user_from_id'];
	  $line_data = $u_wall_row['data'];
	  $line_time = $u_wall_row['time'];
	  $res4 = mysql_query( "select * from users where  id='$user_from_id' ");
	  $user_from_row = mysql_fetch_array($res4);
	  $user_from_name = $user_from_row['name'];
	  $user_from_login = $user_from_row['login'];
	  $user_from_img = $user_from_row['img'];
	
	   echo '
	   <div class="wall_line">
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="center" valign="middle" width="100">
			  <img src="img/users/avatar/'.$user_from_img.'" style="max-height:90px; max-width:90px;">
			</td>
			<td valign="top"  align="left">
			<div>'.$user_from_login.':&nbsp;'.$user_from_name.'</div>
			<div>'.$line_data.'</div>
			<div>'.$line_time.' | Комментировать</div>
			</td>
		  </tr>
		</table>
	   </div>
	   ';
  }

?>