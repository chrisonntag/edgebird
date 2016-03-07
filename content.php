<?php
/**
 * @package Edgebird
 * @since Edgebird 1.0
 */
 ?>
 
<article id="post-<?php the_ID(); ?>" class="col-12">
    <header class="entry-header">
        <h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'edgebird' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
 
        <?php if ( 'post' == get_post_type() ) : ?>
        <div class="entry-meta">
            <?php edgebird_posted_on(); ?>
        </div><!-- .entry-meta -->
        <?php endif; ?>
    </header><!-- .entry-header -->
    
    <?php
        if ( has_post_thumbnail() ) { ?>
            <figure class="featured-image">
                    <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
                        <?php the_post_thumbnail(); ?>
                    </a>
            </figure>
        <?php }
        ?>

    <?php if ( is_search() ) : // Only display Excerpts for Search ?>
    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div><!-- .entry-summary -->
    <?php else : ?>
    <div class="entry-content">
        <?php the_content( __( '<br />Continue reading&nbsp;<span class="meta-nav">&rarr;</span><br />', 'edgebird' ) ); ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'edgebird' ), 'after' => '</div>' ) ); ?>
    </div><!-- .entry-content -->
    <?php endif; ?>
 
    <footer class="entry-footer">
          <?php edgebird_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->