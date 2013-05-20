<?php
/*
Plugin Name: Genesis Title Toggle
Plugin URI: http://www.billerickson.net/
Description: Turn on/off page titles on a per page basis, and set sitewide defaults from Theme Settings. Must be using the Genesis theme.
Version: 1.5
Author: Bill Erickson
Author URI: http://www.billerickson.net
License: GPLv2
*/

class BE_Title_Toggle {
	var $instance;
	
	function __construct() {
		$this->instance =& $this;
		register_activation_hook( __FILE__, array( $this, 'activation_hook' ) );
		add_action( 'init', array( $this, 'init' ) );	
	}
	
	function init() {
		// Translations
		load_plugin_textdomain( 'genesis-title-toggle', false, basename( dirname( __FILE__ ) ) . '/languages' );

		// Metabox on Theme Settings, for Sitewide Default
		add_filter( 'genesis_theme_settings_defaults', array( $this, 'setting_defaults' ) );
		add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitization' ) );
		add_action( 'genesis_theme_settings_metaboxes', array( $this, 'register_metabox' ) );
		
		// Metabox on Edit screen, for Page Override
		add_filter( 'cmb_meta_boxes', array( $this, 'create_metaboxes' ) );
		add_action( 'init', array( $this, 'initialize_cmb_meta_boxes' ), 50 );
		
		// Removes Page Title
		add_action( 'genesis_before', array( $this, 'title_toggle' ) );
		
		// If using post formats, have to hook in later for some themes
		if( current_theme_supports( 'post-formats' ) )
			add_action( 'genesis_before_post', array( $this, 'title_toggle' ), 20 );
	}
	
