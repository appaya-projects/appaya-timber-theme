<?php
/**
 * AWT Class: The main class of theme
 * 
 * @author   Mateusz Szmytko
 * @since    1.0.0
 * @package  AWT
 */

require 'site.php';

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AppayaWpTheme {
	function __construct() {


		add_action( 'after_setup_theme',          array( $this, 'setup' ) );
		
		add_filter( 'body_class',                 array( $this, 'body_classes' ) );

		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		// add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		
	}

	public function setup() {
		load_theme_textdomain( 'AWT', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats' );
		
		add_theme_support( 'custom-logo', array() );
		

		register_nav_menus( array(
			'primary'   => __( 'Primary Menu', 'AWT' ),
		) );

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		add_theme_support( 'customize-selective-refresh-widgets' );	

	}

	function add_to_context( $context ) {
		$context['site'] = new Site();
		return $context;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );


		$twig->addFilter(new Twig_SimpleFilter('t', array($this, 'translate')));
		$twig->addFilter(new Twig_SimpleFilter('image_url', array($this, 'image_url')));
		$twig->addFilter(new Twig_SimpleFilter('static_url', array($this, 'static_url')));
		
		return $twig;
	}

	public function translate($text) {
		return $text;
	}

	public function image_url($text) {
		$directory = get_template_directory_uri() .'/static/images/'. $text;

		return $directory;
	}

	public function static_url($text) {
		$directory = get_template_directory_uri() .'/static/'. $text;

		return $directory;
	}


	public function body_classes( $classes ) {
		// Adds a class of hfeed to non-singular pages.
		$classes[] = 'AWT';

		return $classes;
	}
}


return new AppayaWpTheme();
?>