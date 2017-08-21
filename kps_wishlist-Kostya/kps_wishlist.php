<?php
/*
Plugin Name: KPS Wishlist plugin
Plugin URI: http://kultprosvet.net
Description: Add a wish list widget where registered users can save the posts of the products they want to buy.
Version: 1.0
Author: Klim
Author URI: http://kultprosvet.net
License: GPL2
*/


/**
 * add fields to the admin page
 */
add_action('admin_init', 'kps_admin_init');

function kps_admin_init() {
    register_setting('kps-group', 'kps_dashboard_title');
    register_setting('kps-group', 'kps_number_of_items');
}




//add admin settings
add_action('admin_menu', 'kps_plugin_menu' );

function kps_plugin_menu() {
    // add_options_page( title, menu_anchor, 'permission_name', slug, callback_function );
    add_options_page('KPS Wishlist Options', 'KPS Wishlist', 'manage_options', 'kps', 'kps_plugin_options');
}



function kps_plugin_options () {
    //Закрытие PHP для вывода HTML странная особенность Wordpress
    ?>
    <div class="wrap">
        <h2>KPS Wishlist</h2>
        <form action="options.php" method="post">
            <?php settings_fields('kps-group'); ?>
            <?php do_settings_fields('kps-group'); ?>

            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="kps_dashboard_title">Dashboard widget title</label>
                    </th>
                    <td>
                        <input type="text" name="kps_dashboard_title" id="kps_dashboard_title" value="<?php echo get_option('kps_dashboard_title'); ?>">
                        <br/><small>help text for this field</small>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="kps_number_of_items">Number of items to show</label>
                    </th>
                    <td>
                        <input type="text" name="kps_number_of_items" id="kps_number_of_items" value="<?php echo get_option('kps_number_of_items'); ?>">
                        <br/><small>help text for this field</small>
                    </td>
                </tr>
            </table>

            <?php @submit_button(); ?>

        </form>
    </div>
    <?php
}



//register widget
add_action( 'widgets_init', 'kps_widget_wishlist_init' );

function kps_widget_wishlist_init () {
    register_widget(wishlist_Widget);
}


class wishlist_Widget extends WP_Widget {
    function wishlist_Widget() {
        $widget_options = array(
            'classname' => 'kps_class', //for CSS
            'description' => 'Add items to wishlist'
        );

        //id for DOM element
        $this->WP_Widget('kps_wishlist', 'Wishlist', $widget_options);
    }


    function form($instance) {
        $defaults = array( 'title' => 'Wishlist');
        $instance = wp_parse_args( (array) $instance, $defaults);
        $title = esc_attr($instance['title']);
        echo '<p>Title <input class="widefat" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'" /></p>';
    }


    /**
     * save widget form
     */
    function update($new_instance, $old_instance) {
        // process widget options to save
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title']);
        return $instance;
    }


    /**
     * show widget
     */
    function widget($args, $instance) {
        extract($args);

        // $value = get_post_custom($post->ID);
        // var_export($value); 

        $title = apply_filters('widget_title', $instance['title']);

        if(is_single()){
            echo $before_widget;
            echo $before_title . $title . $after_title;
          

            if(!is_user_logged_in()) {
                echo 'Please sign in to use this wishlist';
            }else {
                global $post;

                if(is_already_wishlisted($post->ID)) {
                    echo '
                    <div id="kps_add_wishlist_div">
                        <a id="kps_add_wishlist" href="" title="Click to remove from wishlist">
                            <i class="fa fa-heart" aria-hidden="true"></i>In wishlist
                        </a>
                    </div>
                    ';
                } else {
                    echo '
                    <div id="kps_add_wishlist_div">
                        <a id="kps_add_wishlist" href="" title="Click to add to wishlist">
                            <i class="fa fa-heart-o" aria-hidden="true"></i>Add to wishlist
                        </a>
                    </div>';
                }

            }

            echo $after_widget;
        }


    }

}


function is_already_wishlisted($post_id) {
    $user = wp_get_current_user();

    $values = get_user_meta($user->ID, 'wanted_post');

    foreach ($values as $value) {
        if($value == $post_id) {
            return true;
        }
    }

    return false;
}



//load external files to add js files

add_action( 'wp', 'kps_init' );

function kps_init() {
    //register plugin js file. Jquery is a requirement for this script so we specify it
    wp_register_script('kpswishlist-js', plugins_url('/kpswishlist-js.js', __FILE__), array('jquery') );

    //load scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('kpswishlist-js');

    global $post;
    wp_localize_script('kpswishlist-js', 'MyAjax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'action' => 'kps_add_wishlist',
        'postId' => $post->ID
    ));

}


add_action('wp_ajax_kps_add_wishlist', 'kps_add_wishlist_process');


function kps_add_wishlist_process() {

    $post_id = (int)$_POST['postId'];

    $user = wp_get_current_user();

    if(!is_already_wishlisted($post_id)) {
        add_user_meta($user->ID, 'wanted_post', $post_id);
        $response = json_encode(array('success' => true));
    } else {
        // update_user_meta($user->ID, 'wanted_post', 0, $post_id);
        delete_user_meta($user->ID, 'wanted_post', $post_id);
        $response = json_encode(array('success' => false));
    }

    // generate the response
    


    // response output
    header("Content-Type: application/json");

    echo $response;
    exit();
}

//load external css files

add_action('wp_enqueue_scripts', 'customise_wishlist');

function customise_wishlist() {
    if (is_single()) {
        wp_enqueue_style('wish', plugins_url('/css/wishlist-ks.css', __FILE__));
        wp_enqueue_style('fa-icons', plugins_url('/css/font-awesome.css', __FILE__));
    }
}


//dashboard widget
add_action('wp_dashboard_setup','kps_create_dashboard_widget');


function kps_create_dashboard_widget() {
    $title = get_option('kps_dashboard_title') ? get_option('kps_dashboard_title') : 'Dashboard Wishlist';
    wp_add_dashboard_widget('css_id', $title,'kps_show_dashboard_widget' );
}

function kps_show_dashboard_widget () {

    $user = wp_get_current_user();
    $values = get_user_meta($user->ID, 'wanted_post');
    
    $limit =  (int)get_option('kps_number_of_items') ? (int)get_option('kps_number_of_items') : 10;

    echo '<ul>';

    foreach ($values as $i => $value) {

        // check limit
        if($i == $limit) {
            break;
        }

        //retrieve from db
        $currentPost = get_post($value);
      
        //show post name
        echo '<li>' . $currentPost->ID . '</li>';

    }

    echo '</ul>';

}
