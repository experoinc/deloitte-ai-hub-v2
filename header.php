<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width">

  <?php wp_head(); ?>
</head>

<body <?php body_class('bg-white text-gray-900 antialiased font-sans'); ?>>
  <div id="page" class="min-h-screen flex flex-col">

    <div id="content" class="site-content flex-grow">
      <main>
        <html>

        <head>
          <meta name="viewport" content="width=device-width">
          <?php wp_head(); ?>
        </head>

        <body <?php body_class('bg-gray-100 font-sans text-gray-900 antialiased'); ?>>
