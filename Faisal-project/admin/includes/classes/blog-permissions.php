<?php
class blog_permissions{
	var $db;
	
	function __construct($db){
		$this->db=$db;
	}
	function insert_update_blog_permission($blog){		
		if(count($blog)){
			foreach ($blog as $userid=>$value){				
				$count=$this->db->count_rows_by_query("select * from blogs where userid=$userid");
				if($count==0){	
					$this->db->query("insert into blogs (userid,locked) values ($userid,'no')");
				}else{				
					$this->db->query("update blogs set locked='no' where userid=$userid");
				}
			}
			$cols='';
			
			$cols=implode(",",array_keys($blog));
			
			if($cols!=''){
				$this->db->query("update blogs set locked='yes' where userid NOT IN ($cols)");		
			}
		}else{
			$this->db->query("update blogs set locked='yes'");		
		}
		return 'Permission Updated';
	}
}	$bp= new blog_permissions($db);
?>