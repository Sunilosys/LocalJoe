
<h5><?php echo $facet_heading; ?><?php
if ($display_format == "Date") {   
    $fromToDate = explode(",", $child_attr_selected[0]);
    
    if ($child_attr_selected[0] != ",") {
       ?>
    <a title="Click to Clear <?php echo $facet_heading; ?> selection" id="<?php echo $solr_column_name . '_rangeclear'; ?>" class='clear'><img src="/images/clear.png" class="small-icon"></img></a>
        <?php } else { ?>
            <a title="Click to Clear <?php echo $facet_heading; ?> selection" style="display:none" id="<?php echo $solr_column_name . '_rangeclear'; ?>" class='clear'><img src="/images/clear.png" class="small-icon"></img></a>
        <?php }
    }
else  {
    
    $tempArray = explode("~$~", $child_attr_selected[0]);
    $allminMax = explode("|", $tempArray[0]);
    $minMax = explode("|", $tempArray[1]);
   
    if ($tempArray[0] != $tempArray[1]) {
       ?>
    <a id="<?php echo $solr_column_name . '_rangeclear'; ?>" class='clear'><img src="/images/clear.png" class="small-icon"></img></a>
        <?php } else { ?>
            <a style="display:none" id="<?php echo $solr_column_name . '_rangeclear'; ?>" class='clear'><img src="/images/clear.png" class="small-icon"></img></a>
        <?php }
    }
    ?>

</h5>
<div id="<?php echo $solr_column_name . '_range_section'; ?>" name="<?php echo $solr_column_name . '_section'; ?>">
<?php if ($display_format == "Date") { ?>
        <input class='datepicker price min example' value="<?php echo $fromToDate[0]; ?>" id="<?php echo $solr_column_name . '_range_fromDate'; ?>" title='From' type='text'/>
        <input class='datepicker price max example' value="<?php echo $fromToDate[1]; ?>" id="<?php echo $solr_column_name . '_range_toDate'; ?>" title='To' type='text'/>
<?php } else { ?>
        <!--<input class='numeric price min example' id="<?php echo $solr_column_name . '_range_min'; ?>" title='Min' type='text'/>
        <input class='numeric price max example' id="<?php echo $solr_column_name . '_range_max'; ?>" title='Max' type='text'/>-->
        <div class="min-max-filter-display">
            <span id="<?php echo $solr_column_name . '_slider_range_min'; ?>" class="min-max"><?php echo $minMax[0]; ?></span>
            <span> - </span>
            <span id="<?php echo $solr_column_name . '_slider_range_max'; ?>" class="min-max"><?php echo $minMax[1]; ?></span>
            <span id="<?php echo $solr_column_name . '_slider_range_count'; ?>" class="min-max"><?php echo $child_attr_counts[0]; ?></span>

        </div>
        <input type="hidden" id="<?php echo $solr_column_name . '_slider_range_all_min'; ?>" value="<?php echo $allminMax[0]; ?>"></input>
        <input type="hidden" id="<?php echo $solr_column_name . '_slider_range_all_max'; ?>" value="<?php echo $allminMax[1]; ?>"></input>
         <input type="hidden" id="<?php echo $solr_column_name . '_slider_range_is_currency'; ?>" value="<?php echo $is_currency; ?>"></input>
                  <input type="hidden" id="<?php echo $solr_column_name . '_slider_range_range_increment'; ?>" value="<?php echo $range_increment; ?>"></input>
        <div id="<?php echo $solr_column_name . '_slider_range'; ?>" class="slider-range"></div>
<?php } ?>
</div>