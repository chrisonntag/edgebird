<?php
/**
 * Post-Format Chat Template 
 *
 * @package Edgebird
 * @since Edgebird 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" class="col-12">
    <div <?php post_class(); ?>> <!-- used for setting the post-format-chat classes -->
        <header class="entry-header">
            <h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'edgebird' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
     
            <div class="entry-meta">
                <span class="byline"><i class="fa fa-video-camera special-format"></i></span><br /><span class="posted-on"><?php the_time() ?></span><br />
            </div><!-- .entry-meta -->
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php the_content( __( '<br />Continue reading&nbsp;<span class="meta-nav">&rarr;</span><br />', 'edgebird' ) ); ?>
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
