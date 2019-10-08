<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header biography">

		<?php the_title( '<h1 class="entry-title biography">', '</h1>' ); ?>		
		<div class="entry-meta">

			<?php //understrap_posted_on(); ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->


	<div class="entry-content">

		<?php 
		/*
			$fields = get_field_objects();
			if ($fields) :
		?>

		<div class="card biography">
			<div class="card-header">
				Biographical Information
			</div>
			<div class="card-body">
				<?php
					foreach( $fields as $field_name => $field ) {
						echo '<h5 class="biography card-title">' . $field['label'] . "</h5>\n";
						echo '<p class="biography card-text">' . nl2br($field['value']) . "</p>";
					}
				?>
			</div>
		</div>

		<h2 class="biography">Biography</h2>

		<?php
			endif;
		*/
		?>

		<?php
			if (get_field("biography_name")) :
		?>
			
		<div class="card biography-card">
		  <div class="card-header">
			Biographical Information
		  </div>
		  <div class="card-body biography-content">

			<div class="row">
				<div class="col-md-6">
					<?php echo get_the_post_thumbnail( $post->ID, 'bio-thumbnail' ); ?>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-12">
							<h5 class="biography card-title">Name</h5>
							<p><?php echo get_field("biography_name"); ?>
						</div>
						<div class="col-md-12">							
							<h5 class="biography card-title">Birth</h5>
							<p>
								<?php 
									$birthdate = get_field("date_of_birth");
									$birthplace = get_field("place_of_birth");
									if ($birthdate != null) 
										echo get_field("date_of_birth");
									if (($birthdate != null) && ($birthplace != null))
										echo ", ";
									if ($birthplace != null) 
										echo get_field("place_of_birth"); 
								?>
							</p>
						</div>
						<div class="col-md-12">		
							<h5 class="biography card-title">Death</h5>
							<p>
								<?php 
									$deathdate = get_field("date_of_death");
									$deathplace = get_field("place_of_death");
									if ($deathdate != null) 
										echo get_field("date_of_death");
									if (($deathdate != null) && ($deathplace != null))
										echo ", ";
									if ($deathplace != null) 
										echo get_field("place_of_death"); 
								?>
							</p>
						</div>
						<?php
						/*
						<div class="col-md-12">
							<h5 class="biography card-title">Gender</h5>
							<p><?php echo get_field("gender"); ?>
						</div>
						<div class="col-md-12">
							<h5 class="biography card-title">Race</h5>
							<p><?php echo get_field("race"); ?></p>
						</div>
						*/
						?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">					
					<h5 class="biography card-title">Country of Origin/Citizenship</h5>
					<p><?php echo get_field("country_of_origin_citizenship"); ?>	
				</div>
			</div>
			<?php
			/*
			<div class="row">
				<div class="col-md-12">
					<h5 class="biography card-title">Address</h5>
					<p><?php echo get_field("address"); ?></p>
				</div>
			</div>
			*/
			?>
			<div class="row">
				<div class="col-md-12">
					<h5 class="biography card-title">Kind of Artist/Cultural Worker</h5>
					<p><?php echo get_field("kind_of_artist_cultural_worker"); ?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h5 class="biography card-title">Avant-Garde Movements Associated With</h5>
					<p><?php echo get_field("avantgarde_movements_the_figure_was_associated_with"); ?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h5 class="biography card-title">Date &amp; Places of Overlap with Loy</h5>
					<p><?php echo get_field("date_places_of_overlap_with_loy"); ?>
				</div>
			</div>
			

		  </div>
		</div>

		<?php
			endif;
		?>

		<?php the_content(); ?>

		<?php if (get_field("works_cited")) {
			echo "<h2>Works Cited</h2>\n";
			echo "<div class='biography-workscited'>" . nl2br(get_field("works_cited")) . "</div>\n";
		}
		?>
		
		<?php 
		    echo "<h2>Other Biographies</h2>\n";
		?>
		<?php //echo do_shortcode("[pt_view id=e1d7ac0jdl]"); ?>

		<?php 

			$args = array(
				'post_type'      => 'post',
				'category_name'  => 'Biography',
				'order'          => 'ASC',
				'orderby'        => 'title'
			);
			$bios = new WP_Query( $args );

			if ( $bios->have_posts() ) : 

		?>

				<div class="pt-cv-wrapper">
					<div class="row">

					<?php 									
						while ( $bios->have_posts() ) : $bios->the_post();
					?>
						<div class="col-md-4">

							<div class="card biography-card">

								<div class="card-body biography-content">
									<?php
										echo "<a href='" . get_the_permalink() . "'>";
										echo get_the_post_thumbnail( $post->ID, 'thumbnail');
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

		<?php
			endif; 
			wp_reset_postdata();
		?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php //understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
