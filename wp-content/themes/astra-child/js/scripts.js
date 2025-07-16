jQuery(document).ready(function ($) {
  $(".custom-buy-button").on("click", function (e) {
    e.preventDefault(); // Щоб не відбувався перехід по лінку одразу
    const $btn = $(this);

    $btn.addClass("clicked");

    setTimeout(() => {
      $btn.removeClass("clicked");
      // Після анімації — переходимо по лінку (імітація кліку)
      window.location.href = $btn.attr("href");
    }, 300);
  });

  $(".custom-buy-button").on("click", function (e) {
    e.preventDefault();

    const $button = $(this);
    const $productCard = $button.closest(".custom-product-card");
    const $productImage = $productCard.find(
      ".woocommerce-loop-product__link img"
    );
    const $cart = $("#hfe-site-header-cart"); // селектор корзини

    // Клонування картинки
    const $flyingImg = $productImage
      .clone()
      .css({
        position: "absolute",
        top: $productImage.offset().top,
        left: $productImage.offset().left,
        width: $productImage.width(),
        height: $productImage.height(),
        zIndex: 1000,
        pointerEvents: "none",
        borderRadius: "12px",
      })
      .appendTo("body");

    // Анімація "польоту"
    $flyingImg.animate(
      {
        top: $cart.offset().top + 10,
        left: $cart.offset().left + 10,
        width: 30,
        height: 30,
        opacity: 0.5,
      },
      800,
      function () {
        $flyingImg.remove();
      }
    );

    // Анімація кнопки
    $button.addClass("clicked");
    setTimeout(() => {
      $button.removeClass("clicked");
      window.location.href = $button.attr("href");
    }, 300);
  });
});

//для перекладу
document.addEventListener("DOMContentLoaded", function () {
  const uaLink = document.querySelector(".lang-to-ua");
  if (uaLink) {
    uaLink.addEventListener("click", function (e) {
      e.preventDefault();
      let currentUrl = window.location.href;
      let newUrl = currentUrl.replace("/en/", "/");
      // Прибрати випадок, якщо було щось типу https://site.com/en
      newUrl = newUrl.replace(/\/en$/, "");
      window.location.href = newUrl;
    });
  }
});

//зміна кольору хедера при скролі
window.addEventListener("scroll", function () {
  const header = document.querySelector(".smart-header");
  if (window.scrollY > 50) {
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
  }
});

//заміна символу гривні
document.addEventListener("DOMContentLoaded", function () {
  const priceElements = document.querySelectorAll(".product-price, .price");
  priceElements.forEach(function (el) {
    el.innerHTML = el.innerHTML.replace(/грн\.?/gi, "₴");
  });
});


document.addEventListener('DOMContentLoaded', function () {
    const lang = document.documentElement.lang; // Отримуємо мову з <html lang="...">
    console.log('Current language:', lang);

    const langToCurrency = {
        'uk': 'UAH',
        'uk_UA': 'UAH',
        'en': 'USD',
        'en_US': 'USD'
    };

    const targetCurrency = langToCurrency[lang.toLowerCase()];
    if (!targetCurrency) return;

    // Очікуємо, поки завантажиться WOOCS
    const interval = setInterval(function () {
        if (typeof woocs_current_currency !== 'undefined' && typeof woocs_set_currency === 'function') {
            if (woocs_current_currency !== targetCurrency) {
                woocs_set_currency(targetCurrency);
                console.log('Currency switched to:', targetCurrency);
            }
            clearInterval(interval);
        }
    }, 300);
});


//Search
document.addEventListener("DOMContentLoaded", function () {
  const searchWrapper = document.querySelector(".hfe-search-button-wrapper");
  const icon = searchWrapper.querySelector("i");
  const input = searchWrapper.querySelector("input");
  icon.addEventListener("click", function (e) {
    e.stopPropagation(); 
    searchWrapper.classList.add("active");
    input.focus();
    input.placeholder = "Search";
  });
  document.addEventListener("click", function (e) {
    if (!searchWrapper.contains(e.target)) {
      searchWrapper.classList.remove("active");
      input.placeholder = "";
    }
  });
});


