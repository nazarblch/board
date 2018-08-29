<?

include("../db.php");

//echo "Пожалуйста подождите...<br>";

//echo $_SERVER['HTTP_REFERER']."<br>"; // нужно проверять

include("checkhost.php");

if( !isset($_POST['user_id']) ) exit("user was lost");
else $user_id = intval($_POST['user_id']);


$res4 = mysql_query( "select img,name from users where id='$user_id' ");
			                        
if($user_row = mysql_fetch_array($res4)){
	echo $user_row['img']."&_&".$user_row['name'];
}else{
	echo "db mistake";
}





?>