<?php if (isset($userLoggedIn) && $userLoggedIn == 1) { ?>
<div class="widget-header" style="border-bottom: 0px solid rgb(204, 204, 204)">
    <div style="float:left">
        <h2 class='title'>  <a id="saved_search_expand_collapse" title="Click to Expand/Collapse" class='expand'><img src="/images/arrow-circle-up.png" class="small-icon"></img></a>
Saved Searches</h2>
    </div>
    <div style="float:right;padding-top:7px">
        <a class="hide" href="#"></a>
        <a class="edit" title="Edit Saved Searches"><img src="/images/edit.png" class="small-icon"></img></a>

      
    </div>
</div>



<div class='content' style="display:none">
    <?php if (isset($savedSearchesInfo)) { ?>
        <ul>
            <?php foreach ($savedSearchesInfo as $key => $value) { ?>
                <li><a class="save-search-link" id="<?php echo 'save_search_link_' . $value['search_id']; ?>" href="#page=search"><?php echo $value['search_name']; ?></a><a title="Click to delete Saved Search : <?php echo $value['search_name']; ?>" id="<?php echo 'delete_' . $value['search_id']; ?>" class="delete"></a>
                    <input type="hidden" value='<?php echo $value['search_terms']; ?>'></input>
                </li>

            <?php } ?>
        </ul>
   <?php } else {?>
    <div>Oops! You don't have any saved search.</div>
    <?php }?>
</div>

<?php } ?>