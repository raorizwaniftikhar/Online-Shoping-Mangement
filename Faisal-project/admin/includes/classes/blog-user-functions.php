<?php
class blog_functions
{
	var $db;
	var $blog;
	var $width;
	var $title_color;
	var $bg_color;
	var $link_color;

	function __construct($db,$blog){
		$this->db = $db;
		$this->blog=$blog;
	}		
	function bog_properties($width,$title_color,$bg_color,$link_color){
		$this->width=$width;
		$this->title_color=$title_color;
		$this->bg_color=$bg_color;
		$this->link_color=$link_color;		
	}
	function render_js_add_post(){
	?>
    	<script type="text/javascript" src="admin/jscripts/tiny_mce/tiny_mce.js"></script>
		<script type="text/javascript" src="admin/jscripts/tiny_mce/js_tinymce.js"></script>
		<script language="javascript">
			function validate_add(){
				with(document.form1){
					if(title.value==''){
						alert('Please Enter Title of New Post!');
						title.focus();
						return false;
					}else if(sub_title.value==''){
						alert('Please Enter Sub-Title Title of New Post!');
						sub_title.focus();
						return false;
					}else{
						command.value='addPost';
						return true;
					}
				}
			}
		</script>
    <?php
	}		
	function render_js_edit_post(){
	?>
    	<script type="text/javascript" src="admin/jscripts/tiny_mce/tiny_mce.js"></script>
		<script type="text/javascript" src="admin/jscripts/tiny_mce/js_tinymce.js"></script>
        <script language="javascript">
			function validate_edit(){
				with(document.form1){
					if(title.value==''){
						alert('Please Enter Title of New Post!');
						title.focus();
						return false;
					}else if(sub_title.value==''){
						alert('Please Enter Sub-Title Title of New Post!');
						sub_title.focus();
						return false;
					}else{
						command.value='editPost';
						return true;
					}
				}
			}
		</script>
	<?php
	}
	function render_js_for_add_cats(){
	?>	
		<script language="javascript">
			function editCat(id,previousName){
				var catId=id;
				with(document.form2){
					var newCatName=prompt('Please Enter New Name For Category',previousName);
					name.value=newCatName;
					serial.value=catId;
					command.value='editCat';
					if(newCatName!=null){
						if(newCatName=='')
							alert('Name of Category is Required Field!');
						else if(newCatName!=previousName){
							submit();
						}
					}
				}
			}
			function deleteCat(id){
				var catid=id;
				with(document.form2){
					if(confirm('By Deleting This all related subcategories and postes Will also deleted')){
						serial.value=catid;
						command.value='deleteCat';
						submit();
					}
				}
			}
			function editSubcat(id,previousName){
				var catId=id;
				with(document.form2){
					var newSubCatName=prompt('Please Enter New Name For Subcategory',previousName);
					name.value=newSubCatName;
					serial.value=catId;
					command.value='editSubCat';
					if(newSubCatName!=null){
						if(newSubCatName=='')
							alert('Name of Category is Required Field!');
						else if(newSubCatName!=previousName){
							submit();
						}
					}
				}
			}
			function deleteSubcat(id){
				var subcatid=id;
				with(document.form2){
					if(confirm('By Deleting This all related postes Will also deleted')){
						serial.value=subcatid;
						command.value='deleteSubCat';
						submit();
					}
				}
			}			
			function validate(){
				with(document.form1){
					if(catName.value==''){
						alert('Please Enter New Category Name');
						catName.focus();
						return false;
					}else if(parentCat.value!=''){
						command.value='addSubCat';
						return true;
					}else{
						command.value='addCat';
						return true;
					}
				}
			}
		</script>
    <?php
	}
	function render_js_for_dashboard(){
	?>
		<script language="javascript">
			function deletePost(id){
				if(confirm('Are You Sure! Do You Want to Delete This Post?')){
					document.form1.command.value='deletePost';
					document.form1.serial.value=id;
					document.form1.submit();
				}
			}
			function viewPost(id){
				document.form1.command.value='viewPost';
				document.form1.serial.value=id;
				document.form1.submit();
			}
			function editPost(id){
				document.form1.command.value='editPost';
				document.form1.serial.value=id;
				document.form1.submit();
			}
			function checkAll(){
				with(document.form1){
					if(posts[0]==undefined){
						posts.checked=true;
					}else{
						for(i=0;i<posts.length;i++){
							posts[i].checked=true;
						}
					}
				}
			}
			function uncheckAll(){
				with(document.form1){
					if(posts[0]==undefined){
						posts.checked=false;
					}else{
						for(i=0;i<posts.length;i++){
							posts[i].checked=false;
						}
					}
				}
			}
			
			function checkSelected(){
				var selected=false;
				with(document.form1){
					if(posts[0]==undefined){
						if(posts.checked==true)
							selected=true;
					}else{
						for(i=0;i<posts.length;i++){
							if(posts[i].checked==true){
								selected=true;
								break;
							}
						}
					}
				}
				return selected;
			}
			
			function deleteSelected(){
				var selectedPosts='';
				with(document.form1){
					if(withSelected.value=='delete'){
						if(checkSelected()){
							if(confirm('Are You Sure! Do You Want to Delete Selected Posts?')){
								if(posts[0]==undefined){
									selectedPosts=posts.value;
								}else{
									for(i=0;i<posts.length;i++){
										if(posts[i].checked==true){
											if(selectedPosts=='')
												selectedPosts=posts[i].value;
											else
												selectedPosts=selectedPosts+","+posts[i].value;
										}
									}
								}
								serial.value=selectedPosts;
								command.value='deletePosts';
								submit();
							}
						}else{
							alert('Please Select Atleast One Post');
						}
					}
				}
			}
		</script>
    <?php			
	}
	function render_js_for_check_comments(){
	?>
    <script type="text/javascript" src="js/jquery-1.4.2.js"></script>
	<script language="javascript">
    function checkAll(){
        with(document.form1){
            if(comments[0]==undefined){
                comments.checked=true;
            }else{
                for(i=0;i<comments.length;i++){
                    comments[i].checked=true;
                }
            }
        }
    }
    function uncheckAll(){
        with(document.form1){
            if(comments[0]==undefined){
                comments.checked=false;
            }else{
                for(i=0;i<comments.length;i++){
                    comments[i].checked=false;
                }
            }
        }
    }
    
    function checkSelected(){
        var selected=false;
        with(document.form1){
            if(comments[0]==undefined){
                if(comments.checked==true)
                    selected=true;
            }else{
                for(i=0;i<comments.length;i++){
                    if(comments[i].checked==true){
                        selected=true;
                        break;
                    }
                }
            }
        }
        return selected;
    }
    
    function apply(){
        var selectedPosts='';
        with(document.form1){
            if(withSelected.value!=''){
                if(checkSelected()){
                    if(confirm('Are You Sure! Do You Want to Apply Selected Operation?')){
                        if(comments[0]==undefined){
                            if(comments.checked == true){
                                selectedPosts=comments.value;
                            }
                        }else{
                            for(i=0;i<comments.length;i++){
                                if(comments[i].checked == true){
                                    if(selectedPosts=='')
                                        selectedPosts=comments[i].value;
                                    else
                                        selectedPosts=selectedPosts+","+comments[i].value;
                                }
                            }
                        }
                        serial.value=selectedPosts;
                        submit();
                    }
                }else{
                    alert('Please Select Atleast One Post');
                }
            }
        }
    }
    function forAll(){
        if(document.form1.allChkBoxs.checked==true)
            checkAll();
        else
            uncheckAll();
    }
    </script>    
    <?php
	}
	function render_css(){
	?>
        <style>
			.blog_width{
				margin:0;
				padding:0;
				width:<?php echo $this->width;?>px;
				font-family:Arial, Helvetica, sans-serif;
			}
			.page_title{
				background-color:<?php echo $this->title_color;?>;
				color:#444444;
			}
			.comment_title{
				background-color:<?php echo $this->title_color;?>;
				color:#444444;
			}
			.heading{
				color:#444444;
				padding:8px;
				float:left;
				font-weight:bold;
				font-size:28px;
			}
			.back_btn{
				float:right;
				padding:10px;
			}
			.b_button{
				font-size:13px; 
			}
			.add_area{
				background-color:<?php echo $this->bg_color;?>;
				border:1px solid #CCC;	
				padding:0px 10px 10px 10px;
				font-size:13px; 
				font-weight:bold;
			}
			.alert_msg{
				border-bottom:dashed 1px #F00; 
				border-top:dashed 1px #F00; 
				color:#F00; 
			}
			#editor{
				width:99%;
				height:350px;
			}
			.border{
				height:18px;
				width:99%;
				border:1px solid #CCC;
			}
			.save_btn{
				padding:5px; 
				width:70px;
			}
			.category{
				width:181px;
				padding-top:30px;
			}
			.cat_head{
				padding:2px 9px; 
				background-color:#F2F2F2; 
				color:#444444;
			}
			.add_cat_link{
				
			}
			.add_cat_link a{
				color: #069; 
				text-decoration:none; 
				font-weight: bold
			}
			.alert_msg{
				height:20px;
			}
			.full_post{				
				width:99%;
				border:1px solid #CCC;
				background-color:#FFF;
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
	function render_add_blog($page_title,$title,$subtitle,$fulltext,$serial,$msg)
	{		
	?>
    <div class="blog_width">
    		<table cellpadding="0" cellspacing="0" width="100%">
            	<td  valign="top" id="register_section">
                	<div class="page_title">
                    	<div class="heading"><?php echo $page_title;?></div>
                        <div class="back_btn">
                        	<input type="button" onclick="javascript:window.location='add-edit-blog.php'" value="&lt;&lt;Back" class="b_button" />
                        </div>
                        <div class="clear"></div>
                    </div>                
                    <div class="add_area">
                        <form name="form1" action="" method="post" onsubmit="return validate_add()">
                        <input type="hidden" name="command" />
                        <table border="0px" cellpadding="3px" cellspacing="0px" width="100%">
                            <?php if($msg!=""){?>
                            <tr>
                                <td align="center" valign="middle" colspan="2" class="alert_msg"><?php $msg?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td>
                                    <table border="0px" cellpadding="3px" cellspacing="0px" width="100%">
                                        <tr><td>Title:</td></tr>
                                        <tr><td><input type="text" name="title" value="<?php echo $title ?>" class="border" /></td></tr>
                                        <tr><td>Sub Title:</td></tr>
                                        <tr><td><input type="text" name="sub_title" value="<?php echo $subtitle?>" class="border"/></td></tr>
                                        <tr><td>Content Area:</td></tr>
                                        <tr><td><textarea name="fulltext" class="mceEditor" id="editor"><?php echo $fulltext?></textarea></td></tr>
                                        <tr><td><input type="submit" value="Save" class="save_btn" /></td></tr>
                                    </table>
                                </td>
                                <td valign="top" align="right" class="category">
                                    <table border="0px" cellpadding="0px" cellspacing="0px" width="100%">
                                        <tr><td class="cat_head" align="left">Categories</td></tr>
                                        <tr>
                                            <td style="padding-top:2px;">
                                                <table border="0px" cellpadding="2px" cellspacing="0px" width="100%" class="border">
                                                    <?php
                                                    $result=$this->blog->get_blog_categories_by_serial($serial);										
                                                    while($row=$this->db->fetch_array($result)){						
                                                    ?>											
                                                        <tr>
                                                            <td align="left">
                                                                <input type="checkbox" name="cat[]" value="<?php echo $row['serial']?>" /> <?php echo $row['name']?>
                                                            </td>
                                                        </tr>
                                                        <?php											
                                                        $result1=$this->blog->get_blog_category_by_catid($row['serial']);
                                                        while($row1=$this->db->fetch_array($result1)){
                                                        ?>
                                                        <tr>
                                                            <td align="left" style="padding-left:15px;">
                                                                <input type="checkbox" name="subcat[]" value="<?php echo $categoryid?>,<?php echo $row1['serial']?>" /><?php echo $row1['name']?> 
                                                            </td>
                                                        </tr>
                                                    <?php
                                                        }
                                                     } 
                                                    ?>
                                                    <tr><td align="left"><input type="checkbox" />Uncategorized</td></tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr><td class="add_cat_link"><a class="links" href="add-edit-blog.php?tab=add_category" style="">+&nbsp;Add New Category</a></td></tr>
                                    </table>
                                </td>
                            </tr>                           
                        </table>
                        </form>
                    </div>
                  </td>
                </table>
            </div>  
        <?php
	}
	function render_edit_blog($page_title,$postid,$msg)
	{		
	?>
        <div class="blog_width">
            <table cellpadding="0" cellspacing="0" width="100%">
                <td  valign="top" id="register_section">
                    <div class="page_title">
                        <div class="heading"><?php echo $page_title;?></div>
                        <div class="back_btn">
                            <input type="button" onclick="javascript:window.location='add-edit-blog.php'" value="&lt;&lt;Back" class="b_button" />
                        </div>
                        <div class="clear"></div>
                    </div>                
                    <div class="add_area">
                        <form name="form1" action="" method="post" onsubmit="return validate_edit()">
                        <input type="hidden" name="command" />
                        <table border="0px" cellpadding="3px" cellspacing="0px" width="100%">
                            <?php if($msg!=""){?>
                            <tr>
                                <td align="center" valign="middle" colspan="2" class="alert_msg"><?php $msg?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td>
                                    <?php
                                        $row=$this->blog->get_row_blogs_posts($postid);                                      
                                    ?>
                                    <table border="0px" cellpadding="3px" cellspacing="0px" width="100%">
                                        <tr><td>Title:</td></tr>
                                        <tr><td><input type="text" name="title" value="<?php echo $row['title'] ?>" class="border" /></td></tr>
                                        <tr><td>Sub Title:</td></tr>
                                        <tr><td><input type="text" name="sub_title" value="<?php echo $row['sub_title']?>" class="border"/></td></tr>
                                        <tr><td>Content Area:</td></tr>
                                        <tr><td><textarea name="fulltext" class="mceEditor" id="editor"><?php echo $row['fulltext']?></textarea></td></tr>
                                        <tr><td><input type="submit" value="Save" class="save_btn" /></td></tr>
                                    </table>
                                </td>                               
                            </tr>                           
                        </table>
                        </form>
                    </div>
                </td>
            </table>
        </div>  
        <?php
	}
	function render_blog_categories($page_title,$catName,$serial,$msg){
		?>
		<div class="blog_width">
        	<form name="form2" method="post" action="">
                <input type="hidden" name="command" />
                <input type="hidden" name="serial" />
                <input type="hidden" name="name" />
            </form> 
            <table cellpadding="0" cellspacing="0" width="100%">
                <td  valign="top" id="register_section">
                    <div class="page_title">
                        <div class="heading"><?php echo $page_title;?></div>
                        <div class="back_btn">
                            <input type="button" onclick="javascript:window.location='add-edit-blog.php'" value="&lt;&lt;Back" class="b_button" />
                        </div>
                        <div class="clear"></div>
                    </div>
                                    
                    <div class="add_area">
                    	<form name="form1" action="" method="post" onsubmit="return validate();">
                            <input type="hidden" name="command" />
                            <input type="hidden" name="serial" />
                        <table border="0px" cellpadding="3px" cellspacing="0px" width="50%">
                            <?php if($msg!=""){?>
                            <tr>
                                <td align="center" valign="middle" colspan="2" class="alert_msg"><?php echo $msg?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td>                                    
                                     <table border="0px" cellpadding="3px" cellspacing="0px" align="left" width="100%">
                                        <tr>
                                            <td>New Category Name&nbsp;:</td>
                                            <td><input type="text" name="catName" value="New Category Name" onfocus="javascript:if(this.value=='New Category Name') this.value='';" onblur="javascript:if(this.value=='') this.value='New Category Name';" /></td>
                                            <td align="right"><input type="submit" value="Add" style="width:70px;" /></td>
                                            <script language="javascript">
                                            <?php if($catName!=""){?>
                                            document.form1.catName.value='<?php echo $catName?>';
                                            <?php }?>
                                            </script>
                                        </tr>
                                        <tr>
                                            <td>Select Parent Category&nbsp;:</td>
                                            <td colspan="2">
                                            <select name="parentCat">
                                                <option selected="selected" value="">-Parent Category-</option>
                                                <?php                                                
                                                $result=$this->blog->get_blog_categories_by_serial($serial);
                                                while($row=$this->db->fetch_array($result)){
                                                ?>
                                                <option value="<?php echo $row['serial']?>"><?php echo $row['name']?></option>
                                                <?php }?>
                                            </select>
                                            <script language="javascript">
                                            document.form1.parentCat.value='<?php $_REQUEST['parentCat']?>';
                                            </script>
                                            </td>
                                        </tr>
                                    </table>
                                </td>                               
                            </tr>
                            <tr>
                                <td>
                                    <table border="0px" cellpadding="2px" cellspacing="0px" width="100%">
                                    <tr><td>&nbsp;</td></tr>
                                      <?php
                                      $result=$this->blog->get_blog_categories_by_serial($serial);
                                      while($row=$this->db->fetch_array($result)){
                                      ?>
                                          <tr>
                                          	<td align="left" valign="middle" bgcolor="#666666" style="color:#FFF; padding:2px; padding:1px 6px; font-size:13px;">
                                            	<div style="float:left">
													<?php echo ucwords($row['name'])?>
                                                </div>
                                                <div style="float:right">
                                              		<!--<a class="links" href="#" onclick="editCat('<?php echo $row['serial']?>','<?php echo $row['name']?>')" style="color:#FFF;">-->
                                                    	<a onmouseover="alert('Warning! You are not Authorize to Change Categories.')">Edit</a>
                                                    <!--</a>--> 
                                                    | 
                                                    <!--<a class="links" href="#" onclick="deleteCat('<?php echo $row['serial']?>')" style="color:#FFF;">-->
                                                    	<a onmouseover="alert('Warning! You are not Authorize to Change Categories.')">Delete</a>
                                                    <!--</a>-->
                                                </div>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td style="padding-left:15px; background-color:#FFF; border:1px solid #CCC; ">
                                                <table border="0px" cellpadding="3px" cellspacing="0px" width="100%">
                                                  <?php
                                                  $categoryid=$row['serial'];                                                  
                                                  $result1=$this->blog->get_blog_category_by_catid($categoryid);
                                                  while($row1=$this->db->fetch_array($result1)){
                                                  ?>
                                                  <tr style="font-size:14px;"><td align="left"  ><?php echo $row1['name']?></td>
                                                  	<td align="right" style="font-size:13px;" >
                                                  		<!--<a class="links" href="#" onclick="editSubcat('<?php echo $row1['serial']?>','<?php echo $row1['name']?>')">-->
	                                                    	Edit
    	                                                <!--</a> -->
                                                        | 
        	                                            <!--<a class="links" href="#" onclick="deleteSubcat('<?php echo $row1['serial']?>')">-->
		                                                    Delete
	                                                    <!--</a>-->
    	                                            </td>
                                                  </tr>
                                                  <?php }?>
                                                </table>
                                            </td>
                                          </tr>
                                      <?php } ?>
                                      <tr><td align="left" valign="middle" bgcolor="#666666" style="color:#FFF; padding:2px; padding-left:5px; font-size:13px;">Uncategorized</td></tr>
                                  </table>
                                </td>
                            </tr>                           
                        </table>
                        </form>
                    </div>
                </td>
            </table>
        </div>
     <?php
	}
	function render_fullpost($postid,$msg){
	?>
		<div class="blog_width">
        	<?php		
			$row=$this->blog->get_row_blogs_posts($postid);
			?>
            <table cellpadding="0" cellspacing="0" width="100%">
                <td  valign="top" id="register_section">
                    <div class="page_title">
                        <div class="heading"><?php echo ucwords($row['title'])?></div>
                        <div class="back_btn">
                            <input type="button" onclick="javascript:window.location='add-edit-blog.php'" value="&lt;&lt;Back" class="b_button" />
                        </div>
                        <div class="clear"></div>
                    </div>                
                    <div class="add_area">
                        <form name="form1" action="" method="post" onsubmit="return validate_edit()">
                        <input type="hidden" name="command" />
                        <table border="0px" cellpadding="3px" cellspacing="0px" width="100%">
                            <?php if($msg!=""){?>
                            <tr>
                                <td align="center" valign="middle" colspan="2" class="alert_msg"><?php $msg?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                            	<td>
                                	<span style="font-size:14px; color:#C66; font-family:Arial, Helvetica, sans-serif;"><?php echo ucwords($row['sub_title'])?></span><br />
                                </td>
                            </tr>
                            <tr>
                                <td class="full_post">                                    
                                   <table border="0px" cellpadding="4px" cellspacing="0px" width="100%">
										<?php if($msg!=""){?>
                                        <tr>
                                            <td style="font-family:Verdana, Geneva, sans-serif; font-size:13px; color:#F00;"><?php echo $msg?></td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td><span style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#999; font-style:italic;">
                                             <?php
                                                $date_parts=explode("-",$row['date']);
                                                echo date("F d, Y",mktime(0,0,0,$date_parts[1],$date_parts[2],$date_parts[0]));
                                            ?>
                                            </span></td>
                                        </tr>
                                        <tr><td style="font-size:6px;">&nbsp;</td></tr>
                                        <tr><td><?php echo $row['fulltext'];?></td></tr>
                                    </table>
                                </td>                               
                            </tr>                           
                        </table>
                        </form>
                    </div>
                </td>
            </table>
        </div>	
    <?php
	}
	function render_dashboard($page_title,$pageno,$totalPages,$msg,$blog_id,$start,$recordPerPage){
	?>
		<div class="blog_width">        	
            <table cellpadding="0" cellspacing="0" width="100%">
                <td  valign="top" id="register_section">
                    <div class="page_title">
                        <div class="heading"><?php echo $page_title?></div>
                        <div class="back_btn">                           
                            <input type="button" onclick="javascript:window.location='add-edit-blog.php?tab=add_post'" value="+&nbsp;New Post" class="b_button" />
                        </div>
                        <div class="back_btn">                           
							<input type="button" onclick="javascript:window.location='add-edit-blog.php?tab=check_comments'" value="Comments" class="b_button" />
                        </div>
                        <div class="clear"></div>
                    </div>                
                    <div class="add_area">
                        <form action="" method="post" name="form1">
                        <input type="hidden" name="command" />
                        <input type="hidden" name="serial" />
                        <table border="0px" cellpadding="3px" cellspacing="0px" width="100%">
                            <?php if($msg!=""){?>
                            <tr>
                                <td align="center" valign="middle" colspan="2" class="alert_msg"><?php $msg?></td>
                            </tr>
                            <?php } ?>
                            <tr>
								<td align="right">
                                    <div style="float:left">
                                        <span style="font-size:13px;">With Selected:</span>&nbsp;
                                        <select name="withSelected">
                                            <option selected="selected" value="">--Select--</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                        <input type="submit" value="Apply" onclick="javascript:deleteSelected()"  align="absmiddle"/>
                                    </div>
                                    <div style="float:right"><span style="font-size:13px;">Pages:</span>
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
                                            ?>&nbsp;<a href="?page=<?php echo $i?>"><?php echo $i?></a>&nbsp;<?php
                                        }
                                    }
                                    ?>
                                    </div>
                                </td>                            
                            </tr>
                            <tr>
                                <td><span onclick="checkAll()" style="cursor:pointer; font-size:12px; color:#D52C19;">Check All</span> <span style="font-size:12px;">/</span> <span onclick="uncheckAll()" style="cursor:pointer; font-size:12px; color:#D52C19;">Uncheck All</span></td>
                            </tr>
                            <?php
                            $i=0;
                            $result=$this->blog->get_blogs_posts_pagewise($blog_id,$start,$recordPerPage);
                            while($row=$this->db->fetch_array($result)){
                                $i=1;
                            ?>
                            <tr>
                                <td>
                                    <table border="0px" cellpadding="3px" cellspacing="0px" width="100%">
                                        <tr>
                                            <td><input type="checkbox" name="posts" value="<?php echo $row['serial']?>" />&nbsp;&nbsp;<span style="font-size:18px;"><?php echo ucwords($row['title'])?></span><br />
                                            <span style="font-size:14px; margin-left:30px; color:#C66; font-family:Arial, Helvetica, sans-serif;"><?php echo ucwords($row['sub_title'])?></span><br />
                                            <span style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#999; padding-top:5px; font-style:italic; padding-left:30px;">
                                            <?php
                                                $date_parts=explode("-",$row['date']);
                                                echo date("F d, Y",mktime(0,0,0,$date_parts[1],$date_parts[2],$date_parts[0]));
                                            ?>
                                            </span></td>
                                        </tr>
                                        <tr>
                                            <td class="full_post" style="padding-left:10px; color:#666; font-weight:normal;"><?php echo substr($row['fulltext'],0,380);?></td>
                                        </tr>                                        
                                        <tr>
                                            <td style="padding:10px 0px 15px 50px;"><a href="#" class="links" onclick="editPost('<?php echo $row['serial']?>')">Edit</a> <span  class="links">|</span> <a href="#" class="links" onclick="deletePost('<?php echo $row['serial']?>')">Delete</a> <span class="links">|</span> <a href="#" class="links" onclick="viewPost('<?php echo $row['serial']?>')">View</a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php }?>
                            <?php if($i==0){?>
                            <tr><td style="padding:3px;" align="center" valign="middle"><span style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#F00; font-weight:bold;">No Post Exist. Click <a class="links" href="add-edit-blog.php?tab=add_post">here</a> to create new post.</span><br /><br /><br /><br /></td></tr>
                            <?php }?>                           
                        </table>
                        </form>
                    </div>
                </td>
            </table>
        </div>                    
     <?php
	}
	function render_check_comments($page_title,$msg,$pageno,$totalPages,$postSerials,$disapproved,$approved){
	?>
    <div class="blog_width">        	
            <table cellpadding="0" cellspacing="0" width="100%">
                <td  valign="top" id="register_section">
                    <div class="page_title">
                        <div class="heading"><?php echo $page_title?></div>
                        <div class="back_btn">
                            <input type="button" onclick="javascript:window.location='add-edit-blog.php'" value="&lt;&lt;Back" class="b_button" />
                        </div>
                        <div class="clear"></div>
                    </div>                
                    <div class="add_area">
                        <form action="" method="post" name="form1">
                            <input type="hidden" name="command" />
                            <input type="hidden" name="serial" />
                        <table border="0px" cellpadding="3px" cellspacing="0px" width="100%">
                            <?php if($msg!=""){?>
                            <tr>
                                <td align="center" valign="middle" colspan="4" class="alert_msg"><?php echo $msg?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="3" align="left" valign="middle" style="padding-bottom:10px;"><span style="font-size:13px;">Filter:&nbsp;</span><a class="links" href="?tab=check_comments&all=1">All</a> | <a class="links" href="?tab=check_comments&approved=1">Approved</a> | <a class="links" href="?tab=check_comments&disapproved=1">Unapproved</a></td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                <div style="float:left">
                                <span style="font-size:13px;">With Selected:</span>&nbsp;
                                <select name="withSelected">
                                    <option selected="selected" value="">--Select--</option>
                                    <option value="approve">Approve</option>
                                    <option value="unapprove">Unapprove</option>
                                    <option value="delete">Delete</option>
                                </select>
                                <input type="submit" value="Apply" onclick="javascript:apply()" align="absmiddle" />
                                </div>
                                <div style="float:right"><span style="font-size:13px;">Pages:</span>
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
                                        ?>&nbsp;<a href="?tab=check_comments&page=<?php echo $i?>"><?php echo $i?></a>&nbsp;<?php
                                    }
                                }
                                ?>
                                </div>
                                </td>
                            </tr>                            
                            <tr class="comment_title">
                                <td align="center" valign="middle" width="3%"><input type="checkbox" name="allChkBoxs" onclick="javascript:forAll()" /></td>
                                <td align="left" valign="middle" width="17%"><span class="labels">Author</span></td>
                                <td align="center" valign="middle" width="60%"><span class="labels">Comments</span></td>
                                <td align="left" valign="middle" width="20%"><span class="labels">In Response To</span></td>
                            </tr>
                            <tr><td colspan="4"><hr size="1" /></td></tr>
                            <?php
                            //$blog_id = $blog_row['serial'];
                            if($disapproved=="1")
                                $query=$this->blog->get_query_disapprove_comments($postSerials);
                            else if($approved=="1")
                                $query=$this->blog->get_query_approve_comments($postSerials);
                            else
                                $query=$this->blog->get_query_comments($postSerials);
                            $i=0;
                            $result=$this->db->query($query);
                            while($row=$this->db->fetch_array($result)){
                                if($i++%2==0)
                                    $color="#FFFFFF";
                                else
                                    $color="#E5E5E5";
                            ?>
                            <tr bgcolor="<?php echo $color?>" >
                                <td align="left" valign="top"><input type="checkbox" name="comments" value="<?php echo $row['serial']?>" /></td>
                                <td align="left" valign="top">
                                    <table border="0px" cellpadding="0px" cellspacing="0px" width="100%">
                                        <tr>
                                            <td><span style="font-size:12px; font-weight:bold;"><?php echo ucwords($row['name'])?>&nbsp;Says</span></td>
                                        </tr>
                                        <tr>
                                            <td><span style="font-size:11px; color:#999; font-style:italic; font-weight:normal;">&nbsp;
                                            <?php
                                            $date_parts=explode("-",$row['date']);
                                            echo date("F d, Y",mktime(0,0,0,$date_parts[1],$date_parts[2],$date_parts[0]));
                                            ?>
                                            </span></td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="padding-left:15px;" align="left" valign="middle"><span style="font-size:12px; font-weight:normal;"><?php echo $row['comments']?></span></td>
                                <td align="left" valign="top" style="padding-left:5px;"><span style="font-size:12px; font-weight:bold;"><?php echo $this->blog->get_post_title($row['postid'])?></span></td>
                            </tr>                          
                            <tr>
                                <td colspan="4" align="left" valign="middle" style="padding-left:30px; padding-top:10px;"><?php if($row['locked']=="yes"){?><a class="links" href="?tab=check_comments&approve=<?php echo $row['serial']?>">Approve</a><?php }else{?><a class="links" href="?tab=check_comments&disapprove=<?php echo $row['serial']?>">Unapprove</a><?php }?> <span  class="links">|</span> <a class="links" href="?tab=check_comments&delete=<?php echo $row['serial']?>">Delete</a></td>
                            </tr>
                            <tr><td colspan="4"><hr size="1" /></td></tr>
                            <?php }?>
                            <?php if($i==0){?>
                            <tr><td colspan="4" align="center" valign="middle" style="padding:3px;"><span style="color:#F00;">No Comment Found</span></td></tr>
                            <tr><td colspan="4"><hr size="1" /></td></tr>
                            <?php }?>                                               
                        </table>
                        </form>
                    </div>
                </td>
            </table>
        </div>    
    <?php
	}

}
$bf=new blog_functions($db,$blog);
?>