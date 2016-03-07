<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Edgebird
 * @since Edgebird 1.0
 */

if ( ! function_exists( 'edgebird_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Edgebird 1.0
 */
function edgebird_posted_on() {
    
    $author_id = get_the_author_meta( 'ID' );

    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
    }

    $time_string = sprintf( $time_string,
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() )
    );

    $posted_on = sprintf(
        esc_html_x( 'Published %s', 'post date', 'edgebird' ),
        '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
    );

    $byline = sprintf(
        esc_html_x( '%s ', 'post author', 'edgebird' ),
        '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
    );

    /* translators: used between category list items, there is a space after the comma */
    $categories = get_the_category();
    $separator = ', ';
    $output = '';
    if ( ! empty( $categories ) ) {
        foreach( $categories as $category ) {
            $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
        }
    }

    $published_in = sprintf(
        esc_html_x( 'in %s', 'category', 'edgebird' ),
        '<span>'.trim( $output, $separator ).'</span></span>'
    );

    if(is_single()) {
        // Display author avatar if author has a Gravatar
        if ( validate_gravatar( $author_id ) ) {
            echo '<div class="meta-content has-avatar">';
            echo '<div class="author-avatar">' . get_avatar( $author_id ) . '</div>';
        } else {
            echo '<div class="meta-content">';
        }
    } else {
        echo '<div class="meta-content">';
    }

    echo '<span class="byline">' . $byline . $published_in . ' </span><br /><span class="posted-on">' . $posted_on . ' </span><br />'; // WPCS: XSS OK.
    if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo '<span class="comments-link">';
        comments_popup_link( esc_html__( 'Leave a comment', 'edgebird' ), esc_html__( '1 Comment', 'edgebird' ), esc_html__( '% Comments', 'edgebird' ) );
        echo '</span>';
    }
    echo '</div><!-- .meta-content -->';
    
}
endif;

 

/**
 * Utility function to check if a gravatar exists for a given email or id
 * Source: https://gist.github.com/justinph/5197810
 * @param int|string|object $id_or_email A user ID,  email address, or comment object
 * @return bool if the gravatar exists or not
 */

function validate_gravatar($id_or_email) {
  //id or email code borrowed from wp-includes/pluggable.php
    $email = '';
    if ( is_numeric($id_or_email) ) {
        $id = (int) $id_or_email;
        $user = get_userdata($id);
        if ( $user )
            $email = $user->user_email;
    } elseif ( is_object($id_or_email) ) {
        // No avatar for pingbacks or trackbacks
        $allowed_comment_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );
        if ( ! empty( $id_or_email->comment_type ) && ! in_array( $id_or_email->comment_type, (array) $allowed_comment_types ) )
            return false;

        if ( !empty($id_or_email->user_id) ) {
            $id = (int) $id_or_email->user_id;
            $user = get_userdata($id);
            if ( $user)
                $email = $user->user_email;
        } elseif ( !empty($id_or_email->comment_author_email) ) {
            $email = $id_or_email->comment_author_email;
        }
    } else {
        $email = $id_or_email;
    }

    $hashkey = md5(strtolower(trim($email)));
    $uri = 'http://www.gravatar.com/avatar/' . $hashkey . '?d=404';

    $data = wp_cache_get($hashkey);
    if (false === $data) {
        $response = wp_remote_head($uri);
        if( is_wp_error($response) ) {
            $data = 'not200';
        } else {
            $data = $response['response']['code'];
        }
        wp_cache_set($hashkey, $data, $group = '', $expire = 60*5);

    }
    if ($data == '200'){
        return true;
    } else {
        return false;
    }
}


/**
 * Returns true if a blog has more than 1 category
 *
 * @since Edgebird 1.0
 */
function edgebird_categorized_blog() {
    if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
        // Create an array of all the categories that are attached to posts
        $all_the_cool_cats = get_categories( array(
            'hide_empty' => 1,
        ) );
 
        // Count the number of categories that are attached to the posts
        $all_the_cool_cats = count( $all_the_cool_cats );
 
        set_transient( 'all_the_cool_cats', $all_the_cool_cats );
    }
 
    if ( '1' != $all_the_cool_cats ) {
        // This blog has more than 1 category so edgebird_categorized_blog should return true
        return true;
    } else {
        // This blog has only 1 category so edgebird_categorized_blog should return false
        return false;
    }
}
 
/**
 * Flush out the transients used in edgebird_categorized_blog
 *
 * @since Edgebird 1.0
 */
function edgebird_category_transient_flusher() {
    // Like, beat it. Dig?
    delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'edgebird_category_transient_flusher' );
add_action( 'save_post', 'edgebird_category_transient_flusher' );


