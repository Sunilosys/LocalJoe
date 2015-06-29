<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

	<article <?php post_class(); ?>>

		<header class="entry-header">
		
			<h1 class="entry-title"><?php the_title(); ?></h1>
			
		</header>
		
		<div class="entry-content">
		
			<?php the_content(); ?>
			
		</div>
		
		<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		
		<?php if ('open' == $post->comment_status) { ?>
		
			<section id="comments">
				
				<?php comments_template(); ?>
					
			</section>
			
		<?php } ?>
		
	</article>
	
<?php endwhile; ?>

</div> <!-- end content -->

<aside id="sidebar" role="complementary">

	<?php get_sidebar('universal'); ?>
	
</aside>

<?php get_footer(); ?>
