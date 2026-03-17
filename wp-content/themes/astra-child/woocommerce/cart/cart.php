<?php
defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<div class="custom-cart-container">
    <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
        
        <div class="custom-cart-grid" style="display: flex; gap: 40px; align-items: flex-start;">
            
            <div class="custom-cart-items-list" style="flex: 2;">
                <?php
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                    $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) {
                        ?>
                        <div class="custom-cart-item" style="display: flex; gap: 20px; padding: 20px 0;">
                            
                            <div class="cart-item-photo">
                                <?php echo $_product->get_image('medium'); ?>
                            </div>
                            
                            <div class="cart-item-details" style="display: flex; flex-direction: column; justify-content: space-between; flex-grow: 1;">
                                <div class="item-info-top">
                                    <h2 class="cart-item-title">
                                        <?php echo $_product->get_name(); ?>
                                    </h2>
                                    
                                    <div class="product-category-row">
                                        <?php
                                        $terms = get_the_terms( $product_id, 'product_cat' );
                                        if ( $terms && ! is_wp_error( $terms ) ) {
                                            $main_cat = $terms[0]->name;
                                            echo '<span class="ast-woo-product-category">' . esc_html( $main_cat ) . '</span>';
                                        }
                                        ?>
                                    </div>

    <div class="product-volume-row">
        <?php 
        $val = get_post_meta( $product_id, '_custom_volume_value', true );
        $unit = get_post_meta( $product_id, '_custom_volume_unit', true );
        
        if ( $val ) {
            echo '<span class="product-volume">' . esc_html( $val ) . ' ' . esc_html( $unit ) . '</span>';
        }
        ?>
    </div>
</div>

                                <div class="item-info-bottom">
                                    <div class="quantity-wrapper">
                                        <button type="button" class="minus">-</button>
                                        <input type="number" 
                                               name="cart[<?php echo $cart_item_key; ?>][qty]" 
                                               value="<?php echo $cart_item['quantity']; ?>" 
                                               step="1" min="0" 
                                               class="input-text qty text">
                                        <button type="button" class="plus">+</button>
                                    </div>

                                    <div class="item-price-delete">
                                        <span class="product-price">
                                            <?php echo WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ); ?>
                                        </span>
                                        <a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>" class="remove-item-link"></a>                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                <button type="submit" name="update_cart" class="button" style="display:none;">Оновити кошик</button>
            </div>

            <div class="custom-cart-sidebar" style="flex: 1.2; background: #E4E1E1; padding-top: 15px; max-width: 350px;">
                <div class="sidebar-block" style="margin-bottom: 22px;">
    <h3>Подарункове пакування</h3>

    <div class="custom-packaging-grid" 
         style="display: flex; gap: 14px;">

        <?php
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 2,
            'product_cat'    => 'gifts',
            'orderby'        => 'title', // Сортування за алфавітом (Назвою)
            'order'          => 'ASC'
        );

        $loop = new WP_Query($args);

        if ($loop->have_posts()) {
            while ($loop->have_posts()) : $loop->the_post();
                global $product;
                ?>

                <div class="packaging-item" 
                     style="text-align: center;">

                    <!-- Фото -->
                    <div class="packaging-photo" style="margin-bottom: 6px; width: 150px; height: 135px;">
                        <?php echo $product->get_image(); ?>
                    </div>

                    <!-- Назва -->
                    <h4 style="font-size: 11px; margin-bottom: 6px; font-weight: 200;">
                        <?php the_title(); ?>
                    </h4>

                    <!-- Опис -->
                    <p style="font-size: 8px; font-weight: 200; margin-bottom: 11px; height: 30px;">
                        <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                    </p>

                    <!-- Кнопка -->
                    <a href="?add-to-cart=<?php echo esc_attr($product->get_id()); ?>" 
                       class="button"
                       style="font-size: 9px; font-weight: 500; padding: 3px 25px; width: 100%; border-radius: 0;">
                        додати
                    </a>

                </div>

                <?php
            endwhile;
        } else {
            echo 'Додайте товари в категорію gifts';
        }

        wp_reset_postdata();
        ?>
    </div>
</div>

                <div class="sidebar-block" style="margin-bottom: 11px;">
                    <h3>Промокод | сертифікат</h3>
                    <div class="custom-coupon-form">
                        <input type="text" name="coupon_code" placeholder="..." id="coupon_code" style="border: 1px solid #570122; background-color: #E4E1E1;">
                    </div>
                </div>

                <div class="custom-totals-area">
                    <div class="price-info" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span>Всього:</span>
                        <span><?php wc_cart_totals_subtotal_html(); ?></span>
                    </div>
                    <?php if ( WC()->cart->get_discount_total() > 0 ) : ?>
                        <div class="price-info" style="display: flex; justify-content: space-between; margin-bottom: 10px; color: green;">
                            <span>Заощаджено:</span>
                            <span>-<?php echo wc_price( WC()->cart->get_discount_total() ); ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="price-info" style="display: flex; justify-content: space-between; font-weight: bold; border-top: 1px solid #ddd; pt: 15px; margin-top: 10px;">
                        <span>До сплати:</span>
                        <span><?php wc_cart_totals_order_total_html(); ?></span>
                    </div>

                    <div style="margin-top: 30px; width: 100%; padding-bottom: 0; display: flex; flex-direction: column;">
                        <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button" style="background: #570122; color: #fff; text-align: center; padding: 12px 0 12px 0; text-decoration: none; font-weight: 600;">Оформити замовлення</a>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" style="background: #F1EEEE; text-align: center; color: #570122; font-size: 16px; font-weight: 600; padding: 12px 0 12px 0;">Продовжити покупки</a>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>