<?php

add_action( 'customize_register', 'cd_customizer_settings' );
function cd_customizer_settings( $wp_customize ) {

	// Colors section
	$wp_customize->add_section( 'cd_colors' , array(
		'title'      => 'Colors',
		'priority'   => 30,
	) );	
	$wp_customize->add_setting( 'background_color' , array(
		'default'     => '#43C6E4'
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
		'label'        => 'Background Color',
		'section'    => 'cd_colors',
		'settings'   => 'background_color',
	) ) );	

	// Metadata Section
	$wp_customize->add_section( 'cd_metadata' , array(
		'title'      => 'Metadata',
		'priority'   => 30,
	) );

	$wp_customize->add_setting( 'collection_name_text' , array(
		'default'     => 'My Collection'
	) );
	$wp_customize->add_setting( 'collection_collex_archive_text' , array(
		'default'     => 'collection'
	) );
	$wp_customize->add_setting( 'collection_chapters_url' , array(
		'default'     => 'http://'
	) );
	$wp_customize->add_setting( 'collection_collex_federation' , array(
		'default'     => 'ModNets'
	) );

	$wp_customize->add_control( 'collection_name_text', array(
		'label'        => 'Collection Name',
		'section'    => 'cd_metadata',
		'type'   => 'text',
	) );
	$wp_customize->add_control( 'collection_collex_archive_text', array(
		'label'        => 'Shorthand Archive Reference',
		'section'    => 'cd_metadata',
		'type'   => 'text',
	) );	
	$wp_customize->add_control( 'collection_chapters_url', array(
		'label'        => 'Collection Table of Contents URL',
		'section'    => 'cd_metadata',
		'type'   => 'text',
	) );
	$wp_customize->add_control( 'collection_collex_federation', array(
		'label'        => 'Collection Federation',
		'section'    => 'cd_metadata',
		'type'   => 'text',
	) );

}

add_action( 'wp_head', 'cd_customizer_css');
function cd_customizer_css()
{
    ?>
         <style type="text/css">
             body { background: #<?php echo get_theme_mod('background_color', '#43C6E4'); ?>; }
         </style>
    <?php
}


?>