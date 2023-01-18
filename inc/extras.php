<?php

// Allow safe svg upload
function enable_svg_upload($upload_mimes)
{
  $upload_mimes['svg'] = 'image/svg+xml';
  $upload_mimes['svgz'] = 'image/svg+xml';
  return $upload_mimes;
}
add_filter('upload_mimes', 'enable_svg_upload', 10, 1);

// Disable dashicons
add_action('wp_enqueue_scripts', 'aiooc_crunchify_dequeue_dashicon');
function aiooc_crunchify_dequeue_dashicon()
{
  if (current_user_can('update_core')) {
    return;
  }
  wp_deregister_style('dashicons');
}

// Disable the emoji's
function disable_emojis()
{
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

  // Remove from TinyMCE
  add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}
add_action('init', 'disable_emojis');

/**
 * Filter out the tinymce emoji plugin.
 */
function disable_emojis_tinymce($plugins)
{
  if (is_array($plugins)) {
    return array_diff($plugins, array('wpemoji'));
  } else {
    return array();
  }
}

// Show contact form after submit
function wpf_dev_frontend_output_success($form_data, $fields, $entry_id)
{

  // Optional, you can limit to specific forms. Below, we restrict output to form #235.
  if (absint($form_data['id']) !== 13) {
    return;
  }
  // Reset the fields to blank
  unset(
    $_GET['wpforms_return'],
    $_POST['wpforms']['id']
  );

  // Uncomment this line out if you want to clear the form field values after submission
  unset($_POST['wpforms']['fields']);

  // Actually render the form.
  wpforms()->frontend->output($form_data['id']);
}

add_action('wpforms_frontend_output_success', 'wpf_dev_frontend_output_success', 10, 3);
