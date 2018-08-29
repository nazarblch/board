<?

function resize($file_input, $file_output, $max_w = 200, $max_h = 300, $percent = false) {
	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		echo 'Cant get img params';
		return;
    }
    $types = array('','gif','jpeg','png');
    $ext = $types[$type];
    if ($ext) {
    	$func = 'imagecreatefrom'.$ext;
    	$img = $func($file_input);
    } else {
    	echo 'Wrong format';
		return;
    }
	
	$prop_coef = $max_h/$max_w;
	
	if($w_i*$prop_coef > $h_i){
		$w_o = $max_w;
		if($w_i < $max_w) $w_o = $w_i;
	}else{
		$h_o = $max_h;
		if($h_i < $max_h) $h_o = $h_i;
	}
	
	if ($percent) {
		$w_o *= $w_i / 100;
		$h_o *= $h_i / 100;
	}
	
	$dy = 0;
	$dx = 0;
	
	if (!$h_o){ $h_o = $w_o/($w_i/$h_i); }
	if (!$w_o){ $w_o = $h_o/($h_i/$w_i); }
	
	$img_o = imagecreatetruecolor($w_o, $h_o);
    //$img_o = imagecreatefromjpeg("back.jpg");
	//imagecolorallocate($img_o, 0xFF, 0xFF, 0xFF);
	
	
	imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
	if ($type == 2) {
		return imagejpeg($img_o,$file_output,90);
	} else {
		$func = 'image'.$ext;
		return $func($img_o,$file_output);
	}
	
	unset($img_o);
}


//resize('wwww.jpg', 'frame.jpg');

function crop($file_input, $file_output, $crop = 'square',$percent = false) {
	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		echo 'Невозможно получить длину и ширину изображения';
		return;
        }
        $types = array('','gif','jpeg','png');
        $ext = $types[$type];
        if ($ext) {
    	        $func = 'imagecreatefrom'.$ext;
    	        $img = $func($file_input);
        } else {
    	        echo 'Некорректный формат файла';
		return;
        }
	if ($crop == 'square') {
		$min = $w_i;
		if ($w_i > $h_i) $min = $h_i;
		$w_o = $h_o = $min;
	} else {
		list($x_o, $y_o, $w_o, $h_o) = $crop;
		if ($percent) {
			$w_o *= $w_i / 100;
			$h_o *= $h_i / 100;
			$x_o *= $w_i / 100;
			$y_o *= $h_i / 100;
		}
    	        if ($w_o <= 0) $w_o += $w_i;
	        $w_o -= $x_o;
	   	if ($h_o <= 0) $h_o += $h_i;
		$h_o -= $y_o;
	}
	$img_o = imagecreatetruecolor($w_o, $h_o);
	imagecopy($img_o, $img, 0, 0, $x_o, $y_o, $w_o, $h_o);
	if ($type == 2) {
		return imagejpeg($img_o,$file_output,100);
	} else {
		$func = 'image'.$ext;
		return $func($img_o,$file_output);
	}
	
	unset($img_o);
}




function generate_name($number)

 {

 $arr = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s','t','u','v','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V','X','Y','Z','1','2','3','4','5','6','7','8','9','0');

 // Генерируем пароль

 $pass = "";

 for($i = 0; $i < $number; $i++)

 {

 // Вычисляем случайный индекс массива

 $index = rand(0, count($arr) - 1);

 $pass .= $arr[$index];

 }

 return $pass;

 }




?>


