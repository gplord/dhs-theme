<?php

/**
 * Template Name: Book (Table of Contents)
 * Template Post Type: dhs_collection
 * Template for displaying a Collection page. (Collections are top-level pages, used as Table of Contents)
 * 
 * @package understrap
 */

get_header();
$container = get_theme_mod('understrap_container_type');
?>

<div class="wrapper" id="full-width-page-wrapper">

	<div class="<?php echo esc_attr($container); ?>" id="content">

		<div class="row justify-content-md-center">

			<div class="col-md-12 content-area" id="primary">

				<main class="site-main" id="main" role="main">

					<?php while (have_posts()) : the_post(); ?>

						<?php get_template_part('loop-templates/content', 'page'); ?>

						<?php

							$id = get_the_ID();
							$args = array(
								'post_type'      => 'dhs_collection',
								'posts_per_page' => -1,
								'post_parent'    => $id,
								'order'          => 'ASC',
								'orderby'        => 'menu_order'
							);
							$parent = new WP_Query($args);

							if ($parent->have_posts()) :

								?>

							<div class="pt-cv-wrapper">

								<h4>Chapters</h4>

								<div class="row">

									<?php
											while ($parent->have_posts()) : $parent->the_post();
												?>
										<div class="col-md-3">

											<div class="card biography-card">

												<div class="card-body biography-content">
													<?php
																echo "<a href='" . get_the_permalink() . "'>";
																echo get_the_post_thumbnail($parent->ID, array(200, 200));
																echo "</a>";
																?>
												</div>
												<div class="card-footer">
													<?php
																echo "<p><a href='" . get_the_permalink() . "'>" . get_the_title() . "</a></p>\n";
																if (get_field('dhs_peer_reviewed')) {
																	echo '<a class="btn btn-primary linkbutton peer-review-button" href="#">Peer Reviewed</a>';
																}
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
							?>

						<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#metadataview" aria-expanded="true" aria-controls="metadataview">Show/Hide Collection Metadata</button>
						<div class="collapse hide" id="metadataview" style="">
							
							<div class="metadata-box">
								<?php include('metadata-collection.php'); ?>

								<h3>Chapter Metadata</h3>

								<?php

								$id = get_the_ID();
								$args = array(
									'post_type'      => 'dhs_collection',
									'posts_per_page' => -1,
									'post_parent'    => $id,
									'order'          => 'ASC',
									'orderby'        => 'menu_order'
								);
								$chapter = new WP_Query($args);

								if ($chapter->have_posts()) :

									while ($chapter->have_posts()) : 
										$chapter->the_post();		
										?>
										
										<div class="metadata-box">

										<?php include('metadata-chapter.php'); ?>

										</div>

									<?php

									endwhile;

								endif;
										
							?>
							</div>

						</div>

					<?php endwhile; // end of the loop. 
					?>

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row end -->

	</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>