<div class="post">
    <div class="box">
        <div id="breadcrumbs" class="header"><h2><ul>
                    <li><a href="/#page=home"></a></li>
                    <li><a class="breadcrumb-link" href="#" id="breadcrumbs_parentcategory_<?php echo $parent_category_id; ?>"><?php echo $parent_category_name; ?></a></li><li><a id="breadcrumbs_category_<?php echo $parent_category_id . '_'; ?><?php echo $category_id; ?>" href="#" class="breadcrumb-link"><?php echo $category_name; ?></a></li>     
                </ul></h2></div>

        <div class='listing' id="preview_post_listing">
            <h2 id="preview_post_title" class="listing-title"><a id="listing-title-link" style="display:none" href="/api/post/<?php echo $posting_id; ?>"><?php echo $title; ?></a>
                <span id="listing-title-span"><?php echo $title; ?></span></h2>
            <div class="post-info"><span>Posted <?php echo $posting_date; ?></span>
            </div> 			 					 
            <div class="data sidebar">
                <div style="margin-bottom:10px;overflow: hidden;">
                    <div  style="float: left; width: 50%;">
                        <?php echo $emphasized_section; ?>                       
                    </div>

                    <div style="float: right; width: 50%;">
                        <?php if ($posting_status_id != Application_Model_LjConstants::$POST_STATUS_ACTIVE_ID) { ?>
                        <div style="float:right" class='<?php echo $posting_status; ?>'>
                                <span class='status-tag'><?php echo $posting_status; ?></span>                                
                            </div>
                         <?php } else { if ($post_anonymously == 0) { ?>
                        <a id="send_response_<?php echo $posting_id; ?>" class="send-response"><span class="message">Email Poster</span></a>
<!--                        <script>
                            var phone = "<?= $phone; ?>";
                            if(phone != phoneformat){
                                document.write("<span class=\"phone\"><span class=\"icon\"></span><span id=\"<?php echo $phone; ?>\"><?php echo $phone; ?></span></span>");
                            }
                        </script>-->
                         <?php } else if ($post_anonymously == 1) {?>
                        <a id="send_response_<?php echo $posting_id; ?>" class="send-response"><span class="message">Email Poster</span></a>
                         <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="pod actions-wrap">

                    <span class="label">Spam:</span> 
                    <ul class='actions rate'>    
                        <li><a id="spam_<?php echo $posting_id; ?>" class="<?php if ($is_spam) echo 'spam selected'; else echo 'spam'; ?>" title='Flag as Spam'></a><span class='pophint'>Flag as Spam</span></li> 

                    </ul>
                    <!--ul class="actions rate">
                        <li><a href="#" class="spam"></a><span class="pophint">Flag as Spam</span></li>  
                    </ul>
                    <span class="label">Shortlist:</span>
                    <ul class="actions">
                        <li><a href="" class="favorite"><img src="/images/icon-twitter.png"></a>
                            <ul class="pophint menu">

                                <li class="title">Add to Shortlist</li>
                                <li><a href="#">Apartments in SJ</a></li>
                                <li><a href="#">Flatscreens</a></li>
                            </ul>
                        </li>
                    </ul><!-- .actions -->	
                    <span class="label rate">Save:</span>                     
                    <ul class='actions rate'>    
                         <li>
                             <a onclick="return false;" id="favorite_<?php echo $posting_id; ?>" class="<?php if ($is_favorite) echo 'favorite selected'; else echo 'favorite'; ?>"><img src='/images//icon-favorite.png'/></a>
                             [shortlisthtmlplaceholder]
                         </li>
                    </ul>
                    <span class="label share">Share:</span>
                    <ul class="actions share">
                        <li><a  id="fblink_<?php echo $posting_id; ?>"  class="facebook"><img src="/images/icon-flag.png"><span class="pophint">Share</span></a></li>                        
                        <li><a id="twitter_<?php echo $posting_id; ?>" class='twitter' href="<?php echo $twitter_share_link; ?>"></a>                                                  
                            <span class='pophint'>Tweet</span></li>
                        <li><a id="email_<?php echo $posting_id; ?>" href="javascript:jsMailThisUrl('preview_post_title');" class="email"><img src="/images/icon-twitter.png"><span class="pophint">Email</span></a></li>
                    </ul><!-- .actions -->
                    <input type="hidden" id="preview_posting_id" value="<?php echo $posting_id; ?>"></input>
                </div><!-- .actions-wrap -->

                <div class="pod seller metadata">
                    <h4 class="title">About this poster</h4>

                    <ul>
                         <?php if ($post_anonymously == 1) { ?>
                        <li><span class="label">Poster:</span><span class="item">Anonymous</span></li>                    
                       <?php } else { ?>
                        <li><span class="label">Poster:</span><span class="item"><a href="/#page=search&ref=sr_fs&categoryName=All Categories&refreshRefineSection=true&selectedFields=user_id_i:<?php echo $user_id; ?>" title="View this posters other items"><?php echo $poster_name; ?></a></span></li>                    
                        <?php } ?>
                        <?php if (isset($address)) { ?>
						<li><span class="label">Location:</span><span id="preview_location_address" class="item"><?php echo $address; ?></span></li>
						<?php } ?>
                    </ul>
                    <?php if (isset($address)) { ?>
					<div id="map_canvas" class="map">
                        <input type="hidden" value="<?php echo $lat; ?>" class="map-lat"></input>
                        <input type="hidden" value="<?php echo $lon; ?>" class="map-lon"></input> 
                        <input type="hidden" value="<?php echo $address; ?>" class="map-address"></input>  
                        <a id="map_link" class="map-icon"><img src="<?php echo $static_map_url; ?>" alt="<?php echo $address; ?>" border="0"/></a>
                    </div>
					<?php } ?>
                </div>                
                <?php if (!empty($category_attributes)) { ?>
                    <div class="metadata pod">			
                        <h4 class="title">Details</h4>                      
                        <ul id="preview_category_attributes">
                            <?php foreach ($category_attributes as $key => $value) { ?>
                                <li><span class="label"><?php echo $value['name'] . ':'; ?></span><span class="item"><?php echo preg_replace('/,(?! )/', ', ', $value['value']) . ' ' . $value['dimension']; ?></span></li>
                            <?php } ?>
                        </ul>
                    </div><!-- .metadata -->
                <?php } ?>
                <?php if ($tags !== "") { ?>
                    <div class="pod tags">
                        <h4 class="title">Tags</h4>
                        <ul id="preview_tags">
                            <?php
                            $string = $tags;

                            $tok = strtok($string, ",");

                            while ($tok !== false) {
                                echo "<li><a class='preview-tags-link'>$tok<a></li>";
                                $tok = strtok(",");
                            }
                            ?>
                        </ul>
                    </div><!-- .tags -->
                <?php } ?>
            </div><!-- .sidebar -->

            <div class="description">
                <?php if (isset($post_images_array) && sizeof($post_images_array) > 0) { ?>
                    <div id="preview-images" class="images">
                        <?php
                        $isMainImageSet = "0";
                        foreach ($post_images_array as $key => $value) {
                            if ($value['is_main_image'] == "1" && $isMainImageSet == "0") {
                                $isMainImageSet = "1";
                                ?>

                                <a class="current image selected cboxElement" href="<?php echo $value['image_url'] ?>" title="">
                                    <img src="<?php echo $value['image_url'] ?>"><span class="caption"><?php echo $value['image_title'] ?></span></a>
                              
                            <?php } else { ?>
                                <a class="image cboxElement" href="<?php echo $value['image_url'] ?>" title=""><img src="<?php echo $value['image_url'] ?>"><span class="caption"><?php echo $value['image_title'] ?></span></a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if (isset($post_images_array) && sizeof($post_images_array) > 0) {
                    $width = sizeof($post_images_array) * 190 . 'px' ?>
                    <div id="thumbs_wrapper"><div class=" jcarousel-skin-tango">
                            <div style="position: relative; display: block;" class="jcarousel-container jcarousel-container-horizontal"><div style="position: relative;" class="jcarousel-clip jcarousel-clip-horizontal">
                                    <ul style="overflow: hidden; position: relative; top: 0px; margin: 0px; padding: 0px; left: 0px; width:<?php echo $width ?>" id="thumbs" class="thumbs jcarousel-list jcarousel-list-horizontal">
                                        <?php
                                        $index = 0;
                                        foreach ($post_images_array as $key => $value) {
                                            $index++;
                                            $class = 'thumb jcarousel-item jcarousel-item-horizontal jcarousel-item-' . $index . ' jcarousel-item-' . $index . '-horizontal';
                                            ?>
                                            <li jcarouselindex="<?php echo $index ?>" style="float: left; list-style: none outside none;" class="<?php echo $class ?>">
                                                <img src="<?php echo $value['image_url'] ?>">
                                            </li>
                                <?php } ?>
                                    </ul>
                                </div>
                                <?php if (isset($post_images_array) && sizeof($post_images_array) > 2) { ?>
                                    <div disabled="disabled" style="display: block;" class="jcarousel-prev jcarousel-prev-horizontal jcarousel-prev-disabled jcarousel-prev-disabled-horizontal"></div>
                                    <div  style="display: block;" class="jcarousel-next jcarousel-next-horizontal"></div>
                                <?php } else { ?>
                                    <div disabled="disabled" style="display: block;" class="jcarousel-prev jcarousel-prev-horizontal jcarousel-prev-disabled jcarousel-prev-disabled-horizontal"></div>
                                    <div disabled="disabled" style="display: block;" class="jcarousel-next jcarousel-next-horizontal jcarousel-next-disabled jcarousel-next-disabled-horizontal"></div>
                    <?php } ?>
                            </div> </div></div>
<?php } ?>
                <div id="preview_post_desc" class="copy"><p><?php echo $description; ?></p></div>
                        <input id="enable_sms_<?php echo $posting_id; ?>" type="hidden" value="<?php echo $enable_sms; ?>"></input>
                        
            </div><!-- .listing-->
        </div>

    </div>
</div>




