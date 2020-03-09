<mlna:Description rdf:about="<?php echo get_permalink(); ?>">
    <collex:federation><?php echo get_field('dhs_federation', $collection_id) ?></collex:federation>
    <collex:archive><?php echo get_field('dhs_shorthand_ref', $collection_id); ?></collex:archive>
    <dc:title><?php echo get_field('dhs_chapter_title'); ?></dc:title>
    <!-- See the COLLEX RDF guidelines for more role codes, or you can use any valid LC relator codes -->
<?php
for ($i = 0; $i < count($authors); $i++) :
?>
    <role:AUT><?php echo $authors[$i]; ?></role:AUT>
<?php 
endfor; 
for ($i = 0; $i < count($editors); $i++) :
?>
    <role:EDT><?php echo $editors[$i]; ?></role:EDT>
<?php
endfor;
for ($i = 0; $i < count($creators); $i++) :
?>
    <role:CRE><?php echo $creators[$i]; ?></role:CRE>
<?php
endfor;
    // CUSTOMIZE: These values are hard-coded, as they are considered universal.  Change these values here if desired
    // TODO: Incorporate these into theme customizer Metadata tab?
?>
    <dc:type>Interactive Resource</dc:type>
    <dc:type>Collection</dc:type>
<?php
for ($i = 0; $i < count($disciplines); $i++) :
?>
    <collex:discipline><?php echo $disciplines[$i]; ?></collex:discipline>
<?php
endfor;
for ($i = 0; $i < count($genres); $i++) :
?>
    <collex:genre><?php echo $genres[$i]; ?></collex:genre>
<?php
endfor;
?>
    <collex:freeculture>True</collex:freeculture>
    <collex:fulltext>True</collex:fulltext>
    <dc:date><?php echo $date; ?></dc:date>
    <collex:text><?php echo get_field('dhs_chapter_title'); ?></collex:text>
    <rdfs:seeAlso rdf:resource="<?php echo get_permalink(); ?>"/>
    <!-- Relate this object to its child objects using dcterms:hasPart-->
<?php
        
        // Loop to generate all child pages of this chapter as dcterms:hasPart tags

        $id = get_the_ID();
        $args = array(
            'post_type'      => 'dhs_collection',
            'posts_per_page' => -1,
            'post_parent'    => $id,
            'order'          => 'ASC',
            'orderby'        => 'menu_order'
        );        
        
        $parent = new WP_Query( $args );
        
        if ( $parent->have_posts() ) : 
            
            while ( $parent->have_posts() ) : 
                $parent->the_post();
?>
    <dcterms:hasPart
        rdf:resource="<?php echo get_permalink(); ?>"/>
<?php
            endwhile; 
        else:
            // None found
        endif; 
        wp_reset_postdata();
        
?>
    <!-- Relate this object to its parent object using dcterms:isPartOf-->
    <dcterms:isPartOf rdf:resource="<?php echo get_permalink( $post->post_parent ); ?>"/>
</mlna:Description>