<?php
	/*
	Plugin Name: CF7 Highrise Plugin
	Plugin URI: 
	Description: Hooks into the CF7's form and adds contacts to Highrise
	Author: Christian Vargas
	Version: 0.1
	Author URI: http://www.cvargas.net
	*/

	if( !defined( 'CF7_HIGHRISE_DIR' ) ){
		define( 'CF7_HIGHRISE_DIR', untrailingslashit( dirname( __FILE__ ) ) );
	}
	if( ! defined( 'CF7_HIGHRISE_BASENAME' ) ){
		define( 'CF7_HIGHRISE_BASENAME', plugin_basename( __FILE__ ) );
	}

	include(CF7_HIGHRISE_DIR.'/admin/functions.php');
?>