<script src="js/uploadscript.js" type="text/javascript"></script>
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">
		
        	
			
            
             <div class="left right" style="width:220px; text-align:center;">
                  <img src="img/users/avatar/back.jpg"  id="avatar">
				
			</div>
			<div class="left" style="width:350px;">			
				<!-- Register Form -->
				<form action="php/reg_user.php" method="post" name="reg_form" id="reg_form" >
					<h1>Регистрация</h1>				
					<input name="img" type="hidden"  value="def.jpg" />
                    
                    <label class="grey" for="name" >ФИО:</label>
					<input class="field reg_form_data" type="text"  name="name" value="" size="27" maxlength="150" />
                    <label class="grey" for="name">Логин:</label>
                    <input class="field reg_form_data" name="login"  type="text" maxlength="30" value=""  size="27" />
					<label class="grey" for="pass" >Пароль:</label>
                    <input class="field reg_form_data" name="pass"   type="password" maxlength="30"   size="27" /> 
                    <label class="grey" for="pass_test">Повтор:</label>
                    <input class="field reg_form_data" name="pass_test" type="password" maxlength="30"   size="27"  /> 
                    <label class="grey" for="email">Email:</label>
					<input class="field reg_form_data" type="text" name="email"  size="27"  />
                    <br><br>
                    Изображение сжимается до 200х300 <br>
                   <div id="uploadButton" >
                        <font style="background-color:#004270; font-weight:600; cursor:pointer; ">
                            &nbsp;Загрузить аватарку&nbsp;
                        </font>
                        &nbsp; &nbsp;
                        <img id="load" src="js/loadstop.gif"/>
                    </div>
                    
					 <input name="sub_reg" type="submit" value="Register"  id="sub_reg" class="bt_register">
					
				</form>
                
                 
      
       	</div>
         
         <div class="left">
				<!-- Login Form -->
				<form class="clearfix" action="php/login.php" method="post" name="login_form">
					<h1>Вход</h1>
					<label class="grey" for="login" style="width:200px;">Логин:</label>
					<input class="field" type="text" name="login"  value="" size="23" />
					<label class="grey" for="pass"  style="width:200px;">Пароль:</label>
					<input class="field" type="password" name="pass"  size="23" />
	            	<label><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> &nbsp;Запомнить меня</label>
        			<div class="clear"></div>
					<input type="submit" id="sub_login_form" name="sub_login_form" value="Login" class="bt_login" />
					<a class="lost-pwd" href="#">Забыли пароль?</a>
				</form>
			</div>   
           
            
		</div>
        
	</div> <!-- /login -->	

    <!-- The tab on top -->	
	<div class="tab">
		<ul class="login">
	    	<li class="left">&nbsp;</li>
	        <li>Hello Guest!</li>
			<li class="sep">|</li>
			<li id="toggle">
				<a id="open" class="open" href="#">Вход_Регистрация</a>
				<a id="close" style="display: none;" class="close" href="#">Close Panel</a>			
			</li>
	    	<li class="right">&nbsp;</li>
		</ul> 
	</div> <!-- / top -->
	
</div>