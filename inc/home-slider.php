<?php
/* -------------------------------------------------------------------------- */
/*                                 Hero slide                                 */
/* -------------------------------------------------------------------------- */
add_shortcode('heroslider', 'itc_heroslider_sht');

function itc_heroslider_sht()
{
  ob_start();

  if (have_rows('hero_slider', 'option')) { ?>
    <!-- Hero SLider -->
    <div id="heroSlider" class="swiper hero-wrapper h-full">
      <div class="swiper-wrapper">
        <?php
        while (have_rows('hero_slider', 'option')) : the_row();

          if (have_rows('banner', 'option')) :

            while (have_rows('banner', 'option')) :
              the_row();

              // Data Slider
              $bgImage = get_sub_field('imagen', 'option');
              $bgImageMobile = get_sub_field('imagen_movil', 'option');
              $link     = get_sub_field('link', 'option');
        ?>

              <?php
              if (get_row_layout() == 'banner_link') { ?>
                <a href="<?php echo $link; ?>" class="swiper-slide hero-slide">
                  <img class="hidden md:block" src="<?php echo $bgImage; ?>">
                  <img class="block md:hidden" src="<?php echo $bgImageMobile; ?>">
                </a>
              <?php
              } elseif (get_row_layout() == 'banner_titulo_boton') { ?>
                <?php $title = get_sub_field('titulo', 'option'); ?>
                <div class="swiper-slide hero-slide flex items-center">
                  <img class="hidden md:block" src="<?php echo $bgImage; ?>">
                  <img class="block md:hidden" src="<?php echo $bgImageMobile; ?>">
                  <div class="hero-slide__content absolute">
                    <h2 class="hero-slide__title"><?php echo $title; ?></h2>
                    <div class="hero-slide__links elementor-button-wrapper">
                      <?php
                      $link_url = $link['url'];
                      $link_title = $link['title'];
                      $link_target = $link['target'] ? $link['target'] : '_self';
                      ?>
                      <a href="<?php echo esc_url($link_url); ?>" class="elementor-button hero-slide__link" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                    </div>
                  </div>
                </div>
        <?php
              }

            endwhile;

          endif;

        endwhile; ?>
      </div>
    </div>
    <div class="swiper-pagination hero-pagination"></div>

<?php
    $myvariable = ob_get_clean();
    return $myvariable;
  }
}
