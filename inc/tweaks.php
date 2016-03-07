<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Edgebird
 * @since Edgebird 1.0
 */


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since Edgebird 1.0
 */
function edgebird_page_menu_args( $args ) {
    $args['show_home'] = true;
    return $args;
}
add_filter( 'wp_page_menu_args', 'edgebird_page_menu_args' );
 
/**
 * Adds custom classes to the array of body classes.
 *
 * @since Edgebird 1.0
 */
function edgebird_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }
 
    return $classes;
}
add_filter( 'body_class', 'edgebird_body_classes' );
 
/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since Edgebird 1.0
 */
function edgebird_enhanced_image_navigation( $url, $id ) {
    if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
        return $url;
 
    $image = get_post( $id );
    if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
        $url .= '#main';
 
    return $url;
}
add_filter( 'attachment_link', 'edgebird_enhanced_image_navigation', 10, 2 );

/**
* Add data-action attribute to every img in order to make zoom.js function properly
*
* @since Edgebird 1.0
*/
function add_dataAction_attribute($content) {
     $dom = new DOMDocument();
     @$dom->loadHTML($content);

     foreach ($dom->getElementsByTagName('img') as $node) {
         $oldsrc = "zoom";
         $node->setAttribute("data-action", $oldsrc);
     }
     $newHtml = $dom->saveHtml();
     return $newHtml;
}

/**
* customise the format of the_time() in the Loop
*
* @since Edgebird 1.0
*/
add_filter('the_content', 'add_dataAction_attribute');


function edgebird_time_ago() {
 
    global $post;
 
    $date = get_post_time('G', true, $post);
 
    /**
     * Where you see 'edgebird' below, you'd
     * want to replace those with whatever term
     * you're using in your theme to provide
     * support for localization.
     */ 
 
    // Array of time period chunks
    $chunks = array(
        array( 60 * 60 * 24 * 365 , __( 'year', 'edgebird' ), __( 'years', 'edgebird' ) ),
        array( 60 * 60 * 24 * 30 , __( 'month', 'edgebird' ), __( 'months', 'edgebird' ) ),
        array( 60 * 60 * 24 * 7, __( 'week', 'edgebird' ), __( 'weeks', 'edgebird' ) ),
        array( 60 * 60 * 24 , __( 'day', 'edgebird' ), __( 'days', 'edgebird' ) ),
        array( 60 * 60 , __( 'hour', 'edgebird' ), __( 'hours', 'edgebird' ) ),
        array( 60 , __( 'minute', 'edgebird' ), __( 'minutes', 'edgebird' ) ),
        array( 1, __( 'second', 'edgebird' ), __( 'seconds', 'edgebird' ) )
    );
 
    if ( !is_numeric( $date ) ) {
        $time_chunks = explode( ':', str_replace( ' ', ':', $date ) );
        $date_chunks = explode( '-', str_replace( ' ', '-', $date ) );
        $date = gmmktime( (int)$time_chunks[1], (int)$time_chunks[2], (int)$time_chunks[3], (int)$date_chunks[1], (int)$date_chunks[2], (int)$date_chunks[0] );
    }
 
    $current_time = current_time( 'mysql', $gmt = 0 );
    $newer_date = strtotime( $current_time );
 
    // Difference in seconds
    $since = $newer_date - $date;
 
    // Something went wrong with date calculation and we ended up with a negative date.
    if ( 0 > $since )
        return __( 'sometime', 'edgebird' );
 
    /**
     * We only want to output one chunks of time here, eg:
     * x years
     * xx months
     * so there's only one bit of calculation below:
     */
 
    //Step one: the first chunk
    for ( $i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];
 
        // Finding the biggest chunk (if the chunk fits, break)
        if ( ( $count = floor($since / $seconds) ) != 0 )
            break;
    }
 
    // Set output var
    $output = ( 1 == $count ) ? '1 '. $chunks[$i][1] : $count . ' ' . $chunks[$i][2];
 
 
    if ( !(int)trim($output) ){
        $output = '0 ' . __( 'seconds', 'edgebird' );
    }
 
    $output .= __(' ago', 'edgebird');
 
    return $output;
}
 
// Filter our edgebird_time_ago() function into WP's the_time() function
add_filter('the_time', 'edgebird_time_ago');


/**
* Append own classes to the comment form
*
* @since Edgebird 1.0
*/
function custom_comment_form($args = array(), $post_id = null) {
  if (isset($args['form_class'])) {
    ob_start();
    comment_form($args, $post_id);
    $string = str_replace('id="comment"', 'id="comment" class="' . $args['form_class'] . ' form-auto"', ob_get_contents());
    $string = str_replace('<input id="author"', '<input class="form-input form-auto" id="author" ', $string);
    $string = str_replace('<input id="email"', '<input class="form-input form-auto" id="email" ', $string);
    $string = str_replace('<input id="url"', '<input class="form-input form-auto" id="url" ', $string);
    $string = str_replace('<input name="submit"', '<input class="btn btn-primary" name="submit" ', $string);
    ob_end_clean();

    // submit
    echo $string;
  } else {
    comment_form($args, $post_id);
  }
}
