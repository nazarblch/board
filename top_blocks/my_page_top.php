<?
if( isset($_GET['user_id']) ) $get_params = "&user_id=".$_GET['user_id']; 
if( isset($_COOKIE['user_id']) ) $get_params_self = "&user_id=".$_COOKIE['user_id']; 
?>
 <a href="index.php?page_id=11<? echo $get_params; ?>" class="top_sec_menu" >
       Информация
 </a>
 
  <a href="index.php?page_id=18<? echo  $get_params_self; ?>" class="top_sec_menu" >
       Сообщения
 </a>
 
 <a href="index.php?page_id=12<? echo $get_params; ?>" class="top_sec_menu" >
       Друзья
 </a>
 
 <a href="index.php?page_id=13<? echo $get_params; ?>" class="top_sec_menu" >
       Стена
 </a>
 
 <a href="index.php?page_id=14<? echo $get_params; ?>" class="top_sec_menu" >
       Фотографии
 </a>
 
 <a href="index.php?page_id=15<? echo $get_params; ?>" class="top_sec_menu" >
       Видео
 </a>
 
 <a href="index.php?page_id=16<? echo $get_params; ?>" class="top_sec_menu" >
       Статьи
 </a>
 
 <a href="index.php?page_id=17<? echo  $get_params_self; ?>" class="top_sec_menu" >
       Закладки
 </a>