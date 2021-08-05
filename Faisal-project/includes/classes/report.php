<?php
	class Report{
		
		var $report_name='';
		var $columns=array();
		var $links=array();
		var $tables;
		var $conditions;
		var $report_width=950;
		var $char_limit=20;
		var $script_name;
		
		var $detail_page;
		var $detail_id='id';
		
		var $primary_column;
		var $highlight_color='#ffffcc';	# color names in lowercase, otherwise its not gonna work in FF
		var $selected_color='#99ccff';
		var $start;
		var $end;
		var $page;
		var $results_per_page;
		var $total_pages;
		var $total_results;
		var $orderfield = '';
		var $order = '';
		var $msg='';
		var $debugging=0;

		function __construct($report_name){
			$this->report_name=$report_name;
			$this->script_name=basename($_SERVER['SCRIPT_FILENAME']);
		}
		function enable_debugging($b){
			$this->debugging=$b;
		}
		function add_column($db_field,$title,$width=0,$align='left',$callback='',$primary='no'){
			$this->columns[]=array('name'=>$db_field,'title'=>$title,'width'=>$width,'align'=>$align,'callback'=>$callback,'primary'=>$primary);
		}
		function add_links($script_name,$param_name,$link_title,$db_column,$command=''){
			$this->links[]=array('type'=>'normal','script_name'=>$script_name,'param_name'=>$param_name,'link_title'=>$link_title,'db_column'=>$db_column,'command'=>$command);
		}
		function add_jslink($function_name,$link_title,$db_column,$alert=''){
			$this->links[]=array('type'=>'javascript','script_name'=>$function_name,'link_title'=>$link_title,'db_column'=>$db_column,'alert'=>$alert);		
		}
		function add_tables($tables){
			$this->tables=$tables;
		}
		function set_detail_link($name,$id='id'){
			$this->detail_page=$name;
			$this->detail_id=$id;
		}
		function set_order_by($orderfields,$orders){
			$this->orderfield=$orderfields;
			$this->order = $orders;
		}
		function add_conditions($conditions){
			$this->conditions=$conditions;
		}
		function set_char_limit($x){
			if($x>10){
				$this->char_limit=$x;
			}
		}
		function get_char_limit(){
			return $this->char_limit;
		}
		function get_primaray_column(){
			$total_columns=count($this->columns);
			for($i=0;$i<$total_columns;$i++){
				if($this->columns[$i]['primary']=='yes'){
					$name=$this->columns[$i]['name'];
					break;
				}
			}
			return $name;
		}
		function get_query(){
			if($this->conditions=='') $this->conditions="1";
			$query="select ";
			foreach($this->columns as $key=>$value){
				if($value['title']=='') $value['title']=$value['name'];
				if($query=='select ')
					$query.=$value['name']." as '".$value['title']."'";
				else
					$query.=",".$value['name']." as '".$value['title']."'";
			}
			if($this->tables=='') die("Report Error:No tables added!");
			
			$query.=" from ".$this->tables." where ".$this->conditions;
			if($_REQUEST['command']=='filter' && $_REQUEST['filter_by']!='' && $_REQUEST['filter_text']!=''){
				if($_REQUEST['strict']=='yes'){
					$query.=" and ".stripslashes($_REQUEST['filter_by'])."='".stripslashes($_REQUEST['filter_text']."'");
				}
				else{
					$query.=" and ".stripslashes($_REQUEST['filter_by'])." like '%".stripslashes($_REQUEST['filter_text'])."%'";
				}
			}
			if($_REQUEST['command']=='sort' && $_REQUEST['sort_by']!='' ){
				if($_REQUEST['sort_order']!='desc') $_REQUEST['sort_order']='';
				$query.=" order by ".stripslashes($_REQUEST['sort_by'])." ".$_REQUEST['sort_order'];
			}else if($this->orderfield !="" and $this->order !=""){
				$query.=" order by ".stripslashes($this->orderfield)." ".$this->order;
			}
			
			
			if($this->debugging){echo "<!--".$query. " -->"; }

			$this->results_per_page=intval($_REQUEST['results_per_page']);
			if($this->results_per_page<10) $this->results_per_page=20;

			$result=mysql_query($query);
			if(!$result) die(mysql_error()."<br>".$query);
			$this->total_results=mysql_num_rows($result);
			$this->total_pages=ceil($this->total_results/$this->results_per_page);

			
			$this->page=intval($_REQUEST['page_no']);
			$page_var=$this->report_name."_page";			
			
			if($this->page <1 ){
				$this->page=$_SESSION[$page_var]<1 ? 1 : $_SESSION[$page_var];
			}
			$_SESSION[$page_var]=$this->page;
			if($this->total_pages > 0)
				if($this->page > $this->total_pages) $this->page=$this->total_pages;
			
			$this->start=($this->page-1)*$this->results_per_page;
			
			$query.=" limit {$this->start},{$this->results_per_page}";
			
			return $query;
		}
		function set_message($msg){
			$this->msg=$msg;
		}
		function set_report_width($width){
			$this->report_width = $width;
		}
		function render_css(){
?>
<style>
#reportContainer{
	width:<?php echo $this->report_width;?>px;
}
.tableHead{
	background:#c0c0c0;
	font-family:Verdana, Geneva, sans-serif;
	font-size:12px;
	font-weight:bold;
}
.small_txt{
	font-size:11px;
	font-family:Verdana, Geneva, sans-serif;
	color:#666;
}
.cell{
	border-left:1px solid #fff;
	border-right:solid 1px #999;
	padding:3px;
	color:#333;
}
.inputBox{
	font-size:11px;
	font-family:Tahoma, Geneva, sans-serif;
	padding:2px;
	background:#eaeaea;
	font-weight:bold;
	border:inset 1px #ccc;
}
.columnHeading{
	font-family:Tahoma, Geneva, sans-serif;
	font-size:11px;
	color:#000;
}
.page{
	display:block;
	float:left;
	padding:3px 2px 3px 2px;
	border:solid 1px #333;
	color:#000;
	background-color:#FFF;
	margin-left:3px;
	text-decoration:none;
}
.page:hover{
	border:solid 1px #666;
	color:#666;
	text-decoration:underline;
}

.this_page{
	display:block;
	float:left;
	padding:3px 3px 3px 3px;
	border:solid 1px #aaa;
	color:#aaa;
	background-color:#FFF;
	margin-left:3px;
	text-decoration:none;
}
.report_msg{
	color:#F00;
	font-size:12px;
	font-family:Verdana, Geneva, sans-serif;
}
</style>
<?php
		}
		function render_javascript(){
?>
<script language="javascript">
	function sort_column(col_name,order){
		var f=document.frmReport;
		f.sort_by.value=col_name;
		f.sort_order.value=order;	// asc or desc
		f.command.value='sort';
		f.submit();
		return false;
	}
	function filter_column(col_name,text){
		var f=document.frmReport;
		f.filter_by.value=col_name;
		f.filter_text.value=text;
		f.command.value='filter';
		f.submit();
		return false;
	}
	function set_color(id,color){
		var f=document.frmReport;
		if(f.row_tracking.checked){
			if(id.bgColor!='<?php echo $this->selected_color?>'){
				id.bgColor=color;
			}
		}
	}
	function toggle_color(id,original,highlight){
		id.bgColor=id.bgColor==highlight ?  original : highlight;
	}
	function show_print(){
		var w= window.open("", "PrintPreview", "scrollbars,resizable,width=900,height=600");
		w.document.write('<div style="padding:10px 0px 10px 0px; float:left"><span style="font-size:24px"><?php echo ucfirst($this->report_name); ?></span> - <?php echo date('d-M-Y h:i A')?></div>');
		w.document.write('<div style="padding:10px 0px 10px 0px; float:right"><input type="button" value="Print" onClick="this.style.display=\'none\';window.print();"></div>');
		w.document.write('<br style="clear:both" />');
		w.document.write('<?php $this->get_print_html();?>');
	}
</script>
<?php
		}
		function render_html(){
			$query=$this->get_query();
			$result=mysql_query($query) or die (mysql_error().$query);
			if(!$result){
				echo(mysql_error());
				return;
			}
?>
		<form name="frmReport" method="post">
    	<input type="hidden" name="sort_by" value="<?php echo stripslashes($_REQUEST['sort_by'])?>" />
    	<input type="hidden" name="sort_order" value="<?php echo stripslashes($_REQUEST['sort_order'])?>" />
    	<input type="hidden" name="filter_by" value="<?php echo stripslashes($_REQUEST['filter_by'])?>" />
    	<input type="hidden" name="filter_text" value="<?php echo stripslashes($_REQUEST['filter_text'])?>" />
        <input type="hidden" name="command" value="<?php echo stripslashes($_REQUEST['command'])?>" />
		<div id="reportContainer">
            <div style="clear:both"></div>
            <div style="background:#e0e0e0; padding:3px; border-bottom:solid 1px #FFF;" class="small_txt">
            	<table width="100%">
                	<tr>
                    	<td>
            	&nbsp;Page:<input type="text" name="page_no" size="3" maxlength="4" class="small_txt" value="<?php echo $this->page?>" />
                	<select name="results_per_page" class="small_txt">
                    	<option value="10">10</option>
                    	<option value="20">20</option>
                    	<option value="50">50</option>
                    	<option value="100">100</option>
                    </select> /Page
                    <script language="javascript">
						document.frmReport.results_per_page.value=<?php echo $this->results_per_page?>;
					</script>
                    <input type="button" value="Go" class="small_txt" onClick="document.frmReport.submit()" />
                    <?php
						$to=$this->start+$this->results_per_page;
						if($to>$this->total_results){
							$to=$this->total_results;
						}
					?>
                    Page <?php echo $this->page?> of <?php echo $this->total_pages?>, displaying results <?php echo $this->start+1?> to <?php echo $to?> of <?php echo $this->total_results?>
                    	</td>
                        <td align="right" style="padding-right:20px">
		            <?php if($this->msg!=''){ ?> <div class="report_msg"><?php echo $this->msg?></div> <?php } ?>
                    		<input type="button" value="Print" onClick="show_print()" />
						</td>
					</tr>
				</table>                    
            </div>
            <table cellspacing="0px" class="small_txt" style="border:solid 1px #CCC; border-top:none" width="100%">
                <tr class="tableHead">
                    <td class="cell">#</td>
                    <?php 
						$total_columns=mysql_num_fields($result);
						for($i=0;$i<$total_columns;$i++){
							$name=$this->columns[$i]['name'];
							$title=$this->columns[$i]['title'];
							if($title=='') continue;
							if(stripslashes($_REQUEST['filter_by'])==$name && $_REQUEST['filter_text']!=''){
								$title=$title."=[".$_REQUEST['filter_text']."]";
							}
							$w=intval($this->columns[$i]['width']);
							if($w>0)
								$width="width=\"".$w."\"";
							else
								$width="";
								
							$callback=$this->columns[$i]['callback'];
							if($callback!=''){
					?>
                    	  <td class="cell" <?php echo $width?>>
                            <table cellpadding="0" cellspacing="0">
                                <tr>
							<td align="center" class="columnHeading"><?php echo $title ?></td>
                            	</tr>
							</table>
							</td>
					<?php
							}else{
					?>
                    <td class="cell" <?php echo $width?>>
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td rowspan="2" style="padding-right:3px">
                    	<input type="text" name="<?php echo "col".$i?>" value="<?php echo $title?>" <?php if($w>0){ echo "style=\"width:{$w}px\""; } ?> class="inputBox" onFocus="if(this.value=='<?php echo $title?>'){this.value=''}" onBlur="this.value='<?php echo $title?>'" onKeyPress="if(event.keyCode==13){filter_column('<?php echo addslashes($name)?>',this.value);}" title="Type some text and press enter to filter data" />
					</td>
                    <td><a href="javascript:void()" title="Sort Ascending" onClick="return sort_column('<?php echo addslashes($name)?>','asc')"><img src="images/up.gif" border="0" alt="Sort Asc" /></a></td>
				</tr>
                <tr><td><a href="javascript:void()" title="Sort Descending" onClick="return sort_column('<?php echo addslashes($name)?>','desc')"><img src="images/down.gif" border="0" align="Sort Desc" /></a></td>
			</table>
                    </td>
					<?php
					 }	// if($callback!=''){
				}
			 ?>
					<td align="center" class="columnHeading">Options</td>
                </tr>
                <?php
					$i=1+$this->start;
					
					while($row=mysql_fetch_array($result)){
						$bgcolor= $i%2==1 ? '#ffffff' : '#eeeeee';
				?>
                		<tr bgcolor="<?php echo $bgcolor?>" onMouseOver="set_color(this,'<?php echo $this->highlight_color?>')" onMouseOut="set_color(this,'<?php echo $bgcolor?>')" onClick="toggle_color(this,'<?php echo $bgcolor?>','<?php echo $this->selected_color?>')">
                        	<td class="cell" align="center"><?php echo $i++?></td>
                            <?php
							$link_done=0;
							$key=$this->get_primaray_column();
							for($j=0;$j<$total_columns;$j++){
								$title=$this->columns[$j]['title'];
								if($title=='') continue;
								$callback=$this->columns[$j]['callback'];
								if($callback!=''){
									if(!function_exists($callback)){
										die("Function $callback doesn't exist!");
									}
									$text=call_user_func($callback,$row[$j]);
									if($text=='') $text='&nbsp;';
								}
								else
									$text=$row[$j]=='' ?  '&nbsp;' : $row[$j];
								$text_title = $text;
								if(strlen($text)>$this->char_limit)
									$text=substr($text,0,$this->char_limit-4)." ...";
									
								if($this->detail_page!='' && $key!='' && $link_done==0){
									$detailpage = $this->detail_page;
									$text='<a href="javascript:window_open('.$row[$key].')">'.$row[$j].'</a>';
									$link_done=1;
								}

																	
							?>
                        	<td class="cell" title="<?php echo $text_title; ?>" align="<?php echo $this->columns[$j]['align']?>"><?php echo $text?></td>
                            <?php } ?>
                        	<td class="cell" align="center">
                            	<?php
$separator_flag=0;
foreach($this->links as $index=>$columns){

	$type=$columns['type']=='' ? 'normal' : $columns['type'];
	$script_name=$columns['script_name']=='' ? $this->script_name : $columns['script_name'];
	$param_name=$columns['param_name'];
	$command=$columns['command'];
	$link_title=$columns['link_title'];
	$db_column=$columns['db_column'];
	$alert=$columns['alert'];

	if($separator_flag)
		echo " | ";
	$separator_flag=1;

	if($type=='normal'){
		if($command=='')
			echo '<a href="'.$script_name.'?'.$param_name.'='.$row[$db_column].'">'.$link_title.'</a>';
		else
			echo '<a href="'.$script_name.'?'.$param_name.'='.$row[$db_column].'&command='.$command.'">'.$link_title.'</a>';
	}
	else{
		$argu_arr=explode(",",$db_column);
		$argu_str='';
		foreach($argu_arr as $value){
			if($argu_str=='')
				$argu_str.=$row[$value];
			else
				$argu_str.=','.$row[$value];
		}
		if($alert)
			echo '<a href="javascript:'.$script_name.'(\''.$argu_str.'\')" onclick="return(confirm(\''.$alert.'\'))" >'.$link_title.'</a>';
		else{
			echo '<a href="javascript:'.$script_name.'(\''.$argu_str.'\')">'.$link_title.'</a>';
		}
	}
}

?>
                            </td>
                        </tr>
                <?php  } ?>
            </table>
            <div style="background:#e0e0e0; padding:3px; border-bottom:solid 1px #FFF" class="small_txt">
            	<table width="100%" border="0">
                	<tr>
                    	<td nowrap="nowrap">
			            	<input type="checkbox" name="strict" value="yes" <?php if($_REQUEST['strict']=='yes'){ echo "checked"; }?> /> Strict Search
			            	<input type="checkbox" name="row_tracking" value="yes" checked="checked" /> Row Tracking
						</td>
                        <td align="right">
                        	<table align="right" border="0">
                            	<tr>
                                	<td>Pages:</td>
                                    <td>
                        	<?php
								$grace=5;
								$range=$grace*2;
								$start  = ($this->page - $grace) > 0 ? ($this->page - $grace) : 1;
								$end=$start + $range;
								if($end > $this->total_pages){
									$end=$this->total_pages;
									$start= ($end - $range) > 0 ? ($end - $range) : 1;
								}
								if($start>1){
							?>
									<a href="javascript:void()" onClick="document.frmReport.page_no.value=1;document.frmReport.submit()" class="page">1</a><div style="float:left"> &nbsp; ... &nbsp;&nbsp; </div>
                            <?php
								}
								
								for($i=$start;$i<=$end;$i++){
									if($i==$this->page){
							?>
									<span class="this_page"><?php echo $i?></span>
                            <?php
									} else {
							?>
									<a href="javascript:void()" onClick="document.frmReport.page_no.value=<?php echo $i?>;document.frmReport.submit()" class="page"><?php echo $i?></a>
                            <?php
									}
								}
								if($end < $this->total_pages){
							?>
									<div style="float:left">&nbsp;&nbsp; ... &nbsp;</div> <a href="javascript:void()" onClick="document.frmReport.page_no.value=<?php echo $this->total_pages?>;document.frmReport.submit()" class="page"><?php echo $this->total_pages?></a>
                            <?php	} ?>
                            		</td>
								</tr>
							</table>
                        </td>
                        <td align="right" style="padding-right:10px" width="70px">
                        	<input type="button" value="Reset" onClick="window.location='<?php echo $this->script_name?>'" class="small_txt" />
						</td>
					</tr>
				</table>
            </div>            
		</div>
	</form>
<?php
		}
		
		function get_print_html(){
			$query=$this->get_query();
			$result=mysql_query($query);
			if(!$result){
				echo(mysql_error());
				return;
			}
?><html><head><style>body{font-family:Verdana, Geneva, sans-serif} .tableHead{background:#c0c0c0;font-family:Verdana, Geneva, sans-serif;font-size:12px;font-weight:bold;} .small_txt{font-size:11px;font-family:Verdana, Geneva, sans-serif;color:#666;} .cell{border-left:1px solid #fff; border-right:solid 1px #999; padding:3px;	color:#333;} .inputBox{font-size:11px; font-family:Tahoma, Geneva, sans-serif; padding:2px;	background:#eaeaea;font-weight:bold;border:inset 1px #ccc;} .columnHeading{font-family:Tahoma, Geneva, sans-serif;font-size:11px;	color:#000;}</style></head><body><table cellspacing="0px" class="small_txt" style="border:solid 1px #CCC; border-top:none"><tr class="tableHead"><td class="cell">#</td><?php 
$total_columns=mysql_num_fields($result);
for($i=0;$i<$total_columns;$i++){
$name=$this->columns[$i]['name'];
$title=$this->columns[$i]['title'];
if($title=='') continue;
?><td align="center" class="columnHeading"><?php echo $title?></td><?php } ?></tr><?php
$i=1+$this->start;
while($row=mysql_fetch_array($result)){
$bgcolor= $i%2==1 ? '#ffffff' : '#eeeeee';
?><tr bgcolor="<?php echo $bgcolor?>"><td class="cell" align="center"><?php echo $i++?></td><?php
for($j=0;$j<$total_columns;$j++){
$title=$this->columns[$j]['title'];
if($title=='') continue;
$callback=$this->columns[$j]['callback'];
if($callback!=''){
if(!function_exists($callback)){
die("Function $callback doesn't exist!");
}
$text=call_user_func($callback,$row[$j]);
if($text=='') $text='&nbsp;';
}
else
$text=$row[$j]=='' ?  '&nbsp;' : $row[$j];
?><td class="cell" align="<?php echo $this->columns[$j]['align']?>"><?php echo addslashes($text)?></td><?php } ?></tr><?php  } ?></table></body></html><?php
		}
	}
?>