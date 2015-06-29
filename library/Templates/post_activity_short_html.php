
<div style="margin-bottom:20px" class='listing <?php echo $posting_status; ?>'>
    <div class="activity-heading">
     

<!--        <img class="banner-edge" src="/images/banner-edge.png"></img>-->


        <?php if ($action_id == 2) { ?>
            <div class="banner" ><?php echo $action_date; ?><div style="float:right">You shared a posting through Email.</div></div>
        <?php } else if ($action_id == 3) { ?>
            <div class="banner"><?php echo $action_date; ?><div style="float:right">You marked a posting as a Spam.</div></div>
        <?php } else if ($action_id == 4) { ?>
            <div class="banner"><?php echo $action_date; ?><div style="float:right">You shared a posting through Facebook.</div></div>
        <?php } else if ($action_id == 5) { ?>
            <div class="banner"><?php echo $action_date; ?><div style="float:right">You shared a posting through Twitter.</div></div>
        <?php } else if ($action_id == 6) { ?>
            <div class="banner"><?php echo $action_date; ?><div style="float:right">You responded to a posting.</div></div>
        <?php } else if ($action_id == 7) { ?>
            <div class="banner"><?php echo $action_date; ?><div style="float:right">You created a posting.</div></div>
        <?php } else if ($action_id == 8) { ?>
            <div class="banner"><?php echo $action_date; ?><div style="float:right">You edited a posting.</div></div>
        <?php } else if ($action_id == 9) { ?>
            <div class="banner"><?php echo $action_date; ?><div style="float:right">You reposted a posting.</div></div>
        <?php } else if ($action_id == 10) { ?>
            <div class="banner"><?php echo $action_date; ?><div style="float:right">You deleted a posting.</div></div>
        <?php } else if ($action_id == 11) { ?>
            <div class="banner"><?php echo $action_date; ?><div style="float:right">You added a posting to Favorites List.</div></div>
        <?php } else if ($action_id == 12) { ?>
            <div class="banner"><?php echo $action_date; ?><div style="float:right">You removed a posting from Favorites List.</div></div>
        <?php } ?>



    </div>
    <div class='description' style="padding-top:10px">
        <?php if (isset($image_url)) { ?>
            <div class='images'>
                <div class='current'><img src = '<?php echo $image_url; ?>'/></div>
            </div>
        <?php } ?>
        <h2 class='listing-title'><a href='<?php echo $details_url; ?>'><?php if ($emphasized_section != '') echo $emphasized_section . ' - '; ?><?php echo $title; ?></a> <div class="editTimeline" style="float:right;display:none"><a id="edittimeline_<?php echo $posting_view_id; ?>" class="edit"  title="Remove from Timeline"><img src="/images/trash.png" style="height:14px;width:14px"></img></a></div>
        </h2>  
        <!--h2 class='listing-title'><a href='<?php echo $details_url; ?>'><?php echo $title; ?></a> - <?php echo $emphasized_section; ?></h2-->  
        <div class='post-info'>Posted <?php echo $posting_date; ?></div>	
        <div class='copy'><p><?php echo $description; ?></p></div>

        <span style="display:none;" id="listing-title-<?php echo $posting_id; ?>"><?php echo $title; ?></span>
    </div>

</div>
