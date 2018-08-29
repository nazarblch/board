<script src="js/uploadscript.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/reg_style.css" />
<form action="php/reg_user.php" method="post" name="reg_form" id="reg_form" enctype="multipart/form-data">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="15px" style="border-right:1px #ece9d8 solid;"><div style=" width: 15px;" >&nbsp;</div></td>
  
    <td width="350">
       <br><br>
       
       <input name="name" type="text" maxlength="150" value="Фамилия Имя Отчество" class="reg_form_data" ><br /> 
       <input name="login" type="text" maxlength="30" value="Логин" class="reg_form_data"  > <br />
       <input name="pass" type="text" maxlength="30" value="Пароль 7-30 символов" class="reg_form_data"  > <br />
       <input name="pass_test" type="text" maxlength="30" value="Повторите Пароль" class="reg_form_data"  > <br />
       <input name="email" type="text" maxlength="70" value="Email" class="reg_form_data"  > <br /><br />
       <input name="img" type="hidden"  value="def.jpg" >
           
      
       &nbsp;&nbsp;&nbsp;&nbsp;Изображение сжимается до 200х300 <br>
       <div id="uploadButton" >
            <font>
                Загрузить аватарку
            </font>
            <img id="load" src="js/loadstop.gif"/>
        </div>
        <ol id="files">
            
        </ol> 
      
       
        <input name="sub_reg" type="button" value="Зарегистрироваться"  id="sub_reg">
    
    </td>
    <td align="left" valign="top">
      <img src="img/users/avatar/def.jpg"  id="avatar">
    </td>
  </tr>
</table>




</form>


       