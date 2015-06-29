 <ul id="add_shortlist_section_<?php echo $posting_id; ?>" class='pophint menu add-shortlist-section'>	
<li class='title'>Favorite</li>
	<?php if (isset($add_shortlists) && sizeof($add_shortlists) > 0) {
		foreach ($add_shortlists as $key => $value) {
			?>
			<li> 
				<?php if ($value['is_added']) { ?>
					<a class = "check selected" id="<?php echo $posting_id; ?>add-remove-shortlist<?php echo $value['folder_id']; ?>" ><?php echo $value['folder_name']; ?></a>
				<?php } else { ?>
					<a class = "check unselected" id="<?php echo $posting_id; ?>add-remove-shortlist<?php echo $value['folder_id']; ?>" ><?php echo $value['folder_name']; ?></a>

				<?php } ?>
			</li>  
			<?php
		}
	}
	?>
	<li><a class="create-new-shortlist" style="padding-left:5px" id="create_new_shortlist_<?php echo $posting_id; ?>">Create New...</a></li>
 </ul>
