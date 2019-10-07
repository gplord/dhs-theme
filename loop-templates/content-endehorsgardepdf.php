<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">
	
		<a href="<?php echo get_permalink(); ?>">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</a>		
		
		<div class="edg-metadata-pdf">
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

		<?php //the_excerpt(); ?>

		<?php 

			$value = get_field( "media_type" );
			$medialink = "";
			$center = false;

			switch ($value) {
				case "image":
					the_post_thumbnail( $post->ID, 'full', array( 'class' => 'img-responsive data-url-test' ) );
					$center = true;
					break;
				case "video":
					$medialink = "<p class='media-label'>Video available at: " . get_field ("media_url") . "</p>\n";
					$center = true;
					break;
				case "audio":
					$medialink = "<p class='media-label'>Audio available at: " . get_field ("media_url") . "</p>\n";
					$center = true;
					break;
				case "interactive":
					$medialink = "<p class='media-label'>Interactive media available at: " . get_field ("media_url") . "</p>\n";
					$center = true;
					break;
				default:
					break;
			}

		?>
		
		<?php
			if ($center) echo "<div class='center'>\n";

			the_content();

			if ($medialink != "") echo $medialink;
			
			if ($center) echo "</div>\n";
		?>

		<?php
		//wp_link_pages( array(
		//	'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
		//	'after'  => '</div>',
		//) );
		?>

	</div><!-- .entry-content -->

	<!--<footer class="entry-footer">-->

		<?php //understrap_entry_footer(); ?>

	<!--</footer>--><!-- .entry-footer -->
	
	<hr>

</article>
