<?php get_header(); ?>

	<article>

		<?php if (have_posts()) : ?>

			<?php /* If this is a category archive */ if (is_category()) { ?>
			
				<h1 class="page-title">Posts filed under &#8220;<?php single_cat_title(); ?>&#8221;</h1>
				
			<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
			
				<h1 class="page-title">Posts tagged &#8220;<?php single_tag_title(); ?>&#8221;</h1>
			
			<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			
				<h1 class="page-title">Archive for <?php the_time('F j, Y'); ?></h1>
				
			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			
				<h1 class="page-title">Archive for <?php the_time('F, Y'); ?></h1>
				
			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			
				<h1 class="page-title">Archive for <?php the_time('Y'); ?></h1>
				
			<?php /* If this is an author archive */ } elseif (is_author()) { ?>
			
				<h1 class="page-title">Posts by <?php echo wp_title(''); ?></h1>
			
		<?php } ?>

		<?php while (have_posts()) : the_post(); ?>
				
					<article <?php post_class(); ?>>
				
						<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="archive"><?php the_title(); ?></a></h1>
			
						<div class="entry-meta">
						
							<p>Posted by <?php the_author_posts_link(); ?> on <time datetime="<?php the_time('c'); ?>" pubdate><?php the_time(get_option('date_format')); ?></time>. <?php if ('open' == $post->comment_status) { ?><a href="<?php the_permalink(); ?>/#comments"><?php comments_number('No comments','One comment','% comments'); ?></a>.<?php } ?></p>
						
						</div>
						
						<div class="entry-summary">
					
							<?php the_excerpt(); ?>
							
						</div>
						
						<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
						
					</article>
				
		<?php endwhile; ?>

	<?php else : ?>

		<h1 class="entry-title">Not Found</h1>

	<?php endif; ?>
	
</article>

<div class="pagination">
			       
	<p class="next"><?php previous_posts_link('Newer posts', '0'); ?></p>
	<p class="previous"><?php next_posts_link('Older posts', '0'); ?></p>
   
</div> <!-- end .pagination -->

</div> <!-- end content -->

<aside id="sidebar" role="complementary">

	<?php get_sidebar('universal'); ?>
	
</aside>

<?php get_footer(); ?>
