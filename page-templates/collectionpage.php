<?php
/**
 * Template Name: Main Collection Page
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
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
                                'post_type'      => 'page',
                                'posts_per_page' => -1,
                                'post_parent'    => $id,
                                'order'          => 'ASC',
                                'orderby'        => 'menu_order'
                            );
                            $parent = new WP_Query( $args );

                            if ( $parent->have_posts() ) : 

                        ?>

                    <div class="pt-cv-wrapper">
                        
                        <h4>Chapters</h4>
                        
                        <div class="row">

                        <?php 									
                            while ( $parent->have_posts() ) : $parent->the_post();
                        ?>
                            <div class="col-md-4">

                                <div class="card biography-card">

                                    <div class="card-body biography-content">
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


					<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#metadataview" aria-expanded="true" aria-controls="metadataview">Show/Hide Collection Metadata</button>
					<div class="collapse hide" id="metadataview" style="">
					<h3>Collection Metadata</h3>

                    
                    <div style="background: #eee; padding: 1em">
					<?php
                        $collection_authors = array();
                        echo "<h5>Collection Authors</h5>\n";
                        // check if the repeater field has rows of data
                        if( have_rows('ml_authors') ):
                         	// loop through the rows of data
                            while ( have_rows('ml_authors') ) : the_row();
                                // display a sub field value
                                the_sub_field('ml_author');
                                $author = get_sub_field('ml_author');
                                array_push($collection_authors, $author);
                                echo "<br>";
                            endwhile;
                        else :
                            // no rows found
                        endif;
                        echo "<hr>";
                        
                        // --------------------------------------------------------- //
                        
                        $collection_editors = array();
                        echo "<h5>Collection Editors</h5>\n";
                        // check if the repeater field has rows of data
                        if( have_rows('ml_editors') ):
                         	// loop through the rows of data
                            while ( have_rows('ml_editors') ) : the_row();
                                // display a sub field value
                                the_sub_field('ml_editor');
                                $collection_editor = get_sub_field('ml_editor');
                                array_push($collection_editors, $collection_editor);
                                echo "<br>";
                            endwhile;
                        else :
                            // no rows found
                        endif;
                        echo "<hr>";
                        
                        // --------------------------------------------------------- //
                        
                        $collection_creators = array();
                        echo "<h5>Collection Creators</h5>\n";
                        // check if the repeater field has rows of data
                        if( have_rows('ml_creators') ):
                         	// loop through the rows of data
                            while ( have_rows('ml_creators') ) : the_row();
                                // display a sub field value
                                the_sub_field('ml_creator');
                                $collection_creator = get_sub_field('ml_creator');
                                array_push($collection_creators, $collection_creator);
                                echo "<br>";
                            endwhile;
                        else :
                            // no rows found
                        endif;
                        echo "<hr>";
                        
                        // --------------------------------------------------------- //
                        
                        $collection_genres = array();
                        echo "<h5>Collection Genres</h5>\n";
                        // check if the repeater field has rows of data
                        if( have_rows('ml_genres') ):
                        
                         	while( have_rows('ml_genres') ): the_row();
                        
                        		// vars
                        		$select = get_sub_field_object('ml_genre');
                        		$value = $select['value'];
                        		echo $value['label'] . "<br>\n";
                        		array_push($collection_genres, $value['label']);
                        
                            endwhile;
                        else :
                            // no rows found
                        endif;
                        
                        
                        echo "<hr>";
                        
                        // Populate Disciplines array for below
                        $collection_disciplines = array();
                        echo "<h5>Collection Disciplines</h5>\n";
                        if( have_rows('ml_disciplines') ):
                        
                        	while( have_rows('ml_disciplines') ): the_row();
                        
                        		// vars
                        		$select = get_sub_field_object('ml_discipline');
                        		$value = $select['value'];
                        		echo $value['label'] . "<br>\n";
                        		array_push($collection_disciplines, $value['label']);
                        
                            endwhile;
                        endif;
                        echo "<hr>\n";
                        
                        echo "<div style='padding: 50px; background: #ddd; font-size: 75%'>";
                        echo "<div style='background: #fff; font-size: 75%; padding: 1em 0'>\n";
                            echo "<pre>\n";

global $wp;
$current_url = home_url(add_query_arg(array(), $wp->request));
                 
echo htmlspecialchars('
    <mlna:Description rdf:about="' . get_theme_mod('collection_chapters_url', get_permalink()) . '">
        <collex:federation>' . get_theme_mod('collection_collex_federation', 'ModNets') . '</collex:federation>
        <collex:archive>' . get_theme_mod('collection_collex_archive_text') . '</collex:archive>
        <dc:title>' . get_theme_mod('collection_name_text') . '</dc:title>');
        
for ($i = 0; $i < count($collection_authors); $i++) {
    echo htmlspecialchars('
        <role:AUT>' . $collection_authors[$i] . '</role:AUT>');
}

for ($i = 0; $i < count($collection_editors); $i++) {
    echo htmlspecialchars('
        <role:EDT>' . $collection_editors[$i] . '</role:EDT>');
}

for ($i = 0; $i < count($collection_creators); $i++) {
    echo htmlspecialchars('
        <role:CRE>' . $collection_creators[$i] . '</role:CRE>');
}

echo htmlspecialchars('
        <dc:type>Interactive Resource</dc:type>
        <dc:type>Collection</dc:type>');

for ($i = 0; $i < count($collection_disciplines); $i++) {
    echo htmlspecialchars('
        <collex:discipline>' . $collection_disciplines[$i] . '</collex:discipline>');
}
        
for ($i = 0; $i < count($collection_genres); $i++) {
    echo htmlspecialchars('
        <collex:genre>' . $collection_genres[$i] . '</collex:genre>');
}

echo htmlspecialchars('
        <collex:freeculture>True</collex:freeculture>
        <collex:fulltext>True</collex:fulltext>');
        
echo htmlspecialchars('
        <dc:date>' . get_field('ml_date') . '</dc:date>');
        
echo htmlspecialchars('
        <collex:text>' . get_field('ml_collex_text'). '</collex:text>
        <rdfs:seeAlso rdf:resource="' . $current_url . '"/>');
        
        $id = 2916;
        $args = array(
            'post_type'      => 'page',
            'posts_per_page' => -1,
            'post_parent'    => $id,
            'order'          => 'ASC',
            'orderby'        => 'menu_order'
         );
        $parent = new WP_Query( $args );
        
        if ( $parent->have_posts() ) : 
            
            while ( $parent->have_posts() ) : $parent->the_post();
        
                echo htmlspecialchars('
        <dcterms:hasPart rdf:resource="' . get_theme_mod('collection_chapters_url', get_permalink()) . '"/>');
        
            endwhile; 
        endif; 
        wp_reset_postdata();

        
echo htmlspecialchars('
    </mlna:Description>
');

        echo "</pre>\n";
        echo "</div>\n";
        echo "</div>\n";

?>
					</div>
					</div>
					
					<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row end -->

	</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
