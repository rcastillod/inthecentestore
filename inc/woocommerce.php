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
 * Redirect to home after login
 */
add_filter('woocommerce_login_redirect', 'itc_login_redirect_to_homepage');

function itc_login_redirect_to_homepage($redirect_to)
{

  return home_url();
}

/**
 * Redirect to edit account
 */
add_action('template_redirect', 'itc_my_account_redirect_to_account_data');

function itc_my_account_redirect_to_account_data()
{
  if (is_account_page() && empty(WC()->query->get_current_endpoint())) {
    wp_safe_redirect(wc_get_account_endpoint_url('edit-account'));
    exit;
  }
}

/**
 * Remove my account tabs
 */
add_filter('woocommerce_account_menu_items', 'itc_remove_my_account_tabs');
function itc_remove_my_account_tabs($menu_links)
{

  unset($menu_links['dashboard']); // Disable Dashboard
  unset($menu_links['downloads']); // Disable Downloads

  return $menu_links;
}

/**
 * Rename my account tabs
 */

add_filter('woocommerce_account_menu_items', 'itc_rename_my_account_tabs');

function itc_rename_my_account_tabs($menu_links)
{

  $menu_links['edit-account'] = 'Datos personales';
  $menu_links['orders'] = 'Mis compras';

  return $menu_links;
}

/**
 * Reorder my account tabs
 */

add_filter('woocommerce_account_menu_items', 'itc_my_account_menu_links_reorder');

function itc_my_account_menu_links_reorder($menu_links)
{

  return array(
    'edit-account' => __('Account details', 'woocommerce'),
    'orders' => __('Orders', 'woocommerce'),
    'edit-address' => __('Addresses', 'woocommerce'),
    'customer-logout' => __('Logout', 'woocommerce')
  );
}

/**
 * Add fields to registration form
 */

// add first and last name
add_action('woocommerce_register_form_start', 'itc_add_register_form_field_first_last_name');

function itc_add_register_form_field_first_last_name()
{
?>

  <p class="form-row form-row-first validate-required">
    <label for="reg_billing_first_name"><?php _e('First name', 'woocommerce'); ?> <span class="required">*</span></label>
    <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if (!empty($_POST['billing_first_name'])) esc_attr_e($_POST['billing_first_name']); ?>" />
  </p>

  <p class="form-row form-row-last validate-required">
    <label for="reg_billing_last_name"><?php _e('Last name', 'woocommerce'); ?> <span class="required">*</span></label>
    <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if (!empty($_POST['billing_last_name'])) esc_attr_e($_POST['billing_last_name']); ?>" />
  </p>

  <div class="clear"></div>

<?php
}

// validate fields
add_filter('woocommerce_registration_errors', 'itc_validate_register_form_field_first_last_name', 10, 3);

function itc_validate_register_form_field_first_last_name($errors, $username, $email)
{
  if (isset($_POST['billing_first_name']) && empty($_POST['billing_first_name'])) {
    $errors->add('billing_first_name_error', __('<strong>Error</strong>: First name is required!', 'woocommerce'));
  }
  if (isset($_POST['billing_last_name']) && empty($_POST['billing_last_name'])) {
    $errors->add('billing_last_name_error', __('<strong>Error</strong>: Last name is required!.', 'woocommerce'));
  }
  return $errors;
}

// save to database
add_action('woocommerce_created_customer', 'itc_save_register_form_field_first_last_name');

