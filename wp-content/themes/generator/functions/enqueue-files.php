<?php 
/*
 * generator Enqueue css and js files
*/
function generator_enqueue()
{
	/* CSS Files */	
	wp_enqueue_style('google-font-api-ubuntu','//fonts.googleapis.com/css?family=Ubuntu');	
	wp_enqueue_style('font-awesome',get_template_directory_uri().'/css/font-awesome.css',array(),'','');
	wp_enqueue_style('bootstrap',get_template_directory_uri().'/css/bootstrap.css',array(),'','');
	wp_enqueue_style('owl-carousel',get_template_directory_uri().'/css/owl.carousel.css',array(),'','');
	/* JS Files */	
	wp_enqueue_script('bootstrap',get_template_directory_uri().'/js/bootstrap.js',array('jquery'));
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri().'/js/owl.carousel.js', array( 'jquery' ), '20131209', true );	
	wp_enqueue_script('generator-default',get_template_directory_uri().'/js/default.js',array('jquery'));	
	if ( is_singular() ) wp_enqueue_script( "comment-reply" ); 
	
	wp_enqueue_style('generator-style',get_stylesheet_uri(),array(),'','');
}
add_action('wp_enqueue_scripts', 'generator_enqueue');