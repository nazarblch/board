<?

include("../db.php");

include("checkhost.php");

if( isset($_POST['name']) ){ 
      $name = htmlspecialchars($_POST['name']);
	  $name =mysql_real_escape_string($name);
}

if( isset($_POST['email']) ){ 
      $email = htmlspecialchars($_POST['email']);
	  $email =mysql_real_escape_string($email);
}


if( isset($_POST['univer']) ){ 
      $univer = htmlspecialchars($_POST['univer']);
	  $univer = mysql_real_escape_string($univer);
}

if( isset($_POST['city']) ){ 
      $city = htmlspecialchars($_POST['city']);
	  $city =mysql_real_escape_string($city);
}


if( isset($_POST['b_day']) ){ 
      $b_day = intval($_POST['b_day']);
}


if( isset($_POST['b_month']) ){ 
      $b_month = htmlspecialchars($_POST['b_month']);
	  $b_month =mysql_real_escape_string($b_month);
}

if( isset($_POST['b_year']) ){ 
      $b_year = intval($_POST['b_year']);
}

if( isset($_POST['tel']) ){ 
      $tel = htmlspecialchars($_POST['tel']);
	  $tel =mysql_real_escape_string($tel);
}

if( isset($_POST['vk']) ){ 
      $vk = intval($_POST['vk']);
}

if( isset($_POST['isq']) ){ 
      $isq = htmlspecialchars($_POST['isq']);
	  $isq =mysql_real_escape_string($isq);
}

if( isset($_POST['skype']) ){ 
      $skype = htmlspecialchars($_POST['skype']);
	  $skype =mysql_real_escape_string($skype);
}

if( isset($_POST['job']) ){ 
      $job = htmlspecialchars(substr($_POST['job'], 0, 255));
	  $job =mysql_real_escape_string($job);
}


if( isset($_COOKIE['user_id']) ){
	    
		$mx = intval($_COOKIE['user_id']);
     	
	    $res4 = mysql_query("select img,login,pass  from users where id='$mx' ");
		if(mysql_num_rows($res4) == 0){ echo "User with id=".$mx." hasn't been registered "; exit; }
		$user_row = mysql_fetch_array($res4);
		
		$user_login = $user_row["login"];
		$user_img = $user_row["img"];
	    $user_pass = $user_row["pass"];
		$hash = md5($mx."hesh_key_login"."login=".$user_login."password=".$user_pass."hesh");
		
		if(isset( $_COOKIE['hash'] )  && $_COOKIE['hash'] == $hash ){
			
           if( ! mysql_query(" update users set name='$name',email='$email',univer='$univer',city='$city',dnuha='$b_day $b_month $b_year',tel='$tel',vk='$vk',isq='$isq',skype='$skype',job='$job'  where id='$mx'  ")) echo ("Ooops db mistake!");			
			
		}else{
			
			echo "Security error : password is incorrect "; 
			exit;
		}
	
}





?>