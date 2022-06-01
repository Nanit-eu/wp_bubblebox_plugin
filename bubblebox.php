<?php

// No direct file access
! defined( 'ABSPATH' ) AND exit;

class VL_BubbleBox_React extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'VL_BubbleBox_React', 'description' => __( 'Display a booking button.', 'nanit') );
        parent::__construct(false, $name = __('Bubblebox plugin', 'nanit'), $widget_ops);
        $this->alt_option_name = 'VL_BubbleBox_React';

        add_action('wp_print_scripts', array(&$this, 'print_scripts'));
        add_action('wp_print_styles', array(&$this, 'print_styles'));
    }

    function form($instance) {
        $title     			= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $title     			= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $action_text 		= isset( $instance['action_text'] ) ? esc_textarea( $instance['action_text'] ) : '';
        $action_propertyid 	= isset( $instance['action_propertyid'] ) ? esc_attr( $instance['action_propertyid'] ) : '';
        $action_btn_text 	= isset( $instance['action_btn_text'] ) ? esc_html( $instance['action_btn_text'] ) : '';
        $inline 			= isset( $instance['inline'] ) ? (bool) $instance['inline'] : false;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'nanit'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('action_text'); ?>"><?php _e('Enter your call to action.', 'nanit'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('action_text'); ?>" name="<?php echo $this->get_field_name('action_text'); ?>"><?php echo $action_text; ?></textarea></p>
        <p><label for="<?php echo $this->get_field_id('action_propertyid'); ?>"><?php _e('Property id', 'nanit'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('action_propertyid'); ?>" name="<?php echo $this->get_field_name('action_propertyid'); ?>" type="text" value="<?php echo $action_propertyid; ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('action_btn_text'); ?>"><?php _e('Title for the button', 'nanit'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('action_btn_text'); ?>" name="<?php echo $this->get_field_name('action_btn_text'); ?>" type="text" value="<?php echo $action_btn_text; ?>" /></p>
        <p><input class="checkbox" type="checkbox" <?php checked( $inline ); ?> id="<?php echo $this->get_field_id( 'inline' ); ?>" name="<?php echo $this->get_field_name( 'inline' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'inline' ); ?>"><?php _e( 'Display the button inline with the text?', 'nanit' ); ?></label></p>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] 			 = strip_tags($new_instance['title']);
        $instance['action_propertyid'] = esc_attr($new_instance['action_propertyid']);
        $instance['action_btn_text'] = strip_tags($new_instance['action_btn_text']);
        $instance['inline'] 		 = isset( $new_instance['inline'] ) ? (bool) $new_instance['inline'] : false;
        if ( current_user_can('unfiltered_html') ) {
            $instance['action_text'] = $new_instance['action_text'];
        } else {
            $instance['action_text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['action_text']) ) );
        }

        return $instance;
    }

    function widget($args, $instance) {
        echo $this->getContent($args, $instance);
    }

    function getContent($args, $instance) {
        $lang= substr(get_locale(),0,2);
        $return='';
        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }
        extract($args);
        $return.='
        <div id="__next" data-reactroot="" style="background:white; width:100%;">
    <div>zertzertzert </div>
</div>
<script id="__NEXT_DATA__" type="application/json">{
    "props": {
        "pageProps": {}
    },
    "page": "/",
    "query": {},
    "buildId": "h_DO-W7bBcx7vkD6Jwg-Z",
    "nextExport": true,
    "autoExport": true,
    "isFallback": false,
    "scriptLoader": []
}</script>';


        $return.= $args['after_widget'];
        return $return;
    }

    public function print_scripts() {

        wp_enqueue_script( 'wpVentureLeap-BubbleBoxC_widget-js-defer', 'http://127.0.0.1:8080/_next/static/chunks/polyfills-5cd94c89d3acac5f.js');
        wp_enqueue_script( 'wpVentureLeap-BubbleBoxD_widget-js-defer', 'http://127.0.0.1:8080/_next/static/chunks/webpack-6c6545dd242ed118.js');
        wp_enqueue_script( 'wpVentureLeap-BubbleBoxE_widget-js-defer', 'http://127.0.0.1:8080/_next/static/chunks/framework-5f4595e5518b5600.js');
        wp_enqueue_script( 'wpVentureLeap-BubbleBoxF_widget-js-defer', 'http://127.0.0.1:8080/_next/static/chunks/main-e0ecf8f11466bcfc.js');
        wp_enqueue_script( 'wpVentureLeap-BubbleBoxG_widget-js-defer', 'http://127.0.0.1:8080/_next/static/chunks/pages/_app-82f7ef6dbd6120ef.js');
        wp_enqueue_script( 'wpVentureLeap-BubbleBoxH_widget-js-defer', 'http://127.0.0.1:8080/_next/static/chunks/69-2f15f5a1c3fe8a54.js');
        wp_enqueue_script( 'wpVentureLeap-BubbleBoxI_widget-js-defer', 'http://127.0.0.1:8080/_next/static/chunks/pages/index-74f9269bc607513c.js');
        wp_enqueue_script( 'wpVentureLeap-BubbleBoxJ_widget-js-defer', 'http://127.0.0.1:8080/_next/static/my-build-id/_buildManifest.js');
        wp_enqueue_script( 'wpVentureLeap-BubbleBoxK_widget-js-defer', 'http://127.0.0.1:8080/_next/static/my-build-id/_ssgManifest.js');
        wp_enqueue_script( 'wpVentureLeap-BubbleBoxL_widget-js-defer', 'http://127.0.0.1:8080/_next/static/my-build-id/_middlewareManifest.js');

    }

    public function print_styles() {
        wp_enqueue_style('wpVentureLeap-BubbleBox_widget', 'http://127.0.0.1:8080/_next/static/css/782436bc58b3fadb.css');
        wp_enqueue_style('wpVentureLeap-BubbleBox_widget', 'http://127.0.0.1:8080/_next/static/css/b44e452a9b15cc82.css');
    }

}
if(!is_admin()) {
    function add_asyncdefer_attribute($tag, $handle) {
        // if the unique handle/name of the registered script has 'async' in it
        if (strpos($handle, 'async') !== false) {
            // return the tag with the async attribute
            return str_replace( '<script ', '<script async ', $tag );
        }
        // if the unique handle/name of the registered script has 'defer' in it
        else if (strpos($handle, 'defer') !== false) {
            // return the tag with the defer attribute
            return str_replace( '<script ', '<script defer ', $tag );
        }
        // otherwise skip
        else {
            return $tag;
        }
    }
    add_filter('script_loader_tag', 'add_asyncdefer_attribute', 10, 2);
}
