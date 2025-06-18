jQuery(document).ready(function($) {
    $('.custom-buy-button').on('click', function(e) {
        e.preventDefault(); // Щоб не відбувався перехід по лінку одразу
        const $btn = $(this);

        $btn.addClass('clicked');

        setTimeout(() => {
            $btn.removeClass('clicked');
            // Після анімації — переходимо по лінку (імітація кліку)
            window.location.href = $btn.attr('href');
        }, 300);
    });


    $('.custom-buy-button').on('click', function(e) {
        e.preventDefault();
    
        const $button = $(this);
        const $productCard = $button.closest('.custom-product-card');
        const $productImage = $productCard.find('.woocommerce-loop-product__link img');
        const $cart = $('#hfe-site-header-cart'); // селектор корзини
    
        // Клонування картинки
        const $flyingImg = $productImage.clone()
            .css({
                position: 'absolute',
                top: $productImage.offset().top,
                left: $productImage.offset().left,
                width: $productImage.width(),
                height: $productImage.height(),
                zIndex: 1000,
                pointerEvents: 'none',
                borderRadius: '12px',
            })
            .appendTo('body');
    
        // Анімація "польоту"
        $flyingImg.animate({
            top: $cart.offset().top + 10,
            left: $cart.offset().left + 10,
            width: 30,
            height: 30,
            opacity: 0.5
        }, 800, function () {
            $flyingImg.remove();
        });
    
        // Анімація кнопки
        $button.addClass('clicked');
        setTimeout(() => {
            $button.removeClass('clicked');
            window.location.href = $button.attr('href');
        }, 300);
    });
});

//для перекладу
document.addEventListener('DOMContentLoaded', function () {
    const uaLink = document.querySelector('.lang-to-ua');
    if (uaLink) {
        uaLink.addEventListener('click', function (e) {
            e.preventDefault();
            let currentUrl = window.location.href;
            let newUrl = currentUrl.replace('/en/', '/');
            // Прибрати випадок, якщо було щось типу https://site.com/en
            newUrl = newUrl.replace(/\/en$/, '');
            window.location.href = newUrl;
        });
    }
});