function itc_save_register_form_field_first_last_name($customer_id)
{
  if (isset($_POST['billing_first_name'])) {
    update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
    update_user_meta($customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']));
  }
  if (isset($_POST['billing_last_name'])) {
    update_user_meta($customer_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
    update_user_meta($customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']));
  }
}

// add phone field
add_action('woocommerce_register_form_start', 'itc_add_register_form_field_phone');
function itc_add_register_form_field_phone()
{

  woocommerce_form_field(
    'phone_number',
    array(
      'type'        => 'tel',
      'required'    => true, // just adds an "*"
      'label'       => 'Teléfono'
    ),
    (isset($_POST['phone_number']) ? $_POST['phone_number'] : '')
  );
}

// save to database
add_action('woocommerce_created_customer', 'itc_save_register_fields_phone');
function itc_save_register_fields_phone($customer_id)
{

  if (isset($_POST['phone_number'])) {
    update_user_meta($customer_id, 'phone_number', wc_clean($_POST['phone_number']));
  }
}


/**
 * Init plugin
 **/
add_action('init', 'itc_init', 100);
function itc_init()
{

  // Add shipping methods filters
  $shipping_methods = WC()->shipping->get_shipping_methods();
  foreach ($shipping_methods as $id => $shipping_method) {
    add_filter("woocommerce_shipping_instance_form_fields_$id", 'itc_add_form_fields');
  }
}

/**
 * Add description field to shipping method form
 */
function itc_add_form_fields($fields)
{
  // Create description field
  $new_fields = array(
    'description' => array(
      'title'   => __('Description', 'itc'),
      'type'    => 'textarea',
      'default' => null,
    ),
  );
  // Insert it after title field
  $keys  = array_keys($fields);
  $index = array_search('title', $keys, true);
  $pos   = false === $index ? count($fields) : $index + 1;
  return array_merge(array_slice($fields, 0, $pos), $new_fields, array_slice($fields, $pos));
}

/**
 * Load description as metadata
 */
add_filter('woocommerce_shipping_method_add_rate_args', 'itc_add_rate_description_arg', 10, 2);
function itc_add_rate_description_arg($args, $method)
{
  $args['meta_data']['description'] = htmlentities($method->get_option('description'));
  return $args;
}

/**
 * Display description field after method label
 */
add_action('woocommerce_after_shipping_rate', 'itc_output_shipping_rate_description', 10);
function itc_output_shipping_rate_description($method)
{
  $meta_data = $method->get_meta_data();
  if (array_key_exists('description', $meta_data)) {
    $description = apply_filters('itc_description_output', html_entity_decode($meta_data['description']), $method);
    $html        = '<div class="shipping_method_description"><small class="itc">' . wp_kses($description, wp_kses_allowed_html('post')) . '</small></div>';
    echo apply_filters('itc_description_output_html', $html, $description, $method);
  }
}

/**
 * Add new custom checkout fields
 */

function add_checkout_field($fields)
{
  $fields['billing']['billing_rut'] = array(
    'type' => 'text',
    'label' => __('RUT', 'woocommerce'),
    'required' => true,
    'class' => array('form-row-wide'),
    'priority' => 30,
  );
  return $fields;
}
add_filter('woocommerce_checkout_fields', 'add_checkout_field');

// save fields to order meta
add_action('woocommerce_checkout_update_order_meta', 'itc_save_custom_fields');
function itc_save_custom_fields($order_id)
{
  if (!empty($_POST['billing_rut']))
    update_post_meta($order_id, 'billing_rut', sanitize_text_field($_POST['billing_rut']));
}

/**
 * Validate new custom checkout fields
 */
add_action('woocommerce_checkout_process', 'itc_validate_custom_fields');

function itc_validate_custom_fields()
{
  if (empty($_POST['billing_rut']))
    wc_add_notice('El RUT es obligatorio.', 'error');
}

/**
 * Send the billing_rut to order email
 */
add_filter('woocommerce_email_order_meta_fields', 'custom_woocommerce_email_order_meta_fields', 10, 3);

function custom_woocommerce_email_order_meta_fields($fields, $sent_to_admin, $order)
{
  $fields['billing_rut'] = array(
    'label' => __('RUT'),
    'value' => get_post_meta($order->id, 'billing_rut', true),
  );
  return $fields;
}

/**
 * Show rut field in order detail admin screen
 */

add_action('woocommerce_admin_order_data_after_billing_address', 'itc_custom_order_meta_rut_field');
function itc_custom_order_meta_rut_field($order)
{
  /* Get rut field */
  $rut = $order->get_meta('billing_rut');
?>
  <div class="rut">
    <p>
      <strong>RUT: </strong><?php echo $rut; ?></br>
    </p>
  </div>
<?php
}


add_action('woocommerce_edit_account_form', 'add_rut_account_details', 10, 1);
function add_rut_account_details()
{
  $user = wp_get_current_user();
?>
  <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="billing_rut"><?php esc_html_e('RUT', 'itcstore'); ?></label>
    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_rut" id="billing_rut" value="<?php echo esc_attr($user->billing_rut); ?>" />
  </p>
<?php
}

add_action('woocommerce_save_account_details', 'save_rut_account_details', 10, 1);
function save_rut_account_details($user_id)
{
  if (isset($_POST['billing_rut'])) {
    update_user_meta($user_id, 'billing_rut', sanitize_text_field($_POST['billing_rut']));
  }
}

// Hide out of stock product on loop
add_filter('woocommerce_shortcode_products_query', function ($query_args, $atts, $loop) {

  if ($atts['class'] == 'outofstock') {
    $query_args['meta_query'] = array(array(
      'key'     => '_stock_status',
      'value'   => 'outofstock',
      'compare' => 'NOT LIKE',
    ));
  }


  return $query_args;
}, 10, 3);


/**
 * Hide the "Shipping to.." text in cart
 */
add_filter('gettext', 'itc_translate_shippingto', 9999, 3);

function itc_translate_shippingto($translated, $untranslated, $domain)
{
  if (!is_admin() && 'woocommerce' === $domain) {
    switch ($translated) {
      case 'Shipping to %s.':
        $translated = '';
        break;
    }
  }
  return $translated;
}

add_action('woocommerce_before_cart', 'itc_hide_shippingto');

function itc_hide_shippingto()
{
  echo '<style>.woocommerce-shipping-destination{display:none}</style>';
}
