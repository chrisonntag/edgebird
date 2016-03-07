<?php
/**
 * Post-Format Chat Template 
 *
 * @package Edgebird
 * @since Edgebird 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" class="col-12">
    <div <?php post_class(); ?>> <!-- used for setting the post-format-quote classes -->
        
        <div class="entry-content">
            <?php the_content(); ?>
            <?php
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'edgebird' ),
                    'after'  => '</div>',
                ) );
            ?>
        </div><!-- .entry-content -->

        <footer class="entry-footer">
              <?php edgebird_entry_footer(); ?>
        </footer><!-- .entry-footer -->
    </div>
        
</article><!-- #post-## -->
