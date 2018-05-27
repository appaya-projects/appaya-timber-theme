<?php
/**
 *
 * @package AppayaWPTheme
 */

$data = Timber::get_context();

if ( is_singular() ) :
	$data['post'] = new TimberPost();
else : 
	$data['posts'] = new Timber\PostQuery();
endif;


if ( is_single() ) :
	$data['page'] = 'single';	
	$template = array( 'single-' . $post->ID. '.twig', 'single-' . $post->post_type. '.twig', 'single.twig' );
elseif ( is_front_page() ) :
	$data['page'] = 'home';
	$template = array('home.twig' );
elseif ( is_page() ) :
	$data['page'] = 'page';	
	$template = array( 'page-' . $post->post_name. '.twig', 'page.twig' );
elseif ( is_category() ) :
	$data['archive_title'] = get_cat_name( get_query_var('cat') );
	$data['archive_description'] = term_description();
	$data['page'] = 'archive';
	$template = array('archive.twig' );
elseif ( is_tag() ) :
	$data['archive_title'] = get_term_name( get_query_var('tag_id') );
	$data['archive_description'] = term_description();
	$data['page'] = 'archive';
	$template = array('archive.twig' );
elseif ( is_author() ) :
	$data['archive_title'] = get_the_author();
	$data['page'] = 'archive';
	$template = array('archive.twig' );	
else: 
	$data['page'] = '404';
	$template = array('404.twig' );
endif;

Timber::render($template, $data );