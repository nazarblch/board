<?

include("../db.php");

echo "Пожалуйста подождите...<br>";

//echo $_SERVER['HTTP_REFERER']."<br>"; // нужно проверять

include("checkhost.php");

if( !isset($_POST['parent']) ) exit("The parent was lost");
$parent = intval($_POST['parent']);

if( !isset($_POST['title_id']) ) exit("The title was lost");
$title_id = intval($_POST['title_id']);

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



if( mysql_query( "insert  into  chat_lines  (data,parent,title_id,user_id,inner_data)  values('$data','$parent','$title_id','$user_id','$inner_data') ") ){
			 
			 echo "Данные успешно добавлены<br>";
			 
			 $line_id = mysql_insert_id();
			 $i = 0;
			 while( isset($_POST['file_id_'.$i]) ) {
				 
				 $file_id = intval($_POST['file_id_'.$i]);
				 mysql_query(" update attached_files set line_id='$line_id' where id='$file_id' and line_id='0' and db_table='0'  ");
				 $i++;
			 }
			 
			
			 
}else{
	
	         echo "Ooops! db mistake <br>";
}


?>


<script type='text/javascript'>
		document.location.href="<? echo $_SERVER['HTTP_REFERER']; ?>";
</script>