<?php
$childAttrArray = $child_attr_counts;
$childAttrSelArray = $child_attr_selected;
if (isset($visible_item_count_left_nav))
$visibleListCounter = $visible_item_count_left_nav;
else
$visibleListCounter = 3;    
$moreItems = 1;
if (sizeof($childAttrArray) <= $visibleListCounter) {
    $visibleListCounter = sizeof($childAttrArray);
    $moreItems = 0;
}

?>
<h5><?php if ($facet_heading == "Category") { ?> <span class="link selected" style="font-weight:bold;" id="<?php echo 'parent_' . $solr_column_name; ?>"><?php echo $facet_name; ?></span><?php } else { echo $facet_heading; }?>
    <?php if (in_array('1',$child_attr_selected) !== FALSE) { ?>
        <a title="Click to Clear <?php echo $facet_heading; ?> selection" id="<?php echo $solr_column_name . '_clear'; ?>" class='clear'><img src="/images/clear.png" class="small-icon"></img></a>
    <?php } else { ?>
        <a title="Click to Clear <?php echo $facet_heading; ?> selection" style="display:none" id="<?php echo $solr_column_name . '_clear'; ?>" class='clear'><img src="/images/clear.png" class="small-icon"></img></a>
    <?php } ?>
</h5>
<?php if ($facet_heading == "Category") { ?>
    <ul id="<?php echo $solr_column_name . '_section'; ?>" name="<?php echo $solr_column_name . '_section'; ?>"><li>

            <ul class="facet-list"> 
                <?php
                for ($i = 0; $i < $visibleListCounter; ++$i) {
                    if ($childAttrSelArray[$i] == '1' || $visibleListCounter == 1) {
                        ?>
                        <li><a class = "check selected" id="<?php echo $solr_column_name . '#' . $i; ?>" href="#"><?php echo $childAttrArray[$i]; ?></a></li>
                    <?php } else if ($childAttrSelArray[$i] == '-1') { ?> 
                        <li>

<!--                            <span class="refinementNotAvailable" >
                                <img align="top" height="12" alt="Disabled Selected Box" width="12" src="/images/check_selected_disabled.jpg" border="0"></img> 
                                <span class="selected" id="<?php echo $solr_column_name . '#' . $i; ?>"><?php echo $childAttrArray[$i]; ?></span>

                            </span>-->
                              <li><a class = "check disabled"  id="<?php echo $solr_column_name . '#' . $i; ?>" href="#"><?php echo $childAttrArray[$i]; ?></a></li>
                        </li>


                    <?php } else { ?> 
                        <li><a class = "check unselected" id="<?php echo $solr_column_name . '#' . $i; ?>" href="#"><?php echo $childAttrArray[$i]; ?></a></li>

                        <?php
                    }
                }
                ?>
            </ul>
            <?php if ($moreItems) { ?>
                <ul class = "moreitems facet-list">
                    <?php
                    for ($j = $visibleListCounter; $j < sizeof($childAttrArray); ++$j) {
                        if ($childAttrSelArray[$j] == '1') {
                            ?>
                            <li><a class = "check selected" id="<?php echo $solr_column_name . '#' . $j; ?>" href="#"><?php echo $childAttrArray[$j]; ?></a></li>
                        <?php } else if ($childAttrSelArray[$j] == '-1') { ?> 
                            <li>

<!--                                <span class="refinementNotAvailable" >
                                    <img align="top" height="12" alt="Disabled Selected Box" width="12" src="/images/check_selected_disabled.jpg" border="0"></img> 
                                    <span class="selected" id="<?php echo $solr_column_name . '#' . $i; ?>"><?php echo $childAttrArray[$i]; ?></span>

                                </span>-->
                                 <li><a class = "check disabled" id="<?php echo $solr_column_name . '#' . $j; ?>" href="#"><?php echo $childAttrArray[$j]; ?></a></li>
                            </li>

                        <?php } else { ?> 
                            <li><a class = "check unselected" id="<?php echo $solr_column_name . '#' . $j; ?>" href="#"><?php echo $childAttrArray[$j]; ?></a></li>

                            <?php
                        }
                    }
                    ?>
                </ul>
                <a class='more'>See More...</a>
            <?php } ?>
        </li>
    </ul>

<?php } else { ?>
    <ul id="<?php echo $solr_column_name . '_section'; ?>" name="<?php echo $solr_column_name . '_section'; ?>"><li>
            <ul class="facet-list"> 
                <?php
                for ($i = 0; $i < $visibleListCounter; ++$i) {
                    if ($childAttrSelArray[$i] == '1') {
                        ?>
                        <li><a class = "check selected" id="<?php echo $solr_column_name . '#' . $i; ?>" href="#"><?php echo $childAttrArray[$i]; ?></a></li>
                    <?php } else if ($childAttrSelArray[$i] == '-1') { ?> 
                        <li>                          
<!--                            <span class="refinementNotAvailable" >
                                <img align="top" height="12" alt="Disabled Selected Box" width="12" src="/images/check_selected_disabled.jpg" border="0"></img> 
                                <span class="selected" id="<?php echo $solr_column_name . '#' . $i; ?>"><?php echo $childAttrArray[$i]; ?></span>
                            </span>-->
                             <li><a class = "check disabled" id="<?php echo $solr_column_name . '#' . $i; ?>" href="#"><?php echo $childAttrArray[$i]; ?></a></li>
                        </li>
                    <?php } else { ?> 
                        <li><a class = "check unselected" id="<?php echo $solr_column_name . '#' . $i; ?>" href="#"><?php echo $childAttrArray[$i]; ?></a></li>

                        <?php
                    }
                }
                ?>
            </ul>
            <?php if ($moreItems) { ?>
                <ul class = "moreitems facet-list">
                    <?php
                    for ($j = $visibleListCounter; $j < sizeof($childAttrArray); ++$j) {
                        if ($childAttrSelArray[$j] == '1') {
                            ?>
                            <li><a class = "check selected" id="<?php echo $solr_column_name . '#' . $j; ?>" href="#"><?php echo $childAttrArray[$j]; ?></a></li>
                        <?php } else if ($childAttrSelArray[$j] == '-1') { ?> 
                            <li>                          
<!--                                <span class="refinementNotAvailable" >
                                    <img align="top" height="12" alt="Disabled Selected Box" width="12" src="/images/check_selected_disabled.jpg" border="0"></img> 
                                    <span class="selected" id="<?php echo $solr_column_name . '#' . $i; ?>"><?php echo $childAttrArray[$i]; ?></span>
                                </span>-->
                                 <li><a class = "check disabled" id="<?php echo $solr_column_name . '#' . $j; ?>" href="#"><?php echo $childAttrArray[$j]; ?></a></li>
                            </li>
                        <?php } else { ?> 
                            <li><a class = "check unselected" id="<?php echo $solr_column_name . '#' . $j; ?>" href="#"><?php echo $childAttrArray[$j]; ?></a></li>

                            <?php
                        }
                    }
                    ?>
                </ul>
                <a class='more'>See More...</a>
            <?php } ?>
        </li>
    </ul>
<?php } ?>
