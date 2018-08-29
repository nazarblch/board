<tr valign="top">
    <td>    
<?
$user_img = $user_global_row["img"];
list($w_i, $h_i, $type) = getimagesize("img/users/avatar/".$user_img);
?>


<script type="text/javascript" >

$(document).ready(function() {	       

			var button = $('#uploadButton'), interval;
			
			$.ajax_upload(button, {
						action : 'php/set_image.php',
						name : 'myfile',
						data : new Array("<? echo $user_global_id; ?>"),
						onSubmit : function(file, ext) {
							// показываем картинку загрузки файла
							$("img#load").attr("src", "js/load.gif");
							$("#uploadButton font").text('Загрузка');
						    this.disable();

						},
						onComplete : function(file, response) {
							// убираем картинку загрузки файла
							$("img#load").attr("src", "js/loadstop.gif");
							$("#uploadButton font").text('Загрузить другую');
                              //alert(response);
							this.enable();
							// показываем что файл загружен
							
							$("#avatar").attr('src', 'img/users/avatar/'+response);
							$("#reg_form :hidden[name=img]").val(response);
							$("#main_avatar").attr('src', 'img/users/avatar/'+response); 
							
						}
		   });
		   
		   
	

         var file_iter = 0;  
         var button = $('#upload_file_button');
			
		 $.ajax_upload(button, {
						action : 'php/load_file.php',
						name : 'myfile',
						data : new Array("<? echo 1; ?>"),  // db table
						onSubmit : function(file, ext) {
							// показываем картинку загрузки файла
							//$("img#load1").attr("src", "js/load.gif");
							$("#upload_file_button").text('Загрузка');
						    this.disable();

						},
						onComplete : function(file, response) {
							// убираем картинку загрузки файла
							//$("img#load1").attr("src", "js/loadstop.gif");
							$("#upload_file_button").text('Прикрепить файл');
                            alert(file);
							alert(response);
							this.enable();
							$("#uploaded_files").prepend("<li>"+file+"</li>");
							$("#mess_form").prepend("<input name='file_id_"+file_iter+"' type='hidden' value='"+response+"' />");
							file_iter++;
						}
		});



		   
		   var condition=new Array();
           condition["name"]=1;
           condition["email"]=1;
		   condition["vk"]=1;
		   
		   
		   $("input.change_info_input").live('click', function(event){
	
				if( condition[$(this).attr('name')] == 0 ){
				
					$(this).css('color', '#000');
					this.value = "";
					condition[$(this).attr('name')] = 1;
				}
	
          });
		   
		   
           $("#change_info_sub").click(function(elem){
			   
			   if( !test_domen() ) return;
			   
			   var form_change_info = $("form#change_info");
			   var name_input = form_change_info.find(" :text[name=name]");
			   var email_input = form_change_info.find(" :text[name=email]");
			   var vk_input = form_change_info.find(" :text[name=vk]");
			   var job_input = form_change_info.find(" :text[name=job]");
			   
			   vk_input.val( parseInt(vk_input.val()) );
			   
			   
			   if( name_input.val().length < 5 || name_input.val() == "Фамилия Имя Отчество" ){
					name_input.css('color', 'red');
					name_input.val(" 5 <= Фамилия Имя Отчество <= 150 символов");
					condition["name"] = 0;
					return;
				}
			   
			   if( !isValidEmail( email_input.val() ) ){
					email_input.css('color', 'red');
					email_input.val("Неверный Email");
					condition["email"] = 0;
					return;
			   }
			   
			   if( !is_int(vk_input.val()) && vk_input.val() != "" &&  vk_input.val() != null ){
				    vk_input.css('color', 'red');
					vk_input.val(" id - целое число ");
					condition["vk"] = 0;
					return;   
			   }
			
			   $.ajax({
					async: false,				// по умолчанию false
					cache: false,				// по умполчанию true,
					type: "POST",				// POST
					url: "php/change_user_info.php",
					//data: "data="+"content",			
					data: $("form#change_info").serialize(),
					dataType: "text", 			// "xml", "text", "script", "json", "jsonp"
					contentType: "application/x-www-form-urlencoded", // по умолчанию «application/x-www-form-urlencoded»
					global: false, 				// по умолчанию true
					ifModified: false,			// по умолчанию false
					//username: 'login',
					//password: 'pass',
					processData: false,			// по умолчанию true
					timeout: 10000,
											
					success: function(data) {
						document.location.href = document.location.href;
						//alert(data);
					}
					
					
					
				});
		  });
		   
		 
		 button = $('#uploadButton1');
			
		 $.ajax_upload(button, {
						action : 'php/load_user_photo.php',
						name : 'myfile',
						data : new Array("<? echo $user_global_id; ?>"),
						onSubmit : function(file, ext) {
							// показываем картинку загрузки файла
							//$("img#load1").attr("src", "js/load.gif");
							$("#uploadButton1 font").text('Загрузка');
						    this.disable();

						},
						onComplete : function(file, response) {
							// убираем картинку загрузки файла
							//$("img#load1").attr("src", "js/loadstop.gif");
							$("#uploadButton1 font").text('Загрузить другую');
                            alert(file);
							this.enable();
							
						}
		});
		
		 $("#sub_mess_form").click(function(elem){
			    if( !test_domen() ) return;
				 var mess_form = $("form[id=mess_form]");
			     var title_input = mess_form.find(" :text[name=title]");
				 var data_input = mess_form.find("#data");
				 
				if(data_input.val() == "" && title_input.val() == "" ){
					alert("Пустое сообщение!");
					return;
				}
				
				 $.ajax({
					async: false,				// по умолчанию false
					cache: false,				// по умполчанию true,
					type: "POST",				// POST
					url: "php/send_mess.php",
					//data: "data="+"content",			
					data: mess_form.serialize(),
					dataType: "text", 			// "xml", "text", "script", "json", "jsonp"
					contentType: "application/x-www-form-urlencoded", // по умолчанию «application/x-www-form-urlencoded»
					global: false, 				// по умолчанию true
					ifModified: false,			// по умолчанию false
					//username: 'login',
					//password: 'pass',
					processData: false,			// по умолчанию true
					timeout: 10000,
											
					success: function(data) {
						data_input.val("");
						title_input.val("");
						mess_form.find(" :hidden[name ^= 'file_id_'] ").remove();
						$("#send_mess_form").find("#uploaded_files").html("");
						file_iter = 0;  
						$("#send_mess_form").find(".close").click();
						
						if(data == 1 || data == "1"){
						}else{
							alert(data);
						}
					}
					
					
					
				});
		 });
				
		   
});


