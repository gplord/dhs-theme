<?php
/**
 * Template Name: Essay Section Page
 *
 * Template for displaying an Essay/Chapter page
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
  								'child_of' => $post->post_parent,
								'sort_column' => 'menu_order'
							));

							$pagecount = count($pages);		// Count the total number of pages returned
							$thispage = 1;					// Keep a counter of which page we're on
							$drawnextbutton = false;		// Assume last page unless we find otherwise
							$nextpagetitle = '';			// Values to be stored during the loop, if we need a next button
							$nextpagelink = '';				
							$nextpagestored = false;		
							if ($pagecount > 1) {
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
								for ($i = 0; $i < count($pages); $i++) {
									if ($pages[$i]->ID == $post->ID) {
										if ($i+1 < count($pages)) {
											$drawnextbutton = true;
											$nextpagetitle = $pages[$i+1]->post_title;
											$nextpagelink = get_page_link($pages[$i+1]);
										}
										echo "<li>" . $pages[$i]->post_title . "</li>\n";
									} else {
										echo "<li><a href='" . get_page_link( $pages[$i]->ID) . "'>" . $pages[$i]->post_title . "</a></li>\n";
									}
								}
									echo "</ul>\n";
									echo "</div>\n";	// Close first column
									echo "<div class='col-md-6 text-right'>\n";
									if ($drawnextbutton) {
										echo "<p><a class='btn btn-primary' href='" . $nextpagelink . "'>Next Section &raquo;</a></p>\n";
									} else {
										echo "<p><a class='btn btn-primary' href='" . get_page_link($post->post_parent) . "'>&laquo; Back to Chapter</a></p>\n";
										$parent = $post->post_parent;
										$parent_get = get_post($parent);
										if ($parent_get != null) {
											$grandparent = $parent_get->post_parent;
											echo "<p><a class='btn btn-primary' href='" . get_page_link($grandparent) . "'>&laquo; Table of Contents</a></p>\n";
										}
									}
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
