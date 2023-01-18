<?php
/* -------------------------------------------------------------------------- */
/*                   Featured home product                                    */
/* -------------------------------------------------------------------------- */
add_shortcode('featured-home-product', 'itc_featured_product_sht');

function itc_featured_product_sht()
{
  ob_start();

  $productId = get_field('featured_home_product', 'option');
  $product = wc_get_product($productId->ID);
  $image = get_the_post_thumbnail($productId->ID, 'home-featured-product');
  $title = get_the_title($productId->ID);
  $description = $product->get_description();
  $permalink = get_permalink($productId->ID);
  $cat_id = get_cat_ID(wc_get_product_category_list($productId->ID));
  $cat_url = get_category_link($cat_id);
?>

  <div class="featured-product flex flex-col md:flex-row md:items-center lg:gap-8 xl:gap-20 pb-12 md:pb-0 pl-10 md:pl-0">
    <div class="featured-product__image -mt-14 mr-14 mb-14">
      <a href="<?php echo $permalink; ?>">
        <?php echo $image; ?>
      </a>
    </div>
    <div class="featured-product__content">
      <h6 class="featured-product__category"><a href="<?php echo $cat_url; ?>"><?php echo wc_get_product_category_list($productId->ID); ?></a></h6>
      <h2 class="featured-product__title"><?php echo $title; ?></h2>
      <div class="featured-product__description mb-10">
        <?php echo $description; ?>
      </div>
      <div class="elementor-button-wrapper">
        <a href="<?php echo $permalink; ?>" class="elementor-button-link elementor-button elementor-size-sm">Ver Más</a>
      </div>
    </div>
  </div>

<?php

  $myvariable = ob_get_clean();
  return $myvariable;
}
