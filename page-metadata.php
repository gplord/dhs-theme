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

/* CUSTOMIZE: Replace these values with your Collection-level RDF metadata values */
/* Example: See original RDF values for mina-loy.com below */
$chapters_url = "https://mina-loy.com/chapters/";                           // Link to main chapters page
$collex_archive = "loy";                                                    // Shortname for collection archive
$dc_title = "Mina Loy Baedeker: Scholarly Handbook for Digital Travelers";  // DC Collection title

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content">

		<div class="row justify-content-md-center">

			<div class="col-md-9 content-area" id="primary">
			    
			    <h3>Digital Humanities Scholarship: Metadata Export</h3>

				<main class="site-main" id="main" role="main">

<h2>Collection-Level Metadata</h2>

<?php // ----------------------------------------------------------------------------------------------------------- ?>

<?php
/*
$args = array(
    'post_type' => 'page',
    'posts_per_page' => 1,
    'meta_query' => array(
        array(
            'key' => '_wp_page_template',
            'value' => 'essaytitlepage.php'
        )
    )
);
$the_pages = new WP_Query( $args );

*/

    $args = array(
        'post_type' => 'page',//it is a Page right?
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => '_wp_page_template',
                'value' => 'page-templates/collectionpage.php', // template name as stored in the dB
            )
        )
    );
    $my_query = new WP_Query($args);
    if( $my_query->have_posts() ) :
    while( $my_query->have_posts() ) :

        $my_query->the_post();
        
        // ---------------------------------------------------------- //
        
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
        
        
    endwhile;
    endif;

        echo "<div style='padding: 50px; background: #eee; font-size: 75%'>";
        
        echo "<div class='row rdf-downloadbar'>\n";
        echo "<div class='col-sm-8'><h4>Collection-Level Metadata (RDF)</h4></div>\n";
        echo "<div class='col-sm-4 text-right'><button class='btn btn-primary rdf-download-button' id='rdf-download-collection'>Save as RDF</button></div>\n";
        echo "</div>\n";

        echo "<div style='background: #fff; font-size: 75%; padding: 1em 0'>\n";
            echo "<pre id='rdf-collection-content'>\n";
 
echo htmlspecialchars('
    <mlna:Description rdf:about="' . get_theme_mod('collection_chapters_url', get_permalink()) . '">
        <collex:federation>' . get_theme_mod('collection_collex_federation', 'ModNets') . '</collex:federation>
        <collex:archive>' . get_theme_mod('collection_collex_archive_text') . '</collex:archive>
        <dc:title>' . get_theme_mod('collection_name_text') . '/dc:title>');

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
        <collex:text>' . get_field('ml_collex_text') . '</collex:text>
        <rdfs:seeAlso rdf:resource="' . get_theme_mod('collection_chapters_url', get_permalink()) . '"/>');
        
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


<?php //------------------------------------------------------------------------------------------------------------ ?>


<h2>Individual Chapter Metadata</h2>

					<?php
					/*
					while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'loop-templates/content', 'page' ); ?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template.
						//if ( comments_open() || get_comments_number() ) :

							//comments_template();

						//endif;
						?>

					<?php endwhile; // end of the loop. ?>
				*/
				?>
				
<?php
/*
$args = array(
    'post_type' => 'page',
    'posts_per_page' => 1,
    'meta_query' => array(
        array(
            'key' => '_wp_page_template',
            'value' => 'essaytitlepage.php'
        )
    )
);
$the_pages = new WP_Query( $args );

*/

    $args = array(
        'post_type' => 'page',//it is a Page right?
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => '_wp_page_template',
                'value' => 'page-templates/essaytitlepage.php', // template name as stored in the dB
            )
        )
    );
$my_query = new WP_Query($args);

