<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package dhs
 */

$the_theme = wp_get_theme();
$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_sidebar( 'footerfull' ); ?>

<div class="wrapper" id="wrapper-footer">

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="row">

			<div class="col-md-12">
				
				<div class="footer-menu">

					<?php 
						/* Footer Search Bar */
						/* CUSTOMIZE: Replace this shortcode with your footer search widget ID, and uncomment the next line */
						echo do_shortcode("[do_widget id=search-3]"); 
					?>							

					<nav class="navbar navbar-expand-md navbar navbar-footer">

						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>

						<!-- The WordPress Menu goes here -->
						<?php wp_nav_menu(
							array(
								'theme_location'  => 'footer-menu',
								'container_class' => 'collapse navbar-collapse d-flex justify-content-center',
								'container_id'    => 'navbarNavDropdown',
								'menu_class'      => 'navbar-nav',
								'fallback_cb'     => '',
								'menu_id'         => 'footer-menu',
								'walker'          => new understrap_WP_Bootstrap_Navwalker(),
							)
						); ?>

					</nav><!-- .site-navigation -->


				</div>

			</div>

		</div>

	</div><!-- container end -->

</div><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>

