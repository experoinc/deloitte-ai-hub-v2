<article id="post-<?php the_ID(); ?>">
	<?php if (is_search() || is_archive()) : ?>
		<div class="ml-6 mr-4 pb-7 flex lg:border-b lg:border-gray-400 mt-6 lg:mt-0 justify-center lg:justify-between flex-col">
			<?php if (have_posts()) :
				while (have_posts()) : the_post();
					echo '<li class="wp-block-post-template min-w-[400px] search-item shadow-none">';
					the_title('<h2 class="text-lg font-semibold wp-block-post-title">', '</h2>', true);
					echo '<div class="wp-block-post-excerpt__excerpt">';
					the_excerpt();
					echo '</div>
			</li>
		  ';
				endwhile;
			endif; ?>
		</div>
	<?php else : ?>

		<div class="relative">
			<?php
			/* translators: %s: Name of current post */
			the_content(
				sprintf(
					__('Continue reading %s', 'deloitte ai'),
					the_title('<span class="screen-reader-text">"', '"</span>', false)
				)
			);
			?>
		</div>

	<?php endif; ?>
</article>