<?php
 include("../db.php");
	
include("checkhost.php");
	
	//echo var_dump($_POST);

/*
$ftp_server = "localhost";
$conn_id = ftp_connect($ftp_server);
$login_result = ftp_login($conn_id, "nazar", "nazar");

if ((!$conn_id) || (!$login_result)) {
        exit;
} else {
       $upload = ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY);
	   // проверка результата
		if (!$upload) {
				echo "Не удалось закачать файл!";
		} else {
				echo "Файл $source_file закачен на $ftp_server под именем $destination_file";
		}
}
ftp_close($conn_id);
*/

// instead
$uploadfile = "../attached_files/text/".$_FILES['myfile']['name'];
move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadfile); 

$src = "text/".$_FILES['myfile']['name'];
$name = $_FILES['myfile']['name'];
$db_table = intval($_POST['data_0']);
$type = 1;
mysql_query("insert into attached_files (src,name,line_id,type,db_table) values('$src','$name','0','$type','$db_table') ");

echo mysql_insert_id();

?> 