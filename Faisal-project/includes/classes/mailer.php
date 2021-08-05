<?php
	class Mailer{
		private $db;
		function __construct($db){
			$this->db=$db;
		}
		function send_mail($template_name,$email,$arr_vars){
			extract($arr_vars);
			$result=$this->db->query("select * from email_templates where name='$template_name'");
			$row=$this->db->fetch_array($result);
			if(!$row){
				die("Template not found : $template_name");
			}
			$from_name=$row['from_name'];	
			$from_email=$row['from_email'];	
			$subject=$row['subject'];
			$message=addslashes($row['message']);
			eval("\$body= \"$message\";");
			
			$header="From: $from_name <$from_email>\r\n";
			$header.="Content-type:text/html";
			
			//$ok=mail($email,$subject,$body,$header);
/*			if($ok){
				$t=time();
				$result=$this->db->query("insert into email_logs values ($t,'$email','$subject','$body')");
			}
*/		}
		function get_email_templates(){
			return $this->db->query("select * from email_templates order by id");	
		}
		function get_email_template_by_id($id){
			$result=$this->db->query("select * from email_templates where id=$id");
			return $this->db->fetch_assoc($result);	
		}
		function add_email_template(){
			if ($_REQUEST['action']=='add'){
				$name=$_POST['name'];
				$from_name=$_POST['from_name'];
				$from_email=$_POST['from_email'];
				$subject=$_POST['subject'];
				$message=$_POST['message'];
				 //$message=update_img_path($message);
				$result=$this->db->query("insert into email_templates (name,from_name,from_email,subject,message) values ('$name','$from_name','$from_email','$subject','$message')");	
				
				if ($result){
					header("Location: email-templates.php?msg=New Template Added Successfully");
					exit();	
				}
			}	
		}
		function edit_email_template($id){
			if ($_REQUEST['action']=='add'){
				$name=$_POST['name'];
				$from_name=$_POST['from_name'];
				$from_email=$_POST['from_email'];
				$subject=$_POST['subject'];
				$message=$_POST['message'];
				//$message=update_img_path($message);
				$result=$this->db->query("update email_templates set name='$name',from_name='$from_name',from_email='$from_email',subject='$subject',message='$message' where id=$id");	
				if ($result){
					header("Location: email-templates.php?msg=Template Updated Successfully");
					exit();	
				}					
			}	
		}
		function del_email_template(){
			if ($_REQUEST['command']=='del'){
				$id=$_REQUEST['id'];
				$result=$this->db->query("delete from email_templates where id=$id");
				if ($result){
					header("Location: email-templates.php?msg=Deleted Successfully");
					exit();	
				}
			}	
		}
		function header_include_textarea(){
	?>
			<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript">

		tinyMCE.init({
			mode : "textareas",
			elements : "content1",
			editor_selector : "mceEditor",
			editor_deselector : "mceNoEditor",
			theme : "advanced",
			plugins : "table,save,advhr,advimage,advlink,insertdatetime,preview,zoom,print,paste,directionality,fullscreen,noneditable,contextmenu",
			theme_advanced_buttons1_add_before : "save,newdocument,separator",
			theme_advanced_buttons1_add : "fontselect,fontsizeselect",
			theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor,liststyle",
			theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
			theme_advanced_buttons3_add_before : "tablecontrols,separator",
			theme_advanced_buttons3_add : "advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
			theme_advanced_toolbar_location : "bottom",
			theme_advanced_toolbar_align : "left",
			plugin_insertdate_dateFormat : "%Y-%m-%d",
			plugin_insertdate_timeFormat : "%H:%M:%S",
			extended_valid_elements : "hr[class|width|size|noshade]",
			file_browser_callback : "fileBrowserCallBack",
			paste_use_dialog : false,
			theme_advanced_resizing : true,
 	  	    relative_urls : false,
		remove_script_host : true,
	document_base_url : "http://www.linksrealestategroup.com//pageimages/Image/",
			theme_advanced_resize_horizontal : false,
			theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
			apply_source_formatting : true
		});
	
		function fileBrowserCallBack(field_name, url, type, win) {
			var connector = "../../filemanager/browser.html?Connector=connectors/php/connector.php";
			var enableAutoTypeSelection = true;
			var cType;
			tinyfck_field = field_name;
			tinyfck = win;
			switch (type) {
				case "image":
					cType = "Image";
					break;
				case "file":
					cType = "File";
					break;
			}
			if (enableAutoTypeSelection && cType) {
				connector += "&Type=" + cType;
			}
			window.open(connector, "tinyfck", "modal,width=600,height=400");
		}
	
		/*tinyMCE.init({
			mode : "textareas",
			theme : "simple",
			editor_selector : "mceEditor",
			editor_deselector : "mceNoEditor"
		});*/
		
		</script>
	
	<?php		
		}
		function header_functions(){
	?>
			<script language="javascript">
				function validate(){
					var f=document.mailForm;
					if(f.name.value==''){
						alert("Please enter the Name");
						f.name.focus();
						return false;
					}
					else if (f.from_name.value==''){
						alert("Please Enter From Name");
						f.from_name.focus();
						return false;	
					}
					else if (f.from_email.value==''){
						alert("Please Enter From Email");
						f.from_email.focus();
						return false;	
					}
					f.command.value='add';
					return true;
				}
				function del(ser){
					if (confirm("Are you sure to Delete?")){
						var f=document.delForm;
						f.id.value=ser;
						f.command.value='del';
						f.submit();
					}
					return false;	
				}
			</script>
	<?php		
		}
		
		function render_html($id=-1){
			if ($id!=-1){
				$row=$this->get_email_template_by_id($id);
				extract($row);
			}
	?>			
			<form name="mailForm" method="post" action="" onsubmit="return validate();">
             <input type="hidden" name="action" value="add" />
                <table>
                    <tr><td>Name: </td><td><input type="text" name="name" value="<?php echo $name; ?>" /></td></tr>
                    <tr><td>From Name: </td><td><input type="text" name="from_name" value="<?php echo $from_name; ?>" /></td></tr>
                    <tr><td>From Email: </td><td><input type="text" name="from_email" value="<?php echo $from_email; ?>" /></td></tr>
                    <tr><td>Subject: </td><td><input type="text" name="subject" value="<?php echo $subject; ?>" /></td></tr>
                    <tr><td>Message: </td><td><textarea class="mceEditor" name="message" style="width:600px;"><?php echo $message; ?></textarea></td></tr>
                    <tr><td></td><td><input type="submit" name="add" value="Submit" /></td></tr>
                </table>
            </form>
<?php			
		}
		function render_edit_html($id=-1){
			if ($id!=-1){
				$row=$this->get_email_template_by_id($id);
				extract($row);
			}
	?>			
			<form name="mailForm" method="post" action="" onsubmit="return validate();">
             <input type="hidden" name="action" value="add" />
             <input type="hidden" name="name" value="<?php echo $name; ?>" />
                <table>
                    <tr><td>Template Name: </td><td><b><?php echo $name; ?></b></td></tr>
                    <tr><td colspan="2">&nbsp;</td></tr>
                	<?php if($name!="Email Property"){?>
                    <tr><td>From Name: </td><td><input type="text" name="from_name" value="<?php echo $from_name; ?>" /></td></tr>
                    <tr><td>From Email: </td><td><input type="text" name="from_email" value="<?php echo $from_email; ?>" /></td></tr>
                    <?php }else{?>
                    <tr><td>From Name: </td><td><input type="text" name="from_name" value="Sender Name" readonly="readonly" /></td></tr>
                    <tr><td>From Email: </td><td><input type="text" name="from_email" value="Sender Email" readonly="readonly" /></td></tr>
                    <?php }?>
                    <tr><td>Subject: </td><td><input type="text" name="subject" value="<?php echo $subject; ?>" /></td></tr>
                    <tr><td>Message: </td><td><textarea id="editor_text" class="mceEditor" name="message" style="width:600px;"><?php echo $message; ?></textarea></td></tr>
                    <tr><td></td><td><input type="submit" name="add" value="Submit" /></td></tr>
                </table>
            </form>
<?php
		}
	function del_form_html(){
	?>
			<form name="delForm" action="" method="post">
				<input type="hidden" name="id" />
				<input type="hidden" name="command" />
			</form>
	<?php	
        }
	}
	$mail=new Mailer($db);
?>