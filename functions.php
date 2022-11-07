<?php

function rjs_styles()
{
  wp_enqueue_script("jquery");
  wp_enqueue_style('tailwindcss', get_template_directory_uri() . '/css/tailwind.prod.css', array(), filemtime(get_template_directory() . '/css/tailwind.prod.css'), 'all');
  wp_enqueue_script('ai-script', get_template_directory_uri() . '/js/app.prod.js', array(), filemtime(get_template_directory() . '/js/app.prod.js'), 'all');

  wp_localize_script('ai-script', 'ajax_args', array(
    'postsUrl' => 'index.php/wp-json/wp/v2/posts',
    'categoriesUrl' => 'index.php/wp-json/wp/v2/categories',
    'tagsUrl' => 'index.php/wp-json/wp/v2/tags',
    'noposts' => __('No older posts found', 'twentyfifteen'),
  ));
}

//Load the files, hook them into the enqueue scripts
add_action('wp_enqueue_scripts', 'rjs_styles');

function register_my_menus()
{
  register_nav_menus(
    array(
      'header-menu' => __('Header Menu'),
      'extra-menu' => __('Extra Menu')
    )
  );
}
add_action('init', 'register_my_menus');
