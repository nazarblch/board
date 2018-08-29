$(document).ready(function() {
	// Expand Panel
	$("#open").click(function(){
		$("div#panel").css("height", "300px");
		$("div#panel").hide();
		$("div#panel").slideDown("slow");
	    $("div#toppanel").css("z-index", 1001); 
	});	
	
	// Collapse Panel
	$("#close").click(function(){
		$("div#panel").slideUp("slow");	
		setTimeout("$('div#toppanel').css('z-index', 999)", 1500);
	});		
	
	// Switch buttons from "Log In | Register" to "Close Panel" on click
	$("#toggle a").click(function () {
		$("#toggle a").toggle();
	});		
		
});