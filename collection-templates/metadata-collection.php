<h3>Collection Metadata</h3>


<div class="row">
    <div class="col">
        <?php

        $collection_authors = array();
        echo "<h5>Collection Authors</h5>\n";

        // check if the repeater field has rows of data
        $i = 0;
        if (have_rows('dhs_authors')) :
            // loop through the rows of data
            while (have_rows('dhs_authors')) : the_row();
                $sub_value = get_sub_field('dhs_author');
                $i++;
                // display a sub field value
                the_sub_field('dhs_author');
                $author = get_sub_field('dhs_author');
                array_push($collection_authors, $author);
                echo "<br>";

            endwhile;
        else :
        // no rows found
        endif;

        ?>
    </div>
    <div class="col">
        <?php

        $collection_editors = array();
        echo "<h5>Collection Editors</h5>\n";
        // check if the repeater field has rows of data
        if (have_rows('dhs_editors')) :
            // loop through the rows of data
            while (have_rows('dhs_editors')) : the_row();
                // display a sub field value
                the_sub_field('dhs_editor');
                $collection_editor = get_sub_field('dhs_editor');
                array_push($collection_editors, $collection_editor);
                echo "<br>";
            endwhile;
        else :
        // no rows found
        endif;

        ?>
    </div>
    <div class="col">
        <?php

        $collection_creators = array();
        echo "<h5>Collection Creators</h5>\n";
        // check if the repeater field has rows of data
        if (have_rows('dhs_creators')) :
            // loop through the rows of data
            while (have_rows('dhs_creators')) : the_row();
                // display a sub field value
                the_sub_field('dhs_creator');
                $collection_creator = get_sub_field('dhs_creator');
                array_push($collection_creators, $collection_creator);
                echo "<br>";
            endwhile;
        else :
        // no rows found
        endif;

        ?>
    </div>
</div>
<hr>
<div class="row">
    <div class="col">
        <?php

        $collection_federations = array();
        echo "<h5>Collection Federations</h5>\n";
        // check if the repeater field has rows of data
        if (have_rows('dhs_federations')) :

            while (have_rows('dhs_federations')) : the_row();

                the_sub_field('dhs_federation');
                $collection_federation = get_sub_field('dhs_federation');
                array_push($collection_federations, $collection_federation);
                echo "<br>";

            endwhile;
        else :
        // no rows found
        endif;

        ?>
    </div>
    <div class="col">
        <?php

        $collection_genres = array();
        echo "<h5>Collection Genres</h5>\n";
        // check if the repeater field has rows of data
        if (have_rows('dhs_genres')) :

            while (have_rows('dhs_genres')) : the_row();

                // vars
                $select = get_sub_field_object('dhs_genre');
                $value = $select['value'];
                echo $value['label'] . "<br>\n";
                array_push($collection_genres, $value['label']);

            endwhile;
        else :
        // no rows found
        endif;

        ?>
    </div>
    <div class="col">
        <?php

        // Populate Disciplines array for below
        $collection_disciplines = array();
        echo "<h5>Collection Disciplines</h5>\n";
        if (have_rows('dhs_disciplines')) :

            while (have_rows('dhs_disciplines')) : the_row();

                // vars
                $select = get_sub_field_object('dhs_discipline');
                $value = $select['value'];
                echo $value['label'] . "<br>\n";
                array_push($collection_disciplines, $value['label']);

            endwhile;
        endif;

        ?>
    </div>
</div>
<hr>

<div class='rdf-metadata-box'>

    <div class='row rdf-downloadbar'>
        <div class='col-sm-8'>
            <h4>Collection-Level Metadata (RDF)</h4>
        </div>
        <div class='col-sm-4 text-right'><button class='btn btn-primary rdf-download-button rdf-download-collection' data-id='<?php echo get_the_ID(); ?>'>Save as RDF</button></div>
    </div>

    <div class='rdf-metadata-container'>
        <pre id='rdf-collection-<?php echo get_the_ID(); ?>' class='rdf-metadata-content'><?php
        global $wp;
        $current_url = home_url(add_query_arg(array(), $wp->request));

        ob_start();
        include('rdf-collection.php');
        $output = ob_get_clean();
        echo htmlspecialchars($output);
        ?>
        </pre>
    </div>
</div>