<?php
defined( 'ABSPATH' ) || exit;
global $product;
if ( empty( $product ) || ! $product->is_visible() ) return;
?>
<div class="custom-product-card slider-card">
    <div class="wishlist-btn">
        <?php echo do_shortcode('[ti_wishlists_addtowishlist loop=yes]'); ?>
    </div>

    <div class="custom-product-top">
        <div class="badges-container">
            <?php 
            if ( is_product_new( get_the_ID() ) ) echo '<div class="custom-new-badge">New</div>';
            woocommerce_show_product_loop_sale_flash(); 
            ?>
        </div>
        <a href="<?php the_permalink(); ?>">
            <?php woocommerce_template_loop_product_thumbnail(); ?>
        </a>
    </div>

    <div class="product-category">
        <?php echo wp_strip_all_tags( wc_get_product_category_list( $product->get_id(), ', ', '', '' ) ); ?>
    </div>

    <h2 class="woocommerce-loop-product__title">
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>

    <div class="product-rating">
        <span class="review-count">
            <?php echo esc_html( $product->get_review_count() ); ?> відгуків
        </span>
        <?php include( locate_template( 'woocommerce/loop/rating.php' ) ); ?>
    </div>

    <div class="product-price">
        <?php echo $product->get_price_html(); ?>
    </div>

    <div class="custom-product-bottom">
        <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
           data-quantity="1"
           class="custom-buy-button ajax_add_to_cart add_to_cart_button"
           data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
           rel="nofollow">
            До кошика
        </a>
    </div>
</div>