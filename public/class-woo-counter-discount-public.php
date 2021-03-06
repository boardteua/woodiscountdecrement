<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://weekdays.te.ua
 * @since      1.0.0
 *
 * @package    Woo_Counter_Discount
 * @subpackage Woo_Counter_Discount/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woo_Counter_Discount
 * @subpackage Woo_Counter_Discount/public
 * @author     Olexandr Chimera <myrror555@gmail.com>
 */
class Woo_Counter_Discount_Public {

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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public static $pair;

    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        // wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woo-counter-discount-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woo-counter-discount-public.js', array('heartbeat'), $this->version, false);
    }

    public function checkout_order_completed($order_id) {

        $order = new WC_Order($order_id);


        // Coupons used in the order LOOP (as they can be multiple)
        foreach ($order->get_used_coupons() as $coupon_name) {

            // Retrieving the coupon ID
            $coupon_id = $this->get_coupon_id($coupon_name);

            // Get an instance of WC_Coupon object in an array(necesary to use WC_Coupon methods)
            // 
            // check reduction option
            if (get_post_meta($coupon_id, 'wc_reduction', true) == 1) {

                $coupon_amount = 0; 
                $reduction_value = 0;

                $coupon_amount = (int) get_post_meta($coupon_id, 'coupon_amount', true);
                $reduction_value = (int) get_post_meta($coupon_id, 'wc_value_reduction', true);
                $min_value = (int) get_post_meta($coupon_id, 'wc_min_value_reduction', true);
            
                // decrement the amount
                $value = $coupon_amount - $reduction_value;

                if ($value >= $min_value) {

                    update_post_meta($coupon_id, 'coupon_amount', $value);

                    wp_cache_clear_cache();
                } else {
                    update_post_meta($coupon_id, 'coupon_amount', $min_value);

                    wp_cache_clear_cache();
                    error_log('min value show ' . $min_value);
                }
            }
        }
    }

    /**
     * Shortcode return amount function
     */
    public function counter_sh($atts) {
        extract(shortcode_atts(['code' => 0,
                        ], $atts, 'dscatts'));
        $coupon_id = $this->get_coupon_id($atts['code']);
        $amount = get_post_meta($coupon_id, 'coupon_amount', true);

        if ($amount) {
            return '<span class="coupon-amount coupon-id-' . $coupon_id . '" >' . $amount . '</span>';
        } else {
            return '<span class="coupon-amount coupon-id-' . $coupon_id . '" >' . __('Error') . '</span>';
        }
    }

    /**
     * Update amount on front by wp-hearbeat
     */
    public function update_amount_front($response) {
        global $wpdb;

        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = 'wc_reduction' AND meta_value = 1 ", OBJECT);

        foreach ($results as $res) {
            $cuid[] = array('id' => $res->post_id, 'am' => get_post_meta($res->post_id, 'coupon_amount', true));
        }


        $response['acn'] = array(
            'amount' => $cuid
        );

        return $response;
    }

    /**
     * return coupon id by code
     */
    private function get_coupon_id($coupon_name) {
        $coupon_post_obj = get_page_by_title($coupon_name, OBJECT, 'shop_coupon');
        return $coupon_post_obj->ID;
    }

}
