<?php

/**
 * Single post partial template.
 *
 * @package understrap
 */

?>
<div class="col edg-grid-item" id="<?php the_ID(); ?>">

	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<div class="row">

			<?php if (has_post_thumbnail()) : ?>
				<div class="col-md-4">
					<a href="<?php echo get_permalink(); ?>">
					<?php echo get_the_post_thumbnail($post->ID, 'edg-thumbnail', array('class' => 'data-url-test')); ?>
					</a>
				</div>
			<?php endif; ?>

			<div class="col-md-8 closereadings-list-text">
				<a href="<?php echo get_permalink(); ?>">
					<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
				</a>
				<div class="edg-metadata closereadings-metadata">
					<?php
					if (get_field("cr_left_text_author") == true) {
						echo "<p class='edg-metadata-name'><strong>Left Text Author</strong>: " . get_field("cr_left_text_author") . "</p>\n";
					}
					if (get_field("cr_right_text_title") == true) {
						echo "<p class='edg-metadata-name'><strong>Right Text Title</strong>: " . get_field("cr_right_text_title") . "</p>\n";
					}
					if (get_field("cr_right_text_author") == true) {
						echo "<p class='edg-metadata-name'><strong>Right Text Author</strong>: " . get_field("cr_right_text_author") . "</p>\n";
					}
					?>
				</div>
			</div>
		</div>
	</article>

</div>