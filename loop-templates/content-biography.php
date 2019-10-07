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
		<div class="col-md-4">
			<?php echo get_the_post_thumbnail( $post->ID, 'edg-thumbnail', array( 'class' => 'data-url-test' ) ); ?>
		</div>
		<div class="col-md-8">
			<a href="<?php echo get_permalink(); ?>">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</a>
			<div class="biography-metadata closereadings-metadata">
				
				<?php
					if (get_field("date_of_birth") == true) {
						echo "<p class='edg-metadata-name'><strong>Dates</strong>: ". get_field("date_of_birth") . " - " . get_field("date_of_death") . "</p>\n";
					}
					if (get_field("place_of_birth") == true) {
						echo "<p class='edg-metadata-name'><strong>Born</strong>: ". get_field("place_of_birth") . "</p>\n";
					}	
					if (get_field("secondary_text_author") == true) {
						echo "<p class='edg-metadata-name'><strong>Secondary Text Author</strong>: ". get_field("secondary_text_author") . "</p>\n";
					}	
				?>
				
				<?php 
					$excerpt = get_the_excerpt();
					$excerpt = str_replace('[...]', '', $excerpt);
					echo "<p class='excerpt'>" . $excerpt . "</p>\n";
				?>

			</div>
		</div>
	</div>
</article>
	
	<header class="entry-header">
	<?php //echo get_the_post_thumbnail( $post->ID, 'large' ); ?>


		<div class="edg-metadata">
		<?php 
			if (get_field("institutional_affiliation")) {
				echo "<p class='edg-metadata-institution'>". get_field("institutional_affiliation") . "</p>\n";
			} 
			if (get_field("occupation")) {
				echo "<p class='edg-metadata-occupation'>".get_field("occupation")."</p>\n";
			}
			
			if (get_field("additional_authors") != "") {
			    echo "<p class='edg-metadata-name'>";
				echo "& " . get_field("additional_authors");
				echo"</p>\n";
			}
			
		?>
		</div>

		<div class="entry-meta">

			<?php //understrap_posted_on(); ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

</article><!-- #post-## -->
</div>