<?  
    include("../db.php");
	include("crop_resize.php");
	
	include("checkhost.php");
	
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
	
	
			$uploaddir = "../img/users/photos/".$mx."/";
			if( !is_dir($uploaddir) ){
				 mkdir($uploaddir, 0755);
				 mkdir($uploaddir."small", 0755);
				 mkdir($uploaddir."mid", 0755);
				 mkdir($uploaddir."big", 0755);
			}
			
			$rand_name = generate_name(10)."_".$mx.".jpg";
			$uploadfile = $uploaddir."mid/".$rand_name;
			
			
			move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadfile);
			
			list($w_i, $h_i, $type) = getimagesize($uploadfile);
			
			resize($uploadfile,$uploadfile, 1000,1000);
			
			$sm_uploadfile = $uploaddir."small/".$rand_name;
			
			if( $w_i > 1.5*$h_i){
				 $dw = ($w_i - 1.5*$h_i)/2;
				 crop($uploadfile, $sm_uploadfile, array($dw, 0, -$dw, 0) );
				 $uploadfile = $sm_uploadfile;
			}
			
			if( $w_i*1.5 < $h_i){
				 $dh = ($h_i - $w_i*1.5)/2;
				 crop($uploadfile, $sm_uploadfile, array(0, $dh, 0, -$dh) );
				 $uploadfile = $sm_uploadfile;
			}
		 
			resize($uploadfile, $sm_uploadfile, 150, 150);
			
	
			echo $rand_name; 
			
			
			mysql_query("insert into user_photos (user_id,src) values('$mx','$rand_name') ");
		}
	}
		
?>