if( $my_query->have_posts() ){
    while( $my_query->have_posts() ){
        $my_query->the_post();
        echo "<div style='padding: 50px; background: #eee; font-size: 75%'>";
        
		//echo "<p>".get_the_ID()."</p>";
		
        echo "<h5>Collection Title</h5>\n";
        the_field('ml_collection_title');
        echo "<hr>\n";
        
        echo "<h5>Chapter Title</h5>\n";
        //echo "<strong>";
		the_field('ml_chapter_title');
		//echo "</strong>\n";
        echo "<br><br>\n";
        echo "<h5>Chapter Subtitle</h5>\n";
        the_field('ml_chapter_subtitle');
        echo "<hr>\n";
        
        echo "<h5>Date</h5>\n";
        //the_field('ml_date');
        $date = get_field('ml_date');
        echo $date;
        echo "<hr>\n";
        
        $authors = array();
        
        echo "<h5>Authors</h5>\n";
        // check if the repeater field has rows of data
        if( have_rows('ml_authors') ):
        
         	// loop through the rows of data
            while ( have_rows('ml_authors') ) : the_row();
        
                // display a sub field value
                the_sub_field('ml_author');
                
                $author = get_sub_field('ml_author');
                array_push($authors, $author);
                
                echo "<br>";
        
            endwhile;
            
        
        else :
        
            // no rows found
        
        endif;
        
        echo "<hr>";
        
        
        $editors = array();
        
        echo "<h5>Editors</h5>\n";
        // check if the repeater field has rows of data
        if( have_rows('ml_editors') ):
        
         	// loop through the rows of data
            while ( have_rows('ml_editors') ) : the_row();
        
                // display a sub field value
                the_sub_field('ml_editor');
                
                $editor = get_sub_field('ml_editor');
                array_push($editors, $editor);

                echo "<br>";
        
            endwhile;
        
        else :
        
            // no rows found
        
        endif;
        
        echo "<hr>";
        
        $creators = array();
        
        echo "<h5>Creators</h5>\n";
        // check if the repeater field has rows of data
        if( have_rows('ml_creators') ):
        
         	// loop through the rows of data
            while ( have_rows('ml_creators') ) : the_row();
        
                // display a sub field value
                the_sub_field('ml_creator');
                
                $creator = get_sub_field('ml_creator');
                array_push($creators, $creator);

                echo "<br>";
        
            endwhile;
        
        else :
        
            // no rows found
        
        endif;
        
        echo "<hr>";
        
        
        $genres = array();
        echo "<h5>Genres</h5>\n";
        // check if the repeater field has rows of data
        if( have_rows('ml_genres') ):
        
         	while( have_rows('ml_genres') ): the_row();
        
        		// vars
        		$select = get_sub_field_object('ml_genre');
        		$value = $select['value'];
        		echo $value['label'] . "<br>\n";
        		array_push($genres, $value['label']);
        
            endwhile;
        
        else :
        
            // no rows found
        
        endif;
        
        
        echo "<hr>";
        
        // Populate Disciplines array for below
        $disciplines = array();
        echo "<h5>Disciplines</h5>\n";
        if( have_rows('ml_disciplines') ):
        
        	while( have_rows('ml_disciplines') ): the_row();
        
        		// vars
        		$select = get_sub_field_object('ml_discipline');
        		$value = $select['value'];
        		echo $value['label'] . "<br>\n";
        		array_push($disciplines, $value['label']);
        
            endwhile;
        	
        endif;
        
        echo "<hr>\n";
        
        echo "<div class='row rdf-downloadbar'>\n";
        echo "<div class='col-sm-8'><h4>Chapter Metadata (RDF)</h4></div>\n";
        echo "<div class='col-sm-4 text-right'><button class='btn btn-primary rdf-download-button rdf-download-chapter' data-id='" . get_the_ID() . "'>Save as RDF</button></div>\n";
        echo "</div>\n";
        
        echo "<div style='background: #fff; font-size: 75%; padding: 1em 0'>\n";
        

        
            echo "<pre class='rdf-chapter' id='rdf-" . get_the_ID() . "'>\n";
            
echo htmlspecialchars('
    <mlna:Description rdf:about="' . get_permalink() . '">
        <collex:federation>ModNets</collex:federation>
        <collex:archive>' . get_theme_mod('collection_collex_archive_text') . '</collex:archive>
        <dc:title>' . get_field('ml_chapter_title') . '</dc:title>
        <!-- See the COLLEX RDF guidelines for more role codes, or you can use any 
            valid LC relator codes -->');

$author_list_string = ""; // Formatted list of authors as comma-separated list, with "and" before the final author

for ($i = 0; $i < count($authors); $i++) {
    
    echo htmlspecialchars('
        <role:AUT>' . $authors[$i] . '</role:AUT>');
        
    // While looping through this already, use this loop to build the $author_string_list for use below
    if (($i + 1) < count($authors)) {
        $author_list_string .= $authors[$i] . ", ";
    } else if (($i +1) == count($authors)) {
        $author_list_string .= "and " . $authors[$i];
    }
    
}

for ($i = 0; $i < count($editors); $i++) {
    
    echo htmlspecialchars('
        <role:EDT>' . $editors[$i] . '</role:EDT>');
    
}

for ($i = 0; $i < count($creators); $i++) {
    
    echo htmlspecialchars('
        <role:CRE>' . $creators[$i] . '</role:CRE>');
    
}

echo htmlspecialchars('
        <dc:type>Interactive Resource</dc:type>
        <dc:type>Collection</dc:type>');

for ($i = 0; $i < count($disciplines); $i++) {
    
    echo htmlspecialchars('
        <collex:discipline>' . $disciplines[$i] . '</collex:discipline>');
    
}
        
for ($i = 0; $i < count($genres); $i++) {
    
    echo htmlspecialchars('
        <collex:genre>' . $genres[$i] . '</collex:genre>');
    
}

        
echo htmlspecialchars('
        <collex:freeculture>True</collex:freeculture>
        <collex:fulltext>True</collex:fulltext>
        <dc:date>' . $date . '</dc:date>
        <collex:text>' . get_field('ml_chapter_title') . ' by ' . $author_list_string . '</collex:text>
        <rdfs:seeAlso rdf:resource="' . get_permalink() . '"/>
        <!-- Relate this object to its child objects using dcterms:hasPart-->');
        
        // Loop to generate all child pages of this chapter as dcterms:hasPart tags
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
            
            while ( $parent->have_posts() ) : $parent->the_post();
        
                echo htmlspecialchars('
        <dcterms:hasPart
            rdf:resource="' . get_permalink() . '"/>');
        
            endwhile; 
        endif; 
        wp_reset_postdata();
        
        // -- end dcterms loop ------------------------------------------------

echo htmlspecialchars('
        <!-- Relate this object to its parent object using dcterms:isPartOf-->
        <dcterms:isPartOf rdf:resource="' . get_theme_mod('collection_chapters_url', get_permalink()) . '"/>
    </mlna:Description>
');
        
            
            echo "</pre>\n";
        echo "</div>\n";    // end RDF Metadata div



        echo "</div>\n";
		echo "<br>\n";

    }
} else {
    echo "none found";
}


/*
$args = array(
    'post_type' => array( 'page' ),
    'order' => 'ASC',
    'orderby' => 'title'
    );
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) {
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
        echo '<p>'; 
        the_title();
        echo ' - ';
        echo get_page_template_slug(); 
        echo '</p>';
    }
    wp_reset_postdata();
}
*/


?>


				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row end -->

	</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>