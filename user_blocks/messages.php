<script type="text/javascript">

$(document).ready(function() {	

$(".mess_line").live('click', function(event){
	if(_user_click == false ){
		var dialog_id = $(this).find(".user").attr('id');
		document.location.href = "index.php?page_id=19&user_id=<? echo $user_global_id; ?>&dialog_id="+dialog_id; 
	}
});

});
</script>

<style>

.mess_title{
	color: #3a9dff;
	font-size:10px;
	font-weight:600;
}

.mess_body{
	color:#555;
	font-size:11px;
	
}

.mess_line .user{
	color: #990000; 
	text-decoration:none;
	opacity:0.6;
	font-weight:600;
	margin-left:10px;
}

.mess_line .self{
	color: #060; 
	text-decoration:none;
	opacity:0.6;
	font-weight:600;
	margin-left:10px;
	cursor:default;
}

.mess_time{
	color:#999;
	
}

</style>

<br><div>Удалить | Выделить все</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr height="10">
	<td></td>
    <td></td>
	<td></td>
</tr>
 
<?
   $color = "#FFFFFF";
  
       $mes_global_res = mysql_query("select * from 
                                       messages,
								      (select max(id) as mid from messages where uid2='$user_cookie_id' group by uid1  ) tb   
                                     where messages.id=tb.mid  order by id desc  ");
  
   while( $mes_global_row = mysql_fetch_array($mes_global_res) ){
	   
	  $user_id =  $mes_global_row['uid1']; 
	  $title =  $mes_global_row['title']; 
	  $time =  substr($mes_global_row['time'], 5, 11);
	  $data = $mes_global_row['data'];
	  $more = "";
	  if(strlen($data) > 120){
		  $more = "&nbsp;&nbsp;...";
	  }
	  $data =  substr( $data, 0, 120);
	   
	  $res3 = mysql_query( "select * from users where  id='$user_id' ");
	  $user_row = mysql_fetch_array($res3);
	  $login = $user_row['login'];
	  $name = $user_row['name'];
	   
	   echo ' <tr class="mess_line" bgcolor="'.$color.'" height="35" >
				<td><a href="" id="'.$user_id.'" class="user" >'.$login.'</a></td>
				<td><div class="mess_title">'.$title.'</div> <div class="mess_body"> '.$data.$more.'</div></td>
				<td width="80"><div class="mess_time">'.$time.'</div></td>
             </tr>
       ';
	   
	   if( $color == "#FFFFFF") $color = "#e7e7e7";
	   else $color = "#FFFFFF"; 
	   
   }
 
?>

</table>


<div class="users_info_arr" >
			 
			
  </div>