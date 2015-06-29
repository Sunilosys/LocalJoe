<div class='listing Active listing-class-placeholder'>
    <div class='description'> 
        <?php if (isset($image_url)) { ?>
            <div class='images'>
                <div class='current'><a href='<?php echo $details_url; ?>'><img src = '<?php echo $image_url; ?>' title='<?php echo $title; ?>'/></a></div>
            </div>
        <?php } ?>
		<h2 class='listing-title'><a href='<?php echo $details_url; ?>'><?php if ($emphasized_section !='') echo $emphasized_section; ?><span class="listing-post-title"><?php echo ' - '.$title; ?><span></a></h2> 
        
        <div class='post-info'>Posted <?php echo $posting_date; ?></div>	
        <div class='copy'><p><?php echo $description; ?></p></div>	
		<span style="display:none;" id="listing-title-<?php echo $posting_id; ?>"><?php echo $title; ?></span>
    </div>
    <div class='bottom-bar'>
        
        <ul class='actions rate'>    
            <li><a id="spam_<?php echo $posting_id; ?>" class="spam-class-placeholder" title='Flag as Spam'></a><span class='pophint'>Flag as Spam</span></li> 

            <li><a onclick="return false;" id="favorite_<?php echo $posting_id; ?>" class="favorite-class-placeholder"><img src='/images//icon-favorite.png'/></a>
            
            </li>
        </ul>

        <ul class='actions share'>
            <li><a  id="fblink_<?php echo $posting_id; ?>" class="facebook"><img src="/images/icon-flag.png"><span class="pophint">Share</span></a></li>

            <li><a id="twitter_<?php echo $posting_id; ?>" class='twitter' href="<?php echo $twitter_share_link; ?>"></a>                           
                <span class='pophint'>Tweet</span></li>			
            <li><a id="email_<?php echo $posting_id; ?>" href='javascript:jsMailThisUrl("listing-title-<?php echo $posting_id; ?>","<?php echo $details_url; ?>");' class='email'><img src='/images//icon-twitter.png'/><span class='pophint'>Email</span></a></li>
        </ul>
        <input type="hidden" value="<?php echo $lat; ?>" class="map-lat"></input>
        <input type="hidden" value="<?php echo $lon; ?>" class="map-lon"></input> 
        <input type="hidden" value="<?php echo $address; ?>" class="map-address"></input> 
        <input id="favorite_list_<?php echo $posting_id; ?>" type="hidden" value="favorite-list-placeholder"></input>
        <?php if (isset($address)) { ?>
		<a class="map-icon"><span class="pophint">Map location</span></a>
        <div class="address"><b>Approx Location:</b> <?php echo $address; ?></div> 
        <?php } ?>
    </div>
</div>