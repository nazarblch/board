<?

include("../db.php");

echo "Пожалуйста подождите...<br>";

//echo $_SERVER['HTTP_REFERER']."<br>"; // нужно проверять

include("checkhost.php");

if( !isset($_POST['theme_id']) ) exit("The theme was lost");
$theme_id = intval($_POST['theme_id']);

if( !isset($_POST['data']) ) exit("The data was lost");
$data = htmlspecialchars($_POST['data']);
$data = mysql_real_escape_string($data);

if( isset($_POST['inner_data']) ) {
	$inner_data = htmlspecialchars($_POST['inner_data']);
	$inner_data = mysql_real_escape_string($inner_data);
}else{
	$inner_data = "";
}

if( !isset($_POST['user_id']) ) exit("The user_id was lost");
$user_id = intval($_POST['user_id']);



if( mysql_query( "insert  into  titles  (data,theme_id,user_id,inner_data)  values('$data','$theme_id','$user_id','$inner_data') ") ){
			 
			 echo "Данные успешно добавлены<br>";
			 
			
			 
}else{
	
	         exit( "Ooops! db mistake <br>" );
}


?>


<script type='text/javascript'>
		document.location.href="http://localhost/board/index.php?theme_id=<? echo $theme_id; ?>";
</script>