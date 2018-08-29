<?

include("../db.php");

include("checkhost.php");


if( !isset($_POST['parent']) ) $parent = 0;
else $parent = intval($_POST['parent']);

if( !isset($_POST['title']) ) exit("Title was lost");
$title = htmlspecialchars($_POST['title']);
$title = mysql_real_escape_string($title);

if( !isset($_POST['data']) ) exit("Data was lost");
$data = htmlspecialchars($_POST['data']);
$data = mysql_real_escape_string($data);
$data =  substr( $data, 0, 900);

if( !isset($_POST['uid2']) ) exit("The user_id was lost");
$uid2 = intval($_POST['uid2']);

$uid1 = intval($_COOKIE['user_id']);



if( mysql_query( "insert into messages (data,parent,title,uid1,uid2) values('$data','$parent','$title','$uid1','$uid2') ") ){
			 
			 $line_id = mysql_insert_id();
			 $i = 0;
			 while( isset($_POST['file_id_'.$i]) ) {
				 
				 $file_id = intval($_POST['file_id_'.$i]);
				 mysql_query(" update attached_files set line_id='$line_id' where id='$file_id' and line_id='0' and db_table='1'  ");
				 $i++;
			 }
			 
			 echo 1;
			 
}else{
	
	         echo "Ooops! db mistake <br>";
}




?>
