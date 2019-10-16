<mlna:Description rdf:about="<?php echo get_theme_mod('collection_chapters_url', get_permalink()); ?>">
    <collex:federation><?php echo get_field('dhs_federation'); ?></collex:federation>
    <collex:archive><?php echo get_field('dhs_shorthand_ref'); ?></collex:archive>
    <dc:title><?php echo get_field('dhs_collection_title'); ?></dc:title>');
<?php
for ($i = 0; $i < count($collection_authors); $i++) :
?>
    <role:AUT><?php echo $collection_authors[$i]; ?></role:AUT>');
<?php
endfor;
for ($i = 0; $i < count($collection_editors); $i++) :
?>
    <role:EDT><?php echo $collection_editors[$i]; ?></role:EDT>');
<?php
endfor;
for ($i = 0; $i < count($collection_creators); $i++) :
?>
    <role:CRE><?php echo $collection_creators[$i]; ?></role:CRE>');
<?php
endfor;
?>
	<dc:type>Interactive Resource</dc:type>
    <dc:type>Collection</dc:type>');
<?php
for ($i = 0; $i < count($collection_disciplines); $i++) :
?>
    <collex:discipline><?php echo $collection_disciplines[$i]; ?></collex:discipline>');
<?php
endfor;
for ($i = 0; $i < count($collection_genres); $i++) :
?>
    <collex:genre><?php echo $collection_genres[$i]; ?></collex:genre>');
<?php
endfor;
// CUSTOMIZE: These values are hard-coded, as they are considered universal.  Change these values here if desired
// TODO: Incorporate these into theme customizer Metadata tab?
?>
	<collex:freeculture>True</collex:freeculture>
	<collex:fulltext>True</collex:fulltext>');
	<dc:date><?php echo get_field('dhs_date'); ?></dc:date>');
	<collex:text><?php echo get_field('ml_collex_text'); ?></collex:text>
    <rdfs:seeAlso rdf:resource="<?php echo $current_url; ?>"/>');
<?php
    $id = get_the_ID();
    $args = array(
        'post_type'      => 'dhs_collection',
        'posts_per_page' => -1,
        'post_parent'    => $id,
        'order'          => 'ASC',
        'orderby'        => 'menu_order'
    );
    $parent = new WP_Query($args);

    if ($parent->have_posts()) :

        while ($parent->have_posts()) : 
            $parent->the_post();
?>
	<dcterms:hasPart rdf:resource="<?php echo get_permalink(); ?>"/>');
<?php
        endwhile;
    endif;
    wp_reset_postdata();
?>
</mlna:Description>