if ( ! function_exists( 'edgebird_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since Edgebird 1.0
 */
function edgebird_content_nav( $nav_id ) {
    global $wp_query, $post;
 
    // Don't print empty markup on single pages if there's nowhere to navigate.
    if ( is_single() ) {
        $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
        $next = get_adjacent_post( false, '', false );
 
        if ( ! $next && ! $previous )
            return;
    }
 
    // Don't print empty markup in archives if there's only one page.
    if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
        return;
 
    $nav_class = 'site-navigation paging-navigation';
    if ( is_single() )
        $nav_class = 'site-navigation post-navigation';
 
    ?>
    <nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
        
 
    <?php if ( is_single() ) : // navigation links for single posts ?>
 
        <?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'edgebird' ) . '</span> %title' ); ?>
        <?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'edgebird' ) . '</span>' ); ?>
 
    <?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>
 
        <?php if ( get_next_posts_link() ) : ?>
        <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'edgebird' ) ); ?></div>
        <?php endif; ?>
 
        <?php if ( get_previous_posts_link() ) : ?>
        <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'edgebird' ) ); ?></div>
        <?php endif; ?>
 
    <?php endif; ?>
 
    </nav><!-- #<?php echo $nav_id; ?> -->
    <?php
}
endif; // edgebird_content_nav


if ( ! function_exists( 'edgebird_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Edgebird 1.0
 */
function edgebird_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
    ?>
    <li class="post pingback">
        <p><?php _e( 'Pingback:', 'edgebird' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'edgebird' ), ' ' ); ?></p>
    <?php
            break;
        default :
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <article id="comment-<?php comment_ID(); ?>" class="comment">
            <footer>
                <?php echo get_avatar( $comment, 70 ); ?>
                <div class="comment-author vcard">

                    <?php printf( __( '%s <span class="says">says:</span>', 'edgebird' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
                    <?php if ( $comment->comment_approved == '0' ) : ?>
                        <em><?php _e( 'Your comment is awaiting moderation.', 'edgebird' ); ?></em>
                        <br />
                    <?php endif; ?>
        
                    <div class="comment-meta commentmetadata">
                        <span class="comment-time"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
                        <?php
                            /* translators: 1: date, 2: time */
                            printf( __( '<i class="fa fa-clock-o"></i>&nbsp;&nbsp;%1$s ago', 'edgebird' ), human_time_diff( get_comment_time('U'), current_time('timestamp') ) ); ?>
                        </time></span>
                        <?php edit_comment_link( __( '(Edit)', 'edgebird' ), ' ' );
                        ?>
                    </div><!-- .comment-meta .commentmetadata -->

                </div><!-- .comment-author .vcard -->
            </footer>
 
            <div class="comment-content"><?php comment_text(); ?></div>
 
            <div class="reply">
                <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div><!-- .reply -->
        </article><!-- #comment-## -->
 
    <?php
            break;
    endswitch;
}
endif; // ends check for edgebird_comment()


/**
 * Customize Read More link
 *
 * @since Edebird 1.0
 */

function edgebird_read_more_link() {
    /* translators: %s: Name of current post. */
    $read_more_link = sprintf('&raquo;&nbsp;'. esc_html__('Continue reading', 'edgebird'));
    $read_more_string =
    '<div class="continue-reading">
        <a href="' . get_permalink() . '" rel="bookmark">' . $read_more_link . '</a>
    </div>';

    return $read_more_string;
}
add_filter( 'the_content_more_link', 'edgebird_read_more_link' );



if ( ! function_exists( 'edgebird_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 *
 * @since Edgebird 1.0
 */
function edgebird_entry_footer() {
    // Hide category and tag text for pages.
    if ( 'post' === get_post_type() ) {

        /* translators: used between tag list items, there is a space after the comma */
        $tags_list = get_the_tag_list( '', esc_html__( ', ', 'edgebird' ) );
        if ( $tags_list ) {
            printf( '<span class="tags-links"><i class="fa fa-tags"></i>&nbsp;&nbsp;' . esc_html__( '%1$s', 'edgebird' ) . '</span>', $tags_list ); // WPCS: XSS OK.
        }
    }
        if(has_tag()) {
            if(comments_open()) {
                if(!is_single()) {
                    echo "&nbsp;|&nbsp;";
                }
            }
        }
        

    if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo '<span class="comments-link"><i class="fa fa-comments"></i>&nbsp;&nbsp;';
        comments_popup_link( esc_html__( 'Leave a comment', 'edgebird' ), esc_html__( '1 Comment', 'edgebird' ), esc_html__( '% Comments', 'edgebird' ) );
        echo '</span>';
    }

    edit_post_link( esc_html__( 'Edit', 'edgebird' ), '&nbsp;|&nbsp;<span class="edit-link">', '</span><br />' );
}
endif;


