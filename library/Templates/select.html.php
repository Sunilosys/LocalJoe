<?php
$childAttrArray = $child_attr_counts;
$childAttrSelArray = $child_attr_selected;

?>
<h5><?php if ($facet_heading == "Category") { ?> <span style="font-weight:bold" id='<?php echo $solr_column_name; ?>' class='link selected'><?php echo $facet_name; ?></span><?php } else { echo $facet_heading; } ?> <?php if (in_array('1',$child_attr_selected) !== FALSE) { ?>
        <a title="Click to Clear <?php echo $facet_heading; ?> selection" id="<?php echo $solr_column_name . '_clear'; ?>" class='clear'><img src="/images/clear.png" class="small-icon"></img></a>
    <?php } else { ?>
        <a title="Click to Clear <?php echo $facet_heading; ?> selection" style="display:none" id="<?php echo $solr_column_name . '_clear'; ?>" class='clear'><img src="/images/clear.png" class="small-icon"></img></a>
    <?php } ?>
</h5>
<ul id="<?php echo $solr_column_name . '_section'; ?>" name="<?php echo $solr_column_name . '_section'; ?>" class='facets'>        
    <li>
        <ul><?php
    for ($i = 0; $i < sizeof($childAttrArray); ++$i) {
        if ($childAttrSelArray[$i] == '1') {
            ?>
                    <li><a class='link selected' id="<?php echo $solr_column_name . '#' . $i; ?>" href="#"><?php echo $childAttrArray[$i]; ?></a></li>
                <?php } else if ($childAttrSelArray[$i] == '-1') { ?> 
                    <span class="refinementNotAvailable" >                                 
                        <span id="<?php echo $solr_column_name . '#' . $i; ?>"><?php echo $childAttrArray[$i]; ?></span>
                    </span>
                <?php } else { ?>
                    <li><a class='link' id="<?php echo $solr_column_name . '#' . $i; ?>" href="#"><?php echo $childAttrArray[$i]; ?></a></li>

                    <?php
                }
            }
            ?>
        </ul>
    </li>
</ul>
