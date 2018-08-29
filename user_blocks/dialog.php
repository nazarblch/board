<?  
   $dialog_id = intval($_GET['dialog_id']);

   $mes_max_id_res = mysql_query("select max(id) as mx from messages ");
   $mes_max_id_row =  mysql_fetch_array($mes_max_id_res);
   
?>
<script type="text/javascript">

var  max_id = <?  echo $mes_max_id_row['mx']; ?>;

$(document).ready(function() {	

$(".dialog_line").live('click', function(event){
	if(_user_click == false ){
		
	}
});

var mess_interval = setInterval("db_check_new_mess(<? echo $dialog_id; ?>)", 5000);


function change_data(){
         
		 var input_data = $("form[id=mess_form]").find("#data");
		 alert(input_data.val().length);
				 
				if(input_data.val().length > 900 ){
					input_data.val(data_input.val().substring(0,900));
					alert("nah");
		        }
}


});

function db_check_new_mess(dialog_id){
	 $.ajax({
					async: false,				// по умолчанию false
					cache: false,				// по умполчанию true,
					type: "POST",				// POST
					url: "php/db_check_new_mess.php",
					//data: "data="+"content",			
					data: "dialog_id=" + dialog_id + "&max_id=" + max_id,
					dataType: "text", 			// "xml", "text", "script", "json", "jsonp"
					contentType: "application/x-www-form-urlencoded", // по умолчанию «application/x-www-form-urlencoded»
					global: false, 				// по умолчанию true
					ifModified: false,			// по умолчанию false
					//username: 'login',
					//password: 'pass',
					processData: false,			// по умолчанию true
					timeout: 10000,
											
					success: function(data) {
						if(data.length > 100){
						
						var res_arr = data.split("&_mess_&");
						max_id = res_arr[0];
						var new_messages_arr = res_arr[1].split("&_and_&");
						 
						for(var i = 0; i < new_messages_arr.length; i++){
							
							$("table[id=messages_table]").prepend(new_messages_arr[i]);
							
							
						}
						
					    }
					 	
						
					}
					
					
					
		});
}

</script>

<style>

.dialog_line .mess_title{
	color: #3a9dff;
	font-size:10px;
	font-weight:600;
	height: 14px;
	overflow:hidden;
	text-align:center;
	float: left;
	margin-left:10px;
	width: 340px;
}

.dialog_line .mess_body{
	padding-left: 10px;
	padding-right:10px;
	float:left;
	margin-top:5px;
	min-width: 320px; 
}

.dialog_line{
	width:100%;
	margin-top: 10px;
	margin-bottom: 10px;
	font-size:10px;
	
}

.user_dialog_container, .self_dialog_container{
	width: 424px;
}

.user_dialog_container{
	margin-left: 100px;
}

.dialog_t, .dialog_b{
	height: 6px;
}

.user_dialog_container .dialog_m{
    background-image: url(img/back/mshe_m.png);
	min-height: 20px;
	max-height: 400px;
	overflow:hidden;	
}

.user_dialog_container .dialog_t{
    background-image: url(img/back/mshe_t.png);
}

.user_dialog_container .dialog_b{
    background-image: url(img/back/mshe_b.png);
}



.self_dialog_container{
	margin-left: 170px;
}

.self_dialog_container .dialog_m{
	background-image: url(img/back/msme_m.png);
	min-height: 20px;
	max-height: 400px;
	overflow:hidden;	
}

.self_dialog_container .dialog_t{
	background-image: url(img/back/msme_t.png);
}

.self_dialog_container .dialog_b{
	background-image: url(img/back/msme_b.png);
}



.dialog_time{
	color:#999;
	float:right;
	margin-right:5px;
	
}

#dialog_head .user{
	color: #990000; 
	text-decoration:none;
	opacity:0.6;
	font-weight:600;
	margin-left:10px;
}

