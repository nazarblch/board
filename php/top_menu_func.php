<?
function make_pass($theme_get_id, $kind){
	
	$line_get_id = $theme_get_id;
	
	$res = "";
	
	if($kind == "theme"){
		
		 $res4 = mysql_query( "select * from themes where id='$theme_get_id' ");
	     $theme_row = mysql_fetch_array($res4);
		 $theme_parent = $theme_row['parent'];
		 $theme_name = $theme_row['name'];
		 
		 if($theme_parent == 0){
			
			  $res = "<a class='pass_link' href='index.php?theme_id=".$theme_get_id."'>".$theme_name."</a> ";
			  return $res; 
		 
		 }else{
			 
			 $res = make_pass($theme_parent, $kind);
			 $res = $res."<a class='pass_link' href='index.php?theme_id=".$theme_get_id."'>".$theme_name."</a> ";
			 return $res; 
		 
			 
		 }
	}
	
	
	if($kind == "line"){
		
		 $res4 = mysql_query( "select parent,data,title_id from chat_lines where id='$line_get_id' ");
	     $line_row = mysql_fetch_array($res4);
		 $line_parent = $line_row['parent'];
		 $line_name = substr($line_row['data'],0,15);
		 
		 if($line_parent == 0){
			
			  $title_id = $line_row['title_id']; 
			  $res4 = mysql_query( "select theme_id,data from titles where id='$title_id' ");
			  $line_row = mysql_fetch_array($res4);
			  $theme_id = $line_row['theme_id'];
			  $title_name = substr($line_row['data'],0,15);
			  
			  $res = make_pass($theme_id, "theme");
			  $res = $res."<a class='pass_link' href='index.php?title_id=".$title_id."'>".$title_name."</a> ";
			  $res = $res."<a class='pass_link' href='index.php?line_id=".$line_get_id."'>".$line_name."</a> ";
			  
			  return $res; 
			  
		 }else{
			 
			 $res = make_pass($line_parent, $kind);
			 $res = $res."<a class='pass_link' href='index.php?line_id=".$line_get_id."'>".$line_name."</a> ";
			 return $res; 
		 
			 
		 }
	}
	
	
	if($kind == "title"){
		
		 	
			  $title_id = $theme_get_id; 
			  $res4 = mysql_query( "select theme_id,data from titles where id='$title_id' ");
			  $line_row = mysql_fetch_array($res4);
			  $theme_id = $line_row['theme_id'];
			  $title_name = substr($line_row['data'],0,15);
			  
			  $res = make_pass($theme_id, "theme");
			  $res = $res."<a class='pass_link' href='index.php?title_id=".$title_id."'>".$title_name."</a> ";
			  
			  
			  return $res; 
			  
		 
	}



}


?>