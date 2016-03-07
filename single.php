<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Edgebird
 * @since Edgebird 1.0
 */
 
get_header(); ?>

<?php
    if ( has_post_thumbnail() ) { ?>
        <figure class="featured-image">
            <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
                <?php the_post_thumbnail(); ?>
            </a>
        </figure>
<?php }
?>
<div class="grid main">
	<div class="row">
 
            <?php while ( have_posts() ) : the_post(); ?>
 
                <?php get_template_part( 'content', 'single' ); ?>
 
                <?php edgebird_content_nav( 'nav-below' ); ?>
 
                <?php
                    // If comments are open or we have at least one comment, load up the comment template
                    if ( comments_open() || '0' != get_comments_number() )
                        comments_template( '', true );
                ?>
 
            <?php endwhile; // end of the loop. ?>
 
	</div><!-- .row -->
</div><!-- .grid main -->
 
<?php get_sidebar(); ?>
<?php get_footer(); ?>