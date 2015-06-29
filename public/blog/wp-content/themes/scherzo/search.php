<?php get_header(); ?>

	<?php if (have_posts()) : ?>

		<h1 class="page-title">Your search for &#8220;<?php the_search_query(); ?>&#8221;</h1>

		<?php while (have_posts()) : the_post(); ?>
			
				<article <?php post_class(); ?>>
				
					<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="archive"><?php the_title(); ?></a></h1>
			
					<div class="entry-meta">
					
						<p>Posted by <?php the_author_posts_link(); ?> on <time datetime="<?php the_time('c'); ?>" pubdate><?php the_time(get_option('date_format')); ?></time>. <a href="<?php the_permalink(); ?>/#comments"><?php comments_number('No comments','One comment','% comments'); ?></a>.</p>
					
					</div>
					
					<div class="entry-summary">
				
						<?php the_excerpt(); ?>
						
					</div>
					
				</article>
				
		<?php endwhile; ?>
		
			<div class="pagination">
							   
				<p class="next"><?php previous_posts_link('Newer search results', '0'); ?></p>
				<p class="previous"><?php next_posts_link('Older search results', '0'); ?></p>
			   
			</div> <!-- end .pagination -->

	<?php else : ?>

		<p>Unfortunately your search didn't return anything. Please try again.</p>

	<?php endif; ?>
	
</div> <!-- end content -->

<aside id="sidebar" role="complementary">

	<?php get_sidebar('universal'); ?>
	
</aside> <!-- end sidebar -->

<?php get_footer(); ?>
