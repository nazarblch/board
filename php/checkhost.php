<? 

$host = substr($_SERVER['HTTP_REFERER'], 7, 11);

if($host != "boardmsu.ru" && $host != "boardmsuru.") exit("HTTP_REFERER isn't accepted <br>".$host);



?>