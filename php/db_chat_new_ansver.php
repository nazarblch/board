<?
    include("../db.php");
	
	include("checkhost.php");

    $title_id = intval($_POST['title_id']);
	$enter_time = mysql_real_escape_string( $_POST['enter_time'] );
	
	$res = mysql_query( " select * from chat_lines where  id > '$enter_time' and title_id='$title_id'  order by id   ");
    
	$data = "";
	
	while($line = mysql_fetch_array($res) ){
		
		if( strlen($data) > 5 ) $data = $data.",";
		 
		$user_id = $line['user_id'];
		$res1 = mysql_query( "select * from users where  id='$user_id' ");
		$user_row = mysql_fetch_array($res1);
		$user = $user_row['login']; 
		
		$data = $data.$line['parent']."&_&".$line['id']."&_&".$user."&_&".$line['data']; 
		
	}
	
	echo $data;

?>