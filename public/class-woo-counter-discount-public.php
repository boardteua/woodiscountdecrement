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

        // wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woo-counter-discount-public.js', array('jquery'), $this->version, false);
    }


    public function checkout_order_completed($order_id) {

        $order = wc_get_order($order_id);

        // Coupons used in the order LOOP (as they can be multiple)
        foreach ($order->get_used_coupons() as $coupon_name) {

            // Retrieving the coupon ID
            $coupon_id = $this->get_coupon_id($coupon_name);

            // Get an instance of WC_Coupon object in an array(necesary to use WC_Coupon methods)
            $coupons_obj = new WC_Coupon($coupon_id);

            // check reduction option
            if (get_post_meta($coupon_id, 'wc_reduction', true) == 1) {

                $reduction_value = get_post_meta($coupon_id, 'wc_value_reduction', true);
                $min_value = get_post_meta($coupon_id, 'wc_min_value_reduction', true);
                $coupons_amount = $coupons_obj->get_amount();

                // decrement the amount

                if ($coupons_amount - $reduction_value >= $min_value) {
                    update_post_meta($coupon_id, 'coupon_amount', $coupons_amount - $reduction_value);
                } else {
                    update_post_meta($coupon_id, 'coupon_amount', $min_value);
                }
                add_action('discount_updated', $this->discount_value, $coupon_id);
            }
        }
    }

    /**
     * Shortcode return amount function
     */
    public function couter_sh($atts) {
        extract(shortcode_atts(['code' => 0,
                        ], $atts, 'dscatts'));

        $amount = get_post_meta($this->get_coupon_id($atts['code']), 'coupon_amount', true);

        if ($amount) {
            echo '<span class="coupon-mount coupon-id-' . $coupon_id . '">' . $amount . '</span>';
        } else {
            echo '<span class="coupon-mount coupon-id-' . $coupon_id . '">Error</span>';
        }
    }

    /**
     * return coupon id by code
     */
    private function get_coupon_id($coupon_name) {
        $coupon_post_obj = get_page_by_title($coupon_name, OBJECT, 'shop_coupon');
        return $coupon_post_obj->ID;
    }

}
