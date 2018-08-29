<?

include("../db.php");

echo "Пожалуйста подождите...<br>";

//echo $_SERVER['HTTP_REFERER']."<br>"; // нужно проверять

include("checkhost.php");


if( !isset($_POST['parent']) ) exit("The parent was lost");
$parent = intval($_POST['parent']);


if( !isset($_POST['data']) ) exit("The data was lost");
$data = htmlspecialchars($_POST['data']);
$data = mysql_real_escape_string($data);


if( !isset($_POST['user_id']) ) exit("The user_id was lost");
$user_id = intval($_POST['user_id']);

$img = "1.jpg";

if( mysql_query( "insert into themes  (name,parent,user_id,img)  values('$data','$parent','$user_id','$img') ") ){
			 
			 echo "Данные успешно добавлены<br>";
			 
			
			 
}else{
	
	         exit( "Ooops! db mistake <br>" );
}


?>


<script type='text/javascript'>
    document.location.href="http://localhost/board/index.php?theme_id=<? echo $parent; ?>";
</script>