<?php
/**
 * The template for displaying the Lightbox page, used by the FlashMob post category
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
							<div class="col-md-12 text-left">
								<p class="lightbox-label">Click and drag the posts below to rearrange them. Print or scroll down to read your custom formation.</p>
							</div>
						</div>
					</div>
					
					<iframe class="preview-pane" type="application/pdf" width="100%" height="650" frameborder="0"></iframe>
					
					<?php /* Start the Loop */ ?>
					
					<div class="row" id="lightbox-sortable">

						<?php $ids = explode(',', $_POST['ids']); ?>

						<?php $query = new WP_Query( array( 'post_type' => 'dhs_flashmob', 'post__in' => $ids ) ); ?>

						<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					
							<?php
						
							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'loop-templates/content-flashmob' );
							?>

						<?php endwhile; ?>											

					</div>
					<p>&nbsp;</p>
					<hr>
					<div id="pdf">
						
						<?php $queryPDF = new WP_Query( array( 'post_type' => 'dhs_flashmob', 'post__in' => $ids ) ); ?>

						<?php while ( $queryPDF->have_posts() ) : $queryPDF->the_post(); ?>
					
							<?php
						
							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'loop-templates/content-flashmobpdf' );
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
