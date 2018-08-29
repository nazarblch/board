<link rel="stylesheet" href="css/my_page_style.css" type="text/css" media="screen" />
<script type="text/javascript">
$(document).ready(function() {	
	 
	 $(".img_slyder").css("width", $(window).width()-350);
	  
	 $(".img_slyder_right").click(function(event){
		 
		 var left = $(".img_slyder_container").css("left");
		 var container_w = parseInt($(".img_slyder_container").width());
		 //alert(parseInt(left.substr(0, left.length-2)));
		
		 if(parseInt(left.substr(0, left.length-2)) >  parseInt(-container_w + $(window).width() - 350) )
		    $(".img_slyder_container").stop().animate({"left": "-=200px"}, 1200,"easeOutQuart");
			
	 });
	 
	 $(".img_slyder_left").click(function(event){
		 var left = $(".img_slyder_container").css("left");
		 
		if(parseInt(left.substr(0, left.length-2)) <= -200) 
		  $(".img_slyder_container").stop().animate({"left": "+=200px"}, 1200,"easeOutQuart");
		else 
		  $(".img_slyder_container").stop().animate({"left": "0px"}, 500,"easeOutQuart");
		 
	 });
});

</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div style="font-size:24px; font-weight:bold; color:#2E3C63; padding:5px; padding-left:20px;"><? echo $user_global_row["name"]; ?></div></td>
  </tr>
  <tr>
    <td>
    
    <div class="user_info_cat1_container">
	
	<?
	
	   $info_un_bd_city = "";
	   
	   if( isset($user_global_row["univer"]) && $user_global_row["univer"] != ""){
		   $info_un_bd_city .= "<font class='user_info_cat1'>Университет:</font><font class='user_info_cat1_data'>".$user_global_row["univer"]."</font>&nbsp;";
	   }
	   
	   if( isset($user_global_row["city"]) && $user_global_row["city"] != ""){
		   $info_un_bd_city .= "<font class='user_info_cat1'>Город:</font><font class='user_info_cat1_data'>".$user_global_row["city"]."</font>&nbsp;";
	   }
	   
	   if( isset($user_global_row["dnuha"]) && $user_global_row["dnuha"] != ""){
		   $info_un_bd_city .= "<font class='user_info_cat1'>День рождения:</font><font class='user_info_cat1_data'>".$user_global_row["dnuha"]."</font>&nbsp;";
	   }
	
	   echo $info_un_bd_city;
	
	?>
    
    </div>
    
    </td>
  </tr>
  <tr>
    <td>
       <div class="user_info_cat2_container">
          <div class="user_info_cat2_title">Контакты</div>
          
          <?
	
			   $info_tel_em_isq_vk = "";
			   
			   if( isset($user_global_row["tel"]) && $user_global_row["tel"] != ""){
				   $info_tel_em_isq_vk .= "<div class='user_info_cat2'>Телефон:&nbsp;&nbsp;<font class='user_info_cat2_data'>".$user_global_row["tel"]."</font></div>";
			   }
			   
			   if( isset($user_global_row["email"]) && $user_global_row["email"] != ""){
				   $info_tel_em_isq_vk .= "<div class='user_info_cat2'>Email:&nbsp;&nbsp;<font class='user_info_cat2_data'>".$user_global_row["email"]."</font></div>";
			   }
			   
			   if( isset($user_global_row["vk"]) && $user_global_row["vk"] != ""){
				 $info_tel_em_isq_vk .= "<div class='user_info_cat2'>Страница Вконтакте:&nbsp;&nbsp;<font class='user_info_cat2_data'>".$user_global_row["vk"]."</font></div>";
			   }
			   
			   if( isset($user_global_row["isq"]) && $user_global_row["isq"] != ""){
				   $info_tel_em_isq_vk .= "<div class='user_info_cat2'>Isq:&nbsp;&nbsp;<font class='user_info_cat2_data'>".$user_global_row["isq"]."</font></div>";
			   }
			   
			   if( isset($user_global_row["skype"]) && $user_global_row["skype"] != ""){
				   $info_tel_em_isq_vk .= "<div class='user_info_cat2'>Skype:&nbsp;&nbsp;<font class='user_info_cat2_data'>".$user_global_row["skype"]."</font></div>";
			   }
			
			   echo $info_tel_em_isq_vk;
			
	     ?>
    
       </div>
    </td>
  </tr>
  
  
  <tr>
    <td align="center" style="overflow:hidden;">
       <?
	   
	       $u_photo_res = mysql_query( "select * from user_photos where user_id='$user_global_id' order by id desc");
	     
       ?>       
       <div class="user_info_cat3_container">  <!-- user photo -->
       <table align="center"  height="200" style="overflow:hidden;"  border="0" cellspacing="0" cellpadding="0">
       <tr align="center" valign="middle">
       <td width="20">
       <div class="img_slyder_left"><img src="img/buttons/leftarr.jpg" width="20" height="200" /> </div>
       </td>
       <td>
         <div class="img_slyder"  style="width:700px;">
         <div class="img_slyder_container"> 
         <table height="200"  border="0" cellspacing="15" cellpadding="0">
         <tr align="center" valign="middle">
         <?
		   $i = 1;
	       while( $u_photo_row = mysql_fetch_array($u_photo_res) ){
			   echo '
			      <td>
					<a href="#mid_img_'.$i.'" class="openmodal">
					<img src="img/users/photos/'.$u_photo_row["user_id"].'/small/'.$u_photo_row["src"].'"  height="150px" id="ph_'.$u_photo_row["id"].'" />
					</a>
                 </td>
		       ';
			   
			   $u_photo_arr[$i] = array($u_photo_row["user_id"],$u_photo_row["src"],$u_photo_row["id"]);
			   $i++;
		   }
         ?>
           
         </tr> 
         </table>
         </div>  
         </div>
        </td>
        <td width="12">&nbsp;&nbsp;</td> 
        <td width="20"> 
         <div class="img_slyder_right"><img src="img/buttons/rightarr.jpg" width="20" height="200" />  </div>
        </td> 
        </tr>
        </table>
       </div> <!-- end user photo -->
    </td>
  </tr>
  
  <tr>
    <td>
       <div class="user_info_cat4_container">  <!-- user wall -->
       </div> <!-- end user wall -->
    </td>
  </tr>
  
  
</table>

<?
   $i = 1;
   
   while( $i <= count($u_photo_arr) ){
	   
	    echo '
			   <div id="mid_img_'.$i.'" class="modal_window mid_img"><img src="img/users/photos/'.$u_photo_arr[$i][0].'/mid/'.$u_photo_arr[$i][1].'"  id="'.$u_photo_arr[$i][2].'"   /></div>
	    ';
		$i++;
   }
?>
 
 <!-- Макска, которая затемняет весь экран -->
     <div id="mask"></div>