</script>

<div id="user_img_container">
    <div>
       <img src="img/users/avatar/<? echo $user_img; ?>"  id="main_avatar" />
    </div>
</div>

<div id="user_actions_container">

<?

if($user_global_page == "self"){
	
	echo "<div id='change_img_but'><a href='#change_img_form' class='openmodal'>Изменить фотографию</a></div>";
	
	echo "<div id='change_info_but'><a href='#change_info_form' class='openmodal'>Редактировать страницу</a></div>";
	
    echo' <div id="uploadButton1" >
								<font >
									Добавить фотографию в альбом
								</font>
		</div>
   ';

}else{
	
	
	echo "<div class='add_friend' id='uid".$user_global_id."'>Добавить в друзья</div>";
	echo "<div class='send_mess' ><a href='#send_mess_form' class='openmodal'>Отправить сообщение</a></div>";
	echo "<div class='send_email'><a href='#send_email_form' class='openmodal'>Отправить Email</a></div>"; 
	
	
}

?>
</div>


<?
// friends list

 $res4 = mysql_query(" select * from friend_edges where (uid1='$user_cookie_id' or uid2='$user_cookie_id') and status='1' limit 10 ");




?>

<div id="boxes">

    <div id="change_img_form" class="modal_window">
    
    <table width="100%" border="0" height="330" cellspacing="0" cellpadding="0">
          <tr height="25px">
            <td align="center" valign="middle" width="240">Замена аватарки</td>
            <td align="right" valign="middle"><a href="#" class="close"/>X</a></td>
          </tr>
          <tr>
            <td align="center" valign="middle" width="240"><img src="img/users/avatar/<? echo $user_img; ?>"  id="avatar"></td>
            <td align="center" valign="middle" width="">
            
                <form  name="reg_form" id="reg_form" >
                   <input name="img" type="hidden"  value="<? echo $user_img; ?>" />
                   
                  
                </form>
               
               
                   Изображение сжимается до200х300 <br>
                    <div id="uploadButton" style="" >
                        <font>
                            Загрузить аватарку
                        </font>
                        <img id="load" src="js/loadstop.gif"/>
                   </div>                 
            
            </td>
          </tr>
    </table>
    
    </div>
    
    <div id="change_info_form" class="modal_window">
            <a href="#" class="close"/>X</a>
            
            
          <form action="" method="post" name="change_info" id="change_info">
          
          <div><label style="width:200px;">ФИО:&nbsp;</label></div> <input name="name" type="text" value="<? echo $user_global_row["name"]; ?>" maxlength="150" class="change_info_input"><br>
          <div><label>Email:&nbsp;</label></div> <input name="email" type="text" value="<? echo $user_global_row["email"]; ?>" maxlength="70" class="change_info_input"><br>
          <div><label>Университет:&nbsp;</label></div> <input name="univer" type="text" value="<? if(isset($user_global_row["univer"])) echo $user_global_row["univer"]; ?>" maxlength="50" class="change_info_input"><br>
          <div><label>Город:&nbsp;</label></div> <input name="city" type="text" value="<? if(isset($user_global_row["city"])) echo $user_global_row["city"]; ?>" maxlength="30" class="change_info_input"><br>
          <div><label>День рождения:&nbsp;</label></div> 
          <?
		     if( isset($user_global_row["dnuha"]) ){
				 $dnuha = split(" ",$user_global_row["dnuha"]);
			 }
          
		  ?>
               <select name="b_day" >
                     <? for($i=1; $i < 31; $i++) 
					     if($i == $dnuha[0])  echo '<option selected value="'.$i.'">'.$i.'</option>'; 
						 else echo '<option value="'.$i.'">'.$i.'</option>'; 
					 ?>
               </select>
               <select name="b_month" >
                     <option value="Января" <? if($dnuha[1]=="Января") echo"selected"; ?> >Январь</option>
                     <option value="Февраля" <? if($dnuha[1]=="Февраля") echo"selected"; ?>>Февраль</option>
                     <option value="Марта" <? if($dnuha[1]=="Марта") echo"selected"; ?>>Март</option>
                     <option value="Апреля" <? if($dnuha[1]=="Апреля") echo"selected"; ?>>Апрель</option>
                     <option value="Мая" <? if($dnuha[1]=="Мая") echo"selected"; ?>>Май</option>
                     <option value="Июня" <? if($dnuha[1]=="Июня") echo"selected"; ?>>Июнь</option>
                     <option value="Июля" <? if($dnuha[1]=="Июля") echo"selected"; ?>>Июль</option>
                     <option value="Августа" <? if($dnuha[1]=="Августа") echo"selected"; ?>>Август</option>
                     <option value="Сентября" <? if($dnuha[1]=="Сентября") echo"selected"; ?>>Сентябрь</option>
                     <option value="Октября" <? if($dnuha[1]=="Октября") echo"selected"; ?>>Октябрь</option>
                     <option value="Ноября" <? if($dnuha[1]=="Ноября") echo"selected"; ?>>Ноябрь</option>
                     <option value="Декабря" <? if($dnuha[1]=="Декабря") echo"selected"; ?>>Декабрь</option>
               </select>
               
               <select name="b_year" >
                     <? 
					     for($i=1945; $i < 2011; $i++){
							 if($i == $dnuha[2]) echo '<option value="'.$i.'" selected>'.$i.'</option>'; 
					         else  echo '<option value="'.$i.'">'.$i.'</option>';
						 }
					?>
               </select>
               
               <div style="margin-top:5px;"><label>Телефон:&nbsp;</label></div> <input style="margin-top:5px;" name="tel" type="text" value="<? if(isset($user_global_row["tel"])) echo $user_global_row["tel"]; ?>" maxlength="20" class="change_info_input"><br>
               <div><label>Идентификатор Вконтакте(id):&nbsp;</label></div> <input name="vk" type="text" value="<? if(isset($user_global_row["vk"])) echo $user_global_row["vk"]; ?>" maxlength="20" class="change_info_input"><br>
               <div><label>Skype:&nbsp;</label></div> <input name="skype" type="text" value="<? if(isset($user_global_row["skype"])) echo $user_global_row["skype"]; ?>" maxlength="30" class="change_info_input"><br>
               <div><label>ISQ:&nbsp;</label></div> <input name="isq" type="text" value="<? if(isset($user_global_row["isq"])) echo $user_global_row["isq"]; ?>" maxlength="20" class="change_info_input"><br>
      
               <label>Работа(специальность):&nbsp;&nbsp;не более 255 символов</label><br>
               <textarea name="job" cols="40" rows="2"><? if(isset($user_global_row["job"])) echo $user_global_row["job"]; ?></textarea><br><br>
               <input name="change_info_sub" id="change_info_sub" type="button" value="Сохранить изменения">
          
          </form>
          
    
    </div>
    
    
    
     <div id="send_mess_form" class="modal_window">
    
    <table width="100%" border="0"  cellspacing="0" cellpadding="0">
          <tr height="25px">
            <td align="center" valign="middle" width="440" style="color:#CCC;">Новое сообщение: <? echo $user_global_login; ?></td>
            <td align="right" valign="middle"><a href="#" class="close"/><img src="img/buttons/close-button.png" width="30" height="30" /></a></td>
          </tr>
          <tr>
            <td align="left" valign="middle" >
            <br>
            
            <form action="send_mess" method="post" name="mess_form" id="mess_form" enctype="multipart/form-data">
            <input name="uid2" type="hidden" value="<? echo $user_global_id; ?>" />
            <label class="grey_label">Тема:</label><br>
            <input class="input_gray_field"  name="title" type="text"  /><br><br>
            <label class="grey_label">Текст:</label><br>
             <textarea class="input_gray_field"  name="data" id="data" cols="20" rows="10"  ></textarea><br>
              <table width="100%" border="0"  cellspacing="0" cellpadding="0">
                  
                   <tr height="">
                   <td> <input type="button" id="sub_mess_form" name="sub_mess_form" class="grey_button" value="Отправить"  /></td>
                     <td align="right"> 
                    <label class="grey_label" style="float:right; text-align:right;" id="upload_file_button">                                     Прикрепить файл
                    </label>
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
    
    
    
    
    
    
    <!-- Макска, которая затемняет весь экран -->
     <div id="mask"></div>
    
</div>

      </td>
</tr>
