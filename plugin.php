<?php
/**
 * Plugin Name: Ultimate Bootstrap Blocks
 * Plugin URI: https://gutenberglab.com/bootstrap-blocks-for-gutenberg-editor/
 * Description: UBB — Plugin to add bootstrap 4 elements/snippets to Gutenberg Editor.
 * Author: Gutenberglab
 * Author URI: https://gutenberglab.com
 * Version: 1.2.6
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'src/init.php';

function ubb_category( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'ultimate-bootstrap-blocks',
				'title' => __( 'Ultimate Bootstrap Blocks', 'Ultimate Bootstrap Blocks' ),
			),
		)
	);
}
add_filter( 'block_categories', 'ubb_category', 10, 2);



/**
 * Block Initializer.
 */
 
function ubb_settings_link($links) { 
	$settings_link = '<a href="admin.php?page=ultimate-bootstrap-blocks.php">Settings</a>'; 
	array_unshift($links, $settings_link); 
	return $links; 
  }
  
  $plugin = plugin_basename(__FILE__); 
  add_filter("plugin_action_links_$plugin", 'ubb_settings_link' );
  
  
  add_action( 'admin_menu', 'ubb_menu' );
  
  function ubb_menu() {
	  add_menu_page( 'UBB Settings', 'UBB Settings', 'manage_options', 'ultimate-bootstrap-blocks.php', 'UBB_Settings', '', "110"  );
  }
  
  function UBB_Settings(){
	  ?>
	  <div class="wrap">
		  <h2>UBB Settings </h2>
		  
		  <form method="post" action="options.php">
			  <?php
				 settings_fields("section");
   
				 do_settings_sections("bootCSS");
				 echo "<div>If checked, then Bootstrap CSS will automatically be inserted into the head of your website. </div>";
  
				 do_settings_sections("bootjs");
				 echo "<div>If checked, then Bootstrap JS will automatically be inserted into the footer of your website. jQuery will not be loaded.</div>";  
				 submit_button();
			  ?>
		  </form>
		  
		   
	  </div>
	  <?php
  }
  
  function ubbCSS_settings_page()
  {
	  add_settings_section("section", "CSS", null, "bootCSS");
	  add_settings_field("bootCSS-checkbox", "Include Bootstrap CSS?", "ubb_checkbox_display", "bootCSS", "section");  
	  register_setting("section", "bootCSS-checkbox");
  
  }
  function ubbjs_settings_page()
  {
  
	  
	  add_settings_section("section", "JS", null, "bootjs");
	  add_settings_field("bootjs-checkbox", "Include Bootstrap Javascripts?", "ubbjs_checkbox_display", "bootjs", "section");  
	  register_setting("section", "bootjs-checkbox");
  }
  
  function ubb_checkbox_display()
  {
	 ?>
		  <!-- Here we are comparing stored value with 1. Stored value is 1 if user checks the checkbox otherwise empty string. -->
		  <input type="checkbox" name="bootCSS-checkbox" value="1" <?php checked(1, get_option('bootCSS-checkbox'), true); ?> />
	 <?php
  }
  
  add_action("admin_init", "ubbCSS_settings_page");
  
  function ubbjs_checkbox_display()
  {
	 ?>
		  <!-- Here we are comparing stored value with 1. Stored value is 1 if user checks the checkbox otherwise empty string. -->
		  <input type="checkbox" name="bootjs-checkbox" value="1" <?php checked(1, get_option('bootjs-checkbox'), true); ?> />
	 <?php
  }
  
  
  add_action("admin_init", "ubbjs_settings_page");
	  
  $bootCSS = get_option('bootCSS-checkbox', '');
  if($bootCSS == '1') {
	  wp_enqueue_style( 'bootstrapCSS', plugin_dir_url( __FILE__ ) . 'assets/css/bootstrap.min.css',false,'4.6.1','all');
	
  
  } 
  
  $bootjs = get_option('bootjs-checkbox', '');
  if($bootjs == '1') {
	  wp_enqueue_script( 'bootstrapjs', plugin_dir_url( __FILE__ ) . 'assets/js/bootstrap.bundle.min.js',true,'4.6.1','all');
	
  
  }