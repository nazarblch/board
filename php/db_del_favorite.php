<?
 include("../db.php");
 
 include("checkhost.php");
 
 $title_id = intval($_POST['title_id']);
 $user_id = intval($_COOKIE['user_id']);
 mysql_query(" delete from favorites where user_id='$user_id' and title_id='$title_id' ");

?>