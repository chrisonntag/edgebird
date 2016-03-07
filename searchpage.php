<?php
/**
 * The template for displaying the Search Page on mobile devices
 *
 * @package Edgebird
 * @since Edgebird 1.0
 */

?>

<?php
get_header(); ?>
 
    <div class="grid main">
        <div id="content" class="row" role="main">
 
            <article id="post-0" class="post searchpage">
                <header class="entry-header">
                    <h1 class="entry-title"><?php _e( 'Search Posts on', 'edgebird' ) . bloginfo('name') ?></h1>
                </header><!-- .entry-header -->
 
                <div class="entry-content">
                    <div class="nothingFound-text col-12">
                        <?php get_search_form(); ?>
                    </div>
                    
                    <div class="404-recentPosts col-6">
                        <?php the_widget( 'WP_Widget_Recent_Posts' ); ?>
                    </div>
 
                    <div class="widget col-6">
                        <h2 class="widgettitle"><?php _e( 'Most Used Categories', 'edgebird' ); ?></h2>
                        <ul>
                        <?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10 ) ); ?>
                        </ul>
                    </div><!-- .widget -->
                    
                    <div class="col-12">
                        <?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
                    </div>
 
                </div><!-- .entry-content -->
            </article><!-- #post-0 .post .error404 .not-found -->
 
        </div><!-- .row -->
    </div><!-- .grid main -->
 
<?php get_footer(); ?>