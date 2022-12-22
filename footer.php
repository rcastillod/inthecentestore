<?php

/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Astra
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

?>
<?php astra_content_bottom(); ?>
</div> <!-- ast-container -->
</div><!-- #content -->
<?php
astra_content_after();

astra_footer_before();

astra_footer();

astra_footer_after();
?>
</div><!-- #page -->
<?php
astra_body_bottom();
wp_footer();
?>
<?php if (get_field('activar_flotante_whatsapp', 'option')) : ?>
  <!-- Whatsapp Link -->
  <a href="<?php echo the_field('link_telefono', 'option'); ?>" class="whatsapp-link" target="_blank">
    <img src="<?php echo get_stylesheet_directory_uri() ?>/dist/img/whatsapp-icon.svg" width="20" alt="Whatsapp Icon">
    <span>Contáctanos</span>
  </a>
<?php endif; ?>
</body>

</html>