<article <?php post_class(); ?>>

	<header class="entry-header">
		
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="archive"><?php the_title(); ?></a></h1>
		
		<div class="entry-meta">
		
			<p>Posted by <?php the_author_posts_link(); ?> on <time datetime="<?php the_time('c'); ?>" pubdate><?php the_time(get_option('date_format')); ?></time>. <?php if ('open' == $post->comment_status) { ?><a href="<?php the_permalink(); ?>/#comments"><?php comments_number('No comments','One comment','% comments'); ?></a>.<?php } ?></p>
		
		</div>
		
	</header>
	
		<?php if ($post->post_excerpt != "" ) {

			echo "<div class=\"entry-summary\">";
	   
			the_excerpt();
			
			echo "<p><a href=\"";
			
			the_permalink();
			
			echo "\">Continue reading <em>";
			
			the_title();
			
			echo "</em></a></p>";
	       
			echo "</div>";

		}
		
		else {
		
			echo "<div class=\"entry-content\">";
	   
			the_content("Continue reading <em>" . the_title('', '', false));
		   
			echo "</div>";
			
			wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));

		}

		?>
	
</article>
