<?php

include('customizer.php');

function understrap_remove_scripts()
{
	// Removes the parent themes stylesheet and scripts from inc/enqueue.php
	wp_dequeue_style('understrap-styles');
	wp_deregister_style('understrap-styles');

	wp_dequeue_script('understrap-scripts');
	wp_deregister_script('understrap-scripts');
}

// Override the parent theme function, removing the parenthetical edit dates
function understrap_posted_on()
{
	/* // Original functionality, from Understrap
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}
	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);
	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'understrap' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
	*/
	$byline = sprintf(
		esc_html_x('Posted by %s', 'post author', 'understrap'),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
	);
	echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
}

function dhs_setup_options () {		// Loaded when theme is first activated, used for default settings
	
	// CUSTOMIZE: If you want a sidebar displayed, this option can be changed in Appearance > Customize > Theme Layout Settings
	// Please note: This theme was not designed to make use of a sidebar, so the layout will need to be customized to your theme
	set_theme_mod('understrap_sidebar_position','none');
	
}
add_action('after_switch_theme', 'dhs_setup_options');

function dhs_enqueue_styles()
{

	// Get the theme data
	$the_theme = wp_get_theme();
	wp_enqueue_style('dhs-styles', get_stylesheet_directory_uri() . '/css/theme.min.css');
	wp_enqueue_style('dhs-styles-custom', get_stylesheet_directory_uri() . '/css/dhs.css', array(), $the_theme->get('Version'));
	wp_enqueue_script('jquery');
	wp_enqueue_script('popper-scripts', get_stylesheet_directory_uri() . '/js/popper.min.js', array(), false);
	wp_enqueue_script('dhs-scripts', get_stylesheet_directory_uri() . '/js/theme.js', array(), $the_theme->get('Version'), true);
	wp_enqueue_script('dhs-scripts', get_stylesheet_directory_uri() . '/js/dhs.js', array(), false);
	if (get_post_type() == 'dhs_closereading') {
		wp_enqueue_script('closereading', get_stylesheet_directory_uri() . '/js/closereading.js', array(), false);
	}


	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	wp_enqueue_script('jquery-ui-sortable');
}


add_action('wp_enqueue_scripts', 'understrap_remove_scripts', 20);
add_action('wp_enqueue_scripts', 'dhs_enqueue_styles');

add_theme_support('post-thumbnails');

function custom_theme_setup()
{
	add_image_size('grid-thumbnail', 240, 240, true);
	//add_image_size('edg-thumbnail', 349, 195, array('left','top'));
	add_image_size('edg-thumbnail', 349, 195, true);
	add_image_size('edg-thumbnail-sm', 250, 150, true);
	add_image_size('bio-thumbnail', 349, 349, true);
	add_image_size('medium', get_option('medium_size_w'), get_option('medium_size_h'), true);
}
add_action('after_setup_theme', 'custom_theme_setup');

function my_custom_sizes($sizes)
{
	return array_merge($sizes, array(
		'edg-thumbnail' => __('En Dehors Garde Thumbnail'),
		'bio-thumbnail' => __('Biography Thumbnail'),
	));
}
add_filter('image_size_names_choose', 'my_custom_sizes');

function dhs_custom_excerpt_length($length)
{
	return 20;
}
add_filter('excerpt_length', 'dhs_custom_excerpt_length', 999);

function wpd_tax_alpha($query)
{
	if ($query->is_category('biography') && $query->is_main_query()) {
		$query->set('orderby', 'title');
		$query->set('order', 'ASC');
	}
}
add_action('pre_get_posts', 'wpd_tax_alpha');

remove_action('shutdown', 'wp_ob_end_flush_all', 1);

// DHS Custom Metadata page, as reserved URL
/*add_action('init', function () {
	$url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
	if ($url_path === get_theme_mod('dhs_metadata_permalink')) {
		// load the file if exists
		// CUSTOMIZE: Replace the template- filename below with your replacement template, if desired
		$load = locate_template('template-metadata.php', true);
		if ($load) {
			//exit(); // just exit if template was found and loaded
		}
	}

});
*/



