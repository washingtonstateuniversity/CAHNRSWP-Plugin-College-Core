<?php
/*
Plugin Name: CAHNRSWP College Core
Plugin URI: http://cahnrs.wsu.edu/communications
Description: Core Features and Shortcodes
Author: cahnrscommunications, Danial Bleile
Author URI: http://cahnrs.wsu.edu/communications
Version: 1.0.0
*/

class CAHNRSWP_College_Core {
	
	// @ var object $instance Current instance of CAHNRSWP_College_Core
	private static $instance;
	
	// @var object $people Current instance of CAHNRSWP_College_Core_People
	public $people;
	
	/**
	 * Singleton Pattern - only one instance of 
	 * class exists
	**/ 
	public static function get_instance(){
		
		if ( null == self::$instance ) {
            self::$instance = new self;
			self::$instance->init_plugin();
        } // end if
 
        return self::$instance;
		
	} // end get_instance

	
	public function init_plugin(){
		
		// init people
		require_once 'classes/class-cahnrswp-college-people.php';
		
		$this->people = new CAHNRSWP_College_People();
		
		add_action( 'init' , array( $this->people , 'plugin_init' ) );
		
		add_action( 'wp_enqueue_scripts', array( $this , 'register_public_scripts' ) );
		
	} // end init_plugin
	
	/**
	 * Enqueue public scripts
	 */
	public function register_public_scripts(){
		
		wp_enqueue_style( 'cahnrs-people-css', plugins_url( 'css/style.css' , __FILE__ ) , false , '0.0.1' );
		
	} // end register_public_scripts
	
	
} // end CAHNRSWP_College_Core

CAHNRSWP_College_Core::get_instance();