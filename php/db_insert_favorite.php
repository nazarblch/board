<?
 include("../db.php");
 
 include("checkhost.php");
 
 $title_id = intval($_POST['title_id']);
 $user_id = intval($_COOKIE['user_id']);
 mysql_query(" insert into favorites (user_id,title_id) values('$user_id','$title_id')  ");

?>