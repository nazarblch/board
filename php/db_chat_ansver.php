<?php

    include("../db.php");
	
	include("checkhost.php");
	
	
	$parent = intval($_POST['parent']);
	if($_POST['parent_is_title'] == 1) $parent = 0;
	$user_id = intval($_POST['user_id']);
	$data = htmlspecialchars($_POST['data']);
	$data = stripslashes($data);
	$data = mysql_real_escape_string($data);
	$data = substr($data, 0, 120);
	
	if( isset($_POST['title_id']) ) $title_id = intval( substr($_POST['title_id'],3) );
	else $title_id = 0;
	
	$res1 = mysql_query( "select * from users where  id='$user_id' ");
    $user_row = mysql_fetch_array($res1);
    $user = $user_row['login'];
		
	if( mysql_query( "insert  into  chat_lines  (data,parent,title_id,user_id,inner_data)  values('$data','$parent','$title_id','$user_id','') ") ){
			 
			 echo stripslashes($data)."&_&".$user."&_&".mysql_insert_id();
			 
	}else{
		
		     echo "db insert error"; 
	}
		 
	
	
	
	
	
	
?>