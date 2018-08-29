var condition=new Array();
    condition["name"]=0;
    condition["login"]=0;
	condition["pass"]=0;
	condition["pass_test"]=0;
	condition["email"]=0;


$(document).ready(function() {
	
	       

			var button = $('#uploadButton'), interval;
			

			$.ajax_upload(button, {
						action : 'php/set_image.php',
						name : 'myfile',
						
						onSubmit : function(file, ext) {
							// показываем картинку загрузки файла
							$("img#load").attr("src", "js/load.gif");
							$("#uploadButton font").text('Загрузка');
						    	

							/*
							 * Выключаем кнопку на время загрузки файла
							 */
							this.disable();

						},
						onComplete : function(file, response) {
							// убираем картинку загрузки файла
							$("img#load").attr("src", "js/loadstop.gif");
							$("#uploadButton font").text('Загрузить другую');

							// снова включаем кнопку
							this.enable();
							//alert(response);
							//_prev_img = response;

							// показываем что файл загружен
							$("<li>" + file + "</li>").appendTo("#files");
							$("#avatar").attr('src', 'img/users/avatar/'+response);
							$("#reg_form :hidden[name=img]").val(response); 
							//alert($("#reg_form :hidden[name=img]").val() );

						}
					});
});



function check_login_exist(login){
	
	var res;
			
			$.ajax({
				async: false,				// по умолчанию false
				cache: false,				// по умполчанию true,
	    	    type: "POST",				// POST
	    	    url: "php/check_login_exist.php",
				//data: "data="+"content",			
				data: "login="+login,
				dataType: "text", 			// "xml", "text", "script", "json", "jsonp"
	    	    contentType: "application/x-www-form-urlencoded", // по умолчанию «application/x-www-form-urlencoded»
				global: false, 				// по умолчанию true
				ifModified: false,			// по умолчанию false
				//username: 'login',
				//password: 'pass',
	    	    processData: false,			// по умолчанию true
				timeout: 10000,
								 		
	    	    success: function(data) {
					
					res = data;
					
				}
				
				
				
			});
			
	return res; 
	
}


$("input.reg_form_data").live('click', function(event){
	
	if( condition[$(this).attr('name')] == 0 ){
	
		$(this).css('color', '#FFF');
		this.value = "";
		condition[$(this).attr('name')] = 1;
	}
	
});


$("#sub_reg").live('click', function(event){    

                    		   
                
				if( !test_domen() ){ event.preventDefault();  alert(document.location.href);  return;} 
				
				var reg_form = $("form[name=reg_form]");
				
				var reg_form_data = $(".reg_form_data");
				
				var name_input = reg_form.find(" :text[name=name]");
				var login_input = reg_form.find(" :text[name=login]");
				var pass_input = reg_form.find(" :password[name=pass]");
				var pass_test_input = reg_form.find(" :password[name=pass_test]");
				var email_input = reg_form.find(" :text[name=email]");
				  
				
				if( name_input.val().length < 5 ){
					//alert("here");
					 event.preventDefault();     
					name_input.css('color', 'red');
					name_input.val(" 5 <= ФИО <= 150 ");
					condition["name"] = 0;
					return;
				}
				
				
				if( login_input.val().length < 4 ||  login_input.val().length > 30 ){
			          event.preventDefault();     
					login_input.css('color', 'red');
					login_input.val("4 <= Логин <= 30 ");
					condition["login"] = 0;
					return;
				}
				
				
				if( check_login_exist( login_input.val() ) != false   ){
					 event.preventDefault();     
					login_input.css('color', 'red');
					login_input.val("Логин занят");
					condition["login"] = 0;
					return;
					
				}
				
				
				if( pass_input.val().length < 7 ||  pass_input.val().length > 30 ){
					 event.preventDefault();     
					pass_input.css('color', 'red');
					condition["pass"] = 0;
					return;
				}
				
				if( pass_test_input.val() != pass_input.val() ){
					 event.preventDefault();     
					pass_test_input.css('color', 'red');
					condition["pass_test"] = 0;
					return;
				}
				
				if( !isValidEmail( email_input.val() ) ){
					 event.preventDefault();     
					email_input.css('color', 'red');
					email_input.val("Неверный Email");
					condition["email"] = 0;
					return;
				}
				
				
				
				reg_form.submit();
					
			
});


$("#sub_login_form").live('click', function(event){
	
	if( !test_domen() ) return; 
				
	var login_form = $("form[name=login_form]");
	
	$("form[name=login_form]").submit();    
});