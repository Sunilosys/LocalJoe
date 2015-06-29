<article <?php post_class(); ?>>

	<div class="entry-content">
		
		<?php the_content(); ?>
		
	</div>
	
	<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
	
	<div class="entry-meta">
	
		<p><time datetime="<?php the_time('c'); ?>" pubdate><?php the_time(get_option('date_format')); ?></time>. <a href="<?php the_permalink(); ?>">Permalink &rarr;</a></p>
		
	</div>
	
</article>
