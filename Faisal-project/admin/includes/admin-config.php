<?php
	$main_menu_tab="";
	
	$current_file=basename($_SERVER['SCRIPT_FILENAME']);

	$main_menu=array(
		array("Home","index.php"),
		array("Articles","view-articles.php","add-articles.php","edit-articles.php"),
		array("Videos","view-videos.php","upload-videos.php","edit-videos.php"),
		array("Events","view-event.php"),
		array("Ads","../adManagement/index.php"),
		array("Stats","#"),
		array("Customization","preferences.php","slide-photos.php","add-slide-photo.php","view-pics.php","upload-pics.php","pages.php","add-page.php","edit-page.php"),
		array("Miscellaneous","view-members.php","view-artists.php","member-detail.php","artist-detail.php")
	);
	
	$sub_menu=array(
		"Home"=>array(
			array("Link One","#"),
			array("Link Two","#"),
			array("Link Three","#")
		),
		"Customization"=>array(
			array("Preferences","preferences.php"),
			array("Web Pages","pages.php","add-page.php","edit-page.php"),
			array("Slide Photos","slide-photos.php","add-slide-photo.php"),
			array("Pictures","view-pics.php","upload-pics.php")
		),
		"Miscellaneous"=>array(
			array("Members","view-members.php","member-detail.php"),
			array("Artists","view-artists.php","artist-detail.php")		
		),
		"Articles"=>array(
		)
	);
	
	//The Following Code Generate Sub menu List of Articles
	$i=0;
	$query="select * from article_category";
	$result=mysql_query($query);

	while ($row=mysql_fetch_assoc($result))
	{
		$sub_menu['Articles'][$i][0]="$row[category_name]";
		$sub_menu['Articles'][$i][1]="view-articles.php?aid=$row[serial]";
		$sub_menu['Articles'][$i][2]="view-articles.php?aid=$row[serial]";
		$i++;
	}
	//The End of Article Sub menu List
?>