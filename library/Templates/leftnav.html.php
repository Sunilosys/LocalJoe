<div class="widget-header">
    <div style="float:left">
<h2 class='title'>  <a id="refine_search_expand_collapse" title="Click to Expand/Collapse" class='collapse'><img class="small-icon" src="/images/arrow-circle-down.png"></img></a>Refine Search </h2>
    </div>
     <div style="float:right;padding-top:7px">
    <?php if (isset($showClearAll) && $showClearAll == true) { ?><a style="right:12px;" title="Clear All" id="left_nav_clear_all" class='clear'><img src="/images/clear.png" class="small-icon"></img></a><?php } ?>
<a title="Save Search" id="btnSaveSearch" ><img class="small-icon" src="/images/save.png"></img></a>
  
     </div>
</div>
<div id="refine_search_container">
<?php echo $left_nav_html; ?>
<!--<div class='buttons'>
    <a id="btnSaveSearch" class='button secondary savesearch'>Save Search</a>
</div>-->
<input id="category_fields_hidden" type="hidden" value="<?php echo $category_fields_hidden; ?>"></input>
<input id="select_fields_hidden" type="hidden" value="<?php echo $select_fields_hidden; ?>"></input>
<input id="multiselect_fields_hidden" type="hidden" value="<?php echo $multiselect_fields_hidden; ?>"></input>
<input id="range_fields_hidden" type="hidden" value="<?php echo $range_fields_hidden; ?>"></input>
<input id="all_fields_hidden" type="hidden" value="<?php echo $all_fields_hidden; ?>"></input>
<input id="emphasized_hidden" type="hidden" value="<?php echo $emphasized_hidden; ?>"></input>
</div