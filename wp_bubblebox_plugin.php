<?php
/**
 * Plugin Name:     BubbleBox widget
 * Plugin URI:      http://www.venture-leap.com
 * Description:     BubbleBox widget
 * Author:          Fred@nanit.be
 * Author URI:      http://www.venture-leap.com
  * Text Domain:     bubblebox-widget-plugin
 * Domain Path:     /languages
 * Version:         0.2
 *
 * @package         Vl_bubblebox_widget_plugin
 */

/**
 * My Plugin class
 */
class Vl_bubblebox_widget_plugin {}
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require dirname(__FILE__) . "/bubblebox.php";

function display_vl_bubblebox_widget_list($atts = [], $content = null, $tag = '') {

    // normalize attribute keys, lowercase
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );

    // override default attributes with user attributes
    $wporg_atts = shortcode_atts( [
        'title' => '',
    ], $atts, $tag );
    $string     = '';
    if ( !isset($atts['mode']) ) {
        $atts['mode']='modal';
    }
    if ( !isset($atts['display']) || (isset($atts['display']) && $atts['display']<>'true')) {
        $atts['display']=false;
    }
    else {
        $atts['display']=true;
    }
    $bbWidget=new VL_BubbleBox_React();
    $string+=$bbWidget->getContent([],$atts);
    return $string;
}
function vl_bubblebox_widget() {


    add_shortcode( 'vl_bubblebox_widget', 'display_vl_bubblebox_widget_list' );
}

add_action( 'init', 'vl_bubblebox_widget' );



// Register and load the widget
function VL_BubbleBox_React_load() {
    register_widget( 'VL_BubbleBox_React' );
}
add_action( 'widgets_init', 'VL_BubbleBox_React_load' );


if( ! class_exists( 'Smashing_Updater' ) ){
    include_once( plugin_dir_path( __FILE__ ) . 'Bubblebox_Updater.php' );
}

$updater = new Bubblebox_Updater( __FILE__ );
$updater->set_username( 'Nanit-eu' );
$updater->set_repository( 'wp_bubblebox_plugin' );
/*
	$updater->authorize( 'abcdefghijk1234567890' ); // Your auth code goes here for private repos
*/
$updater->initialize();
