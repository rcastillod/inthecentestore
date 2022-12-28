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


add_action('wp_enqueue_scripts', 'itc_move_jquery_to_footer');

function itc_move_jquery_to_footer()
{
  // unregister the jQuery at first
  wp_deregister_script('jquery');

  // register to footer (the last function argument should be true)
  wp_register_script('jquery', includes_url('/js/jquery/jquery.js'), false, null, true);

  wp_enqueue_script('jquery');
}

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
