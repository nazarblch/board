<style>
ul.photo_table{
	list-style:none;
}

ul.photo_table li{
	height:150px;
	width:150px;
	float:left;
	text-align:center;
	padding:10px;
	margin:7px;
}

ul.photo_table li img{
	max-height:150px;
	max-width:150px;
	border: #E4E4E4 4px solid;
}

.mid_img{
	display:none;
	position:absolute;
    top:0;
    z-index:10000;
	padding:7px;
    background-color: #999;
	
}

.mid_img img{
	position:relative;
}

.add_photo_bat{
	
	text-align:center;
	width:200px;
	margin-left:60px;
	font-weight:600;
	text-decoration:none;
	color:#09C;
	
}
</style>
<?
 
  if(!isset($user_global_id) && !isset($_COOKIE["user_id"])) exit(" User id hasn't been defined ");
  
  if(!isset($user_global_id) && isset($_COOKIE["user_id"])){
       $u_photo_res = mysql_query( "select * from user_photos where user_id='$user_cookie_id' order by id desc ");
  }else{
	   $u_photo_res = mysql_query( "select * from user_photos where user_id='$user_global_id' order by id desc ");
  }
  
  if( $user_global_page == "self"){
	  echo '
	  
	  ';
  }
  
  if(mysql_num_rows($u_photo_res) == 0)exit("Photo albom is empty");
  
  echo "<ul class='photo_table'>";
  $i = 1;
  while( $u_photo_row = mysql_fetch_array($u_photo_res) ){
	
			   echo '
			      <li>
					<a href="#mid_img_'.$i.'" class="openmodal">
					<img src="img/users/photos/'.$u_photo_row["user_id"].'/small/'.$u_photo_row["src"].'"  height="150px" id="ph_'.$u_photo_row["id"].'" />
					</a>
                 </li>
		       ';
			   
			   $u_photo_arr[$i] = array($u_photo_row["user_id"],$u_photo_row["src"],$u_photo_row["id"]);
			   $i++;
  }
     
  echo "</ul>"	 


?>

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