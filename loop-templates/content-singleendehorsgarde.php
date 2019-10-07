<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<div class="entry-meta">
		
			<?php
				echo "<p>";
				if (get_field("use_real_name") == true) {
					echo "by: ". get_field("first_name") . " " . get_field("last_name");
				} else {
					echo "by: " . get_field("preferred_name");
				}
				if (get_field("institutional_affiliation")) {
					echo "<br>". get_field("institutional_affiliation");
				} 
				if (get_field("occupation")) {
					echo "<br>".get_field("occupation");
				}
				if (get_field("additional_authors") != "") {
				    echo "<br>& " . get_field("additional_authors");
			    }
				echo "</p>\n";
			?>
			<?php //understrap_posted_on(); ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<?php 
		$value = get_field( "media_type" );
		if ($value == "image") {
			echo get_the_post_thumbnail( $post->ID, 'large' ); 
		}
	?>

	<div class="entry-content">

		<?php the_content(); ?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php //understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
