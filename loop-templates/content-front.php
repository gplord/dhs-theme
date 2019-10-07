<?php
/**
 * _gpl
 * Partial template for content in frontpage.php template
 *
 * @package understrap
 */

?>
<div id="front-page-template">
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<!-- <header class="entry-header">

		<?php // the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	</header><!-- .entry-header -->

	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="entry-content">

		<?php the_content(); ?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
			'after'  => '</div>',
		) );
		?>

		<?php
		
		if ( is_active_sidebar( 'main-content-widget' ) ) : ?>
			<div id="main-content-widget-area" class="main-content-widget-area widget-area" role="complementary">
			<?php dynamic_sidebar( 'main-content-widget' ); ?>
			</div>
			
		<?php endif; ?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
</div>
