<?

   include("../db.php");
   
   $mx_res = mysql_query( "select max(id) as mx from chat_lines");
   $mx_row = mysql_fetch_array($mx_res);
   $mx_id = $mx_row['mx'];

   echo $mx_id;         //date("Y-m-d H:m:s");

?>