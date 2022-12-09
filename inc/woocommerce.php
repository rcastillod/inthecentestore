<?php

/**
 * Remove Checkout Fields
 */
add_filter('woocommerce_checkout_fields', 'itc_remove_fields', 9999);

function itc_remove_fields($woo_checkout_fields_array)
{

  unset($woo_checkout_fields_array['billing']['billing_company']); // remove company field
  unset($woo_checkout_fields_array['billing']['billing_postcode']); // remove postcode field

  return $woo_checkout_fields_array;
}

/**
 * Reorder Checkout Fields
 */

add_filter('woocommerce_checkout_fields', 'itc_reorder_chechout_fields', 9999);

function itc_reorder_chechout_fields($checkout_fields)
{
  $checkout_fields['billing']['billing_state']['priority'] = 50;
  $checkout_fields['billing']['billing_city']['priority'] = 60;
  $checkout_fields['billing']['billing_address_1']['priority'] = 70;
  $checkout_fields['billing']['billing_address_2']['priority'] = 80;

  return $checkout_fields;
}

/**
 * Change billing_address_1 & billing_address_2 placeholder
 */
add_filter('woocommerce_default_address_fields', 'itc_override_default_checkout_fields', 10, 1);
function itc_override_default_checkout_fields($address_fields)
{
  $address_fields['address_1']['placeholder'] = __('Nombre de la calle', 'woocommerce');
  $address_fields['address_2']['placeholder'] = __('Número de la casa', 'woocommerce');

  $address_fields['city']['label'] = __('Comuna', 'woocommerce');

  return $address_fields;
}

/**
 * Show only one error in checkout
 */
add_action('woocommerce_after_checkout_validation', 'itc_one_error', 9999, 2);

function itc_one_error($fields, $errors)
{

  // if any validation errors
  if (!empty($errors->get_error_codes())) {

    // remove all of them
    foreach ($errors->get_error_codes() as $code) {
      $errors->remove($code);
    }

    // add our custom one
    $errors->add('validation', 'Por favor ingresa todos los campos requeridos!');
  }
}

add_action('woocommerce_before_add_to_cart_form', 'ta_the_content');

function ta_the_content()
{
  echo '<div class="product_description">';
  echo the_content();
  echo '</div>';
}

/**
 * Remove my account tabs
 */
add_filter('woocommerce_account_menu_items', 'itc_remove_my_account_tabs');
function itc_remove_my_account_tabs($menu_links)
{

  unset($menu_links['downloads']); // Disable Downloads

  return $menu_links;
}
