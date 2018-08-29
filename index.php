<?
 $global_host_name = "http://localhost/board";
 include("db.php");
 include("php/top_menu_func.php");
  
 global $user_global_row, $user_global_login, $user_global_name, $user_global_pass, $user_global_page, $user_global_status; 
  
 if ( isset($_GET['user_id']) ){
	 
	 $user_global_id = intval($_GET['user_id']);
 
 }
 
 if ( isset($_COOKIE['user_id']) ){
		 
		 $user_cookie_id = intval($_COOKIE['user_id']);
 }
 
 if ( isset($user_global_id) ){
	 
	 $res10 = mysql_query( "select * from users where  id='$user_global_id' ");
	 if( mysql_num_rows($res10) == 0 ) exit("Пользователь с id=".$user_global_id." не найден в базе");
	 $user_global_row = mysql_fetch_array($res10);
	 
	 $user_global_login = $user_global_row['login'];
	 $user_global_name = $user_global_row['name'];
	 $user_global_pass = $user_global_row['pass'];
	 $user_global_status = $user_global_row['status'];
	 $user_global_email = $user_global_row['email'];
	 
	 $user_global_hash = md5($user_global_id."hesh_key_login"."login=".$user_global_login."password=".$user_global_pass."hesh");
	 
	 if( isset($_COOKIE['hash']) && $_COOKIE['hash'] == $user_global_hash ){
		 $user_global_page = "self";
		 if($user_global_status == 0) exit("Пожалуйста подтвердите регистрацию на".$user_global_email);
	 }else{
		 $user_global_page = "user";
	 }
	 
 }
 
?>
<?

if( isset($_GET['page_id']) && !isset($_GET['user_id']) ){
    $page_id = intval($_GET['page_id']);
    $res0 = mysql_query( "select * from pages where id='$page_id' ");
	$page_row = mysql_fetch_array($res0);
	$page_name = $page_row['name'];
	$page_link = "index.php?page_id=".$page_id;  
}else{
	if( !isset($_GET['user_id']) ){
		$page_name = "чат";
		$page_link = "index.php";
		$page_id = 1;
	}else{
		$page_name = $user_global_login;
		$page_link = "index.php?user_id=".$_GET['user_id'];
	}
}

	$pass = "<img src='img/back/pathsep.jpg'>&nbsp;&nbsp;";
	    
	$pass = $pass."<a class='pass_link'  href='".$page_link."'>".$page_name."</a>";
	
	
	
if( isset($_GET['theme_id']) && !isset($_GET['line_id']) && !isset($_GET['title_id'])  ){
	$theme_get_id = intval($_GET['theme_id']);
	$pass = $pass.make_pass($theme_get_id, "theme");
}


if(  !isset($_GET['line_id']) && isset($_GET['title_id'])  ){
	$title_get_id = intval($_GET['title_id']);
	$pass = $pass.make_pass($title_get_id, "title");
}

if( isset($_GET['line_id']) ){
	$line_get_id = intval($_GET['line_id']);
	$pass = $pass.make_pass($line_get_id, "line");
}

$pass = $pass."&nbsp;&nbsp;<img src='img/back/pathsep.jpg'>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<link media="screen" rel="stylesheet" href="css/main_style.css" />
<script src="js/jquery_min.js" type="text/javascript"></script>
<script src="js/jquery.easing-1.3.min.js" type="text/javascript"></script>
<script src="js/ajaxupload.js" type="text/javascript"></script>


<script src="js/popup_mess.js" type="text/javascript"></script>

<script type="text/javascript" src="highslide/highslide-with-html.packed.js"></script>

<!-- stylesheets -->
  	<link rel="stylesheet" href="css/slide.css" type="text/css" media="screen" />
	
  	<!-- PNG FIX for IE6 -->
  	<!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
	<!--[if lte IE 6]>
		<script type="text/javascript" src="js/pngfix/supersleight-min.js"></script>
	<![endif]-->
	 
    <!-- Sliding effect -->
	<script src="js/slide.js" type="text/javascript"></script>
    
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />

<!--
	2) Optionally override the settings defined at the top
	of the highslide.js file. The parameter hs.graphicsDir is important!
-->

<script type="text/javascript">
	hs.graphicsDir = 'highslide/graphics/';
	hs.outlineType = 'rounded-white';
	hs.showCredits = false;
	hs.wrapperClassName = 'draggable-header';
	hs.width = 1000;
	hs.height = 500;
	//hs.align = 'center';
	
	$("#main_table").css("min-height", "1000px"); 
	
	
</script>



</head>
<body marginheight="0" topmargin="0" >

<!-- Panel -->
<? if(!isset($_COOKIE['user_id'])  ||  !isset($_COOKIE['hash']) )include("reg_top_panel.php");?>
<!--panel -->

