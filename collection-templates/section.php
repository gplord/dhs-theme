<?php
/**
 * Template Name: Section
 * Template Post Type: dhs_collection
 * Template for displaying a section page. (Sections are the children of Chapters, grandchildren of Collections)
 * 
 * @package understrap
 */

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="full-width-page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content">

		<div class="row justify-content-md-center">

			<div class="col-md-9 content-area" id="primary">

				<main class="site-main" id="main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'loop-templates/content', 'page' ); ?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template.
						//if ( comments_open() || get_comments_number() ) :

							//comments_template();

						//endif;
						?>

						<hr>

						<?php
							$pages = get_pages( array(
								'post_type' => 'dhs_collection',
  								'child_of' => $post->post_parent,
								'sort_column' => 'menu_order'
							));

							$pagecount = count($pages);		// Count the total number of pages returned
							$thispage = 1;					// Keep a counter of which page we're on
							$drawnextbutton = false;		// Assume last page unless we find otherwise
							$nextpagelink = '';				// Store link to next page
							$drawprevbutton = false;		// If we're past the first page in a list, draw a previous button
							$prevpagelink = '';				// Store link to previous page
							$nextpagestored = false;		
							if ($pagecount > 1) {
								echo "<div class='row chapter-toc'>\n";
									echo "<div class='col-md-6'>\n";

									echo "<p><a class='btn btn-primary' href='" . get_the_permalink($post->post_parent) . "'>&laquo; Back to Chapter</a>\n";
									$parent = $post->post_parent;
									$parent_get = get_post($parent);
									if ($parent_get != null) {
										$grandparent = $parent_get->post_parent;
										echo " <a class='btn btn-primary' href='" . get_the_permalink($grandparent) . "'>&laquo; Table of Contents</a>\n";
									}
									echo "</p>\n";

									echo "</div>\n";
									echo "<div class='col-md-6 text-right'>\n";

									for ($i = 0; $i < $pagecount; $i++) {
										if ($pages[$i]->ID == $post->ID) {
											if ($i+1 < $pagecount) {
												$drawnextbutton = true;
												$nextpagelink = get_page_link($pages[$i+1]);
											}
											if ($i > 0) {
												$drawprevbutton = true;
												$prevpagelink = get_page_link($pages[$i-1]);
											}
										}
									}
									if ($drawprevbutton) {
										echo "<a class='btn btn-primary' href='" . $prevpagelink . "'>&laquo; Previous Section</a>\n";
									}
									if ($drawnextbutton) {
										echo "<a class='btn btn-primary' href='" . $nextpagelink . "'>Next Section &raquo;</a>\n";
									}

									echo "</div>\n";
								echo "</div>\n";
								echo "<div class='row chapter-toc'>\n";
								echo "<div class='col-md-6'>\n";
								echo "<p>Sections in this chapter:</p>\n";
								echo "<ul>\n";
/*								foreach ( $pages as $page ) {
									if ($page->ID == $post->ID) {		// Found the current page
										echo "<li>" . $page->post_title . "</li>\n";
										if ($thispage < $pagecount) {
											$drawnextbutton = true;
										}
									} else {
										echo "<li><a href='" . get_page_link( $page->ID ) . "'>" . $page->post_title . "</a></li>\n";
									}
									$thispage++;
								}
								*/
								for ($i = 0; $i < $pagecount; $i++) {
									if ($pages[$i]->ID == $post->ID) {
										echo "<li>" . $pages[$i]->post_title . "</li>\n";
									} else {
										echo "<li><a href='" . get_page_link( $pages[$i]->ID) . "'>" . $pages[$i]->post_title . "</a></li>\n";
									}
								}
								echo "</ul>\n";
								echo "</div>\n";	// Close first column
								echo "<div class='col-md-6 text-right'>\n";
								echo "</div>\n";	// Close second column
								echo "</div>\n";
							}
						?>

					<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row end -->

	</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
