<?php

/**
 * The template for the custom Metadata page.
 *
 * This template is used automatically by the /metadata permalink.
 * This permalink can be changed in the Appearances > Customize screen, under "Metadata"
 *
 * @package understrap
 */

get_header();
$container = get_theme_mod('understrap_container_type');
?>

<div class="wrapper" id="page-wrapper">

    <div class="<?php echo esc_attr($container); ?>" id="content">

        <div class="row justify-content-md-center">

            <div class="col-md-12 content-area" id="primary">

                <h3>Digital Humanities Scholarship: Metadata Export</h3>

                <main class="site-main" id="main" role="main">

                    <?php
                    // Query to get all collections
                    $args = array(
                        'post_type' => 'dhs_collection',
                        'post_status' => 'publish',
                        'meta_query' => array(
                            array(
                                'key' => '_wp_page_template',
                                'value' => 'collection-templates/collection.php',
                            )
                        )
                    );
                    $collection_query = new WP_Query($args);

                    if ($collection_query->have_posts()) :

                        while ($collection_query->have_posts()) :
                            $collection_query->the_post();
                            $collection_id = get_the_ID();
                    ?>

                            <div class="metadata-box">
                                <?php include('collection-templates/metadata-collection.php'); ?>

                                <h3>Chapter Metadata</h3>

                                <?php
                                        // New query to get all chapters of this Collection
                                        $args = array(
                                            'post_type'      => 'dhs_collection',
                                            'posts_per_page' => -1,
                                            'post_parent'    => $collection_id,
                                            'order'          => 'ASC',
                                            'orderby'        => 'menu_order'
                                        );
                                        $chapter = new WP_Query($args);

                                        if ($chapter->have_posts()) :

                                            while ($chapter->have_posts()) :
                                                $chapter->the_post();
                                ?>

                                        <div class="metadata-box">
                                            <?php include('collection-templates/metadata-chapter.php'); ?>
                                        </div>

                                <?php
                                            endwhile;
                                        endif;

                                ?>
                            </div>
                    <?php
                        endwhile;
                    endif;
                    ?>

                </main><!-- #main -->

            </div><!-- #primary -->

        </div><!-- .row end -->

    </div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>