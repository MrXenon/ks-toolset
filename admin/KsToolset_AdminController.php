<?php
 class KsToolset_AdminController {

    static function prepare() {

        if ( is_admin() ) :
            add_action( 'admin_menu', array('KsToolset_AdminController', 'add_tool_menus') );
        endif;
        }
            static function add_tool_menus(){
                $my_page_1 = add_menu_page( __( 'KS Toolset', 'ks-toolset'),__( 'KS Toolset', 'ks-toolset' ),'','ks-toolset-admin',array( 'KsToolset_AdminController', 'adminMenuPage'),'https://www.kevinschuit.com/images/20x20logoWit.png','3');
                $my_page_2 = add_submenu_page ('ks-toolset-admin',__( 'Dashboard', 'ks-toolset' ),__( 'Dashboard', 'ks-toolset'),'manage_options', 'ks_dashboard', array( 'KsToolset_AdminController', 'ksDashboard'));
                $my_page_3 = add_submenu_page ('ks-toolset-admin',__( 'Color changer', 'ks-toolset' ),__( 'Color changer', 'ks-toolset'),'manage_options', 'ks_color_changer', array( 'KsToolset_AdminController', 'ksColorChanger'));
                $my_page_4 = add_submenu_page ('ks-toolset-admin',__( 'Support', 'ks-toolset' ),__( 'Support', 'ks-toolset'),'manage_options', 'ks_support', array( 'KsToolset_AdminController', 'ksSupport'));
               
                 // Load the JS conditionally
                 add_action( 'load-' . $my_page_1,array('KsToolset_AdminController', 'load_admin_js') );
                 add_action( 'load-' . $my_page_2,array('KsToolset_AdminController', 'load_admin_js') );
                 add_action( 'load-' . $my_page_3,array('KsToolset_AdminController', 'load_admin_js') );
                 add_action( 'load-' . $my_page_4,array('KsToolset_AdminController', 'load_admin_js') );
             }
         
            static function load_admin_js(){
                 add_action( 'admin_enqueue_scripts',array('KsToolset_AdminController','enqueue_admin_js') );
             }
         
            static function enqueue_admin_js(){
                 wp_enqueue_script('bootstrap1', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/js/bootstrap.bundle.js');
                 wp_enqueue_script('bootstrap2', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/js/bootstrap.esm.js');
                 wp_enqueue_script('bootstrap3', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/js/bootstrap.js');
                 wp_enqueue_script('bootstrap4', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/jquery/jquery.slim.min.js');

                 wp_enqueue_style('bootstrap1', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/css/bootstrap.css');
                 wp_enqueue_style('bootstrap2', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/css/bootstrap-utilities.css');
                 wp_enqueue_style('bootstrap3', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/css/bootstrap-grid.css');
                 wp_enqueue_style('css', plugin_dir_url(__FILE__).'../css/style.css');
                 
                 wp_enqueue_style('admin-bootstrap-min', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css');
                 wp_enqueue_style('admin-bootstrap-extended', 'https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap-extended.min.css');
                 wp_enqueue_style('admin-simple-line', 'https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/fonts/simple-line-icons/style.min.css');
                 wp_enqueue_style('admin-colors4', 'https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/colors.min.css');
                 wp_enqueue_style('admin-bootstrap4', 'https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap.min.css');
                 wp_enqueue_style('gfonts', 'https://fonts.googleapis.com/css?family=Montserrat&display=swap');
             }


            static function adminMenuPage() {
                include KS_TOOLSET_PLUGIN_ADMIN_VIEWS_DIR . '/admin_main.php';
            }
            static function ksDashboard (){
            include KS_TOOLSET_PLUGIN_ADMIN_VIEWS_DIR . '/ks_dashboard.php';
            }
            static function ksColorChanger (){
            include KS_TOOLSET_PLUGIN_ADMIN_VIEWS_DIR . '/ks_color_changer.php';
            }
            static function ksSupport (){
            include KS_TOOLSET_PLUGIN_ADMIN_VIEWS_DIR . '/ks_support.php';
            }

    }
?>