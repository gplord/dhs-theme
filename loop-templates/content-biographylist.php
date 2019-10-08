<?php

/**
 * Single post partial template.
 *
 * @package understrap
 */

?>
<div class="col biography-grid-item" id="<?php the_ID(); ?>">

	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<div class="row">

			<?php if (has_post_thumbnail()) : ?>
				<div class="col-md-4">
					<a href="<?php echo get_permalink(); ?>">
					<?php echo get_the_post_thumbnail($post->ID, 'edg-thumbnail', array('class' => 'data-url-test')); ?>
					</a>
				</div>
			<?php endif; ?>

			<div class="col-md-8 biography-list-text">
				<a href="<?php echo get_permalink(); ?>">
					<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
				</a>
				<div class="biography-metadata closereadings-metadata">

					<?php
					if (get_field("date_of_birth") == true) {
						echo "<p class='edg-metadata-name'><strong>Dates</strong>: " . get_field("date_of_birth") . " - " . get_field("date_of_death") . "</p>\n";
					}
					if (get_field("place_of_birth") == true) {
						echo "<p class='edg-metadata-name'><strong>Born</strong>: " . get_field("place_of_birth") . "</p>\n";
					}
					?>

				</div>
			</div>
		</div>
	</article><!-- #post-## -->

</div>