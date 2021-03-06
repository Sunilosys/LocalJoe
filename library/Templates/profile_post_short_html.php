
<div class='listing <?php echo $posting_status; ?>'>
    <div class='description'>
        <?php if (isset($image_url)) { ?>
            <div class='images'>
                <div class='current'><img src = '<?php echo $image_url; ?>'/></div>
            </div>
        <?php } ?>
        <h2 class='listing-title'><a href='<?php echo $details_url; ?>'><?php if ($emphasized_section != '') echo $emphasized_section . ' - '; ?><?php echo $title; ?></a></h2>  
<!--h2 class='listing-title'><a href='<?php echo $details_url; ?>'><?php echo $title; ?></a> - <?php echo $emphasized_section; ?></h2-->  
        <div class='post-info'>Posted <?php echo $posting_date; ?></div>	
        <div class='copy'><p><?php echo $description; ?></p></div>
        <div id="postStats_<?php echo $posting_id; ?>" style="width: 535px; left:160px;display:none;"></div>
        <span style="display:none;" id="listing-title-<?php echo $posting_id; ?>"><?php echo $title; ?></span>
    </div>
    <div class='bottom-bar'>
        <div class='status'>
            <span class='status-tag'><?php echo $posting_status; ?></span>
            <span class="expires"><?php echo $expiresIn; ?></span>
           
        </div> <!-- .status -->
        <div class='post-buttons'>
             <a class='button-stats button secondary small' id="stats_<?php echo $posting_id; ?>">Show Stats</a>
            <?php if (strtolower($posting_status) == "created") { ?>             

                <a class='delete secondary button small' id="delete_<?php echo $posting_id; ?>">Delete</a>
                <a href="#page=editpost&postingId=<?php echo $posting_id; ?>" id="edit_<?php echo $posting_id; ?>" class='editpost secondary button small'>Edit</a>
            <?php } else if (strtolower($posting_status) == "active") { ?>             

                <a class='delete secondary button small' id="delete_<?php echo $posting_id; ?>">Delete</a>
                <a class='repost button secondary small' id="repost_<?php echo $posting_id; ?>">Repost</a> 
                <a href="#page=editpost&postingId=<?php echo $posting_id; ?>" id="edit_<?php echo $posting_id; ?>" class='editpost secondary button small'>Edit</a>
            <?php } else if (strtolower($posting_status) == "expired") { ?>
                <a class='delete secondary button small' id="delete_<?php echo $posting_id; ?>">Delete</a>
                <a class='repost button secondary small' id="repost_<?php echo $posting_id; ?>">Repost</a>
               <a href="#page=editpost&postingId=<?php echo $posting_id; ?>" class='editpost secondary button small'>Edit</a>

            <?php } else if (strtolower($posting_status) == "deleted") { ?>
                <a class='delete secondary button small' style="display:none" id="delete_<?php echo $posting_id; ?>">Delete</a>
                <a class='repost button secondary small' id="repost_<?php echo $posting_id; ?>">Repost</a> 

                <a href="#page=editpost&postingId=<?php echo $posting_id; ?>" class='editpost secondary button small' id="edit_<?php echo $posting_id; ?>" >Edit</a>

            <?php } ?>
        </div>
        <input type="hidden" value="<?php echo $lat; ?>" class="map-lat"></input>
        <input type="hidden" value="<?php echo $lon; ?>" class="map-lon"></input> 
        <input type="hidden" value="<?php echo $address; ?>" class="map-address"></input> 
        <?php if (isset($address)) { ?>
            <a class="map-icon" title="Click to locate address"> </a>
            <div class="address" style="width:245px"><b>Approx Location:</b> <?php echo $address; ?></div> 

        <?php } ?>
    </div><!--bottom-bar-->
</div>