.white_field{
	background-color:#ECECEC;
	width:55% !important;
	border:#FFF 0px inset;
	box-shadow: inset #ccc 2px 2px 2px 0px;
	border-radius: 4px;
	font-size:11px;
	font-family:Arial, Helvetica, sans-serif;
	padding-left:5px;
	padding-top:3px;
}

.sub_mess_butt{
	 font-weight:600; color:#999; padding-top:5px;
}

.sub_mess_butt:hover{
	 color:#333; 
}



</style>

<div  style="background-color: #F7F7F4;">
<br>

<div id="dialog_head" >
Диалог с пользователем
<?

 $res3 = mysql_query( "select * from users where  id='$dialog_id' ");
 $user_row = mysql_fetch_array($res3);
 
 echo '<a href="" id="'.$dialog_id.'" class="user" >'.$user_row['login'].'</a>';

?>
</div>

<div>
<table width="90%" border="0"  cellspacing="0" cellpadding="0">
         
          <tr>
            <td align="left" style=" padding-left:100px;" valign="middle"  >
            <br>
            
            <form action="send_mess" method="post" name="mess_form" id="mess_form" enctype="multipart/form-data">
            <input name="uid2" type="hidden" value="<? echo $dialog_id; ?>" />
            <label class="">Тема:</label><br>
            <input class="white_field"  name="title" type="text" maxlength="60"  /><br><br>
            <label class="">Текст:</label><br>
             <textarea class="white_field"  name="data" id="data" cols="20" rows="5"  onkeydown="if(this.value.length>900) this.value = this.value.substring(0,900)" ></textarea><br>
              <table width="54%" border="0"  cellspacing="0" cellpadding="0">
                  
                   <tr height="20px">
                   <td> <div id="sub_mess_form1" class="sub_mess_butt"   >Отправить</div></td>
                     <td align="right"> 
                    <label class="sub_mess_butt"  id="upload_file_button">Прикрепить файл</label>
                   </td>
                  </tr>
                  
                  <tr >
                  <td>
                   <ul id="uploaded_files" style="list-style:none; color:#069;">
                   </ul>
                  </td>
                  <td align="right">  
                       
                    </td>
                  
                  </tr>
             </table>
             
                           
            </form>
            </td>
            
            <td align="center" valign="middle" >
            
            
            </td>
          </tr>
    </table>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0"  bgcolor="#F7F7F4" id="messages_table">
  

 
<?
   
	    $mes_global_res = mysql_query("select * from  messages
								       where ( uid2='$user_cookie_id' and uid1='$dialog_id' ) or ( uid1='$user_cookie_id' and uid2='$dialog_id' ) 
                                      order by id desc  ");
	   
   
   while( $mes_global_row = mysql_fetch_array($mes_global_res) ){
	   
	  $uid2 = $mes_global_row['uid2'];
	  if($uid2 != $user_cookie_id){
		  $cont_type = "self";
	  }else{
		  $cont_type = "user";
	  }
	  $title =  substr( $mes_global_row['title'], 0, 70); 
	  $time =  substr($mes_global_row['time'], 5, 11);
	  $data = $mes_global_row['data'];
	  $more = "";
	  if(strlen($data) > 900){
		  $more = "&nbsp;&nbsp;...";
	  }
	  $data =  substr( $data, 0, 900);
	   
	   
	   echo '<tr>
				<td >
					<div class="dialog_line">
					   <div class="'.$cont_type.'_dialog_container">
						  <div class="dialog_t"></div>
						  <div class="dialog_m">
							 <div><div class="mess_title">'.$title.'</div><font class="dialog_time">'.$time.'</font></div>
							 <div class="mess_body">'.$data.$more.'</div>
						  </div>
						  <div class="dialog_b"></div>
					   </div>
					</div>   
				</td>
			</tr>
       ';
	  
	   
   }
 
?>

</table>
</div>


<div class="users_info_arr" >
</div>




