<?
include("../db.php");

include("checkhost.php");


if( !isset($_POST['friend_id'])) exit("user id was lost");
$uid2 = $_COOKIE['user_id'];
$uid1 = $_POST['friend_id'];

$res = mysql_query("select * from friend_edges where uid1='$uid1' and uid2='$uid2' and status='0' ");
if(mysql_num_rows($res) == 0) exit(" edge is not exist ");
$row = mysql_fetch_array($res);
$edge_id = $row['id']; 

$res = mysql_query("update friend_edges set status='1' where id='$edge_id' ");
  
if(!$res)  exit("db error");  
  
echo 1;
  
?>