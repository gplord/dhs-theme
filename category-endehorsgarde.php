<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

get_header();
?>

<?php
$container   = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="archive-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">
				
				<?php 
					$query = new WP_Query( array( 
						'post_type' => 'post',
						'category_name' => 'endehorsgarde',
						'orderby' => 'rand'
					) ); 
				?>

				<?php if ( $query->have_posts() ) : ?>

					<header class="page-header">
						<h1 class="page-title">Post(card)s: En Dehors Garde Flash Mob </h1>
						<?php
						//the_archive_title( '<h1 class="page-title">', '</h1>' );
						//the_archive_description( '<div class="taxonomy-description">', '</div>' );
						?>
					</header><!-- .page-header -->
				
				<p>In Summer 2018, dozens of writers, artists, students, and scholars joined a digital “<a href="https://mina-loy.com/chapters/avant-garde-theory-2/digital-flash-mob/">flash mob</a>,” submitting post(card)s that expressed their ideas about the <a href="https://mina-loy.com/chapters/avant-garde-theory-2/the-en-dehors-garde/">en dehors garde</a>—a term we coined to account for women, people of color, and others who have been marginalized or excluded from histories of the avant-garde. These are their post(card)s:</p>
				<p></p>
															
					<div class="alert alert-info text-center" role="alert">
						<p class="lightbox-label" style="font-family: 'Montserrat', sans-serif">
						To select a post(card), check the button in the top, right corner of the card.
						<br>Click "View in Lightbox" to see the selected post(card)s combined in a rearrangeable format.
						</p>
						<form id="lightbox-selection" action="/Lightbox" method="post">
							<input type="hidden" id="lightbox-ids" name="ids" value="">
							<button type="submit" class="btn btn-dark" value="Submit">View in Lightbox</button>
						</form>
					</div>
					
					<div class="row">

					<?php /* Start the Loop */ ?>					
					<?php //$query = new WP_Query( array( 'post_type' => 'post', 'post__in' => array( 2708, 2706, 2704 ) ) ); ?>

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

				<?php else : ?>

					<?php get_template_part( 'loop-templates/content', 'none' ); ?>

				<?php endif; ?>

			</main><!-- #main -->

			<!-- The pagination component -->
			<?php understrap_pagination(); ?>

		</div><!-- #primary -->

		<!-- Do the right sidebar check -->
		<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

	</div> <!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
