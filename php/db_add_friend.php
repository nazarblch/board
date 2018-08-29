<?
include("../db.php");

include("checkhost.php");


if( !isset($_POST['friend_id'])) exit("user id was lost");
$uid1 = $_COOKIE['user_id'];
$uid2 = $_POST['friend_id'];

$res = mysql_query("select * from friend_edges where uid1='$uid1' and uid2='$uid2' ");
if(mysql_num_rows($res) != 0) exit(" edge has already exist ");

$res = mysql_query("insert into friend_edges (uid1,uid2) values('$uid1','$uid2') ");
  
if(!$res)  exit("db error");  
  
echo 1;
  
?>