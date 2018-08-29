<?
$db=mysql_connect ("localhost", "boardms3_nazar", "hgiDGmuzvEM4raKxd") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("boardms3_main"); 
mysql_query( 'SET NAMES utf8' );
?>