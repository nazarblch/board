<?
include("../db.php");

include("checkhost.php");


$edge_id = $_POST["e_id"];

$res = mysql_query("delete from friend_edges where id='$edge_id' ");
  
if(!$res)  exit("db error");  
  
echo 1;
  
?>