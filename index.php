<?php
/**
 * The main template file. Here's everything we need.
 * 
 * @package Edgebird
 * @since Edgebird 1.0
 */
 
get_header(); ?>
<div class="grid main">
	<div class="row">
		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
 				
			<?php
	          /* Include the Post-Format-specific template for the content.
	          * If you want to overload this in a child theme then include a file
	          * called content-___.php (where ___ is the Post Format name) and that will be used instead.
	          */
	          get_template_part( 'content', get_post_format() );
	        ?>
 
		<?php endwhile; ?>

			<?php edgebird_content_nav( 'nav-below' ); ?>
			
		<?php else: ?>
			<?php get_template_part( 'no-results', 'index' ); ?>
		<?php endif; ?>   
	</div>       
</div> <!-- Closing the main div -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
