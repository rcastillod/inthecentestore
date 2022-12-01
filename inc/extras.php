<?php

// Add new image size
add_image_size('home-featured-product', 490, 690); // Featured home product

// Disable dashicons
add_action('wp_enqueue_scripts', 'aiooc_crunchify_dequeue_dashicon');
function aiooc_crunchify_dequeue_dashicon()
{
  if (current_user_can('update_core')) {
    return;
  }
  wp_deregister_style('dashicons');
}
