<?php
/**
 * Edgebird functions and definitions
 *
 * @package Edgebird
 * @since Edgebird 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Edgebird 1.0
 */
if ( ! isset( $content_width ) )
    $content_width = 700; /* pixels */


if ( ! function_exists( 'edgebird_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Edgebird 1.0
 */
function edgebird_setup() {
 
    /**
     * Custom template tags for this theme.
     */
    require( get_template_directory() . '/inc/template-tags.php' );
 
    /**
     * Custom functions that act independently of the theme templates
     */
    require( get_template_directory() . '/inc/tweaks.php' );
 
    /**
     * Make theme available for translation
     * Translations can be filed in the /languages/ directory
     * If you're building a theme based on Edgebird, use a find and replace
     * to change 'edgebird' to the name of your theme in all the template files
     */
    load_theme_textdomain( 'edgebird', get_template_directory() . '/languages' );
 
    /**
     * Add default posts and comments RSS feed links to head
     */
    add_theme_support( 'automatic-feed-links' );

    /**
    * Add support for featured images
    */
    add_theme_support( 'post-thumbnails' ); 

    /**
     * Enable support for Post Formats
     */
     add_theme_support( 'structured-post-formats', array(
        'video'
    ) );

    add_theme_support( 'post-formats', array(
     'aside', 'audio', 'chat', 'quote'
    ) );
 
    /**
     * This theme uses wp_nav_menu() in one location.
     */
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'edgebird' ),
    ) );
}
endif; // edgebird_setup()

add_action( 'after_setup_theme', 'edgebird_setup' );


/**
* Hide the "stick Post"-option in the admin menu
*
* @since Edgebird 1.0
*/
function edgebird_hide_sticky_option() {
    global $post_type, $pagenow;
    if( 'post.php' != $pagenow && 'post-new.php' != $pagenow && 'edit.php' != $pagenow )
        return; 
        ?>
        <style type="text/css">#sticky-span { display:none!important }
            .quick-edit-row .inline-edit-col-right div.inline-edit-col > :last-child > label.alignleft:last-child{ display:none!important; }</style>
        <?php
}

add_action( 'admin_print_styles', 'edgebird_hide_sticky_option' );
update_option( 'sticky_posts', array() );


/**
 * Enqueue scripts and styles
 *
 * @since Edgebird 1.0
 */
function edgebird_scripts() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );
 
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
 
    wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery.js');
    wp_enqueue_script( 'transition', get_template_directory_uri() . '/js/transition.js');
    wp_enqueue_script( 'zoom', get_template_directory_uri() . '/js/zoom.js');
    wp_enqueue_script( 'script', get_template_directory_uri() . '/js/script.js');
}
add_action( 'wp_enqueue_scripts', 'edgebird_scripts' );



function edgebird_customize_register( $wp_customize ) {

    $wp_customize->add_section( 'edgebird_general_options' , array(
        'title'      => __( 'Visible Section Name', 'edgebird' ),
        'priority'   => 30,
    ) );

    $wp_customize->add_setting( 'header_textcolor' , array(
        'default'     => '#000000',
        'transport'   => 'refresh',
    ) );

}
add_action( 'customize_register', 'edgebird_customize_register' );







