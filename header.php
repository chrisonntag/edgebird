<?php
/**
 * The Header file.
 *
 * Displays all of the <head> section and everything up till <header>
 *
 * @package Edgebird
 * @since Edgebird 1.0
 */
?>
<!DOCTYPE html>
<html lang="<?php bloginfo('language'); ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

	<!-- Descripcion -->
    <title>
	    <?php
			/*
			* Print the <title> tag based on what is being viewed.
			*/
			global $page, $paged;
			 
			wp_title( '|', true, 'right' );
			 
			// Add the blog name.
			bloginfo( 'name' );
			 
			// Add the blog description for the home/front page.
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";
			 
			// Add a page number if necessary:
			if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'edgebird' ), max( $paged, $page ) );	 
		?>
	</title>
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="">
	<meta name="keywords" content="">

    <!-- Favicon -->
	<link rel="shortcut icon" href="">

	<!-- CSS Stylesheets -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="profile" href="http://gmpg.org/xfn/11" />

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
   	<!--[if lt IE 9]>
   		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
   	<![endif]-->

	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<header id="header-top" class="nav-down">
		<div id="header-top_left">
			<a href="<?php bloginfo('url'); ?>" class="header-top_logo"><img src="<?php echo get_template_directory_uri(); ?>/images/pagelogo.png"></img></a>
		</div>
		<div id="header-top_middle">
			<h2></h2>
		</div>
		<div id="header-top_right">
			<?php get_search_form(); ?>
		</div>
		<div class="readposition"></div>
	</header>



