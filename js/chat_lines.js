var _exist = false;
var _title_is_active = false;
var _line_is_active = false;
var _is_title = 0;
var _cr_sec = false;
var _user_click = false;
var _online_arr = new Array();
var _zakladky_arr = new Array();

		
		$(".data_line").live('mouseover', function(event){
			
		  if(_exist == false){	
		    if(_line_is_active == true) $('.active').css({'background-color':''});
			if(_title_is_active == true) $('.active').find('.theme_title').css({'background-color':''});
			$('.active').removeClass('active');
		  
			$(this).addClass('active');
			$(this).css({'background-color':'#FAEDED'});
			_title_is_active = false;
			_line_is_active = true;
		  }
			
	    });
		
		$(".title_line").live('mouseover', function(event){
			if(_exist == false){
				 if(_line_is_active == true) $('.active').css({'background-color':''});
			     if(_title_is_active == true) $('.active').find('.theme_title').css({'background-color':''});
			     $('.active').removeClass('active');
				
				$(this).addClass('active');
				$(this).find('.theme_title').css({'background-color':'#eaeff0'});
				_title_is_active = true;
				_line_is_active = false;
			}
			
	    });
		
		
		$(".data_line").live('mouseout', function(event){
		   if(_exist == false){	
		        $('.active').css({'background-color':''}); 
				$('.active').removeClass('active');
				
				_line_is_active = false;
		   }
			
	    });
		
		$(".title_line").live('mouseout', function(event){
			 if(_exist == false){	
				$('.active').find('.theme_title').css({'background-color':''});
				$('.active').removeClass('active');
				_title_is_active = false;
			 }
			
	    });	
		
		
		window.onkeypress = function(e){
			
		   if(_cr_sec == true) return;  			
					
		   e = (e) ? e : (window.event); 
					
		   var a = e.keyCode;
			
			
			if(a == 27){
				
				$('#add_t').parent().find('.tab').css({'width': '25px'});
				$('#add_t').parent().find('#user_link').css({'display': ''});
				
				
				$('#add_t').remove();
				$('#add_br').remove();
				_exist = false;
				
				return;
				
			}
			
			if(a == 13 && _exist == true) {
				
				var id = $('#add_t').parent().parent().attr('id');
				var title_id = $('#add_t').parents('table').attr('id');
				var data = $('#add_t').val();
				
				
				$('#add_t').parent().find('.tab').css({'width': '25px'});
				$('#add_t').parent().find('#user_link').css({'display': ''});
				
				update_db(id, data, _is_title, title_id);
				
				$('#add_t').remove();
				$('#add_br').remove();
				_exist = false;
				
				return;
				
			}
			
			if(a == 13 || e.altKey || e.ctrlKey){ 
			     $('#add_t').blur();
				 
			}
			
			if(_exist == false && a != 37 && a != 38 && a != 39 && a != 40 && a != 13 && (_line_is_active || _title_is_active)  ){
				  	
				if( !isset(getCookie("user_id")) || !isset(getCookie("hash")) ) return; 
				//alert(isset(sadad));
				
				if(_title_is_active == false){
					$('.active').find('.theme_data').append("<input id='add_t' name='add_t' style='width:"+ String(window.innerWidth-500) +"px' maxlength='200' type='text'  />");
					$('.active').find('.tab').css({'width': '0px'});
					_is_title = 0;
				}else{
					$('.active').find('.theme_title').append("<br id='add_br'><input id='add_t' name='add_t' style='width:"+ String(window.innerWidth-500) +"px' maxlength='200' type='text'  />");
					_is_title = 1;
				}
				
			
				
				//$('.active').find('#user_link').css({'display': 'none'});
				$('.active').find('#add_t').focus() 
				    
				_exist = true;
			
			}
			
			//e.preventDefault();
			//$('.active').find('#add_t').append(String.fromCharCode(a));
			

			
		}
		
		
		
		
		
		function update_db(id, mydata, _is_title, title_id){
			
			
			var user_id = getCookie('user_id');
			
			if(user_id == "" || user_id == null){
				return;
			}
			
			if(mydata == "" || mydata == null ){
				return;
			}
			
			_cr_sec = true;
			
			
			$.ajax({
				async: false,				// по умолчанию false
				cache: false,				// по умполчанию true,
	    	    type: "POST",				// POST
	    	    url: "php/db_chat_ansver.php",
				//data: "data="+"content",			
				data: "data=" + mydata + "&parent=" + id + "&parent_is_title=" + _is_title + "&title_id=" + title_id + "&user_id=" + user_id,
				dataType: "text", 			// "xml", "text", "script", "json", "jsonp"
	    	    contentType: "application/x-www-form-urlencoded", // по умолчанию «application/x-www-form-urlencoded»
				global: false, 				// по умолчанию true
				ifModified: false,			// по умолчанию false
				//username: 'login',
				//password: 'pass',
	    	    processData: false,			// по умолчанию true
				timeout: 30000,
				
				//beforeSend: function(XMLHttpRequest){
				//	},
								 		
	    	    success: function(data) {
					var new_data = data.split("&_&");
					var new_data0 = new_data[0];
					
					var cur_user = new_data[new_data.length-2];
					
					if(_is_title == false){
						
						var tabstr = "";
						var k = 1;
						
						$("tr[id="+id+"]").find(".tab").each(function()
						{
							tabstr += "<div  class='tab' >&nbsp;</div>";
							k++;
						});
						
						new_data0 = new_data0.substring(0, 120 - k*5);
						
					
						$("tr[id="+id+"]").after("<tr class='data_line' height='18px;' id='"+ new_data[new_data.length-1] +"'> <td class='first_tab' width='15px' ><div>&nbsp;</div></td><td align='left' valign='middle'  class='theme_data' ><div  class='tab' >&nbsp;</div>" + tabstr + new_data0 + "<a href='' id='"+user_id+"' class='self' > :"+  cur_user +" </a></td></tr>"
						);
						
					}else{
						
						    new_data0 = new_data0.substring(0, 120 - 5);
						
							$("table[id=t"+id+"]").prepend("<tr class='data_line' height='18px;' id='"+ new_data[new_data.length-1] +"'> <td class='first_tab' width='15px' ><div>&nbsp;</div></td><td align='left' valign='middle'  class='theme_data' ><div  class='tab' >&nbsp;</div>" + new_data0 + "<a href='' id='"+user_id+"' class='self' > :"+ cur_user +" </a></td></tr>"
						     );
					
						
					}
					
					
				
					
				}
	    	});
			
			
	        _cr_sec = false;
			
		}
		
		
		function db_zakladky_update(title_id){
			
			$.ajax({
				async: false,				
				cache: false,				
	    	    type: "POST",				
	    	    url: "php/db_insert_favorite.php",
				data: "title_id=" + title_id,
				dataType: "text", 		
	    	    contentType: "application/x-www-form-urlencoded",
				global: false, 				
			    processData: false,			
				timeout: 30000
			});
			
		}
		
		
		function db_zakladky_del(title_id){
			
			$.ajax({
				async: false,				
				cache: false,				
	    	    type: "POST",				
	    	    url: "php/db_del_favorite.php",
				data: "title_id=" + title_id,
				dataType: "text", 		
	    	    contentType: "application/x-www-form-urlencoded",
				global: false, 				
			    processData: false,			
				timeout: 30000
			});
			
		}
		
		
		
		function check_new_lines(title_id){
			
			var enter_time = getCookie('enter_time');
			var user_id = getCookie('user_id');
			
			
			
			
			$.ajax({
				async: true,				// по умолчанию false
				cache: true,				// по умполчанию true,
	    	    type: "POST",				// POST
	    	    url: "php/db_chat_new_ansver.php",
				//data: "data="+"content",			
				data: "enter_time=" + enter_time + "&title_id=" + title_id,
				dataType: "text", 			// "xml", "text", "script", "json", "jsonp"
	    	    contentType: "application/x-www-form-urlencoded", // по умолчанию «application/x-www-form-urlencoded»
				global: false, 				// по умолчанию true
				ifModified: false,			// по умолчанию false
				//username: 'login',
				//password: 'pass',
	    	    processData: false,			// по умолчанию true
				timeout: 10000,
								 		
	    	    success: function(data) {
					
					//alert(enter_time);
					//alert(data);
					
					if(data.length < 15 || data =="" || data ==null ) return;
					
					var data_arr = data.split(",");
					var i = 0;
					var par_id, chd_id, new_data, user;
					
					for(i = 0; i < data_arr.length; i++){
						
						
						par_id = data_arr[i].split("&_&")[0];
						chd_id = data_arr[i].split("&_&")[1];
						user = data_arr[i].split("&_&")[2];
						new_data = data_arr[i].split("&_&")[3];
						
						
						if(par_id == 0){
							
							new_data = new_data.substring(0, 120 - 5);
							
						  if( $("tr[id="+chd_id+"]").attr('id') == "undefined" ||  $("tr[id="+chd_id+"]").attr('id') == null)
							$("table[id=tt_"+title_id+"]").prepend("<tr class='data_line' height='18px;' id='"+ chd_id +"'> <td class='first_tab' width='15px' ><div>&nbsp;</div></td><td align='left' valign='middle'  class='theme_data' ><div  class='tab' >&nbsp;</div>" + new_data + "<a href='' id='"+user_id+"' class='user' > :"+ user +" </a></td></tr>"
						     );
							
						}else{
							
							var tabstr = "";
							var k = 1;
							
							$("tr[id="+par_id+"]").find(".tab").each(function()
							{
								tabstr += "<div  class='tab' >&nbsp;</div>";
								k++;
							});
							           
							new_data = new_data.substring(0, 120 - k*5);
						
							
						  if( $("tr[id="+chd_id+"]").attr('id') == "undefined" ||  $("tr[id="+chd_id+"]").attr('id') == null)
							$("tr[id="+par_id+"]").after("<tr class='data_line' height='18px;' id='"+ chd_id +"'> <td class='first_tab' width='15px' ><div>&nbsp;</div></td><td align='left' valign='middle'  class='theme_data' ><div  class='tab' >&nbsp;</div>" + tabstr + new_data + "<a href='' id='"+user_id+"' class='user' > :"+  user +" </a></td></tr>"
						    );
							
						}
						
						 $("#content").find("a[id="+user_id+"]").each(function(ind, oelem)
								{	
									$(this).removeClass('user');
									$(this).addClass('self');						
								}
		                );
						
						 
						
					}
					
					
				}
				
				
			});	
			
			var time = get_server_time();       
	        setCookie('enter_time', time, '', '/');			
			
		}
		
		
		function get_server_time(){
			
			var time;
			
			$.ajax({
				async: false,				// по умолчанию false
				cache: false,				// по умполчанию true,
	    	    type: "POST",				// POST
	    	    url: "php/time_ansver.php",
				//data: "data="+"content",			
				data: "",
				dataType: "text", 			// "xml", "text", "script", "json", "jsonp"
	    	    contentType: "application/x-www-form-urlencoded", // по умолчанию «application/x-www-form-urlencoded»
				global: false, 				// по умолчанию true
				ifModified: false,			// по умолчанию false
				//username: 'login',
				//password: 'pass',
	    	    processData: false,			// по умолчанию true
				timeout: 10000,
								 		
	    	    success: function(data) {
					time = data;
					
				}
				
				
				
			});
			
			return time; 
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		$(".active").live('click', function(event){
			
			if(_title_is_active == false){
				
				if(_exist == false && _user_click == false) document.location.href = "index.php?line_id="+$('.active').attr('id');
					
			}else{
				
				if(_exist == false && _user_click == false) document.location.href = "index.php?title_id="+ ($('.active').attr('id')).substring(2);
					
			}
			
		});	
		
		
		

	   $("#sub_chat_insert").live('click', function(event){
		   
                if( !test_domen() ) return; 
				
				if( $("form[name=big_insert] :hidden[name=ansver]").val() !=  $("form[name=big_insert] :text[name=check]").val() ){
					$("form[name=big_insert] :text[name=check]").prev().css('color', 'red');
					return;
				}
				
				if( $("form[name=big_insert] :text[name=data]").val() == "" || $("form[name=big_insert] :text[name=data]").val() == null ){
					$("form[name=big_insert] label:contains('Заголовок')").css('color', 'red');
					return;
				}
				
				var user_id = getCookie('user_id');
				
				$("form[name=big_insert] :hidden[name=user_id]").val(user_id);
				
				
				$("#big_insert").submit();
					
			
		});
		
		
		function is_int(mixed_var){
          if(parseInt(mixed_var) =="NaN" || isNaN(mixed_var) || mixed_var == '') return false;
		  else return true;
        }



		function test_domen(){
			 
			var re = /^http:\/\/boardmsu(.)*$/;
		    return re.test(document.location.href);
			
		}
		
		function isValidEmail(email){
			
             re = /^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/;
             return re.test(email);
        }
		
		
		function testf(){
			$("form :file[name=attached_file_1]").open();
		}
		
		
		
		
		$("#sub_chat_insert_title").live('click', function(event){
		   
                if( !test_domen() ) return; 
				
				if( $("form[name=chat_insert_title] :hidden[name=ansver]").val() !=  $("form[name=chat_insert_title] :text[name=check]").val() ){
					$("form[name=chat_insert_title] :text[name=check]").prev().css('color', 'red');
					return;
				}
				
				if( $("form[name=chat_insert_title] :text[name=data]").val() == "" || $("form[name=chat_insert_title] :text[name=data]").val() == null ){
					$("form[name=chat_insert_title] label:contains('Заголовок')").css('color', 'red');
					return;
				}
				
				var user_id = getCookie('user_id');
				
				$("form[name=chat_insert_title] :hidden[name=user_id]").val(user_id);
				
				
				$("#chat_insert_title").submit();
					
			
		});
		
		
		
		$("#sub_chat_add_theme").live('click', function(event){
		   
                if( !test_domen() ) return; 
				
				if( $("form[name=chat_add_theme] :hidden[name=ansver]").val() !=  $("form[name=chat_add_theme] :text[name=check]").val() ){
					$("form[name=chat_add_theme] :text[name=check]").prev().css('color', 'red');
					return;
				}
				
				if( $("form[name=chat_add_theme] :text[name=data]").val() == "" || $("form[name=chat_add_theme] :text[name=data]").val() == null ){
					$("form[name=chat_add_theme] label:contains('Название темы')").css('color', 'red');
					return;
				}
				
				var user_id = getCookie('user_id');
				
				$("form[name=chat_add_theme] :hidden[name=user_id]").val(user_id);
				
				
				$("#chat_add_theme").submit();
					
			
		});
		
		
		$(".user").live('click', function(event){	
			_user_click = true;
			tooltip($(this));
			event.preventDefault();
			setTimeout("_user_click = false", 500);	 
			
		});
		
		$(".self").live('click', function(event){	
		        event.preventDefault();
		});
		
		
		$(".user_info_class").live('mouseover', function(event){
			
			//alert("hren");
		    set_vis();
			
		});
		
		$(".user_info_class").live('mouseout', function(event){
			
			
			//setTimeout("hide_info($(this).parent().attr('id'))",700);
			del_vis();
			
		});
			
		
		$(".user, .self").live('mouseout', function(event){
			
			 
			 //hide_info(document.getElementById($(this).attr("id")));
			 hide_info();
		});	
		
		 function update_cookie(line_id, type){
			 
			var cookies;
			  
		    if( getCookie('online')==null )cookies = ''; 
		    else cookies = getCookie('online').split('_');
			 
			
			if(cookies.indexOf(line_id) != -1) cookies.splice(cookies.indexOf(line_id),1);
			if(cookies.indexOf(line_id) != -1) cookies.splice(cookies.indexOf(line_id),1);  
			
			if( type == 0 ){
				if(cookies.length>1){
				setCookie('online', cookies.join('_'), '', '/');
				}else{
					setCookie('online', '', '', '/');
				}
				
				
			}else{
				
				if(cookies.length>0){
					cookies.push(line_id);
					setCookie('online', cookies.join('_'), '', '/');
				}else{
					setCookie('online', line_id, '', '/');
				}
				
			}
			
		 }
		 
		$(".theme_title").find(".online").live('click', function(event){
			_user_click = true;
			
			var line_id = $(this).parent().parent('.title_line').attr('id').split('_')[1];
			if( isset(_online_arr[line_id]) ){
				//alert(_online_arr[line_id]);
				clearInterval(_online_arr[line_id]);
				_online_arr[line_id] = null;
				$(this).css({"color":"#999","visibility":""}); 
				update_cookie(line_id, 0);
			}else{
				_online_arr[line_id] = setInterval("check_new_lines("+line_id+")", 5000);
				$(this).css({"color":"#5BA655","visibility":"visible"});
				update_cookie(line_id,1);
			}
			
			 
			
			setTimeout("_user_click = false", 500);	 
		});
		
		
		$(".theme_title").find(".zakladky").live('click', function(event){
			
			if( !isset(getCookie("user_id")) || !isset(getCookie("hash")) ) return; 
			
			_user_click = true;
			
			var line_id = $(this).parent().parent('.title_line').attr('id').split('_')[1];
			if( isset(_zakladky_arr[line_id]) ){
				return;
			}else{
				$(this).css({"background-image":"url(img/icons/star1.png)","visibility":"visible"});
				_zakladky_arr[line_id] = 1;
				db_zakladky_update(line_id);
				
			}
			
			setTimeout("_user_click = false", 500);	 
		});
		
		
		$(".theme_title").find(".delete").live('click', function(event){
			
			if( !isset(getCookie("user_id")) || !isset(getCookie("hash")) ) return; 
			
			_user_click = true;
			var line_id = $(this).parent().parent('.title_line').attr('id').split('_')[1];
			
			$(this).parent().parent('.title_line').parent().parent().remove();
			$("table[id=tt_"+line_id+"]").remove();
			db_zakladky_del(line_id);
				
			setTimeout("_user_click = false", 500);	 
		});
		
		
		$(".add_friend").live('click', function(event){
			if( !isset(getCookie("user_id")) || !isset(getCookie("hash")) ) return; 
			
			var friend_id = $(this).attr('id');
			friend_id = friend_id.substr(3, friend_id.length);
			
			$.ajax({
				async: false,				
				cache: false,				
	    	    type: "POST",				
	    	    url: "php/db_add_friend.php",
				data: "friend_id=" + friend_id,
				dataType: "text", 		
	    	    contentType: "application/x-www-form-urlencoded",
				global: false, 				
			    processData: false,			
				timeout: 30000,
				
				success: function(data) {
					if( data != 1 && data != '1') alert(data);
				}
				
			});
		});
		
		
		$(".friend_confirm").live('click', function(event){
			if( !isset(getCookie("user_id")) || !isset(getCookie("hash")) ) return; 
			
			var friend_id = $(this).attr('id');
			friend_id = friend_id.substr(3, friend_id.length);
			
			$.ajax({
				async: false,				
				cache: false,				
	    	    type: "POST",				
	    	    url: "php/db_friend_confirm.php",
				data: "friend_id=" + friend_id,
				dataType: "text", 		
	    	    contentType: "application/x-www-form-urlencoded",
				global: false, 				
			    processData: false,			
				timeout: 30000,
				
				success: function(data) {
					if( data != 1 && data != '1') alert(data);
				}
				
			});
			
			$(this).remove();
		});
		
		$(".friend_del").live('click', function(event){
			if( !isset(getCookie("user_id")) || !isset(getCookie("hash")) ) return; 
			
			var e_id = $(this).parent().parent().parent().attr('id');
			e_id = e_id.substr(2, e_id.length);
						alert(e_id);
			
			$.ajax({
				async: false,				
				cache: false,				
	    	    type: "POST",				
	    	    url: "php/db_friend_del.php",
				data: "e_id=" + e_id,
				dataType: "text", 		
	    	    contentType: "application/x-www-form-urlencoded",
				global: false, 				
			    processData: false,			
				timeout: 30000,
				
				success: function(data) {
					if( data != 1 && data != '1') alert(data);
				}
				
			});
			
			$(this).parent().parent().parent().remove();
		});
		
		
		 $(".sub_mess_butt").live('click', function(event){
			   if( !test_domen() ) return;
				 var mess_form = $(this).parents("form[id=mess_form]");
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
						$("#uploaded_files").html("");
						file_iter = 0;  
						$("#send_mess_form").find(".close").click();
						
						if(data == 1 || data == "1"){
						}else{
							alert(data);
						}
					}
					
					
					
				});
		 });