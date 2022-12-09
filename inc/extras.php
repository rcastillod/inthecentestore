<?php

// Disable dashicons
add_action('wp_enqueue_scripts', 'aiooc_crunchify_dequeue_dashicon');
function aiooc_crunchify_dequeue_dashicon()
{
  if (current_user_can('update_core')) {
    return;
  }
  wp_deregister_style('dashicons');
}
