<?php
defined( 'ABSPATH' ) || exit;

global $product;

woocommerce_breadcrumb( array(
    'delimiter'   => '', // Повністю прибираємо стандартну косу риску
    'wrap_before' => '<nav class="woocommerce-breadcrumb-custom">',
    'wrap_after'  => '</nav>',
) );

// Пропускаємо, якщо товар не існує або не видимий
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( '', $product ); ?>>
    <div class="custom-product-card">

        <div class="product-left">
            <div class="wishlist-btn">
                <?php echo do_shortcode('[ti_wishlists_addtowishlist loop=yes]'); ?>
            </div>

            <div class="custom-product-top">
                <div class="badges-container">
                    <?php
                    if ( is_product_new( get_the_ID() ) ) {
                        echo '<div class="custom-new-badge">New</div>';
                    }
                    woocommerce_show_product_loop_sale_flash();
                    ?>
                </div>
                
                <?php woocommerce_template_loop_product_thumbnail(); ?>

                <div class="product-category">
                    <?php
                    $categories = wc_get_product_category_list( $product->get_id(), ', ', '', '' );
                    if ( $categories ) {
                        echo '<span class="ast-woo-product-category">' . wp_strip_all_tags( $categories ) . '</span>';
                    }
                    ?>
                </div>
            </div> 
        </div> 
        <div class="product-right">
                <h2 class="woocommerce-loop-product__title">
                    <?php the_title(); ?>
                </h2>

                <div class="product-rating">
                    <div class="rating-wrapper">
                        <?php 
                            include( locate_template( 'woocommerce/loop/rating.php' ) ); 
                        ?>
                        <span class="review-count">
                            <?php echo esc_html( $product->get_review_count() ); ?> відгуків
                        </span>
                    </div>
                </div>

                <div class="product-price-row">
                    <span class="product-price">
                        <?php
                        if ( $product->is_on_sale() ) {
                            echo '<del>' . wc_price( $product->get_regular_price() ) . '</del> ';
                        }
                        echo '<ins>' . wc_price( $product->get_price() ) . ' | ' . '</ins>';
                        ?>
                    </span>
                    <span class="product-volume">
                        <?php 
                        $val = get_post_meta( $product->get_id(), '_custom_volume_value', true );
                        $unit = get_post_meta( $product->get_id(), '_custom_volume_unit', true );
                        if ( $val ) echo esc_html( $val ) . ' ' . esc_html( $unit );
                        ?>
                    </span>
                </div>

                <div class="product-long-description">
                    <?php 
                        // Отримуємо повний опис
                        $description = $product->get_description(); 
                        
                        if ( ! empty( $description ) ) {
                            // Пропускаємо через фільтр, щоб працювали абзаци та шорткоди
                            echo apply_filters( 'the_content', $description ); 
                        }
                    ?>
                </div>

                <div class="custom-product-bottom-action">
                    <div class="quantity-wrapper">
                        <button type="button" class="minus">-</button>
                        <input type="number" step="1" min="1" value="1" class="input-text qty text">
                        <button type="button" class="plus">+</button>
                    </div>

                    <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
                       data-quantity="1"
                       class="custom-buy-button ajax_add_to_cart add_to_cart_button"
                       data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
                       rel="nofollow">
                       До кошика
                   </a>
               </div>
           </div> 
       </div> 
   </li>






