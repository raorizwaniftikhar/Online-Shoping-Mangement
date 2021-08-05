<?php
//include("class.upload-file.php");
class WebPages{
	var $db;
	var $upload;
	function __construct($db){
		$this->db=$db;
		//$this->upload=new fileUpload();
	}
	function get_pages(){
		return $this->db->query("select * from pages order by id");
	}
	function get_page_by_id($id){
		$result=$this->db->query("select * from pages where id=$id");
		return $this->db->fetch_assoc($result);	
	}
	function count_pages(){
		$res=$this->db->query("select * from pages");
		return $this->db->count_rows($res);
	}
	function add_page($fields_arr){
		$name=addslashes($fields_arr['name']);
		$title=addslashes($fields_arr['title']);
		$description=mysql_escape_string(addslashes($fields_arr['description']));
		$text=mysql_escape_string(addslashes($fields_arr['text']));
		$section=$fields_arr['section'];
		$locked='no';
		return $this->db->query("insert into pages values ('','$name','$title','$description','$text','$section','$locked')");
	}
	function edit_page($fields_arr,$id){
		$name=addslashes($fields_arr['name']);
		$title=addslashes($fields_arr['title']);
		$description=mysql_escape_string(addslashes($fields_arr['description']));
		$text=mysql_escape_string(addslashes($fields_arr['text']));
		$section=$fields_arr['section'];
		$locked=$fields_arr['locked'];
		$query="update pages set name='$name',title='$title',description='$description',text='$text',locked='$locked',section='$section' where id=$id";	
		return $this->db->query($query);	
	}
	function get_pages_by_section($section='both'){
		$row = $this->db->query("select id,name from pages where section='$section'");	
		return $row;
	}
	function del_page($id){
		return $this->db->query("delete from pages where id=$id");	
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
	
		
		function validate(){
			var f=document.frm1;
			if(f.name.value==''){
				alert("Page name is required");
				f.name.focus();
				return false;
			}
			else if(f.title.value==''){
				alert("Page title is required");
				f.title.focus();
				return false;
			}
			f.command.value='update';
			f.submit();
		}
	</script>

<?php		
	}
	function header_functions(){
?>
		<script language="javascript">
            function validate(){
                var f=document.frm1;
                if(f.title.value==''){
                    alert("Please enter the title");
                    f.title.focus();
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
	function render_page_html($id='-1'){
		if ($id!='-1'){
			$row=$this->get_page_by_id($id);
			extract($row);
		}
?>		
		<form name="frm1" method="post" action="" onSubmit="return validate()" enctype="multipart/form-data" >
            <table>
                <tr>
                    <td>Name: </td>
                    <td><input type="text" name="name" value="<?php echo $name; ?>" /></td>
                </tr>
                <tr>
                	<td>Title: </td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>
                <tr>
                	<td>Description: </td>
                    <td><textarea name="description" rows="5" cols="50"><?php echo $description; ?></textarea></td>
                </tr>
                <tr>
                	<td>Text: </td>
                	<td><textarea class="mceEditor" name="text" cols="50" style="width:650px;"><?php echo $text; ?></textarea></td>
                </tr>
               
                <tr>
                	<td>Section: </td>
                    <td>
                    	<select name="section">
                        	<option value="link">Header</option>
                            <option value="footer">Footer</option>
                            <!--<option value="link">Link</option>-->
                            <option value="both">Both</option>
                        </select>
                    </td>
                    <script language="javascript">
						document.frm1.section.value='<?php echo $section; ?>';
					</script>
                </tr>
                <?php
					if (!$locked)
						$locked='no';
				?>
                <tr>
                	<td>Locked: </td>
                    <td>
                    	<input type="radio" name="locked" value="yes">Yes
                        <input type="radio" name="locked" value="no">No
                    </td>
                    <script language="javascript">
						if ('<?php echo $locked; ?>'=='yes')
							document.frm1.locked[0].checked=true;
						else
							document.frm1.locked[1].checked=true;
					</script>
                </tr>
                <tr>
                	<td></td>
                    <td><input type="submit" name="sbtPage" value="Submit" ></td>
                </tr>
            </table>
        </form>
<?php            
	}
	function del_form(){
?>
		<form name="delForm" action="" method="post">
        	<input type="hidden" name="id" />
            <input type="hidden" name="command" />
        </form>
<?php	
	}
	function get_tab_content(){
		return $this->db->query("select * tab_pages pages");
	}
}

$web_page=new WebPages($db);
?>