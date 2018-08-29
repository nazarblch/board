<script type="text/javascript">
$(document).ready(function() {	

         var file_iter = 0;  
         var button = $('#upload_file_button');
			
		 $.ajax_upload(button, {
						action : 'php/load_file.php',
						name : 'myfile',
						data : new Array("<? echo 0; ?>"),
						onSubmit : function(file, ext) {
							// показываем картинку загрузки файла
							//$("img#load1").attr("src", "js/load.gif");
							$("#upload_file_button").text('Загрузка');
						    this.disable();

						},
						onComplete : function(file, response) {
							// убираем картинку загрузки файла
							//$("img#load1").attr("src", "js/loadstop.gif");
							$("#upload_file_button").text('Загрузить другой');
                            alert(file);
							alert(response);
							this.enable();
							$("#uploaded_files").prepend("<li>"+file+"</li>");
							$("#big_insert").prepend("<input name='file_id_"+file_iter+"' type='hidden' value='"+response+"' />");
							file_iter++;
						}
		});
});
</script>
   <?
	          $first_element = 0;	   // the top parent
			  $line_in_top = false;
			  
			  if( isset($_GET['theme_id']) ){
				  $get_theme_id = intval($_GET['theme_id']);
				  
				  $res9 = mysql_query( " select id from themes where parent='$get_theme_id' ");
				  
				  $theme_childrens = $get_theme_id;
				  while( $theme_childrens_row = mysql_fetch_array($res9) ){
					  $theme_childrens = $theme_childrens.",";
					  $theme_childrens = $theme_childrens.$theme_childrens_row['id'];  
				  }
				  
				  
				  $get_theme_add = "and theme_id in(".$theme_childrens.")";
				  $get_theme_where = "where theme_id in(".$theme_childrens.")"; 
			  }else{
				  $get_theme_add = "";
				  $get_theme_where = "";
			  }
		   
		     
			  
			  if( isset($_GET['title_id']) && !isset($_GET['line_id'])){
				  
				   $title_id = intval( $_GET['title_id'] );
				  
				   $res2 = mysql_query( "select * from titles where id='$title_id' ".$get_theme_add);
				   
				   if( mysql_num_rows($res2) == 0 ){
					    unset( $_GET['title_id'] );
						   echo "<div class='tab' style=' width: 15px; height:30px;'></div>&nbsp;Сообщений с данными параметрами не найдено ";
				   }
			  }
			  
			  if( !isset($_GET['title_id']) && isset($_GET['line_id'])){
				  
				   $line_in_top = true;
				   
				   $first_element = intval( $_GET['line_id'] );
				  
				   $res2 = mysql_query( "select * from chat_lines where id='$first_element' ");
				   
				   if( mysql_num_rows($res2) == 0 ) {
					   //unset( $_GET['line_id'] );
					   echo "<br><div class='tab' style=' width: 15px;'></div>&nbsp;Сообщений с данными параметрами не найдено <br>";
					   $line_in_top = false;
					   $first_element = 0;
				   }
				   
				   
			  }
			  
			   if( !isset($_GET['title_id']) && !isset($_GET['line_id']) ) $res2 = mysql_query( "select * from titles ".$get_theme_where." order by time desc ");
			  
			  
    
              if($line_in_top == false){           // standart mode
			 
			   
	                 while($title_line = mysql_fetch_array($res2) ){
						 
						 
						 $id = $title_line['id'];
						 if(isset( $title_line['theme_id'] ))$theme_id = $title_line['theme_id'];
						 $data = $title_line['data'];
						 $time = substr($title_line['time'], 5, 11);
						 $user_id = $title_line['user_id'];
						 $theme_id = $title_line['theme_id'];
						 $inner_data = $title_line['inner_data'];
						 
						 
						 
						 $res3 = mysql_query( "select * from users where  id='$user_id' ");
						 $user_row = mysql_fetch_array($res3);
						 $user = $user_row['login'];
						 
						 
						 $res4 = mysql_query( "select * from themes where  id='$theme_id' ");
						 $theme_row = mysql_fetch_array($res4);
						 $theme_img = $theme_row['img'];
						 $theme_name = $theme_row['name']; 
						 
						 echo '
						       <table width="100%"  border="0" cellspacing="0" cellpadding="0" id="t__'.$id.'"  >
							      <tr height="3px">
										<td width="15px" style="border-right:1px #ece9d8 solid;"><div style=" width: 15px;" ></div></td>
										<td></td>
										<td></td>
										<td></td>
										</tr>
									 
									  <tr class="title_line" id="t_'.$id.'">
									  
										  <td width="15px" style="border-right:1px #ece9d8 solid;"><div style=" width: 15px;" >&nbsp;</div></td>
										  <td align="center" valign="middle" width="29px;" style="background-color:#f5f5f5;">
										  <img align="middle" alt="'.$theme_name.'" title="'.$theme_name.'" src="img/theme/'.$theme_img.'" width="22" height="22">
										  </td>
										  
										  <td align="left" valign="middle"  class="theme_title" >
										  '.$data.'
										  <a href="" id="'.$user_id.'" class="user" > :'.$user.'</a>
										   <div class="zakladky" title="добавить в закладки">&nbsp;</div>
										   <div class="online" title="включить автообновление">online</div>
										  </td>
						
										<td align="center" width="100px;" style="background-color:#f5f5f5;"><font color="#999999">'.$time.'</font></td>
										  
									  </tr>
									  
									   <tr height="5px">
										<td width="15px" style="border-right:1px #ece9d8 solid;"><div style=" width: 15px;" ></div></td>
										<td></td>
										<td></td>
										<td></td>
										</tr>
									 
									  <tr>
									  
							   </table> 
								 
						 
						 ';
						 
						 
						 echo '<table width="100%"   border="0" cellspacing="0" cellpadding="0" id="tt_'.$id.'" >';
			
			             if( isset($_GET['title_id']) && !isset($_GET['line_id']) && $inner_data != ""){
							 
							 	echo '<tr height="10px">
												<td width="15px" style="border-right:1px #ece9d8 solid; "><div style=" width: 15px;" ></div></td>
												<td></td>
												</tr>
				
												 <tr class="inner_data"  id="inner_'.$id.'" >
													  <td class="first_tab" width="15px" ><div>&nbsp;</div></td>
													  <td align="left" valign="middle" >
										';
											
											
											
										echo '<div class="inner_data_text">	'.$inner_data.' </div>';
										
										print_attached_files($id, "titles");
													  
													    
										echo '			  
													 
													  </td>
												 </tr>
											 
										';
						 }
						
			
			
			
			
			                 getlines( $id , $first_element, 0 );   // ( $title_id , $parent, $level )
							 
							 if( isset($_GET['title_id']) && !isset($_GET['line_id'])) print_insert_form($id, 0); //  print_insert_form($title_id, $parent_id); 
			       			 
	                     echo '</table>';					 
				     }
				}
					 
					 
					 
			    if($line_in_top == true){     // spesial line mode
						    
							
							$title_line = mysql_fetch_array($res2);
		
		                    $id = $title_line['id'];
							$title_id = $title_line['title_id'];
							$data = $title_line['data'];
							if( isset($title_line['inner_data']) && $title_line['inner_data'] != "" )$inner_data = $title_line['inner_data'];
							else $inner_data = "";
							$user_id = $title_line['user_id'];
							
							$res1 = mysql_query( "select * from users where  id='$user_id' ");
							$user_row = mysql_fetch_array($res1);
							$user = $user_row['login'];
							
							$data = substr($data, 0, 120);    // cut data
							
							
							
								 echo '<table width="100%"   border="0" cellspacing="0" cellpadding="0" id="tt_'.$title_id.'" >';
								 
								 echo '<tr height="3px">
										<td width="15px" style="border-right:1px #ece9d8 solid;"><div style=" width: 15px;" ></div></td>
										<td></td>
										</tr>
		
										 <tr class="data_line" height="18px;" id="'.$id.'" >
											  <td class="first_tab" width="15px" ><div>&nbsp;</div></td>
											 
											  <td align="left" valign="middle"  class="theme_data" >
								';
									
									
									
								echo '
												'.$data.' 
											  <a href="" id="'.$user_id.'" class="user" > :'.$user.'</a>
											 
											  </td>
										 </tr>
									 
								';
								
								
								if($inner_data != ""){
								
										echo '<tr height="10px">
												<td width="15px" style="border-right:1px #ece9d8 solid; "><div style=" width: 15px;" ></div></td>
												<td></td>
												</tr>
				
												 <tr class="inner_data"  id="inner_'.$id.'" >
													  <td class="first_tab" width="15px" ><div>&nbsp;</div></td>
													  <td align="left" valign="middle" >
										';
											
											
											
										echo '<div class="inner_data_text">	'.$inner_data.' </div>';
										
										print_attached_files($id, "chat_lines");
													  
													    
										echo '			  
													 
													  </td>
												 </tr>
											 
										';
								}
								
								
			
			                         getlines( $title_id , $first_element, 0 );   // ( $title_id , $parent, $level )
									 
									 print_insert_form($title_id ,$id); 
			       			 
	                             echo '</table>';					 
				    
							
							
						
		            }
					   
           ?>
           
           <table width="100%"  border="0" cellspacing="0" cellpadding="0" >
              <tr>
                  <td width="15px" style="border-right:1px #ece9d8 solid;"><div style=" width: 15px;" >&nbsp;</div></td>
                  
                 
                 
                  <td align="left" valign="middle"   >&nbsp;
                  
                  </td>
                  
                  
              </tr>
         </table>
           
           
		   <div class="users_info_arr" >
			 
			
           
           </div>
       
     