<div class='listing' style="height:100px">
    <div class='description'> 

        <div class='images'>
            <div class='current'><a href='<?php echo $details_url; ?>'><img style="height:90px;width:90px" src = '<?php if (isset($this->profile_pic_url)) echo $this->profile_pic_url; else echo '/images/noprofile.gif'; ?>' title='<?php echo $first_name . ' ' . $last_name; ?>'/></a></div>
        </div>

        <h2 style="font-size:15px;font-weight:normal"><a href='<?php echo $details_url; ?>'><span><?php echo $title; ?><span></a></h2> 

                        <div class='post-info'>Logged in <?php echo $last_login_date; ?></div>	


                        </div>

                        </div>