<?
   include("../db.php");
   
  include("checkhost.php");
   
   if( !isset($_POST['name']) ) exit("name was lost <br>");
   if( !isset($_POST['login']) ) exit("login was lost <br>");
   if( !isset($_POST['pass']) ) exit("pass was lost <br>");
   if( !isset($_POST['email']) ) exit("email was lost <br>");
   
   
   $name = mysql_real_escape_string(trim($_POST['name']));
   $login = mysql_real_escape_string(trim($_POST['login']));
   $pass = mysql_real_escape_string(trim($_POST['pass']));
   $email = mysql_real_escape_string(trim($_POST['email']));
   $ip = $_SERVER['REMOTE_ADDR'];
   
   
   if( isset($_POST['img']) ) $img = mysql_real_escape_string(trim($_POST['img']));
   else $img = "def.jpg";
   
   $res4 = mysql_query("SELECT EXTRACT(YEAR FROM CURRENT_TIMESTAMP ) AS year,EXTRACT(MONTH FROM CURRENT_TIMESTAMP )AS month,EXTRACT(DAY FROM CURRENT_TIMESTAMP ) AS day, EXTRACT(HOUR FROM CURRENT_TIMESTAMP )*60+EXTRACT(MINUTE FROM CURRENT_TIMESTAMP ) as time");
   $time_row = mysql_fetch_array($res4);
   $cur_year = $time_row['year'];
   $cur_month = $time_row['month'];
   $cur_day = $time_row['day'];
   $cur_time = $time_row['time'];
   
   $res4 = mysql_query("select id from users where ip='$ip' ");
   if(mysql_num_rows($res4) > 5){ 
        
		$res4 = mysql_query("select max(time) as mx_time from users where ip='$ip' ");
		$time_row = mysql_fetch_array($res4);
		$time_mx = $time_row["time_mx"];
		$res4 = mysql_query("SELECT EXTRACT(YEAR FROM '$time_mx' ) AS year,EXTRACT(MONTH FROM '$time_mx' )AS month,EXTRACT(DAY FROM '$time_mx' ) AS day, EXTRACT(HOUR FROM '$time_mx' )*60+EXTRACT(MINUTE FROM '$time_mx' ) as time");
        $time_row = mysql_fetch_array($res4);
        $mx_year = $time_row['year'];
        $mx_month = $time_row['month'];
        $mx_day = $time_row['day'];
        $mx_time = $time_row['time'];
   
        if( $mx_year==$cur_year && $mx_month==$cur_month && $mx_day==$cur_day && $mx_time+5 > $cur_time)	
          exit(" Time overflow, wait 5 minutes and try again ");
   }
   
   $res4 = mysql_query("select id from users where login='$login' ");
   if(mysql_num_rows($res4) != 0) exit("user with login=".$login." is already exist <br>");
   
   $pass = md5("my_password_equal_to".$pass);
   if(mysql_query("insert into users (name,login,pass,img,email,ip) values('$name','$login','$pass','$img','$email','$ip') ") ){
	   echo "Данные успешно добавлены <br>";
	   echo "Для подтвержрения регистрации вам отправлено сообщение на: ".$email."<br>";
	   $subject = "Board MSU: Подтвержрение регистрации ";
	   $reg_link = "http://boardmsuru.97.com1.ru/php/reg_confirmation.php?user_id=".mysql_insert_id()."&code=".md5("hesh_key".$img."login=".$login."name=".$name."pass=".$pass."hesh");
	   $message = $name.", Ваш адрес был указан при регистрации нового аккаунта на нашем сервисе. Это письмо — приглашение активировать созданный аккаунт и подтвердить, что введенный адрес является правильным и работающим.<br> Если произошла ошибка и Вы не регистрировались на boardmsu.ru, то просто проигнорируйте это письмо. <br><br>"."Для подтвержрения регистрации перейдите пожалуйста по ссылке: <br>".$reg_link;
	   //mail($email,$subject,$message);
	   echo $message;
   }else{
	   exit("Ooops db mistake!");
   }
     

?>