/**
 * Class WP_Bootstrap_Navwalker
 * GitHub URI: https://github.com/twittem/wp-bootstrap-navwalker
 * Description: A custom WordPress nav walker class to implement the Bootstrap 4
 * navigation style in a custom theme using the WordPress built in menu manager.
 * Version: 2.0.4
 * Author: Edward McIntyre - @twittem
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
class understrap_WP_Bootstrap_Navwalker extends Walker_Nav_Menu
{
	/**
	 * The starting level of the menu.
	 *
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth Depth of page. Used for padding.
	 * @param mixed  $args Rest of arguments.
	 */
	public function start_lvl(&$output, $depth = 0, $args = array())
	{
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\" dropdown-menu\" role=\"menu\">\n";
	}

	/**
	 * Open element.
	 *
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int    $depth Depth of menu item. Used for padding.
	 * @param mixed  $args Rest arguments.
	 * @param int    $id Element's ID.
	 */
	public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
	{
		$indent = ($depth) ? str_repeat("\t", $depth) : '';
		/**
		 * Dividers, Headers or Disabled
		 * =============================
		 * Determine whether the item is a Divider, Header, Disabled or regular
		 * menu item. To prevent errors we use the strcasecmp() function to so a
		 * comparison that is not case sensitive. The strcasecmp() function returns
		 * a 0 if the strings are equal.
		 */
		if (strcasecmp($item->attr_title, 'divider') == 0 && $depth === 1) {
			$output .= $indent . '<li class="dropdown-divider" role="presentation">';
		} else if (strcasecmp($item->title, 'divider') == 0 && $depth === 1) {
			$output .= $indent . '<li class="dropdown-divider" role="presentation">';
		} else if (strcasecmp($item->attr_title, 'dropdown-header') == 0 && $depth === 1) {
			$output .= $indent . '<li class="dropdown-header" role="presentation">' . esc_html($item->title);
		} else if (strcasecmp($item->attr_title, 'disabled') == 0) {
			$output .= $indent . '<li class="disabled" role="presentation"><a href="#">' . esc_html($item->title) . '</a>';
		} else {
			$class_names = $value = '';
			$classes     = empty($item->classes) ? array() : (array) $item->classes;
			$classes[]   = 'nav-item menu-item-' . $item->ID;
			$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
			/*
			if ( $args->has_children )
			  $class_names .= ' dropdown';
			*/
			if ($args->has_children && $depth === 0) {
				$class_names .= ' dropdown';
			} elseif ($args->has_children && $depth > 0) {
				$class_names .= ' dropdown-submenu';
			}
			if (in_array('current-menu-item', $classes)) {
				$class_names .= ' active';
			}
			// remove Font Awesome icon from classes array and save the icon
			// we will add the icon back in via a <span> below so it aligns with
			// the menu item
			if (in_array('fa', $classes)) {
				$key         = array_search('fa', $classes);
				$icon        = $classes[$key + 1];
				$class_names = str_replace($classes[$key + 1], '', $class_names);
				$class_names = str_replace($classes[$key], '', $class_names);
			}

			$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
			$id          = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
			$id          = $id ? ' id="' . esc_attr($id) . '"' : '';
			$output .= $indent . '<li' . $id . $value . $class_names . '>';
			$atts           = array();
			if (empty($item->attr_title)) {
				$atts['title'] = !empty($item->title) ? strip_tags($item->title) : '';
			} else {
				$atts['title'] = $item->attr_title;
			}
			$atts['target'] = !empty($item->target) ? $item->target : '';
			$atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
			// If item has_children add atts to a.

			if ($args->has_children && $depth === 0) {
				$atts['href']        = '#';
				$atts['data-toggle'] = 'dropdown';
				$atts['class']       = 'nav-link dropdown-toggle';
			} else {
				$atts['href']  = !empty($item->url) ? $item->url : '';
				$atts['class'] = 'nav-link';
			}
			$atts       = apply_filters('nav_menu_link_attributes', $atts, $item, $args);
			$attributes = '';
			foreach ($atts as $attr => $value) {
				if (!empty($value)) {
					$value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}
			$item_output = $args->before;
			// Font Awesome icons
			if (!empty($icon)) {
				$item_output .= '<a' . $attributes . '><span class="fa ' . esc_attr($icon) . '"></span>&nbsp;';
			} else {
				$item_output .= '<a' . $attributes . '>';
			}
			$item_output .= $args->link_before . apply_filters(
				'the_title',
				$item->title,
				$item->ID
			) . $args->link_after;
			$item_output .= ($args->has_children && 0 === $depth) ? ' <span class="caret"></span></a>' : '</a>';
			$item_output .= $args->after;
			$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
		}
	}

	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth.
	 *
	 * This method shouldn't be called directly, use the walk() method instead.
	 *
	 * @see Walker::start_el()
	 * @since 2.5.0
	 *
	 * @param object $element Data object
	 * @param array  $children_elements List of elements to continue traversing.
	 * @param int    $max_depth Max depth to traverse.
	 * @param int    $depth Depth of current element.
	 * @param array  $args
	 * @param string $output Passed by reference. Used to append additional content.
	 *
	 * @return null Null on failure with no changes to parameters.
	 */
	public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
	{
		if (!$element) {
			return;
		}
		$id_field = $this->db_fields['id'];
		// Display this element.
		if (is_object($args[0])) {
			$args[0]->has_children = !empty($children_elements[$element->$id_field]);
		}
		parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}

	/**
	 * Menu Fallback
	 * =============
	 * If this function is assigned to the wp_nav_menu's fallback_cb variable
	 * and a manu has not been assigned to the theme location in the WordPress
	 * menu manager the function with display nothing to a non-logged in user,
	 * and will add a link to the WordPress menu manager if logged in as an admin.
	 *
	 * @param array $args passed from the wp_nav_menu function.
	 *
	 */
	public static function fallback($args)
	{
		if (current_user_can('manage_options')) {
			extract($args);
			$fb_output = null;
			if ($container) {
				$fb_output = '<' . $container;
				if ($container_class) {
					$fb_output .= ' class="' . $container_class . '"';
				}
				if ($container_id) {
					$fb_output .= ' id="' . $container_id . '"';
				}
				$fb_output .= '>';
			}
			$fb_output .= '<ul';
			if ($menu_class) {
				$fb_output .= ' class="' . $menu_class . '"';
			}
			if ($menu_id) {
				$fb_output .= ' id="' . $menu_id . '"';
			}
			$fb_output .= '>';
			$fb_output .= '<li><a href="' . admin_url('nav-menus.php') . '">Add a menu</a></li>';
			$fb_output .= '</ul>';
			if ($container) {
				$fb_output .= '</' . $container . '>';
			}
			echo $fb_output;
		}
	}
}