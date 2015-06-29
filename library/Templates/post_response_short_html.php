
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
       
        <span style="display:none;" id="listing-title-<?php echo $posting_id; ?>"><?php echo $title; ?></span>
    </div>
    <div class='bottom-bar post-responses'>
        
        <div style="padding-bottom:5px;"><img style="height:15px;width:15px" src="/images/icon-email.png"></img><span style="font-weight:bold;vertical-align:top"> Replied <?php echo $response_date; ?></span></div>
       <div><p><span style="font-weight:bold">Subject </span><?php echo $subject; ?></p></div>
       <div><p><span style="font-weight:bold">Message </span></p></div>
        <div><p><?php echo $message; ?></p></div>
    </div><!--bottom-bar-->
</div>