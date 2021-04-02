<?php

/**
 * Enqueue scripts and styles.
 */
function anews_scripts_styles()
{
	global $wp_styles;
	global $wp_scripts;
	// init JS
	wp_enqueue_script('anews-app.js', get_template_directory_uri() . '/static/js/app.js', array(), false, true);

	// init CSS
	wp_enqueue_style('anews-style', get_stylesheet_uri(), array(), false, 'all');
	wp_enqueue_style('anews-stylebase', get_template_directory_uri() . '/static/css/style.css', array(), false, 'all');
}
add_action('wp_enqueue_scripts', 'anews_scripts_styles');

function anews_show_post_types($query)
{
	// que no sea el admin y sea el query principal
	if (!is_admin() && $query->is_main_query()){
		// query a la home page
		if(is_home()){
			$query->set('post_type', array('post', 'noticia'));
			$query->set('posts_per_page', 13);
		}
	}
}
add_action('pre_get_posts', 'anews_show_post_types');
