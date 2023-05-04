<?php

/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define('CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0');

/**
 * Enqueue styles
 */
function child_enqueue_styles()
{
  /** ITC theme style */
  wp_enqueue_style('itc-css', get_stylesheet_directory_uri() . '/dist/css/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all');
  /** Swiper style */
  wp_enqueue_style('swiper-css', get_stylesheet_directory_uri() . '/dist/css/external/external.css', '', CHILD_THEME_ASTRA_CHILD_VERSION, 'all');

  /** Swiper scripts */
  wp_enqueue_script('swiper-js', get_stylesheet_directory_uri() . '/dist/js/external/external.js', '', '8.4.4', true);
  /** ITC scripts */
  wp_enqueue_script('itc-scripts', get_stylesheet_directory_uri() . '/dist/js/scripts.js', '', '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'child_enqueue_styles', 15);


/**
 * Add facebook domain verification meta tag
 */
function custom_header_metadata()
{
?>
  <meta name="facebook-domain-verification" content="d3h85pnvau3luzacgqlqg6pkmb5c8j" />
<?php

}
add_action('wp_head', 'custom_header_metadata');
