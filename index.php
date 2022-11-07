<?php get_header(); ?>

<div class="container mx-auto p-0">
  <?php get_template_part( 'template-parts/content', get_post_format() ); ?>
</div>

<?php
get_footer();
