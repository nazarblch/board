<?

 include("../db.php");
 
 if( !isset($_GET['user_id']) ) exit(" User id was lost ");
 else $user_id = intval($_GET['user_id']);

 if( !isset($_GET['code']) ) exit(" Code was lost ");
 else $code = $_GET['code'];

 $res4 = mysql_query(" select * from users where id='$user_id' ");
 if(mysql_num_rows($res4) == 0) exit(" User hasn't found in the data base ");
 
 $user_row = mysql_fetch_array($res4);
 
 $name = $user_row["name"];
 $login = $user_row["login"];
 $img = $user_row["img"];
 $pass = $user_row["pass"];
 $status = $user_row["status"];
 $code_test = md5("hesh_key".$img."login=".$login."name=".$name."pass=".$pass."hesh");
 if( $status != 0 ) exit("User has been already registered");
 
  $new_location = " document.location.href";
 
 if($code_test == $code){ 
	 if(mysql_query(" update users set status=1 where id='$user_id' ")){
	     
		 //$hash = md5("hesh_key_login"."login=".$login."password=".$pass."hesh");
		 $new_location = 'login.php?user_id='.$user_id."&login=".$login."&pass=".$pass;
		 
		   
	 }else{
		 
		 exit("Ooops data base mistake!");
	 }
	 
 }else{
	 
	 exit(" Security error ");
	 
 }

?>

<script type="text/javascript">
    document.location.href = "<? echo $new_location; ?>";
</script>