	/**
	 * Activation Hook - Confirm site is using Genesis
	 *
	 */
	function activation_hook() {
		if ( 'genesis' != basename( TEMPLATEPATH ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( sprintf( __( 'Sorry, you can&rsquo;t activate unless you have installed <a href="%s">Genesis</a>', 'genesis-title-toggle'), 'http://www.billerickson.net/get-genesis' ) );
		}
	}
	
	/**
	 * Sitewide Setting - Register Defaults
	 * @link http://www.billerickson.net/genesis-theme-options/
	 *
	 * @param array $defaults
	 * @return array modified defaults
	 *
	 */
	function setting_defaults( $defaults ) {
		$post_types = apply_filters( 'be_title_toggle_post_types', array( 'page' ) );
		foreach ( $post_types as $post_type )
			$defaults[] = array( 'be_title_toggle_' . $post_type => '' );
		return $defaults;
	}
	
	/** 
	 * Sitewide Setting - Sanitization
	 * @link http://www.billerickson.net/genesis-theme-options/
	 *
	 */
	function sanitization() {
		$fields = array();
		$post_types = apply_filters( 'be_title_toggle_post_types', array( 'page' ) );
		foreach ( $post_types as $post_type )
			$fields[] = 'be_title_toggle_' . $post_type;
			
	    genesis_add_option_filter( 'one_zero', GENESIS_SETTINGS_FIELD, $fields );	
	}
	
	/**
	 * Sitewide Setting - Register Metabox
	 * @link http://www.billerickson.net/genesis-theme-options/
	 *
	 * @param string, Genesis theme settings page hook
	 */
	
	function register_metabox( $_genesis_theme_settings_pagehook ) {
		add_meta_box('be-title-toggle', __( 'Title Toggle', 'genesis-title-toggle' ), array( $this, 'create_sitewide_metabox' ), $_genesis_theme_settings_pagehook, 'main', 'high');
	}
	
	/**
	 * Sitewide Setting - Create Metabox
	 * @link http://www.billerickson.net/genesis-theme-options/
	 *
	 */
	function create_sitewide_metabox() {
		$post_types = apply_filters( 'be_title_toggle_post_types', array( 'page' ) );
		foreach ( $post_types as $post_type )
			echo '<p><input type="checkbox" name="' . GENESIS_SETTINGS_FIELD . '[be_title_toggle_' . $post_type . ']" id="' . GENESIS_SETTINGS_FIELD . '[be_title_toggle_' . $post_type . ']" value="1" ' . checked( 1, genesis_get_option( 'be_title_toggle_' . $post_type ), false ) .' /> <label for="' . GENESIS_SETTINGS_FIELD . '[be_title_toggle_' . $post_type . ']"> ' . sprintf( __( 'By default, remove titles in the <strong>%s</strong> post type.', 'genesis-title-toggle' ), $post_type ) .'</label></p>';

	
	}
	 
	/**
	 * Create Page Specific Metaboxes
	 * @link http://www.billerickson.net/wordpress-metaboxes/
	 *
	 * @param array $meta_boxes, current metaboxes
	 * @return array $meta_boxes, current + new metaboxes
	 *
	 */
	function create_metaboxes( $meta_boxes ) {
	
		// Make sure we're still in Genesis, plugins like WP Touch need this check
		if ( !function_exists( 'genesis_get_option' ) )
			return $meta_boxes;

		
		// Get all post types used by plugin and split them up into show and hide.
		// Sitewide default checked = hide by default, so metabox should let you override that and show the title
		// Sitewide default empty = display by default, so metabox should let you override that and hide the title
		
		$show = array();
		$hide = array();
		$post_types = apply_filters( 'be_title_toggle_post_types', array( 'page' ) );
		foreach ( $post_types as $post_type ) {
			$default = genesis_get_option( 'be_title_toggle_' . $post_type );
			if ( !empty( $default ) ) $show[] = $post_type;
			else $hide[] = $post_type;
		}
		
		
		// Create the show and hide metaboxes that override the default
		
		if ( !empty( $show ) ) {
			$meta_boxes[] = array(
				'id' => 'be_title_toggle_show',
				'title' => __( 'Title Toggle', 'genesis-title-toggle' ),
				'pages' => $show,
				'context' => 'normal',
				'priority' => 'high',
				'show_names' => true,
				'fields' => array(
					array(
						'name' => __( 'Show Title', 'genesis-title-toggle' ),
						'desc' => __( 'By default, this post type is set to remove titles. This checkbox lets you show this specific page&rsquo;s title', 'genesis-title-toggle' ),
						'id' => 'be_title_toggle_show',
						'type' => 'checkbox'
					)
				)
			);
		}

		if ( !empty( $hide ) ) {
			$meta_boxes[] = array(
				'id' => 'be_title_toggle_hide',
				'title' => __( 'Title Toggle', 'genesis-title-toggle' ),
				'pages' => $hide,
				'context' => 'normal',
				'priority' => 'high',
				'show_names' => true,
				'fields' => array(
					array(
						'name' => __( 'Hide Title', 'genesis-title-toggle' ),
						'desc' => __( 'By default, this post type is set to display titles. This checkbox lets you hide this specific page&rsquo;s title', 'genesis-title-toggle' ),
						'id' => 'be_title_toggle_hide',
						'type' => 'checkbox'
					)
				)
			);
		}
		
		return $meta_boxes;
	}

	function initialize_cmb_meta_boxes() {
		$post_types = apply_filters( 'be_title_toggle_post_types', array( 'page' ) );
	    if ( !class_exists('cmb_Meta_Box') && !empty( $post_types ) ) {
	        require_once( dirname( __FILE__) . '/lib/metabox/init.php' );
	    }
	}
	
	function title_toggle() {
		// Make sure we're on the single page
		if ( !is_singular() )
			return;
		
		global $post;	
		$post_type = get_post_type( $post );
		
		// See if post type has pages turned off by default
		$default = genesis_get_option( 'be_title_toggle_' . $post_type );
		
		// If titles are turned off by default, let's check for an override before removing
		if ( !empty( $default ) ) {
			$override = get_post_meta( $post->ID, 'be_title_toggle_show', true );
			
			// If override is empty, get rid of that title
			if (empty( $override ) ) {
				remove_action( 'genesis_post_title', 'genesis_do_post_title' );
				remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
			}
				
		// If titles are turned on by default, let's see if this specific one is turned off
		} else {
			$override = get_post_meta( $post->ID, 'be_title_toggle_hide', true );
			
			// If override has a value, the title's gotta go
			if ( !empty( $override ) ) {
				remove_action( 'genesis_post_title', 'genesis_do_post_title' );
				remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
			}
		}
	}
}

new BE_Title_Toggle;