<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package understrap
 */

get_header();

$container   = get_theme_mod( 'understrap_container_type' );

?>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<?php if ( have_posts() ) : ?>
				
					<header class="page-header">
						<h1 class="page-title">Lightbox Viewer</h1>
						<?php
						//the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
						?>
					</header><!-- .page-header -->					
															
					<div class="alert alert-info text-center" role="alert">
						<!--<form id="lightbox-selection" action="/Lightbox" method="post">
							<input type="hidden" id="lightbox-ids" name="ids" value="">
							<button type="submit" class="btn btn-dark" value="Submit">View in Lightbox</button>
						</form>-->					
						<div class="row pdf-downloadbar">
							<div class="col-md-9 text-left">
								<p class="lightbox-label">Click and drag the posts below to rearrange them. Scroll down to read your En Dehors Garde formation in full. (Please view in Chrome or Firefox, as the PDF exporter may not work in other browsers.)</p>
								<div id="pdf-progressbar">
									<div class="progress">
										<div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
											Generating PDF: 20%
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 text-right">
								<button class="btn btn-info pdfbutton">Download as PDF</button>
							</div>
						</div>
					</div>
					
					<iframe class="preview-pane" type="application/pdf" width="100%" height="650" frameborder="0"></iframe>
					
					<?php /* Start the Loop */ ?>
					
					<div class="row" id="lightbox-sortable">

						<?php $ids = explode(',', $_POST['ids']); ?>

						<?php $query = new WP_Query( array( 'post_type' => 'post', 'post__in' => $ids ) ); ?>

						<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					
							<?php
						
							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'loop-templates/content-endehorsgarde' );
							?>

						<?php endwhile; ?>											

					</div>
					<p>&nbsp;</p>
					<hr>
					<div id="pdf">
						
						<?php $queryPDF = new WP_Query( array( 'post_type' => 'post', 'post__in' => $ids ) ); ?>

						<?php while ( $queryPDF->have_posts() ) : $queryPDF->the_post(); ?>
					
							<?php
						
							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'loop-templates/content-endehorsgardepdf' );
							?>

						<?php endwhile; ?>

					</div>

				<?php else : ?>

					<?php get_template_part( 'loop-templates/content', 'none' ); ?>

				<?php endif; ?>

			</main><!-- #main -->

		</div><!-- #primary -->
		

		<!-- Do the right sidebar check -->
		<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

	</div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
