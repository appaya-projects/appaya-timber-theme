<?php 
/*	Template Name: Home template	*/

$data = Timber::get_context();
$data['post'] = new TimberPost();

$data['page'] = 'home';	
$template = array( 'home.twig' );

Timber::render($template, $data );