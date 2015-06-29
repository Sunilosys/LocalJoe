<div class='listing Active listing-class-placeholder'>
    <div class='description'> 
        <?php if (isset($image_url)) { ?>
            <div class='images'>
                <div class='current'><a href='<?php echo $details_url; ?>'><img src = '<?php echo $image_url; ?>' title='<?php echo $title; ?>'/></a></div>
            </div>
        <?php } ?>
        <h2 class='listing-title'><a href='<?php echo $details_url; ?>'><?php if ($emphasized_section != '') echo $emphasized_section; ?><span class="listing-post-title"><?php echo ' - ' . $title; ?><span></a></h2> 

                        <div class='post-info'>Posted <?php echo $posting_date; ?></div>	
                        <div class='copy'><p><?php echo $description; ?></p></div>	
                        <span style="display:none;" id="listing-title-<?php echo $posting_id; ?>"><?php echo $title; ?></span>
                        </div>
                        <div class='bottom-bar'>


                            <input type="hidden" value="<?php echo $lat; ?>" class="map-lat"></input>
                            <input type="hidden" value="<?php echo $lon; ?>" class="map-lon"></input> 
                            <input type="hidden" value="<?php echo $address; ?>" class="map-address"></input> 
                            <?php if (isset($address)) { ?>
                                <a class="map-icon"><span class="pophint">Map location</span></a>
                                <div class="address"><b>Approx Location:</b> <?php echo $address; ?></div> 
                            <?php } ?>
                        </div>
                        </div>