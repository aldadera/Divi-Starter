<?php

/*	-----------------------------------------------------------------------------------------------
	DIVI ENQUEUE STYLESHEETS
--------------------------------------------------------------------------------------------------- */

function starter_get_parent_style() {

    wp_enqueue_style( 'divi-styles', get_theme_file_uri( '/style.css' ), array());

}
add_action( 'wp_enqueue_scripts', 'starter_get_parent_style' );