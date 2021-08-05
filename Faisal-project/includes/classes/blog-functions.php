<?php
class blog_functions
{
	var $db;
	var $blog;
	var $width;
	var $title_color;
	var $bg_color;
	var $link_color;
	var $m;

	function __construct($db,$blog,$m){
		$this->db = $db;
		$this->blog=$blog;
		$this->m=$m;
	}		
	function bog_properties($width,$title_color,$bg_color,$link_color){
		$this->width=$width;
		$this->title_color=$title_color;
		$this->bg_color=$bg_color;
		$this->link_color=$link_color;		
	}
	function render_css(){
	?>
        <style>
			.blog_width{
				margin:0 0 0 3px;
				padding:0;
				width:<?php echo $this->width;?>px;
				font-family:Verdana, Geneva, sans-serif;
				border:1px solid #CCC;
			}
			.page_title{
				background-color:<?php echo $this->title_color;?>;
				color:#FFF;
			}
			.heading{
				color:#FFF;
				padding:16px;	
				font-size:18px;			
				font-weight:bold;
				float:left;								
			}
			.blog_view_heading{
				color:<?php echo $this->link_color;?>;
				font-size:23px;
			}
			.sub_title{
				font-size:15px;
				color:#C66;
				font-weight:bold;
			}
			.sub_title2{
				font-size:16px;color:#C66;font-style:italic; font-weight:normal;
			}
			.sub_title3{
				font-size:13px;color:#C66; font-weight:bold;
			}
			.comment_title1{
				font-size:11px; color:#069; font-weight:bold;
			}
			.comment_title{
				font-size:11px; color:#666; font-weight:bold;
			}
			
			.comment_text{
				font-size:12px; 
				font-weight:normal;
				color:#666;
			}			
			.back_btn{
				font-size:12px;
				float:right;
				padding:13px;
			}
			.b_button{
				font-size:13px; 
			}
			.add_area{				
				background-color:<?php echo $this->bg_color;?>;	
				padding: 0 10px 10px 5px;
				font-size:13px; 				
			}
			.alert_msg{
				border-bottom:dashed 1px #F00; 
				border-top:dashed 1px #F00; 
				color:#F00; 
			}
			.border{
				width:99%;
				border:1px solid #CCC;
			}
			.heading_link {
				color:<?php echo $this->link_color;?>; 
				font-family:Arial, Helvetica, sans-serif;
				font-size:17px;
				font-weight:bold;
			}
			a:hover{
				color:#09F; 				
			}
			.dim_text{
				font-size:10px;
				color:#999;
				font-weight:normal;
			}
			.full_text{					
				background-color:#FFF;			
				padding:15px ;
			}
			.links{
				color:<?php echo $this->link_color;?>; 
				font-family:Arial, Helvetica, sans-serif;
				font-size:13px;
				text-decoration:none;
			}
			
			.clear{
				clear:both;
			}
			</style>      
	<?php
	}
	function render_js_for_comments(){
	?>
    <script language="javascript">
	function validate(){
		with(document.form1){
			if(name.value==''){
				alert('Please Enter Your Name!');
				name.focus();
				return false;
			}else if(email.value==''){
				alert('Please Enter Your Email');
				email.focus();
				return false;
			}else if(comments.value==''){
				alert('Please Type Some Comments');
				comments.focus();
				return false;
			}else{
				command.value='addComment';
				return true;
			}
		}
	}
	</script>
    <?php
	}
	function render_blog_dashboard($page_title,$pageno,$totalPages){

	?>
	<div class="blog_width">        	
      <table cellpadding="0" cellspacing="0" width="100%">	            
          <td  valign="top">                      
              <!--<div class="page_title">
                  <div class="heading"><?php //echo $page_title;?></div>
                  <div class="back_btn">                                              
                  </div>
                  <div class="clear"></div>
              </div>-->					             
              <div class="add_area">
              	  <div align="right" style="width:98%">
                  	<?php
					  if($pageno>=4)
						  $i=$pageno-3;
					  else
						  $i=1;
					  if($pageno+3<$totalPages)
						  $end=$pageno+3;
					  else
						  $end=$totalPages;
					  for($i; $i<=$end; $i++){
						  if($i==$pageno){
							  echo $i;
						  }else{
							  ?>&nbsp;<a href="?tab=dashboard&page=<?php echo $i?>"><?php echo $i?></a>&nbsp;<?php
						  }
					  }
					  ?>
                  </div>                                                                                                                    	
                  <?php
                     $result=$this->blog->get_blogs_posts_by_limit();
                     $i = 0;                       
                     while($row = $this->db->fetch_array($result)) { 
                     $blog_row = $this->blog->get_blog_row_by_serial($row['blogid']);
                  ?>                                                                          
                   <div>
                   <table width="740px">
                   	<tr>
                    	<td width="13%">
                        	<img src="images/blog.png"  width="81px"/>
                        </td>
                    	<td valign="middle">
                          <div>
                              <a class="heading_link" href="blog-dashboard.php?tab=blog&postid=<?php echo $row['serial']?>"><?php echo $row['title']?></a>
                              <span class="dim_text">
                              	<?php 
									$user_row=$this->m->get_row($blog_row['userid']);
									echo '(By '.$user_row['firstname'].' '.$user_row['lastname'].')';
								?>
                              </span>
                          </div>
                          <span style="font-size:12px;  color:#C66; font-family:Verdana, Geneva, sans-serif;"><?php echo ucwords($row['sub_title'])?></span>                                      
                          <div style="margin-bottom:6px;">
                              <span class="dim_text">
                              <?php
                                  $date_parts=explode("-",$row['date']);
                                  echo date("F d, Y",mktime(0,0,0,$date_parts[1],$date_parts[2],$date_parts[0]));
                              ?>
                              </span>
                          </div>                                        
                        </td>
                     </tr>
                   </table>
                      <div class="full_text">
                         <span style="font-size:12px; font-weight:normal;">
						  	<?php 									
								$text = preg_replace('/<\s*img[^>]+>/Ui', '', substr($row['fulltext'], 0, 300)); 
								echo strip_tags($text);
							?> ...
                         </span>   
                      </div>                        
                     
                      <div style="border-bottom:dotted 1px #9D9D9D; font-size:20px; margin-bottom:15px;">&nbsp;&nbsp;&nbsp;</div>
                   </div>                                             
                  <?php 
                      $i++; 
                  } 
                  if($i == 0) { ?>
                     <div align="center" style="color:#F00; font-size:14px;">No Blog Posts</div>
                  <?php 
                  } ?>
             </div> 
          </td>
      </table>
    </div>
    <?php
	}
	function render_blog_with_comments($postid,$name,$email,$web,$user_name){
	?>
		<div class="blog_width">        	
			<table cellpadding="0" cellspacing="0" width="100%">	            
				<td  valign="top">
					<?php 								  
					$row=$this->blog->get_row_blogs_posts($postid);
					?>                      
					<table width="100%">
							<tr>
								<td><div class="blog_view_heading"><?php echo $row['title']?></div></td><td width="4%" valign="top"><a href="blog-dashboard.php?tab=dashboard"><img src="images/back-button.png" border="0" style="width:28px; height:28px;"/></a></td>
                            </tr>
                    </table>   										
					<div class="add_area">                                                                                                                    	
						 <span class="sub_title"><?php echo ucwords($row['sub_title'])?></span><br />
						 <span class="dim_text">
							<?php 
								$date_parts=explode("-",$row['date']);
								echo date("F d, Y",mktime(0,0,0,$date_parts[1],$date_parts[2],$date_parts[0]));
							?>
						 </span>
                         <hr />                                                                         
						 <div style="padding:15px 0px;">
							<table border="0px" cellpadding="0px" cellspacing="0px" width="100%">
								<tr>
									<td class="full_text"><?php  echo $row['fulltext']?></td>
								</tr>
								<tr><td>&nbsp;</td></tr>                         
								<tr>
									<td>
										<table border="0px" cellpadding="0px" cellspacing="0px" width="50%" align="left">
											<tr>
												<td class="comment_title1">In Response to <span class="sub_title3">'<?php  echo $row['title']?>'</span></td>
											</tr>
											<tr><td><hr /></td></tr>
											<?php 
											$result=$this->blog->get_blog_comments($postid);
											while($row=$this->db->fetch_array($result)){                                      
											?>
											<tr>
												<td class="comment_title"><?php echo ucwords($row['name'])?>&nbsp;Says</td>
											</tr>
											<tr>
												<td class="dim_text">
												<?php 
												$date_parts=explode("-",$row['date']);
												echo date("F d, Y",mktime(0,0,0,$date_parts[1],$date_parts[2],$date_parts[0]));
												?>
												</td>
											</tr>
                                            <tr>
                                            	<td>&nbsp;</td>
                                            </tr>
											<tr class="border">
												<td class="comment_text"><?php  echo $row['comments']?></td>
											</tr>
											<tr><td><hr /></td></tr>
											<?php  
											}?>
										</table>
									</td>
								</tr>                          
								<tr>
									<td style="padding-top:7px;">
										<form action="" method="post" name="form1" onsubmit="return validate()">
										<input type="hidden" name="command" />
										<input type="hidden" name="postid" value="<?php  echo $postid?>" />
										<table border="0px" cellpadding="1px" cellspacing="0px" width="90%" align="center">
											<tr>
												<td class="comment_title">Leave a Reply</td>
											</tr>
											<tr>
												<td><input type="text" name="name" value="<?php  echo $name?>"  style="height:13px;"/> <span class="dim_text">Name</span></td>
											</tr>
											<tr>
												<td><input type="text" name="email" value="<?php  echo $email?>" style="height:13px;"/> <span class="dim_text">Email</span></td>
											</tr>
											<tr>
												<td><input type="text" name="web" value="<?php  echo $web?>" style="height:13px;"/> <span class="dim_text">Web URL</span></td>
											</tr>
											<tr>
												<td class="comment_title">Comments</td>
											</tr>
											<tr>
												<td><textarea name="comments" cols="50" rows="8"></textarea></td>
											</tr>
											<tr>
												<td><input type="submit" value="Post Comment" style="height:20px; font-size:10px; width:100px;" /></td>
											</tr>                                      
										</table>
										</form>
									</td>
								</tr>
							</table>
						</div>
				   </div> 
				</td>
			</table>
		  </div>
     <?php		
	}
}
$bf=new blog_functions($db,$blog,$m);
?>