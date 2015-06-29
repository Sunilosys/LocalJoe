<?php if (isset($userLoggedIn) && $userLoggedIn == 1) { ?>
<div class="widget-header" style="border-bottom: 0px solid rgb(204, 204, 204)">
    <div style="float:left">
        <h2 class='title'> <a id="short_list_expand_collapse" title="Click to Expand/Collapse" class='expand'><img src="/images/arrow-circle-up.png" style="height:12px;width:12px"></img></a>Favorites List</h2>
    </div>
    <div style="float:right;padding-top:7px">
        <a class="hide" href="#"></a>
        <a title="Add New Favorite List" id="new-shortlist" name="new-shortlist" ><img src="/images/add_small.png" style="height:12px;width:12px"></img></a>
        <a class="edit" title="Edit Favorite List"><img src="/images/edit.png" style="height:12px;width:12px"></img></a>
        
       

    </div>
</div>
  

<div class='content' style="display:none">
    <?php if (isset($shortListInfo)) { ?>
        <ul>
            <?php foreach ($shortListInfo as $key => $value) { ?>
                <li><a class="short-list-link" id="<?php echo 'short_list_link_' . $value['folder_id']; ?>" href="#page=search"><?php echo $value['folder_name']; ?></a><a  id="<?php echo 'delete_' . $value['folder_id']; ?>" class="delete"></a>
                    <input type="hidden" value='<?php echo $value['folder_postings']; ?>'></input>
                </li>

            <?php } ?>
        </ul>

    <?php } else {?>
    <div>Oops! You don't have any favorite list.</div>
    <?php }?>
<!--    <div class='buttons'>
        <a id="new-shortlist" class='button secondary new-shortlist'>New Favorite List</a>

    </div>-->
</div>

<?php } ?>

