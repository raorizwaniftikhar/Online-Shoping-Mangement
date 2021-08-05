<div class="panel" >
    <div class="containers" >
        <div class="wt-rotator" >
            <div class="screen" ></div>
            <div class="c-panel" >
                <div class="thumbnails">
                    <ul>
                     <?php
                                    $res=$db->query("select * from slider_images ");
                                    $i=0;
                                    while ($pic_row=$db->fetch_assoc($res)){
                                        $i++;
                                ?>

                        <li>
   						    <a href="slider-images/thumb-<?php echo $pic_row['name']; ?>"><img src="slider-images/thumb-<?php echo $pic_row['name']; ?>" alt="" title=""/></a>

                            <div style="left:6px; top:6px; width:950px; color:#F00; background-color:#FFF">
                                <h3 style="color:#0CF"><?php echo $pic_row['title']; ?></h3>
                                <?php echo $pic_row['description']; ?>
                            </div>  
                        </li>
                        <?php } ?>
                    </ul>
                </div>  
                <div class="buttons">
                    <div class="prev-btn"></div>
                    <div class="play-btn"></div>    
                    <div class="next-btn"></div>               
                </div>
            </div>
        </div>	
    </div>
</div>