<?php
defined( 'ABSPATH' ) || exit;

global $product;

// Пропускаємо, якщо товар не існує або не видимий
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( '', $product ); ?>>
    <div class="custom-product-card">

        <!-- Кнопка додавання в обране -->
        <div class="wishlist-btn">
            <?php echo do_shortcode('[ti_wishlists_addtowishlist loop=yes]'); ?>
        </div>

        <!-- Верхня частина -->
        <div class="custom-product-top">
            <div class="badges-container">
                <?php
                    if ( is_product_new( get_the_ID() ) ) {
                        echo '<div class="custom-new-badge">New</div>';
                    }
                ?>
                <div>
                    <?php woocommerce_show_product_loop_sale_flash(); ?>
                </div>
            </div>
            <a href="<?php the_permalink(); ?>">
                <?php woocommerce_template_loop_product_thumbnail(); ?>
            </a>

            <!-- Категорія -->
            <div class="product-category">
                <?php
                $categories = wc_get_product_category_list( $product->get_id(), ', ', '', '' );
                if ( $categories ) {
                    echo '<span class="ast-woo-product-category">' . wp_strip_all_tags( $categories ) . '</span>';
                }
                ?>
            </div>

            <!-- Назва товару -->
            <h2 class="woocommerce-loop-product__title">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h2>
        </div>

        <!-- Рейтинг + Відгуки -->
        <div class="product-rating">
            <?php
            $average = $product->get_average_rating();
            
                echo wc_get_rating_html( $average );

            ?>
            <span class="review-count"><?php echo esc_html( $product->get_review_count() ); ?> відгуків</span>
        </div>

        <!-- Ціна -->
        <div class="product-price">
            <?php
            if ( $product->is_on_sale() ) {
                echo '<del>' . wc_price( $product->get_regular_price() ) . '</del> ';
            }
            echo '<ins>' . wc_price( $product->get_price() ) . '</ins>';
            ?>
        </div>

        <!-- Кнопка "До кошика" -->
        <div class="custom-product-bottom">
            <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
               data-quantity="1"
               class="custom-buy-button"
               data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
               data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
               aria-label="<?php echo esc_attr( $product->add_to_cart_description() ); ?>"
               rel="nofollow">
                До кошика
            </a>
        </div>
    </div>
</li>






