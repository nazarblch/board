<?
    include("../db.php");
	
	include("checkhost.php");
	
    $dialog_id = intval($_POST['dialog_id']);
	$max_id = intval($_POST['max_id']);
	$user_cookie_id = intval($_COOKIE['user_id']);
	
	
	$res = mysql_query( " select * from  messages
					      where ( uid2='$user_cookie_id' and uid1='$dialog_id' and  id>'$max_id' ) or ( uid1='$user_cookie_id' and uid2='$dialog_id' and id>'$max_id' ) 
                          order by id ");
    
	$mess_data = "";
	$new_max_id = 0;
	
	if(mysql_num_rows($res)){
	
	while($mes_global_row = mysql_fetch_array($res) ){
		
	    if( strlen($mess_data) > 5 ) $mess_data = $mess_data."&_and_&";
		
		$new_max_id = $mes_global_row["id"];  
		
		$uid2 = $mes_global_row['uid2'];
		if($uid2 != $user_cookie_id){
	        $cont_type = "self";
		  }else{
			  $cont_type = "user";
		}
		
		  $title =  substr( $mes_global_row['title'], 0, 70); 
		  $time =  substr($mes_global_row['time'], 5, 11);
		  $data = $mes_global_row['data'];
		  $more = "";
		  if(strlen($data) > 900){
			  $more = "&nbsp;&nbsp;...";
		  }
		  $data =  substr( $data, 0, 900);
		
		$mess_data = $mess_data.'<tr>
						<td >
							<div class="dialog_line">
							   <div class="'.$cont_type.'_dialog_container">
								  <div class="dialog_t"></div>
								  <div class="dialog_m">
									 <div><div class="mess_title">'.$title.'</div><font class="dialog_time">'.$time.'</font></div>
									 <div class="mess_body">'.$data.$more.'</div>
								  </div>
								  <div class="dialog_b"></div>
							   </div>
							</div>   
						</td>
					</tr>';
		
	}
	
	echo $new_max_id."&_mess_&".$mess_data;
	
	}else{
		echo 0;
	}

?>