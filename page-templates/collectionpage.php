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
                 
echo htmlspecialchars('
    <mlna:Description rdf:about="https://mina-loy.com/chapters/">
        <collex:federation>ModNets</collex:federation>
        <collex:archive>loy</collex:archive>
        <dc:title>Mina Loy Baedeker: Scholarly Handbook for Digital Travelers</dc:title>');
        
        






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
        <dc:date>' . the_field('ml_date') . '</dc:date>');
        
echo htmlspecialchars('
        <collex:text>Mina Loy Baedeker: Scholarly Handbook for Digital Travelers By Suzanne W.
            Churchill, Linda A. Kinnahan, and Susan Rosenbaum Preamble These are suspect places –
            Mina Loy, “Songs to Joannes” Mina Loy Baedeker charts Loy’s navigation of Italian
            Futurism, New York Dada, and French and American Surrealism between the 1910s and the
            1960s. Analyzing and interpreting her shifting avant-garde affiliations, experiments
            with genre and media, and geographic migrations, the chapters serve as a Scholarly
            Handbook for Digital Travelers. 3 baedekers The term “Baedeker” emerged in 1826, when
            German publisher Verlag Karl Baedeker began to publish travel guides for cities around
            the world, which included introductions, fold-out maps, travel routes, and information
            about important sights and destinations, all written by experts. Popularly called
            “Baedekers,” the guides became best-sellers and were translated into multiple languages
            (Wikipedia). cover of Lunar Baedeker and Time-tablesMina Loy, a world-traveler, likely
            relied on the guides for practical advice. She also drew upon them for imaginative
            inspiration, adopting the phrase “Lunar Baedeker”—guidebook to the moon—for the two
            volumes of her writing published in her lifetime: Lunar Baedecker [sic] (Contact
            Publishing Co., 1923). The Lunar Baedeker &amp; Time-Tables (Jonathan Williams, 1958)
            Posthumous collections of her work have used the same title phrase: The Last Lunar
            Baedeker (Jargon Society, 1982). The Lost Lunar Baedeker: Poems of Mina Loy (Farrar,
            Straus &amp; Giroux, 1996). In calling our scholarly chapters a “Mina Loy Baedeker,” we
            acknowledge Loy’s ingenious use of innovative forms to navigate real and imagined
            territory, as well as contemporary readers’ need for a new kind of handbook for
            navigating her complex archive. The Handbook is organized chronologically and
            geographically, following Loy’s movements through time and space. The chapters may be
            read consecutively, or navigate your own path. Note: In Spring 2019, Mina Loy Baedeker
            will be subjected to double-blind peer review by ModNets and a process of public peer
            review via Hypothes.is.</collex:text>
        <rdfs:seeAlso rdf:resource="https://mina-loy.com/chapters/"/>');
        
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
        <dcterms:hasPart rdf:resource="' . get_permalink() . '"/>');
        
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
