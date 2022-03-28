<?php
/*
Plugin Name:  Product List with Image Sliders
Plugin URI:   http://krushna53.com/
Description:  To show multiple images in a slider for the product listing page.
Version:      1.0
Author:       Krushna53
Author URI:   https://krushna53.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  krushna53
Domain Path:  /product-list
*/


function custom_shortcode($atts) {
  // set a default value
  $default_attribute_values = [
    'count' => 9
  ];
  $attributes_passed_by_user = $atts;
  $final_value = shortcode_atts($default_attribute_values, $attributes_passed_by_user);
  
  $all_ids = get_posts ( array(
    // $all_ids = new WP_Query( array(
      'post_type' => 'product',
      'numberposts' => $final_value['count'],
      'post_status' => 'publish',
      'fields' => 'ids',
    ));
     $html = '';
    foreach ( $all_ids as $product_id ) {
     $html .= individual_product_slider($product_id);
    }
    echo $html;
}
  // $product_id = '121';    
//  echo do_shotcode("[add_to_cart_url id='102']");
function individual_product_slider($product_id){
  $product = new WC_product($product_id);
  $attachment_ids = $product->get_gallery_image_ids();
  $product_name = $product->get_title();
  $product_price = $product->get_price_html();
  $html = '<div class="Main_container">';
  $html .= '<div class="inner-container">';
  // $html .= '<div class="inner-box"><h7>'.($product_price) .'</h7>';


    // do_shortcode('[add_to_cart_url id="'.$product_id.'"]'); 
  //  output -- >   ---> https://projects.krushna53.com/commerce/?add-to-cart=116
  //$add_to_cart_url = site_url() . '/'. do_shortcode('[add_to_cart_url id="'.$product_id.'"]');
  // <button type="button"><a href="/?add-to-cart=116">Add to Cart</a></button>


  $html .= '<div class="slideshow">';

  foreach( $attachment_ids as $attachment_id )  {
    $original_image_url = wp_get_attachment_url( $attachment_id );
    $html .= '<div>
    <div class="slide">
        <img src="'. $original_image_url .'" />
        </div>
    </div>';
  }
  $html .= '</div>';
  $add_to_cart_url = site_url() . '/'. do_shortcode('[add_to_cart_url id="'.$product_id.'"]');
  
  $html .= '<div class="inner-box"><h4>'.($product_name) .'</h4><h6>'.($product_price) .'</h6>';
  $html .= '<button type="button" class="slider_cart_btn"><a href="'.$add_to_cart_url.'">Add to Cart</a></button></div></div></div>';
  return $html;
}

function custom_plugin_slick_slider() {

  wp_enqueue_script('slick','https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js',[],false,true);
  wp_enqueue_style('slick_theme_css','https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css');
  wp_register_style('product_slider', plugins_url('product-slider/css/product_slider.css'));
  wp_enqueue_style('product_slider',plugins_url('product-slider/css/product_slider.css'),[],false,true);
  wp_enqueue_style('slick_css','https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css');
  wp_register_script('product_slider',plugins_url('product-slider/js/product_slider.js')); 
  wp_enqueue_script('product_slider',plugins_url('product-slider/js/product_slider.js'), [],false,true);
}

add_action( 'wp_enqueue_scripts', 'custom_plugin_slick_slider');

add_shortcode( 'product_slider', 'custom_shortcode');
/*  Add to cart button*/
// add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );

// add_action( 'after_setup_theme', function() {
//   add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 12 );
// }, 999);




?>
