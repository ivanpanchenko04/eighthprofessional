<?php

//remove
function remove_css_js_version( $src ) {
    return remove_query_arg( 'ver', $src );
}
add_filter( 'style_loader_src', 'remove_css_js_version', 9999 );


function custom_enqueue_fonts() {
    wp_enqueue_style( 'google-fonts-mulish', 'https://fonts.googleapis.com/css2?family=Mulish:wght@400;500;600;700&display=swap', false );
}
add_action( 'wp_enqueue_scripts', 'custom_enqueue_fonts' );


add_action( 'wp_enqueue_scripts', 'astra_child_enqueue_styles', 15 );
function astra_child_enqueue_styles() {
    // Підключаємо стилі батьківської теми
    wp_enqueue_style( 'astra-parent-style', get_template_directory_uri() . '/style.css' );

    // Підключаємо стилі дочірньої теми
    wp_enqueue_style( 'astra-child-style', get_stylesheet_directory_uri() . '/style.css', array('astra-parent-style'), wp_get_theme()->get('Version') );
}

add_filter('woocommerce_sale_flash', 'custom_sale_percentage_badge', 20, 3);
function custom_sale_percentage_badge($html, $post, $product) {
    if ($product->is_type('variable')) {
        $percentage = 0;
        foreach ($product->get_children() as $child_id) {
            $variation = wc_get_product($child_id);
            if ($variation->is_on_sale()) {
                $regular = $variation->get_regular_price();
                $sale = $variation->get_sale_price();
                $current_percentage = round((($regular - $sale) / $regular) * 100);
                if ($current_percentage > $percentage) {
                    $percentage = $current_percentage;
                }
            }
        }
    } else {
        $regular = (float) $product->get_regular_price();
        $sale = (float) $product->get_sale_price();
        $percentage = round((($regular - $sale) / $regular) * 100);
    }

    return '<span class="custom-sale-badge">Знижка ' . $percentage . '%</span>';
}

/* попап додавання до кошику */
function add_cart_popup_html() {
    ?>
    <div id="add-to-cart-popup" class="add-to-cart-popup">
        Товар додано в кошик!
    </div>
    <?php
}
add_action( 'wp_body_open', 'add_cart_popup_html' );


function custom_enqueue_scripts() {
    // Підключаємо jQuery
    wp_enqueue_script('jquery');

    // Підключаємо власний JS
    wp_enqueue_script(
        'scripts.js',
        get_stylesheet_directory_uri() . '/js/scripts.js',
        array('jquery'),
        filemtime(get_stylesheet_directory() . '/js/scripts.js'),
        true 
    );
}
add_action('wp_enqueue_scripts', 'custom_enqueue_scripts');

// script smart header
function enqueue_custom_js() {
    wp_enqueue_script( 'custom-buy-animation', get_stylesheet_directory_uri() . '/js/smart-header.js', array('jquery'), null, true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_custom_js' );

// шорткод для вибору мови (переклад)
function custom_language_switcher_shortcode() {
    $request_uri = $_SERVER['REQUEST_URI'];
    $base_url = home_url();
    $current_lang = 'ua';

    // Перевіряємо, чи є /en/ на початку URL
    if (preg_match('#^/en(/|$)#', $request_uri)) {
        $current_lang = 'en';
        $path_without_lang = preg_replace('#^/en#', '', $request_uri); // Прибираємо /en
    } else {
        $path_without_lang = $request_uri;
    }

    // Формуємо URL для кожної мови
    $ua_url = $base_url . untrailingslashit($path_without_lang);
    $en_url = $base_url . '/en' . untrailingslashit($path_without_lang);

    // Активна мова
    $active_lang = $current_lang === 'en' ? 'EN' : 'UA';
    $active_flag = $current_lang === 'en'
        ? '/wp-content/plugins/translatepress-multilingual/assets/images/flags/en_US.png'
        : '/wp-content/plugins/translatepress-multilingual/assets/images/flags/uk.png';

    ob_start();
    ?>
    <div class="custom-lang-dropdown">
        <button class="lang-btn">
            <img src="<?php echo esc_url($active_flag); ?>" alt="<?php echo esc_attr($active_lang); ?>" />
            <?php echo esc_html($active_lang); ?>
        </button>
        <div class="lang-dropdown-content">
            <?php if ($current_lang !== 'ua') : ?>
                <a href="<?php echo esc_url($ua_url); ?>" class="lang-to-ua">
                    <img src="/wp-content/plugins/translatepress-multilingual/assets/images/flags/uk.png" alt="UA" /> UA
                </a>
            <?php endif; ?>
            <?php if ($current_lang !== 'en') : ?>
                <a href="<?php echo esc_url($en_url); ?>">
                    <img src="/wp-content/plugins/translatepress-multilingual/assets/images/flags/en_US.png" alt="EN" /> EN
                </a>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('language_switcher', 'custom_language_switcher_shortcode');

// шорткод для слайдер на головній сторінці
function custom_product_slider_shortcode() {
    // Отримуємо товари
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 20,
        'post_status' => 'publish',
    );

    $products = new WP_Query($args);
    if (!$products->have_posts()) return '';

    // Підключення Swiper.js
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', array(), null, true);

    // Власний JS для ініціалізації
    add_action('wp_footer', function () {
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                new Swiper('.custom-product-slider', {
                    slidesPerView: 1.2,
                    spaceBetween: 20,
                    loop: false,
                    navigation: {
                        nextEl: '.custom-slider-next',
                        prevEl: '.custom-slider-prev',
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 2.2,
                            slidesPerGroup: 2,
                        },
                        1024: {
                            slidesPerView: 5,
                            slidesPerGroup: 4,
                        }
                    }
                });
            });
        </script>
        <?php
    });

    ob_start(); ?>
    <div class="custom-product-slider-wrapper">
        <div class="custom-slider-prev">&#10094;</div>
        <div class="swiper custom-product-slider">
            <div class="swiper-wrapper">
                <?php while ($products->have_posts()) : $products->the_post(); global $product; ?>
                    <div class="swiper-slide">
                        <?php wc_get_template_part('content', 'product'); ?>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
        <div class="custom-slider-next">&#10095;</div>
    </div>
    <?php return ob_get_clean();
}
add_shortcode('custom_product_slider', 'custom_product_slider_shortcode');

