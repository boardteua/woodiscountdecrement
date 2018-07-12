<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://weekdays.te.ua
 * @since      1.0.0
 *
 * @package    Woo_Counter_Discount
 * @subpackage Woo_Counter_Discount/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Counter_Discount
 * @subpackage Woo_Counter_Discount/admin
 * @author     Olexandr Chimera <myrror555@gmail.com>
 */
class Woo_Counter_Discount_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woo_Counter_Discount_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woo_Counter_Discount_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        //wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woo-counter-discount-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woo_Counter_Discount_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woo_Counter_Discount_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        //wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woo-counter-discount-admin.js', array('jquery'), $this->version, false);
    }

    public function add_counter_fields($id) {

        $chk = get_post_meta($id, 'wc_reduction', true);
        $value = get_post_meta($id, 'wc_value_reduction', true);

        $html = '';

        $html .= '<div class="reduction_fields" >';
        $html .= '<p class="form-field reduction_field ">';
        $html .= '<label for="reduction" >' . __('Discount reduction') . ' </label><input class="checkbox" type="checkbox" name="reduction" id="meta-checkbox"  ' . checked($chk, true, false) . ' />';
        $html .= '</p>';

        $html .= '<p class="form-field value_reduction_field ">';
        $html .= '<label for="value_reduction" >' . __('Discount reduction value') . ' </label><input class="short wc_input_price" type="text" name="value_reduction" id="meta-checkbox" value="' . $value . '"  />';
        $html .= '</p>';
        $html .= '</div>';

        echo $html;
    }

    function add_counter_otions_save($id) {

        // Sanitize user input.
        $chk = $_POST['reduction'] ? true : false;
        update_post_meta($id, 'wc_reduction', $chk);
        update_post_meta($id, 'wc_value_reduction', wc_format_decimal($_POST['value_reduction']));
    }

}
