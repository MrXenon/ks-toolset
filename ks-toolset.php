<?php
defined( 'ABSPATH' ) OR exit;
/**
 * Plugin Name: KS TOOLSET
 * Plugin URI: https://kevinschuit.com 
 * Description: Toolset by Kevin Schuit
 * Version: 1.0.0
 * Author: Kevin Schuit
 * Author URI: https://kevinschuit.com
 * Text Domain: ks-toolset
 * Domain Path: /lang/
 * Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
 
 define ( 'KS_TOOLSET_PLUGIN', __FILE__ );

 //Inculde the general defenition file:
 require_once plugin_dir_path ( __FILE__ ) . 'includes/defs.php';
 require_once( 'KSTOOLPluginUpdater.php' );

/* Register the hooks */
    register_activation_hook( __FILE__, array( 'KsToolset', 'on_activation' ) );
    register_deactivation_hook( __FILE__, array( 'KsToolset', 'on_deactivation' ) );
 
 class KsToolset
 {
     public function __construct()
     {
         do_action('ks_toolset_pre_init');
         add_action('init', array($this, 'init'), 1);
     }

     public static function on_activation()
     {
         if ( ! current_user_can( 'activate_plugins' ) )
             return;
         $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
         check_admin_referer( "activate-plugin_{$plugin}" );

         KsToolset::createDb();
     }
     public static function on_deactivation()
     {
         if ( ! current_user_can( 'activate_plugins' ) )
             return;
         $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
         check_admin_referer( "deactivate-plugin_{$plugin}" );
     }

     public function init()
     {

        add_filter( 'plugin_row_meta', [$this, 'custom_plugin_row_meta'], 10, 2 );
         do_action('ks_toolset_init');

         if (is_admin()) {
             $this->requireAdmin();
             $this->createAdmin();
             new KSTOOLPluginUpdater( __FILE__, 'MrXenon', "ks-toolset" );
         } else {
         }

         $this->loadViews();
     }

     public function custom_plugin_row_meta( $links, $file ) 
    {
        if ( strpos( $file, 'ks-toolset.php' ) !== false ) {
            $new_links = array(
                '<a href="'.admin_url().'admin.php?page=ks_support">Support</a>',
                   '<a href="'.admin_url().'admin.php?page=ks_dashboard">Dashboard</a>'
			);
		
		$links = array_merge( $links, $new_links );
	}
	
	return $links;
    }

     public function requireAdmin()
     {
         require_once KS_TOOLSET_PLUGIN_ADMIN_DIR . '/KsToolset_AdminController.php';
     }

     public function createAdmin()
     {
         KsToolset_AdminController::prepare();
     }

     public function loadViews()
     {
         include KS_TOOLSET_PLUGIN_INCLUDES_VIEWS_DIR . '/view_shortcodes.php';
     }

     public static function createDb()
     {

         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

         //Calling $wpdb;
         global $wpdb;

         $charset_collate = $wpdb->get_charset_collate();

         $prefix = 'ks_';

         //Name of the table that will be added to the db
         $colorChange       =    $wpdb->prefix .$prefix. "color_changer";

         $shortcodes		=	 $wpdb->prefix .$prefix. "shortcodes";
		 $author			=	 $wpdb->prefix .$prefix. "author";
		 $updateLog			=	 $wpdb->prefix .$prefix. "update";
         $choice            =    $wpdb->prefix .$prefix. "choice";


         //Create the submissions table
         $sql = "CREATE TABLE IF NOT EXISTS $colorChange (
            cid INT(11) NOT NULL AUTO_INCREMENT,
            color_default VARCHAR(7) NOT NULL,
            color_new VARCHAR(7) NOT NULL,
            PRIMARY KEY  (cid))
            ENGINE = InnoDB $charset_collate";
         dbDelta($sql);

         $wpdb->query("DROP TABLE $shortcodes");

		 $sql = "CREATE TABLE IF NOT EXISTS $shortcodes (
            sid BIGINT(11) NOT NULL AUTO_INCREMENT,
            short_name VARCHAR(64) NOT NULL,
            short_desc VARCHAR(1024) NOT NULL,
            PRIMARY KEY  (sid))
            ENGINE = InnoDB $charset_collate";
         dbDelta($sql);

         $wpdb->query("DROP TABLE $author");

		 $sql = "CREATE TABLE IF NOT EXISTS $author (
            aid BIGINT(11) NOT NULL AUTO_INCREMENT,
            author_name VARCHAR(64) NOT NULL,
			author_email VARCHAR(64) NOT NULL,
			author_website VARCHAR(64) NOT NULL,
            PRIMARY KEY  (aid))
            ENGINE = InnoDB $charset_collate";
         dbDelta($sql);


        $wpdb->query("DROP TABLE $updateLog");

        $sql = "CREATE TABLE IF NOT EXISTS $updateLog (
            uid BIGINT(11) NOT NULL AUTO_INCREMENT,
            update_version VARCHAR(64) NOT NULL,
            update_desc VARCHAR(2048) NOT NULL,
            update_list TEXT(2048) NOT NULL,
            future_desc VARCHAR(2048) NOT NULL,
            PRIMARY KEY  (uid))
            ENGINE = InnoDB $charset_collate";
        dbDelta($sql);    

        $wpdb->query("DROP TABLE $choice");

        $sql = "CREATE TABLE IF NOT EXISTS $choice (
            choice_id BIGINT(11) NOT NULL AUTO_INCREMENT,
            choice_name VARCHAR(64) NOT NULL,
            choice_var VARCHAR(1) NOT NULL,
            PRIMARY KEY  (choice_id))
            ENGINE = InnoDB $charset_collate";
        dbDelta($sql);  

        $sql = "INSERT INTO `$shortcodes` (`sid`, `short_name`,`short_desc`) VALUES
            (1, '[ks_change_color]','This shortcode when included, swaps out the color of the page, with the inserted default and changes it into the new inserted color.');";
        dbDelta($sql);

        $sql = "INSERT INTO `$choice` (`choice_id`, `choice_name`,`choice_var`) VALUES
            (1, 'Yes','1'),
            (2, 'No','0');";
        dbDelta($sql);
        

		$sql = "INSERT INTO `$author` (`aid`, `author_name`,`author_email`,`author_website`) VALUES
		    (1, 'Kevin Schuit','info@kevinschuit.com','https://kevinschuit.com');";
		dbDelta($sql);

            $sql = "INSERT INTO `$updateLog` (`uid`, `update_version`,`update_desc`,`update_list`,`future_desc`) VALUES
                (1, 'V1.0.0','Base toolset to manage a website.',
                '<li>Added a dashboard</li>
                <li>Imported the shortcode</li>
                <li>Inserted a javascript color switcher as a shortcode.</li>', 
                'Next update depends on the particular request');";

            dbDelta($sql);
     }
 }
 // Instantiate the class
 $ks_toolset = new KsToolset();
 ?>