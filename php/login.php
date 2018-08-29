<?

 include("../db.php");
 
 include("checkhost.php");
 
 if( isset($_GET['user_id']) ) $user_id = intval($_GET['user_id']);
 if( isset($_POST['user_id']) ) $user_id = intval($_POST['user_id']);

 if( !isset($_GET['login']) && !isset($_POST['login']) ) exit(" login was lost ");
 if( isset($_GET['login']) ) $login = mysql_real_escape_string($_GET['login']);
 if( isset($_POST['login']) ) $login = mysql_real_escape_string($_POST['login']);
 
 if( !isset($_GET['pass']) && !isset($_POST['pass']) ) exit(" password was lost ");
 if( isset($_GET['pass']) ) $pass = $_GET['pass'];
 if( isset($_POST['pass']) ) $pass = $_POST['pass'];
 
 if( isset($_POST['sub_login_form']) || isset($_GET['sub_login_form']) ) $pass = md5("my_password_equal_to".$pass);
 
 
 if( isset($user_id) ) $res4 = mysql_query(" select * from users where id='$user_id' and login='$login' ");
 else $res4 = mysql_query(" select * from users where  login='$login' ");
 if(mysql_num_rows($res4) == 0) exit(" User hasn't been found in the data base ");
 
 $user_row = mysql_fetch_array($res4);
 
 $user_id = $user_row["id"]; 
 $name = $user_row["name"];
 //$login = $user_row["login"];
 //$img = $user_row["img"];
 $pass_test = $user_row["pass"];
 
 if($pass_test != $pass) exit(" Security error: ".$pass." password isn't correct ");
 
 $hash = md5($user_id."hesh_key_login"."login=".$login."password=".$pass."hesh");


 setcookie("user_id", $user_id, mktime(0, 0, 0, 7, 1, 2020),  "/", $_SERVER['SERVER_NAME'], 0);
 setcookie("hash", $hash, mktime(0, 0, 0, 7, 1, 2020),  "/", $_SERVER['SERVER_NAME'], 0);

 //header('Location: ../index.php?user_id='.$user_id."&hash=".$hash);


?>

<script type="text/javascript">
    document.location.href = "../index.php?user_id=<? echo $user_id; ?>";
</script>