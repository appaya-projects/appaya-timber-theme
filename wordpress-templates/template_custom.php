<?php 
/*	Template Name: Custom template	*/

$data = Timber::get_context();
$data['post'] = new TimberPost();

$data['page'] = 'page';	
$template = array( 'page-custom.twig' );

Timber::render($template, $data );