// перемикання мов

// add_action('plugins_loaded', function () {
//     add_action('template_redirect', 'set_currency_based_on_language');
// });

// function set_currency_based_on_language() {
//     if (function_exists('trp_get_current_language') && class_exists('WOOCS')) {
//         global $WOOCS;

//         $current_lang = trp_get_current_language();
//         $lang_currency_map = array(
//             'uk' => 'UAH',
//             'uk_UA' => 'UAH',
//             'en' => 'USD',
//             'en_US' => 'USD',
//         );

//         if (isset($lang_currency_map[$current_lang])) {
//             $currency = $lang_currency_map[$current_lang];

//             if ($WOOCS->current_currency !== $currency) {
//                 $WOOCS->set_currency($currency);
//                 WC()->session->set('woocs_currency', $currency);
//                 setcookie('woocs_currency', $currency, time() + 3600 * 24, '/');
//             }
//         }
//     }
// }


// add_action('wp_footer', function() {
//     echo '<!-- trp_get_current_language: ' . (function_exists('trp_get_current_language') ? trp_get_current_language() : 'not defined') . ' -->';
// });



// // конвертування ціни в долар при перемиканні мови

// add_filter('woocommerce_get_price_html', 'convert_price_to_usd_for_en', 20, 2);
// add_filter('woocommerce_cart_item_price', 'convert_price_to_usd_for_en_cart', 20, 3);
// add_filter('woocommerce_cart_item_subtotal', 'convert_price_to_usd_for_en_cart', 20, 3);
// add_filter('woocommerce_cart_subtotal', 'convert_total_to_usd_for_en', 20, 3);
// add_filter('woocommerce_cart_totals_order_total_html', 'convert_total_to_usd_for_en_html', 20);

// function convert_price_to_usd_for_en($price_html, $product) {
//     if (function_exists('trp_get_current_language') && trp_get_current_language() === 'en') {
//         $uah_price = floatval($product->get_price());
//         $usd_price = round($uah_price / 40); // !  курс тут
//         return '<span class="amount">$' . $usd_price . '</span>';
//     }
//     return $price_html;
// }

// function convert_price_to_usd_for_en_cart($price_html, $cart_item, $cart_item_key = '') {
//     if (function_exists('trp_get_current_language') && trp_get_current_language() === 'en') {
//         $uah_price = floatval($cart_item['data']->get_price());
//         $usd_price = round($uah_price / 40);
//         return '<span class="amount">$' . $usd_price . '</span>';
//     }
//     return $price_html;
// }

// function convert_total_to_usd_for_en($formatted_price, $cart) {
//     if (function_exists('trp_get_current_language') && trp_get_current_language() === 'en') {
//         $uah_total = floatval(WC()->cart->get_total('edit'));
//         $usd_total = round($uah_total / 40);
//         return '<span class="amount">$' . $usd_total . '</span>';
//     }
//     return $formatted_price;
// }

// function convert_total_to_usd_for_en_html($value) {
//     if (function_exists('trp_get_current_language') && trp_get_current_language() === 'en') {
//         $uah_total = floatval(WC()->cart->get_total('edit'));
//         $usd_total = round($uah_total / 40);
//         return '<strong><span class="amount">$' . $usd_total . '</span></strong>';
//     }
//     return $value;
// }


//polylang solution
// add_filter('woocs_currency', 'set_currency_by_language');

// function set_currency_by_language($currency) {
//     if (function_exists('pll_current_language')) {
//         $lang = pll_current_language(); 
//         if ($lang === 'uk') {
//             return 'UAH';
//         } elseif ($lang === 'en') {
//             return 'USD';
//         }
//     }
//     return $currency; 
// }


function is_product_new($product_id) {
    $post_date = get_the_date('U', $product_id);
    return ( time() - $post_date ) < (200 * DAY_IN_SECONDS);
}

