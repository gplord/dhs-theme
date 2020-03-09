<?php
// Expects query with chapter as current retrieved post object
$chapter_id = get_the_ID();
$collection_id = wp_get_post_parent_id($chapter_id);
?>

        
<h3><?php the_field('dhs_chapter_title'); ?></h3>

<?php if (get_field('dhs_chapter_subtitle')) : ?>
<h5><?php the_field('dhs_chapter_subtitle'); ?></h5>
<?php endif; ?>

<div class="row">
    <div class="col-md-3">
<h5>Date</h5>
    </div>
    <div class="col-md-9">
<?php $date = get_field('dhs_date');
echo $date; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
<h5>Authors</h5>
    </div>
    <div class="col-md-9">
<?php
$authors = array();

        // check if the repeater field has rows of data
        if( have_rows('dhs_authors') ):
        
         	// loop through the rows of data
            while ( have_rows('dhs_authors') ) : 
                the_row();
        
                // display a sub field value
                the_sub_field('dhs_author');
                
                $author = get_sub_field('dhs_author');
                array_push($authors, $author);
                
                echo "<br>\n";
        
            endwhile;
            
        
        else :
        
            // no rows found
        
        endif;
?>
    </div>
</div>
    
<?php
    // check if the repeater field has rows of data
    if( have_rows('dhs_editors') ):
?>
<div class="row">
    <div class="col-md-3">
        <h5>Editors</h5>
    </div>
    <div class="col-md-9">
        <?php
        $editors = array();
        
         	// loop through the rows of data
            while ( have_rows('dhs_editors') ) : the_row();
        
                // display a sub field value
                the_sub_field('dhs_editor');
                
                $editor = get_sub_field('dhs_editor');
                array_push($editors, $editor);

                echo "<br>";
        
            endwhile;
            ?>
    </div>
</div>
<?php        
        else :
        
            // no rows found
        
        endif;
?>        

<?php
// check if the repeater field has rows of data
if( have_rows('dhs_creators') ):
?>

<div class="row">
    <div class="col-md-3">
        <h5>Creators</h5>
    </div>
    <div class="col-md-9">
        <?php
        $creators = array();
        
         	// loop through the rows of data
            while ( have_rows('dhs_creators') ) : the_row();
        
                // display a sub field value
                the_sub_field('dhs_creator');
                
                $creator = get_sub_field('dhs_creator');
                array_push($creators, $creator);

                echo "<br>";
        
            endwhile;
            ?>      
    </div>
</div>
<?php        
        else :
        
            // no rows found
        
        endif;
?>

<div class="row">
    <div class="col-md-3">
        <h5>Genres</h5>
    </div>
    <div class="col-md-9">
<?php        
        $genres = array();
        // check if the repeater field has rows of data
        if( have_rows('dhs_genres') ):
        
         	while( have_rows('dhs_genres') ): the_row();
        
        		// vars
        		$select = get_sub_field_object('dhs_genre');
        		$value = $select['value'];
        		echo $value['label'] . "<br>";
        		array_push($genres, $value['label']);
        
            endwhile;
        
        else :
        
            // no rows found
        
        endif;
?>      
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <h5>Disciplines</h5>
    </div>
    <div class="col-md-9">
<?php
        // Populate Disciplines array for below
        $disciplines = array();
        if( have_rows('dhs_disciplines') ):
        
        	while( have_rows('dhs_disciplines') ): the_row();
        
        		// vars
        		$select = get_sub_field_object('dhs_discipline');
        		$value = $select['value'];
        		echo $value['label'] . "<br>";
        		array_push($disciplines, $value['label']);
        
            endwhile;
        	
        endif;
?>      
    </div>
</div>
        
<div class='rdf-metadata-box'>
    <div class='row rdf-downloadbar'>
        <div class='col-sm-8'><h4>Chapter Metadata (RDF)</h4></div>
        <div class='col-sm-4 text-right'><button class='btn btn-primary rdf-download-button rdf-download-chapter' data-id='<?php echo get_the_ID(); ?>'>Save as RDF</button></div>
    </div>
        
    <div class='rdf-metadata-container'>
        <pre lang="xml" class='rdf-chapter rdf-metadata-content' id='rdf-chapter-<?php echo get_the_ID(); ?>'><?php
ob_start();
include('rdf-chapter.php');
$output = ob_get_clean();
echo htmlspecialchars($output);
?>
        </pre>
    </div>
</div>
