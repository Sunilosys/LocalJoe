<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

	<?php if(!get_post_format()) {

		get_template_part('format', 'standard');

	}

	else {

		get_template_part('format', get_post_format());

	}
	
	?>
	
<?php endwhile; ?>

<div class="pagination">
			       
	    <p class="next"><?php previous_posts_link('Newer posts', '0'); ?></p>
	    <p class="previous"><?php next_posts_link('Older posts', '0'); ?></p>
   
</div> <!-- end .pagination -->

</div> <!-- end content -->

<aside id="sidebar" role="complementary">

	<?php get_sidebar('universal'); ?>

	<?php get_sidebar('front'); ?>

</aside>

<?php get_footer(); ?>
