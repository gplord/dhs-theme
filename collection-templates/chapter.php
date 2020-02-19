<?php
/**
 * Template Name: Chapter
 * Template Post Type: dhs_collection
 * Template for displaying a section page. (Chapters are the children of Collections)
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

$id = get_the_ID();
$args = array(
	'post_type'      => 'dhs_collection',
	'posts_per_page' => -1,
	'post_parent'    => $id,
	'order'          => 'ASC',
	'orderby'        => 'menu_order'
);
$parent = new WP_Query( $args );

if ( $parent->have_posts() ) : 

?>

<div class="pt-cv-wrapper">

<?php

$toc = $parent->post_parent;
$toc_get = get_post($toc);
if ($toc_get != null) {
	$grandparent = $toc_get->post_parent;
	echo "<p><a class='btn btn-primary' href='" . get_the_permalink($grandparent) . "'>&laquo; Table of Contents</a></p>\n";
}

?>


<div class="row">

<?php 									
while ( $parent->have_posts() ) : $parent->the_post();
?>
<div class="col-md-4">

	<div class="card collection-card">

		<div class="card-body collection-content">
			<?php
				echo "<a href='" . get_the_permalink() . "'>";
				echo get_the_post_thumbnail( $parent->ID, array(200,200));
				echo "</a>";
			?>
		</div>
		<div class="card-footer">
			<?php
				echo "<p><a href='" . get_the_permalink() . "'>" . get_the_title() . "</a></p>\n";
			?>
		</div>
	</div>

</div>

<?php endwhile; ?>

</div>
</div>


<?
endif; 
wp_reset_postdata();
?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template.
						//if ( comments_open() || get_comments_number() ) :

							//comments_template();

						//endif;
						?>

					<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row end -->

	</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>