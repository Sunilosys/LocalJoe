<!doctype html>

<html <?php language_attributes(); ?>>

	<head>
	
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		
		<title><?php wp_title(' &mdash; ',true,'right'); ?><?php bloginfo('name'); ?></title>

		<?php if ( is_home() ) {?>
			
			<meta name="description" content="<?php bloginfo('description'); ?>">
						
		<?php } ?>
		
		<!--[if lt IE 9]>
		
			<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
			
		<![endif]-->

		<link rel="stylesheet" media="all" href="<?php bloginfo('stylesheet_url'); ?>">
						
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		
		<link rel="profile" href="http://gmpg.org/xfn/11">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
		
		<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>

		<?php wp_head(); ?>
		
	</head>
	
	<body <?php body_class(); ?>>
	
		<p class="accessibility"><a href="#content">Skip to content</a></p>
	
		<div id="wrapper">

			<a class="header-link" href="<?php echo home_url(); ?>" rel="index" title="Go to home page">
	
				<header id="site-header" role="banner">
				
					<div id="branding">
						
						<h1 id="site-title"><?php bloginfo('name'); ?></h1>
						
						<p id="tag"><?php bloginfo('description'); ?></p>
						
					</div> <!-- end #branding -->
					
				</header>
				
			</a>
		
			<div id="content" role="main">
