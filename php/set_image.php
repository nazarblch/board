<?
    $update_db = false; 
     
    include("../db.php");
	include("crop_resize.php");
	
	include("checkhost.php");
	
	//echo var_dump($_POST);
	
	if( !isset($_POST['data_0']) || intval($_POST['data_0']) == "" ){
	
		$res4 = mysql_query("select max(id) as mx from users");
		$mx_row = mysql_fetch_array($res4);
		$mx = $mx_row['mx'] + 1; 
	
	}else{
		
		$mx = intval($_POST['data_0']);
		
		$res4 = mysql_query("select img,login,pass  from users where id='$mx' ");
		if(mysql_num_rows($res4) == 0){ echo $_POST[0]; exit; }
		$user_row = mysql_fetch_array($res4);
		
		$user_login = $user_row["login"];
		$user_img = $user_row["img"];
	    $user_pass = $user_row["pass"];
		$hash = md5($mx."hesh_key_login"."login=".$user_login."password=".$user_pass."hesh");
		
		if(isset( $_COOKIE['hash'] )  && $_COOKIE['hash'] == $hash ){
			$update_db = true;
			//echo $mx."_";
		}else{
			$update_db = false;
			echo $_POST[0]; 
			exit;
		}
	}
	
	
	
	ini_set( 'display_errors', 0);
    ini_set( 'session.save_path', '/tmp' ); // for debug purposes
    ini_set('session.name', 'set_img_iter');
   
	
	$sessName      = ini_get('session.name'); 
    $sessVar       = $_SERVER['REMOTE_ADDR'];
	$sessVar_time  = $_SERVER['REMOTE_ADDR']."_time";
	
	
	$sessVar    = $_SERVER['REMOTE_ADDR'];
	
	$res4 = mysql_query("select  ses_id  from sessions where ip='$sessVar' or mx='$mx' ");
	if(mysql_num_rows($res4) > 5){
		
		while($sess_row = mysql_fetch_array($res4)){
		     $session_id = $sess_row['ses_id'];
		}
		
		session_id($session_id);
		session_start(); 
		
	}else{
		session_start();
		$session_id = session_id(); 
		mysql_query("insert into sessions (ip,mx,ses_id)  values('$sessVar','$mx','$session_id') ");
	}
	
   
    
	 

	if( !isset( $_SESSION[$sessVar] ) )  $_SESSION[$sessVar] = 1;
	else  $_SESSION[$sessVar] += 1;
	
	if($_SESSION[$sessVar] > 5){
		if( $_SESSION[$sessVar_time] + 5*60 < time() ){
			
			$_SESSION[$sessVar] = 1;
			
		}else{
		     	
			echo $_POST[0];
			exit();

		}
	}
	
	//echo $_SESSION[$sessVar];
	
	
	$sessVar_mx    = $mx."_iter";
	$sessVar_mx_time  = $mx."_time";
	//mysql_query("insert into users (id) values()");
	if( !isset( $_SESSION[$sessVar_mx] ) )  $_SESSION[$sessVar_mx] = 1;
	else  $_SESSION[$sessVar_mx] += 1;
	
	
	
	if($_SESSION[$sessVar_mx] > 25){
		if( $_SESSION[$sessVar_mx_time] + 5*60 < time() ){
			
			$_SESSION[$sessVar_mx] = 1;
			
		}else{
		     	
			echo $_POST[0];
			exit();

		}
	}
	
	$_SESSION[$sessVar_time] = time();
	$_SESSION[$sessVar_mx_time] = time();
	
	
	/*
	$conn_id = @ftp_connect('localhost', 21, 5); // коннектимся к серверу FTP
		
		if($conn_id) // если соединение с сервером прошло удачно, продолжаем
		{
			
			$login_result = @ftp_login($conn_id, '', ''); // вводим свои логин и пароль для FTP
			
			if($login_result) // если сервер принял логин пароль, идем дальше
			{
				//echo "соединение с сервером прошло удачно, продолжаем<br><br>";
				// теперь нужно поиграть с пассивным режимом, включить его или выключить(TRUE, FALSE)
				// если дальнейшие функции ftp будут работать не правильно, пробуйте менять этот параметр (TRUE или FALE)
				ftp_pasv ($conn_id, TRUE); // в данном случае пассивный режим включен
				
				 ftp_chdir ($conn_id, 'board/img/users');
			     ftp_mkdir ($conn_id, "u_".$mx); // ну и само создание папки
				
					
				
			}
		}
		
								
		ftp_close($conn_id); // и закрываем коннект с FTP	
       */
	     
	    //$new_dir = "../img/users/"."u_".$mx;
	    //if( !is_dir($new_dir) ) mkdir($new_dir, 0755);
	    //echo $mx; 
		$uploaddir = "../img/users/avatar/";
		//if ($objs = glob($new_dir."/*")) {
        //    foreach($objs as $obj) {
        //         unlink($obj);
        //    }
        // }
		if(isset( $_POST[0]) && $_POST[0] != "def.jpg" && !isset($user_img) ) unlink($uploaddir.$_POST[0]);
		if( isset($user_img) && $update_db == true && $user_img != "def.jpg")  unlink($uploaddir.$user_img);
		//echo $uploaddir.$_POST[0];
		
		$rand_name = generate_name(10)."_".$mx.".jpg";
		//$uploadfile = $uploaddir.basename($_FILES['myfile']['name']);
		$uploadfile = $uploaddir.$rand_name;
		
		
		move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadfile);
		
		list($w_i, $h_i, $type) = getimagesize($uploadfile);
		
		if( $w_i > 2*$h_i){
			 $dw = ($w_i - 2*$h_i)/2;
			 crop($uploadfile, $uploadfile, array($dw, 0, -$dw, 0) );
		}
		
		if( $w_i*2.5 < $h_i){
			 $dh = ($h_i - $w_i*2.5)/2;
			 crop($uploadfile, $uploadfile, array(0, $dh, 0, -$dh) );
		}
	 
	    if( $w_i > 200 || $h_i > 300) resize($uploadfile,$uploadfile);

        echo $rand_name; 
		
		if( $update_db == true ){
			mysql_query(" update users set img='$rand_name' where id='$mx'  ");
		}
?>