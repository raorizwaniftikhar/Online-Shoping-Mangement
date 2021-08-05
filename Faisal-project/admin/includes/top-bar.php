<div style="background-color:#dadada;border-bottom:solid 1px #BBB; text-align:right; padding:3px">
	<?php if ($go_back_link=='yes'){ ?>
		<div style="float:left">
    	<ul id="barLinks">
        	<li><a href="#" onclick="history.go(-1);">Back</a></li>
        </ul>
        <div style="clear:both"></div>
    </div>
	<?php } ?>
    <div style="float:right; padding:3px">Logged in as <?php echo $_SESSION['type']; ?>
    <a href="logout.php">Logout</a></div>
    <div style="clear:both"></div>
</div>