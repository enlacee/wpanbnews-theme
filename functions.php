<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
	});

	add_filter('template_include', function($template) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});

	return;
}

Timber::$dirname = array('templates', 'views');

class StarterSite extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		parent::__construct();
	}

	function register_post_types() {
		//this is where you can register custom post types
	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

	function add_to_context( $context ) {
		$context['menu'] = new TimberMenu();
		$context['site'] = $this;
		$context['thumbnailDefault'] = get_template_directory_uri() . '/static/images/thumbnail.178x150.jpg';
		// vars
		$context['appVars'] = array(
			'taxonomyNew' => 'category-new',//Anbnews_Admin_CustomPost::taxonomyNew,
			'taxonomyNewTag' => 'category-new-tag',//Anbnews_Admin_CustomPost::taxonomyNewTag,
			'taxonomyAgency' => 'agencia'//Anbnews_Admin_CustomPost::taxonomyAgency
		);

		// post *deportes*
		$context['postsNews'] = Timber::get_posts(array(
			'post_type' => 'noticia',
			'category-new' => 'el-comercio-peru',
			'numberposts' => 6
		));

		// post *deportes*
		$context['postsEconomy'] = Timber::get_posts(array(
			'post_type' => 'noticia',
			'category-new' => 'rpp-noticias',
			'numberposts' => 6
		));

		$context['postsSport'] = Timber::get_posts(array(
			'post_type' => 'noticia', //category-new
			//'category' => 'deportes',
			'category-new' => 'diario-depor',
			'numberposts' => 6
		));

		return $context;
	}

	function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
		return $twig;
	}

}

new StarterSite();

require_once 'functions/functions.php';
