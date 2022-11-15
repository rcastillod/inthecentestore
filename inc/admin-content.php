<?php

/* -------------------------------------------------------------------------- */
/*                  Admin content pages                                       */
/* -------------------------------------------------------------------------- */

if (function_exists('acf_add_options_page')) {

  // Ajustes Generales
  acf_add_options_page(array(
    'page_title' => 'Contenidos ITC',
    'menu_title' => 'Contenidos ITC',
    'menu_slug' => "ajustes",
    'capability' => 'edit_posts',
    'redirect' => true,
    'position' => 20,
    'icon_url' => 'dashicons-admin-site'
  ));
  // 01.- Información General
  acf_add_options_sub_page(array(
    'page_title' => 'Información General',
    'menu_title' => 'Información General',
    'parent_slug' => 'ajustes',
  ));
  // 02.- Home Slider
  acf_add_options_sub_page(array(
    'page_title' => 'Home Slider',
    'menu_title' => 'Home Slider',
    'parent_slug' => 'ajustes',
  ));
  // 03.- Home Contenido
  acf_add_options_sub_page(array(
    'page_title' => 'Home Contenido',
    'menu_title' => 'Home Contenido',
    'parent_slug' => 'ajustes',
  ));
}
