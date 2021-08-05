<!--Code For Error Message-->
<?php
    if($_REQUEST['msg']!="" and $msg=="")
        $msg=$_REQUEST['msg'];
    if($msg!=""){
        $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $pos=intval(strpos($url,"msg"));
        if(strpos($url,"&")){
            if($amp_pos=intval(strpos($url,"&",$pos))){
                $sub_str=substr($url,0,$pos).substr($url,$amp_pos+1);
            }else{
                $sub_str=substr($url,0,$pos-1);
            }
        }else if(strpos($url,"msg")){
            $sub_str=substr($url,0,$pos-1);
        }else{
            $sub_str=$url;
        }
?>
    <div class="yellow_bg_error"><?php echo $msg;?>
        <div style="font-size:11px; float:right" class="error">
            <a href="<?php echo $sub_str;?>">
                <img src="<?php echo BASE_URL;?>admin/images/err_msg_close.gif" border="0" />
            </a>
        </div>
    </div>
<?php }?>
<!--End Code For Error Message-->
