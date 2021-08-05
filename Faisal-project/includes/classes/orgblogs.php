<?php
	class Blogs extends Database{
		private $image_allowed_extensions=array('jpg','jpeg','png','gif','x-png','JPG','JPEG','GIF','X-PNG');
		private $thumb_path;
		function __construct(){
			parent::__construct();
			$this->table='blog_categories';
			$this->thumb_path=SITE_PATH.'/site-content/blog-pics/';
			$this->i=1;
		}
		function get_categories($parent_id=0){
			$result=mysql_query("select * from blog_categories where parent_id=$parent_id");
			if(mysql_num_rows($result)==0) return;
			while($row=mysql_fetch_array($result)){
				$this->tree_html.="<tr class=\"alt\"><td align=\"center\"> $this->i</td><td id=\"left\">{$row['name']}</td><td align=\"center\"><a href=\"#\" onclick=\"del({$row['id']});\">Delete</a> | <a href=\"./blog-categories.php?command=edit&id={$row['id']}\">Edit</a></td>";
				$this->i++;
				$this->get_categories($row['id']);
			}
			return $this->tree_html;
		}
		function get_user_categories($parent_id=0){
			$result=mysql_query("select * from blog_categories where parent_id=$parent_id");
			if(mysql_num_rows($result)==0) return;
			$this->tree_html.="<ul class=\"menulink\">\r\n";
			if ($parent_id==0)
				$this->tree_html.="<li><a href=\"./blogs.php?cat_id=0\">All Categories</a>\r\n";
			while($row=mysql_fetch_array($result)){
				$this->tree_html.="\r\n<li><a href=\"./blogs.php?cat_id={$row['id']}\">{$row['name']}</a>";
				$this->get_user_categories($row['id']);
				$this->tree_html.="</li>";
			}
			$this->tree_html.="\r\n</ul>";
			return $this->tree_html;
		}
		function get_post_pic($post_id){
			$row=$this->fetch_array_by_query("select picture from blog_posts where id=$post_id");
			if ($row['picture']!='')
				return $row['picture'];
			else
				return '../images/no-image.jpg';
		}
		function get_options($parent_id=0,&$indent=''){
	
			$result=mysql_query("select * from blog_categories where parent_id=$parent_id");
			if(mysql_num_rows($result)==0){
				return;
			}
			if($parent_id!=0) $indent=$this->get_spaces($indent,10);
			while($row=mysql_fetch_array($result)){
				$this->options_html.="<option value=\"{$row['id']}\">{$indent}{$row['name']}</option>\r\n";
				$this->get_options($row['id'],$indent);
			}
			$indent=$this->get_spaces($indent,-10);
			return $this->options_html;
		}
		private function get_spaces($spaces='',$x=0){
			if($x>=0){
				for($i=1;$i<=$x;$i++)
					$spaces.='-';
			}
			else{
				$x=abs($x);
				$l=strlen($spaces);
				$spaces=substr($spaces,0,$l-$x);
			}
			return $spaces;
		}
		function make_query($category_id=0,$member_id=0,$start=0,$limit=0,$user_type='admin'){
			$web_id=WEBID;
			$where="where 1";
			if ($member_id>0)			$where.=" and blog_posts.member_id=$id";
			if ($category_id>0)			$where.=" and blog_posts.category_id=$category_id";
			if ($user_type=='user')		$where.=" and blog_posts.status='published'";
			$query="select blog_posts.*,(select count(*) from blog_comments) as comments from blog_posts Left join blog_comments ON blog_comments.post_id=blog_posts.id $where group by blog_posts.id order by blog_posts.id desc";
			if ($limit>0)
				$query.=" limit $start,$limit";
			return $this->query($query);
		}
		function fetch_blog_posts($category_id=0,$member_id=0,$start=0,$limit=0,$user_type='admin'){
			$web_id=WEBID;
			$where="where 1";
			if ($member_id>0)			$where.=" and blog_posts.member_id=$id";
			if ($category_id>0)			$where.=" and blog_posts.category_id=$category_id";
			if ($user_type=='user')		$where.=" and blog_posts.status='published'";
			$query="select blog_posts.*,(select count(*) from blog_comments) as comments from blog_posts Left join blog_comments ON blog_comments.post_id=blog_posts.id $where group by blog_posts.id order by blog_posts.id desc";
			if ($limit>0)
				$query.=" limit $start,$limit";
			$result=$this->query($query);
			$blogs=array();
			while ($row=$this->fetch_assoc($result)){
				$blogs[]=$row;
			}
			return $blogs;
		}

		function fetch_post_comments($post_id){
			$query="select * from blog_comments where post_id=$post_id";
			$result=$this->query($query);
			$comments=array();
			while ($row=$this->fetch_assoc($result)){
				$comments[]=$row;
			}
			return $comments;
		}
		function fetch_all_comments($start,$limit){
			$query="select * from blog_comments order by id desc limit $start,$limit";
			$result=$this->query($query);
			$comments=array();
			while ($row=$this->fetch_assoc($result)){
				$comments[]=$row;
			}
			return $comments;
		}
		function get_popular_posts(){
			$web_id=WEBID;
			$result=$this->query("select * from blog_posts where status='published'  order by views desc limit 0,5");
			$posts=array();
			while ($row=$this->fetch_assoc($result)){
				$posts[]=$row;
			}
			//print_r($posts);
			return $posts;
		}
		function upload_image($thumb){
			$path_info = pathinfo($thumb['name']);
			if (in_array(strtolower($path_info['extension']),$this->image_allowed_extensions)){
				$new_file_name=time().'.'.$path_info['extension'];
				move_uploaded_file($thumb['tmp_name'],$this->thumb_path.$new_file_name);
				return $new_file_name;
			}
			else{
				die("This image format is not supported in our system");
			}
		}
		function add_view($post_id){
			return $this->query("update blog_posts set views=views+1 where id=$post_id");
		}
		function del_image($image){
			if ($image!='no-image.jpg')
				@unlink($this->thumb_path.$image);
		}
		function get_thumb_path(){
			return $this->thumb_path;
		}
		function get_row($id,$table_name=''){
			$query="select * from blog_posts where id=$id ";
			$row=$this->fetch_array_by_query($query);
			return $row;
		}
		function get_category($id){
			$query="select * from blog_categories where id=$id ";
			$row=$this->fetch_array_by_query($query);
			return $row;
		}
		function delete_post($id){
			$result=$this->delete($id,'blog_posts');
			if($result){
				$res=$this->query("delete from blog_comments where post_id=".$id);
			}
			
		}
		function delete_category($id){
			$result=$this->delete($id);
			if($result){
				$post_id_result=$this->query("select distinct id from blog_posts where category_id=".$id);
				$ids=array();
				while($row_post_ids=$this->fetch_array($post_id_result)){
					$ids[]=$row_post_ids['id'];
				}
				if(count($ids) >0){
					$ids=implode(",",$ids);
				}
				$query="delete from blog_posts where category_id=".$id;
				$res=$this->query($query);
				if($res && count($ids) > 0){
					$query="delete from blog_comments where post_id in(".$ids.")";
					$res=$this->query($query);
				}
			}
		}
		function check_post_exit($id){
			$query="select * from blog_posts where id=$id";
			$result=$this->query($query);
			if($this->num_rows($result)){
				return true;
			}else{
				return false;
			}
		}
		
	}
	$blog=new Blogs();
?>