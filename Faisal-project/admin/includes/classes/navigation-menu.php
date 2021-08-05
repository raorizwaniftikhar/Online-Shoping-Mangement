<?php
	class sub_menu{
		var $name;
		var $link;
		var $sub_menu;
		var $sub_menu_links;
		function __construct($name,$link){
			$this->name=$name;
			$this->link=$link;
			$this->sub_menu_links=array();
			$this->sub_menu=array();
		}
		function add($name,$link){
			$this->sub_menu[]=$name;
			$this->sub_menu_links[]=$link;
		}
	}
	# -------------------------------------------------------------------------
	class main_menu{
		private $menu_items;
		function __construct(){
			$this->menu_items=array();
		}
		function add_sub_menu($sub_menu){
			$this->menu_items[]=$sub_menu;
		}
		function render_main_menu($section){
?>
            <ul>
            <?php
				foreach($this->menu_items as $items){
					if($section==$items->name){
			?>
                <li><b><span><?php echo $items->name; ?></span></b></li>
<?php
					}else{
?>						
                <li><a href="<?php echo $items->link; ?>"><span><?php echo $items->name; ?></span></a></li>
            <?php
					}
				}
			?>
            </ul>
<?php
		}
		function render_sub_menu($section){
			foreach($this->menu_items as $items){
				if ($items->name==$section){
					$count=0;
					$page_name=basename($_SERVER['SCRIPT_FILENAME']);
					foreach($items->sub_menu as $sub){
?>
                    <ul>
                        <?php if ($page_name==$items->sub_menu_links[$count]){ ?><li><span><a href="<?php echo $items->sub_menu_links[$count]; ?>" style="background-color:#A5A5A5;"><?php echo $sub; ?></a></span></li><?php } else { ?>
                        <li><span><a href="<?php echo $items->sub_menu_links[$count]; ?>"><?php echo $sub; ?></a></span></li><?php } ?>
                    </ul>
<?php			
						$count++;
					}
					break;
				}
			}
		}
	}
	
	$menu=new main_menu();
	$type = $_SESSION['type'];

	if($type=='Admin')
	{
	
	$prod=new sub_menu("Products","products.php");
	$prod->add("Categories","categories.php");
	$prod->add("Products","products.php");
	$menu->add_sub_menu($prod);
	
	
	$usr=new sub_menu("Users","users.php");
	$usr->add("User","users.php");
	$menu->add_sub_menu($usr);
	
	$pref=new sub_menu("Preferences","slider-images.php");
	
	$pref->add("Slider Images","slider-images.php");
	$pref->add("Change Password","change-password.php");
	
	$menu->add_sub_menu($pref);
	
	$blogs=new sub_menu("Orders","orders.php");
	$blogs->add("Orders","orders.php");
	
	$menu->add_sub_menu($blogs);
	}
	
	else if($type =='Sales manager')
	{
			
		$prod=new sub_menu("Products","products.php");
	$prod->add("Categories","categories.php");
	$prod->add("Products","products.php");
	$menu->add_sub_menu($prod);
		}
	
			else if($type =='Accounts manager')
	{
			
		$blogs=new sub_menu("Orders","orders.php");
	$blogs->add("Orders","orders.php");
	
	$menu->add_sub_menu($blogs);
		}
else if($type =='Purchase manager')
	{
			$prod=new sub_menu("Products","products.php");
	$prod->add("Categories","categories.php");
	$prod->add("Products","products.php");
	$menu->add_sub_menu($prod);
		$blogs=new sub_menu("Orders","orders.php");
	$blogs->add("Orders","orders.php");
	
	$menu->add_sub_menu($blogs);
		}
?>