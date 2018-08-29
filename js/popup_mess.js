var d = document;
var offsetfromcursorY=25 // y offset of tooltip
var ie=d.all && !window.opera;
var ns6=d.getElementById && !d.all;
var tipobj=null,op;
var _vis = false;
var _hover = false;
var el=null;
		
function tooltip(object) {
	var id = object.attr('id');
	
	if(el!=null && (el.attr('id') != id || el != object) ){
		el.removeClass("_hover");
		tipobj.hide();
		//alert("xsdxSD");
	}
	
	
	el = object;
	
	if(el.hasClass("_hover")) return;
	if(_vis == true) return;
	
	el.addClass("_hover");
	
	if( $("div#user_info_"+id).length <= 0 ){
		get_user_info(id);
	}
	
	tipobj=$("div#user_info_"+id);
	/*
	el.live('mousemove', function(event){
		if(! $(this).hasClass("_hover")) setTimeout("$( 'div#user_info_'+$(this).attr('id') ).fadeIn(1)", 1500);
	    $(this).addClass("_hover");
	});
	*/
	var el_p = el;
	
	var x = el.offset().left;
	var y = el.offset().top;
	x = x + el.width() - 170;
	y = y - el.height()/2 - 110;
	
	
	
	
	tipobj.css("left",x+"px");
	tipobj.css("top",y+"px");
	//alert(x);
	//tipobj.css("margin-top","-25px");
	
	//setTimeout('appear()', 500);
	//setTimeout("if( el.hasClass('_hover') ){ tipobj.fadeIn(1);  tipobj.css('visibility','visible');}",1500);
	if( el.hasClass('_hover') ){ tipobj.fadeIn(1);  tipobj.css('visibility','visible');}
}

function set_vis(){
	_vis = true;
	
}

function del_vis(){
	_vis = false;
	hide_info();
}



function hide_info() {
	 if(el != null && el.hasClass('_hover')) el.removeClass("_hover");
	//alert(_hover);
	
	// var curobj = $('a#'+id);
	 
		//d.getElementById('mess').style.visibility='hidden';
		//el.onmousemove='';
		setTimeout("if(el != null && !el.hasClass('_hover') && _vis == false ) tipobj.fadeOut(300)", 500);
	
}


function get_user_info(user_id){
	
	$.ajax({
				async: false,				// по умолчанию false
				cache: false,				// по умполчанию true,
	    	    type: "POST",				// POST
	    	    url: "php/db_user_ansver.php",
				//data: "data="+"content",			
				data: "user_id="+user_id,
				dataType: "text", 			// "xml", "text", "script", "json", "jsonp"
	    	    contentType: "application/x-www-form-urlencoded", // по умолчанию «application/x-www-form-urlencoded»
				global: false, 				// по умолчанию true
				ifModified: false,			// по умолчанию false
				//username: 'login',
				//password: 'pass',
	    	    processData: false,			// по умолчанию true
				timeout: 5000,
								 		
	    	    success: function(data) {
					
					
				     if(data != "db mistake"){
					
						var img = data.split("&_&")[0];
						var name = data.split("&_&")[1];
						
						$(".users_info_arr").prepend('<div  class="user_info_class" id="user_info_'+user_id+'"><table align="center" width="85%" border="0" cellspacing="0" cellpadding="0"><tr><td width="110" align="left" valign="middle"><img src="img/users/avatar/'+img+'" /></td><td align="left" valign="middle"><div class="user_info_name">'+name+'</div></td></tr></table></div>');
					
					}
					
					
					
				}
				
				
				
	});
	
	
	
}


var mid_img_is_active = 0;
var mid_img_active_id = 0;

$(document).ready(function() {	

$(".mid_img").find("img").css({"max-width": $(window).width()-40, "max-height": $(document).height()-60});

$('a.openmodal').click(function(e) {
		//Cancel the link behavior
		if(mid_img_is_active ==1) return;
		e.preventDefault();
		
		//Get the A tag
		var id = $(this).attr('href');
		 
	
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		//Set the popup window to center
		$(id).css('top', winH/2-$(id).height()/2 - 10);
		$(id).css('left', winW/2-$(id).width()/2);
	
		//transition effect
		$(id).fadeIn(2000);
		
		mid_img_is_active = 1;
		if(id.split("_")[1] == "img")
		   mid_img_active_id = parseInt(id.split("_")[2]); 
	
});
	
	//if close button is clicked
	$('.modal_window .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		$('#mask, .modal_window').hide();
		mid_img_is_active = 0;
		
	});		
	
	//if mask is clicked
	$('#mask').click(function () {
		
		$(this).hide();
		$('.modal_window').hide();
		mid_img_is_active = 0;
		
	});	
	
	function change_mid_img(direct){
		        $("#mid_img_"+mid_img_active_id).hide();
				var prevW = $("#mid_img_"+mid_img_active_id).width();
				var prevH = $("#mid_img_"+mid_img_active_id).height();
				var prevT = $(window).height()/2-prevH/2 - 10;
	         	var prevL = $(window).width()/2-prevW/2;
				if(direct==37)mid_img_active_id--;
				if(direct==39)mid_img_active_id++;
	
	            var id = "#mid_img_"+mid_img_active_id;
			
			    var curW = $(id).width();
				var curH = $(id).height();
				var curT = $(window).height()/2-curH/2 - 10;
	         	var curL = $(window).width()/2-curW/2;
				$(id).find("img").css('width', prevW);
	         	$(id).find("img").css('height', prevH);
				$(id).css('left', prevL);
	         	$(id).css('top', prevT);
				
				$(id).fadeIn(300);
				
				$(id).animate({"left": curL+"px","top": curT+"px"}, 200,"easeOutQuart");
				$(id).find("img").animate({"width": curW+"px","height": curH+"px"}, 500,"easeOutQuart");
				
				
				
	}
	
	document.onkeydown = function(e){
		
		if( mid_img_is_active==1 ){  
			e = (e) ? e : (window.event); 
			var a = e.keyCode;
			if( a==27 ){
				$('#mask, .modal_window').hide();
				mid_img_is_active==0;
			}
			
			
			
			if( a==37 && mid_img_active_id > 1){
				
	            change_mid_img(37);
				
			}
			
			if( a==39 && mid_img_active_id < $(".mid_img").length && mid_img_active_id > 0){
	            change_mid_img(39);
				
			}
		}
		
		
		
	}
	
});		

function isset(a){
	try{
		if(a == null || a == 'undefined' ) return false;
	    else return true;
	}catch(e){return false}
}
	
