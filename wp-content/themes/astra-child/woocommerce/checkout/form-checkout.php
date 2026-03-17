<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// 1. Видаляємо блок купона (якщо він не прибраний через hooks)
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

do_action( 'woocommerce_before_checkout_form', $checkout );
?>

<div class="custom-checkout-wrapper">
    <h1 class="checkout-main-title">Оформлення замовлення</h1>

    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

        <?php if ( $checkout->get_checkout_fields() ) : ?>
            
            <div class="checkout-section">
                <h2 class="section-title">Ваші контактні дані</h2>
                <div class="section-fields">
                    <?php 
                    $billing_fields = $checkout->get_checkout_fields( 'billing' );
                    $ordered_keys = ['billing_first_name', 'billing_last_name', 'billing_phone', 'billing_email'];
                    foreach ( $ordered_keys as $key ) {
                        if ( isset( $billing_fields[$key] ) ) {
                            $field = $billing_fields[$key];
                            $field['placeholder'] = $field['label'];
                            $field['label_class'] = array('screen-reader-text');
                            $field['class'] = array('form-row-wide'); 
                            woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="checkout-section">
    <h2 class="section-title">Адреса доставки</h2>
    <div class="section-fields">
        <p class="form-row">
            <select name="shipping_type" id="shipping_type" class="custom-select-style">
                <option value="warehouse">У відділення</option>
                <option value="postomat">В поштомат</option>
            </select>
        </p>

        <div class="city-selector-wrapper">
             <select name="billing_city" id="billing_city" class="custom-select-style">
                 <option value="">Введіть назву міста...</option>
             </select>
             <input type="hidden" name="billing_city_ref" id="billing_city_ref">
        </div>

        <p class="form-row">
            <select name="billing_address_1" id="billing_address_1" class="custom-select-style">
                <option value="">Оберіть відділення</option>
            </select>
        </p>
    </div>
</div>

        <?php endif; ?>

        <div class="checkout-section payment-section">
            <h2 class="section-title">Оплата</h2>
            
            <div id="payment" class="woocommerce-checkout-payment">
                <?php if ( WC()->cart->needs_payment() ) : ?>
                    <ul class="wc_payment_methods payment_methods methods">
                        <?php
                        // Виводимо ТІЛЬКИ список методів оплати
                        if ( ! empty( $available_gateways ) ) {
                            foreach ( $available_gateways as $gateway ) {
                                wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
                            }
                        } else {
                            echo '<li class="woocommerce-notice woocommerce-control-note">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ) . '</li>';
                        }
                        ?>
                    </ul>
                <?php endif; ?>

                <div class="form-row place-order">
                    <noscript>
                        <?php printf( esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ), '<em>', '</em>' ); ?>
                        <br/><button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>"><?php esc_html_e( 'Update totals', 'woocommerce' ); ?></button>
                    </noscript>

                    <?php wc_get_template( 'checkout/terms.php' ); ?>

                    <?php do_action( 'woocommerce_review_order_after_submit' ); ?>

                    <?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
                </div>
            </div>

            <div class="final-order-button-wrapper" style="margin-top: 40px;">
                <p class="policy-text">
                    * Погоджуюсь з правилами <a href="/oferta/">публічний договір (оферта)</a>
                </p>
                <button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" data-value="Оформити замовлення">
                    Оформити замовлення
                </button>
            </div>
        </div>

    </form>
</div>