<?php
/**
 * Single Page Template 
 *
 * @package Edgebird
 * @since Edgebird 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('show_readingposition'); ?> data-id="1" data-order="1">
    <header class="entry-header">

        <?php
                the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
        ?>

        <?php
        if ( has_excerpt( $post->ID ) ) {
            echo '<div class="deck">';
            echo '<h3>' . get_the_excerpt() . '</h3>';
            echo '</div><!-- .deck -->';
        }
        ?>



        <?php
        if ( 'chat' === get_post_format() ) { ?>
            <div class="entry-meta">
                <span class="byline"><i class="fa fa-comment special-format"></i></span><br /><span class="posted-on"><?php the_time() ?></span><br />
            </div><!-- .entry-meta -->
    </header><!-- .entry-header -->
        <?php } else if ( 'aside' === get_post_format() ) { ?>

            <div class="entry-meta">
                <span class="byline"><i class="fa fa-sticky-note special-format"></i></span><br /><span class="posted-on"><?php the_time() ?></span><br />
            </div><!-- .entry-meta -->
    </header><!-- .entry-header -->

        <?php } else if ( 'audio' === get_post_format() ) { ?>

            <div class="entry-meta">
                <span class="byline"><i class="fa fa-volume-up special-format"></i></span><br /><span class="posted-on"><?php the_time() ?></span><br />
            </div><!-- .entry-meta -->
    </header><!-- .entry-header -->

        <?php } else if ( 'video' === get_post_format() ) { ?>

            <div class="entry-meta">
                <span class="byline"><i class="fa fa-video-camera special-format"></i></span><br /><span class="posted-on"><?php the_time() ?></span><br />
            </div><!-- .entry-meta -->
    </header><!-- .entry-header -->

        <?php } else if ( 'gallery' === get_post_format() ) { ?>

            <div class="entry-meta">
                <span class="byline"><i class="fa fa-picture-o special-format"></i></span><br /><span class="posted-on"><?php the_time() ?></span><br />
            </div><!-- .entry-meta -->
    </header><!-- .entry-header -->

        <?php } else { //all other post-formats
        ?>

    </header><!-- .entry-header -->
</article>
</div><!-- .row --> 
</div><!-- .grid main -->  

        <div class="entry-meta entry-meta-single">
            <?php edgebird_posted_on(); ?>
        </div><!-- .entry-meta -->

<div class="grid main">
<div class="row">

<article id="post-<?php the_ID(); ?>" <?php post_class('show_readingposition'); ?> data-id="1" data-order="2">


<?php } //end elseif 'all other post formats' ?>


    <div class="entry-content">
        <?php the_content(''); ?>
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
        
</article><!-- #post-## -->
