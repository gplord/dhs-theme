<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

?>
<div class="col-md-4 edg-grid-item" id="<?php the_ID(); ?>">

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<label class="edg-checkbox-container">
	  <input type="checkbox" class="edg-checkbox" name="<?php the_ID(); ?>" id="<?php the_ID(); ?>">
	  <span class="edg-checkbox-checkmark"></span>
	</label>
	
	<header class="entry-header">
	<?php //echo get_the_post_thumbnail( $post->ID, 'large' ); ?>
	<?php echo get_the_post_thumbnail( $post->ID, 'edg-thumbnail', array( 'class' => 'data-url-test' ) ); ?>

		<a href="<?php echo get_permalink(); ?>">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</a>

		<div class="edg-metadata">
		<?php 
			if (get_field("use_real_name") == true) {
				echo "<p class='edg-metadata-name'>". get_field("first_name") . " " . get_field("last_name");
				echo "</p>\n";
			} else {
				echo "<p class='edg-metadata-name'>".get_field("preferred_name")."</p>\n";
			}			
		?>		
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


	<div class="entry-content">

		<?php //the_content(); ?>
		<?php //the_excerpt(); ?>
		<?php 
			$excerpt = get_the_excerpt();
			$excerpt = str_replace('[...]', '', $excerpt);
			echo "<p class='excerpt'>" . $excerpt . "</p>\n";
		?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->

	<!--<footer class="entry-footer">-->
		<?php //understrap_entry_footer(); ?>
	<!--</footer>--><!-- .entry-footer -->

</article><!-- #post-## -->
</div>
