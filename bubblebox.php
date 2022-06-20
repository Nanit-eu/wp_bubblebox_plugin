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
        <div id="__next" data-reactroot="" style="width:100%;">
    <div>zertzertzert </div>
</div>
<script id="__NEXT_DATA__" type="application/json">{
    "props": {
        "pageProps": {}
    },
    "page": "/",
    "query": {},
    "buildId": "my-build-id",
    "assetPrefix": "http://127.0.0.1:8080",
    "nextExport": true,
    "autoExport": true,
    "isFallback": false,
    "scriptLoader": []
}</script>';


        $return.= $args['after_widget'];
        return $return;
    }

    public function print_scripts() {
        $i=0;
        foreach (self::get_build_files('js') as $file){
            wp_enqueue_script('wpVentureLeap-BubbleBox_' . $i++ . '_widget-js-defer', $file);
        }
    }

    public function print_styles() {
        $i=0;
        foreach (self::get_build_files('js') as $file){
            wp_enqueue_style('wpVentureLeap-BubbleBox_' . $i++ . '_widget', $file);
        }
    }

    static public function get_build_files($fileType='js') {
        $filesList=['js'=>[],'css'=>[]];

        $string = file_get_contents(__DIR__."/build-manifest.json");
        $react_ressources = json_decode($string, true);
        $i=0;
        foreach ($react_ressources['polyfillFiles'] as $file) {
            $filesList['js'][$file]=$file;
        }
        foreach ($react_ressources['pages'] as $pages) {
            foreach ($pages as $file) {
                if(strpos($file, '.css')>0)
                    $filesList['css'][$file]=$file;
                else
                    $filesList['js'][$file]=$file;
            }
        }
        foreach ($react_ressources['lowPriorityFiles'] as $file) {
            $filesList['js'][$file]=$file;
        }
        return array_keys($filesList[$fileType]);
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
