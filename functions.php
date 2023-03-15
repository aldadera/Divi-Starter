<?php

/* DIVI ENQUEUE STYLESHEETS
*/

function starter_get_parent_style() {

    wp_enqueue_style( 'divi-styles', get_theme_file_uri( '/style.css' ));
    wp_enqueue_script( 'starter-script', get_theme_file_uri() .'/js/starter.js', array('jquery'), true);
}
add_action( 'wp_enqueue_scripts', 'starter_get_parent_style' );

/* ALLOW SVG
*/

add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

    global $wp_version;
    if ( $wp_version >= '6.1' ) {
       return $data;
    }
  
    $filetype = wp_check_filetype( $filename, $mimes );
  
    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];
  
  }, 10, 4 );
  
  function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }

add_filter( 'upload_mimes', 'cc_mime_types' );
  
  function fix_svg() {
    echo '<style type="text/css">
          .attachment-266x266, .thumbnail img {
               width: 100% !important;
               height: auto !important;
          }
          </style>';
  }
add_action( 'admin_head', 'fix_svg' );

/* TGM PLUGIN ACTIVATION (Add recommended plugins here)
*/

require_once dirname( __FILE__ ) . '/includes/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'starter_register_required_plugins' );
function starter_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
  $plugins = array(
    array(
       'name'     => 'Classic Editor',
       'slug'     => 'classic-editor',
       'required' => false,
     ),
     array(
      'name'     => 'WP Fastest Cache',
      'slug'     => 'wp-fastest-cache',
      'required' => false,
    ),
     /*array( 
       'name'     => 'Ini Untuk Custom Plugin',
       'slug'     => 'plugin-file', // The slug has to match the extracted folder from the zip.
       'source'   => get_template_directory_uri() . '/includes/bundled-plugins/plugin-file-name.zip',
       'required' => true,
     ),*/
   );
 
   /*
    * Array of configuration settings.
   */
   $config = array(
     'id'           => 'tgmpa',
     'default_path' => '/includes/bundled-plugins/',  // Default absolute path to bundled plugins.
     'menu'         => 'install-plugins',             // Menu slug.
     'parent_slug'  => 'themes.php',                  // Parent menu slug.
     'capability'   => 'edit_theme_options',          // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
     'has_notices'  => true,                          // Show admin notices or not.
     'dismissable'  => true,                          // If false, a user cannot dismiss the nag message.
     'is_automatic' => false,                         // Automatically activate plugins after installation or not.
     'strings'      => array(
       'page_title' => __( 'Recommended Plugins', 'theme-slug' ),
       'menu_title' => __( 'Starter Plugins', 'theme-slug' ),
       // <snip>...</snip>
       //  'nag_type'   => 'error', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
     )
   );
   tgmpa( $plugins, $config );
 }