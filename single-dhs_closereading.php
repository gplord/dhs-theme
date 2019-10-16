<?php

/**
 * The template for displaying Close Readings pages.
 *
 * @package understrap
 */

get_header();
$container   = get_theme_mod('understrap_container_type');
?>

<div class="wrapper wrapper-fullscreen" id="single-wrapper">

	<?php /* <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1"> */ ?>
	<div class="container-fluid closereading-fullscreen" id="content" tabindex="-1">
		<?php /* <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1"> */ ?>

		<?php while (have_posts()) : the_post(); ?>

			<div class="row">

				<div class="col-md-4 content-area" id="primary">

					<?php /* ---- Loop code here --------------------------------------- */ ?>

					<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

						<header class="entry-header">

							<?php the_title('<h1 class="entry-title closereading-title">', '</h1>'); ?>

							<div class="entry-meta">

								<?php understrap_posted_on(); ?>

							</div><!-- .entry-meta -->

						</header><!-- .entry-header -->

					</article><!-- #post-## -->

					<?php /* ---- End loop code ---------------------------------------- */ ?>

				</div><!-- End Main Content column -->
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-2 content-area">
							<header class="entry-header">
								<h5 class="closereading-title" style="display: inline">Layout Ratio</h5>
								<select name="closereading-layout" class="form-control closereading-layout-select" id="layout-group">
									<option id="closereading-layout1" value="closereading-layout1">3:1</option>
									<option id="closereading-layout2" value="closereading-layout2">2:1</option>
									<option id="closereading-layout4" value="closereading-layout4" selected>1:1</option>
									<option id="closereading-layout5" value="closereading-layout5">1:2</option>
									<option id="closereading-layout6" value="closereading-layout6">1:3</option>
								</select>

							</header>
						</div>
						<div class="col-md-2 content-area">
							<header class="entry-header">
								<h5 class="closereading-title" style="display: inline">Font Size</h5>
								<select name="closereading-font" class="form-control closereading-font-select" id="font-select">
									<option value="10">10pt</option>
									<option value="11">11pt</option>
									<option value="12">12pt</option>
									<option value="13" selected>13pt</option>
									<option value="14">14pt</option>
								</select>
							</header>
						</div>
						<div class="col-md-2 content-area">
							<header class="entry-header">
								<div style="display:inline">
									<label class="switch">
										<input type="checkbox" id="smoothscroll" name="smoothscroll" checked>
										<span class="slider round"></span>
									</label>
								</div>
								<label for="smoothscroll" data-toggle="tooltip" data-placement="bottom" title="Animated transition scrolling when clicking a section">
									<strong class="closereading-control-label">Animate Scroll</strong>
								</label>
							</header>
						</div>
						<div class="col-sm-2">
							<header class="entry-header">
								<div style="display:inline">
									<label class="switch">
										<input type="checkbox" id="autoscroll" name="autoscroll">
										<span class="slider round"></span>
									</label>
								</div>
								<label for="autoscroll" data-toggle="tooltip" title="Automatically scroll the opposite panel to follow current section">
									<strong class="closereading-control-label">Scroll on Hover</strong>
								</label>
							</header>
						</div>
						<div class="col-sm-2">
							<header class="entry-header">
								<div style="display:inline">
									<label class="switch">
										<input type="checkbox" id="darkmode" name="darkmode">
										<span class="slider round"></span>
									</label>
								</div>
								<label for="darkmode" data-toggle="tooltip" title="Invert colors for light text against a dark background">
									<strong class="closereading-control-label">Dark Mode</strong>
								</label>
							</header>
						</div>
						<div class="col-sm-2">
							<header class="entry-header">
								<div style="display:inline">
									<label class="switch">
										<input type="checkbox" id="fullscreen" name="fullscreen">
										<span class="slider round"></span>
									</label>
								</div>
								<label for="fullscreen" data-toggle="tooltip" title="Enter or exit fullscreen view">
									<strong class="closereading-control-label">Fullscreen</strong>
								</label>
							</header>
						</div>
					</div>
				</div>


			</div><!-- End Main Content row -->

	</div><!-- End container column -->

	<div class="container-fluid closereading-fullscreen-content" id="content" tabindex="-1">
		<!-- Begin full-width container -->

		<div class="row">
			<div class="col-md-6 closereading-layout-left">
				<div class="closereading-header">
					<?php if (get_field('cr_left_text_title')) : ?>
						<h3><?php the_field('cr_left_text_title'); ?></h3>
					<?php endif; ?>
					<?php if (get_field('cr_left_text_author')) : ?>
						<h4> by <?php the_field('cr_left_text_author'); ?></h4>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-md-6 closereading-layout-right">
				<div class="closereading-header">
					<?php if (get_field('cr_right_text_title')) : ?>
						<h3><?php the_field('cr_right_text_title'); ?></h3>
					<?php endif; ?>
					<?php if (get_field('cr_right_text_author')) : ?>
						<h4> by <?php the_field('cr_right_text_author'); ?></h4>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="row" id="closereading-viewer">

			<div class="col-md-6 closereading-layout-left" id="left-cr">

				<?php /* ---- Loop code here --------------------------------------- */ ?>

				<article <?php post_class(); ?> id="post-<?php the_ID(); ?>-left">

					<div class="entry-content" id="left-scrollspy" data-offset="0" style="overflow: auto; height: 100%; position: relative">

						<?php if (get_field('cr_left_text_content')) : ?>
							<div id="closereading-lefttext" class="closereading-content">

								<?php

										$this_section = "left-";
										$other_section = "right-";

										$content = preg_replace("/{this}/", $this_section,  get_field("cr_left_text_content"));
										$content = preg_replace("/{other}/", $other_section, $content);
										echo do_shortcode($content);

										?>

							</div>
						<?php endif; ?>

					</div><!-- .entry-content -->

					<div class="closereading-footer">
						<?php
							if (get_field('cr_left_text_link')) {
								$link_left = get_field('cr_left_text_link');
								echo "<a href='" . $link_left['url'] . "'>" . $link_left['title'] . "</a>\n";
							}
						?>
						<?php if (get_field('cr_left_text_citation')) : ?>
							<p><?php the_field('cr_left_text_citation'); ?></p>
						<?php endif; ?>
					</div>

				</article><!-- #post-## -->

				<?php /* ---- End loop code ---------------------------------------- */ ?>

			</div><!-- #left column -->

			<div class="col-md-6 closereading-layout-right" id="right-cr">

				<article <?php post_class(); ?> id="post-<?php the_ID(); ?>-right">

					<!--<div class="entry-content" id="rightscrollspy" data-spy="scroll" data-target="#closereading-lefttext" data-offset="0" style="overflow-y: scroll; height: 500px; position: relative">-->
					<div class="entry-content" id="right-scrollspy" data-offset="0" style="overflow: auto; height: 500px; position: relative">

						<?php if (get_field('cr_right_text_content')) : ?>
							<div id="closereading-righttext" class="closereading-content">

								<?php

										$this_section = "right-";
										$other_section = "left-";

										$content = preg_replace("/{this}/", $this_section, nl2br(get_field("cr_right_text_content")));
										$content = preg_replace("/{other}/", $other_section, $content);
										echo $content;

										?>
							</div>
						<? endif; ?>

					</div><!-- .entry-content -->

					<div class="closereading-footer">
						<?php
							if (get_field('cr_right_text_link')) {
								$link_right = get_field('cr_right_text_link');
								echo "<a href='" . $link_right['url'] . "'>" . $link_right['title'] . "</a>\n";
							}
						?>
						<?php if (get_field('cr_right_text_citation')) : ?>
							<p><?php the_field('cr_right_text_citation'); ?></p>
						<?php endif; ?>
					</div>

				</article><!-- #post-## -->

			</div><!-- #right column -->

		</div><!-- .row -->
		<div class="row">
			<div class="col-md-12">
				<footer class="entry-footer">


				</footer><!-- .entry-footer -->
			</div>
		</div>
	<div><!-- Container end -->

	<?php 
	endwhile; // end of the loop. 
	?>

</div><!-- Wrapper end -->

<?php get_footer(); ?>