<table width="100%" height="100%" id="main_table"  border="0" cellspacing="0" cellpadding="0">    <!--  main table -->
  
  
  <tr>      <!--  header -->
    <td height="38px">
    
    
    <table width="100%" height="38px" border="0" cellspacing="0" cellpadding="0" background="img/back/topmenu.png"> <!--  header table -->
    <tr>
                
        <td align="center" valign="bottom">
   
        <div class="top_button"  style=" <? if($page_id==1) echo "background:url(img/buttons/chatbg.png) no-repeat center;"; ?> margin-left:290px; width:70px;"  onclick="document.location.href='index.php'" >Чат</div> <!-- chat --> 
        <div class="top_button"  style=" <? if($page_id==2) echo "background:url(img/buttons/chatbg.png) no-repeat center;"; ?> width:70px;" onclick="document.location.href='index.php?page_id=2'">Книги</div> <!-- books -->
        <div class="top_button" style=" <? if($page_id==3) echo "background:url(img/buttons/shparg.png) no-repeat center;"; ?> width:102px;" onclick="document.location.href='index.php?page_id=3'">Шпаргалки</div> <!-- shparg -->
        <div class="top_button" style=" <? if($page_id==7) echo "background:url(img/buttons/shparg.png) no-repeat center;"; ?> width:102px;" onclick="document.location.href='index.php?page_id=7'">Новости</div>
         <div class="top_button" style="width:102px; float:right;" onclick="deleteCookie('user_id', '/','<? echo $_SERVER['SERVER_NAME']; ?>'); deleteCookie('hash', '/','<? echo $_SERVER['SERVER_NAME']; ?>');document.location.href=document.location.href">Выход</div>
        
        </td>
    </tr>
    </table>
    
    </td>
 </tr>
    
    
    <tr>
      <td >
    
    <table width="100%" height="31px" border="0" cellspacing="0" cellpadding="0" background="img/back/untopmenu.png">
     <tr>
           
          <td align="center" valign="top">
          
            <!-- my page -->
            <div style="margin-top:7px; float:left; margin-left:30px;"> 
               <a href="index.php?user_id=<? echo $user_cookie_id; ?>" style="color: #15ADFF; font-weight:700; font-family: Verdana, Geneva, sans-serif; font-size:12px; text-decoration:none;">
                 Моя страница
               </a>
            </div> 
            
           <div style="float:left; margin-left:25px; margin-top:5px; margin-right:15px;">
           <? 
		      $new_mes_global_res = mysql_query("select * from messages where uid2='$user_cookie_id' and status='0' order by id desc");
		      $new_mes_global_num = mysql_num_rows($new_mes_global_res);
			  if($new_mes_global_num > 0) echo '<img src="img/icons/mess.png" width="16" height="16" />('.$new_mes_global_num.')';
		   ?>
                <!-- messages --> 
           </div>
          
           
           <div style="float:left; margin-left:55px; margin-top:7px;">
		   <? 
		   
		   if ( !isset($_GET['page_id']) && !isset($_GET['user_id']) ){
				 include("top_td.php");
			}
				
		    if ( isset($_GET['user_id']) && !isset($_GET['page_id']) ){
				include("top_blocks/my_page_top.php");
			}
				     
			if ( isset($_GET['page_id']) ){
				     
                switch ($_GET['page_id']) {
					case 1:
						include("top_td.php");
						break;
					case 2:
						include("top_blocks/books_top.php");
						break;
					case 3:
						include("top_blocks/shpargalky_top.php");
						break;
					case 8:
						include("top_blocks/search_top.php");
						break;
					case 9:
						include("top_blocks/support_top.php");
						break;
					case 6:	
					case 11:
					case 12:
					case 13:
					case 14:
					case 15:
					case 16:												
					case 17:
					case 18:
					case 19:
						include_once("top_blocks/my_page_top.php");
						break;
					
					default:
						include("top_td.php");
				}      
                      
			}
			
		   ?>
           </div>
           
           <div id="pathfield" style="float:left; margin-left:35px; margin-top:1px; overflow:hidden; max-width:40%; height:25px;"><? echo $pass; ?> </div>
           
          </td> 
    </tr>
    
   </table>  <!--  end header table -->

    
    
    
    </td>
  </tr>     <!--  end header -->
  
  
  
  <tr bgcolor="#FFFFFF">      <!--  middle -->
    <td valign="top" >
    
    <table width="100%" height="100%" style="" border="0" cellspacing="0" cellpadding="0"> <!--  middle table -->
    <tr>
        <td  width="216px" valign="top" style="background-color:#d6d6d6;">
		    <?  
			
					  include("left_td.php");
				
		    ?>
        </td>
        <td valign="top"> 
		    <? include("content_td.php"); ?> 
        </td>
        
   </tr>
   </table>  <!--  end middle table -->

    
    
    </td>
  </tr>     <!--  end middle -->
  
  
  <tr >      <!--  footer -->
    <td height="39px" align="center" background="img/back/footer.jpg" valign="middle">
    
    <table width="600px" height="39px"  border="0" cellspacing="0" cellpadding="0"> <!--  footer table -->
    <tr valign="middle" align="center">
            <td><a href=""  class="footer_link">Техподдержка 8-916-999-99-99</a></td>
            <td><a href=""  class="footer_link">FAQ</a></td>
            <td><a href=""  class="footer_link">Разработчикам</a></td>
            <td><a href=""  class="footer_link">Board-market</a></td>
            <td><a href=""  class="footer_link">Администрация</a></td>
    </tr>
    </table> <!-- end footer table -->

    
    </td>
  </tr>     <!--  end footer -->
  
  
  
  
</table>  <!-- end main table -->



</body>
</html>