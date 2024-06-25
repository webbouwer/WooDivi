<?php
/* WooDivi Child Theme functions */


/* Add stylesheet */
function set_child_theme_styles() {

    $parent_style = 'divi-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'divi-child-enhanced-basic-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );

}
add_action( 'wp_enqueue_scripts', 'set_child_theme_styles' ); 


/* Remove zoom option in single product image 
function remove_image_zoom_support() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}
add_action( 'wp', 'remove_image_zoom_support', 100 );
*/

/* Add Gallery image captions */
// https://gist.github.com/ratputin/97249004e947c0b199043c88256ac082
// https://github.com/woocommerce/woocommerce/blob/a7582d50da833fa44618c0c9389724bbf1bf8bcf/includes/class-wc-frontend-scripts.php#L475
add_filter('woocommerce_single_product_image_thumbnail_html', function($html, $attachment_id) {
  $caption = get_post_field('post_excerpt', $attachment_id);
  if(trim($caption)) {
    //$html = str_replace('</div>', '<span class="gtnCaps gallery-caption">' . $caption . '</span></div>', $html);
    $html = str_replace('</div>', '<div class="gallery-caption"><div>' . $caption . '</div></div></div>', $html);
  }
  return $html;
}, 10, 2);

/* Add Gallery prev next */
// https://wpbeaches.com/add-navigation-arrows-in-woocommerce-product-gallery-slider/
add_filter( 'woocommerce_single_product_carousel_options', 'wd_update_flexslider_options' );
// Filter WooCommerce Flexslider options - Add Navigation Arrows
function wd_update_flexslider_options( $options ) {
    $options['directionNav'] = true;
    return $options;
}



/* Set product columns to 6 (css: .products.columns-6 .landscape.product) */
function dw_loop_columns() { 
  return 6; // 3 products per row 
} 
add_filter('loop_shop_columns' , 'dw_loop_columns', 999);


/* Custom category list display 
add_action('woo_grid_cat_display', 'woo_grid_cat_display_column', 20);
function woo_grid_cat_display_column($category) {

  $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
  $image = wp_get_attachment_url( $thumbnail_id );

  echo '<div class="category-cover">';
  echo '<a href="' . get_term_link( $category->slug, 'product_cat' ) . '" style="background: linear-gradient( rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2) ), url('.$image.');background-size:cover;">';
  //echo '<img src="'.$image.'"/>';
  echo '<div class="category-title">'.$category->name.'</div>';
  echo '</a>';
  echo '</div>';

}
  */


/* global image orientation by image(thumb) id*/
//$imageID = $product->get_image_id(); // or get_post_thumbnail_id($product->id)
// $imgorientclass = wd_get_orientation_by_imgid($imgid);
function wd_get_orientation_by_imgid($imgid){
	$image = wp_get_attachment_image_src( $imgid, ''); 
	
					 $image_orientation = 'portrait';
	
						 $image_w = $image[1];
						 $image_h = $image[2];
	
						 if ($image_w > (2.3 * $image_h) ) {
							 $image_orientation = 'panorama';
						 }else if ($image_w > $image_h) {
							 $image_orientation = 'landscape';
						 }else if ($image_w == $image_h) {
							 $image_orientation = 'square';
						 }else {
							 $image_orientation = 'portrait';
						 }
		return $image_orientation;
}



  /*
// add product image class (for css column control)
function filter_wp_get_attachment_image_attributes( $attr, $attachment, $size ) {
 // add image class based on 
  $attr['class'] .= ' my-class';

  // 2. Returns true when on the product archive page (shop).
  // use is_shop()
  // Or Specific product ID
  if ( $attachment->post_parent == 30 ) {
      // Add class
      $attr['class'] .= ' my-class-for-product-id-30';
  }
  // OR
  // 3.2 Specific product ID
  $product = wc_get_product( $attachment->post_parent );
  // Is a WC product
  if ( is_a( $product, 'WC_Product' ) ) {
      if ( $product->get_id() == 815 ) {
          // Add class
          $attr['class'] .= ' my-class-for-product-id-815';
      }
  }


  return $attr; 
}
add_filter( 'wp_get_attachment_image_attributes', 'filter_wp_get_attachment_image_attributes', 10, 3 );
  */



