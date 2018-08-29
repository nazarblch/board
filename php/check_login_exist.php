<?
   include("../db.php");
   
   include("checkhost.php");
   
   if( !isset($_POST['login']) ){
	   echo true;
	   exit();
   }else{
	   $login = mysql_real_escape_string($_POST['login']);
   }
   
   $res4 = mysql_query("select id from users where login='$login' ");
   
   if(mysql_num_rows($res4) != 0) echo true;
   else echo false;

?>