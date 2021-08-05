<?php
class messages{
	private $msg;
	private $type;		//can be error or success
	
	function __construct(){
		$this->type='success';
	}
	function render_html($type=''){
		if ($type=='error')		$this->type=$type;
		if ($type=='success')	$this->type=$type;
		if ($this->msg!=''){
?>
            <div style="background-color:<?php echo $this->get_background_color(); ?>; padding:5px; margin:2px;">
                <div style="float:left;"><img src="images/<?php echo $this->get_pic(); ?>" style="margin-top:0px;" /></div>
                <div style="color:<?php echo $this->get_text_color(); ?>; margin-left:10px; font-weight:bold; float:left"><?php echo $this->msg; ?></div>
                <div style="clear:both"></div>
            </div>
<?php
		}
	}
	function set_type($type){
		$this->type=$type;
	}
	function set_msg($msg,$type=''){
		$this->msg=$msg;
		$this->type=$type;
	}
	function get_pic(){
		if ($this->type=='error')
			return 'error.png';
		else
			return 'success.png';
	}
	function get_background_color(){
		if ($this->type=='error')
			return '#FAFAFA';
		else
			return '#FAFAFA';
	}
	function get_text_color(){
		if ($this->type=='error')
			return '#900';
		else
			return '#060';
	}
}
$msg=new messages();
?>