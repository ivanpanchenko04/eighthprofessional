jQuery(document).ready(function ($) {
  // --- 1. Логіка кнопок Кількість (+/-) ---
  function updateMinusColor($wrapper, val) {
    const $minus = $wrapper.find(".minus");
    if (val <= 1) {
      $minus.css("color", "#ccc");
    } else {
      $minus.css("color", "#570122");
    }
  }

  // Ініціалізація кольору мінуса при завантаженні
  $(".quantity-wrapper").each(function () {
    updateMinusColor($(this), parseInt($(this).find(".qty").val()));
  });

  // Обробка кліку на +/-
  $(document).on("click", ".plus, .minus", function (e) {
    e.preventDefault();
    const $wrapper = $(this).closest(".quantity-wrapper");
    const $input = $wrapper.find(".qty");
    let currentVal = parseInt($input.val());
    const isAdd = $(this).hasClass("plus");

    if (!isNaN(currentVal)) {
      let newVal = isAdd ? currentVal + 1 : currentVal > 1 ? currentVal - 1 : 1;
      $input.val(newVal).trigger("change");
      updateMinusColor($wrapper, newVal);

      // Оновлюємо data-quantity у сусідній кнопки покупки
      $(this)
        .closest(".custom-product-card")
        .find(".custom-buy-button")
        .attr("data-quantity", newVal);
    }
  });

  // Обробка ручного введення в інпут
  $(document).on("input change", ".quantity-wrapper .qty", function () {
    const $input = $(this);
    const $wrapper = $input.closest(".quantity-wrapper");
    const $btn = $wrapper
      .closest(".custom-product-card")
      .find(".custom-buy-button");
    let val = parseInt($input.val());

    // Якщо ввели щось не те або менше 1 — скидаємо на 1
    if (isNaN(val) || val < 1) {
      val = 1;
      $input.val(1);
    }

    // Оновлюємо колір мінуса
    updateMinusColor($wrapper, val);

    // Передаємо актуальну кількість кнопці покупки
    $btn.attr("data-quantity", val);
  });

  // --- 2. Логіка кнопки "До кошика" (Анімація польоту + AJAX/Перехід) ---
  $(document).on("click", ".custom-buy-button", function (e) {
    e.preventDefault();
    const $button = $(this);
    const $productCard = $button.closest(".custom-product-card");

    // Знаходимо картинку (якщо структура змінилася, перевірте селектор img)
    const $productImage = $productCard.find(".product-left img");
    const $cart = $("#hfe-site-header-cart");

    if ($productImage.length && $cart.length) {
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
        },
      );
    }

    // Анімація натискання кнопки
    $button.addClass("clicked");
    setTimeout(() => {
      $button.removeClass("clicked");
      // Переходимо за посиланням (яке вже включає правильний data-quantity)
      window.location.href =
        $button.attr("href") + "&quantity=" + $button.attr("data-quantity");
    }, 300);
  });
});

// --- 3. Інші скрипти (Переклад, Скрол, Валюта, Пошук) ---
document.addEventListener("DOMContentLoaded", function () {
  // Переклад
  const uaLink = document.querySelector(".lang-to-ua");
  if (uaLink) {
    uaLink.addEventListener("click", function (e) {
      e.preventDefault();
      window.location.href = window.location.href
        .replace("/en/", "/")
        .replace(/\/en$/, "");
    });
  }

  // Заміна символу гривні
  const priceElements = document.querySelectorAll(
    ".product-price, .price, .product-price-row",
  );
  priceElements.forEach((el) => {
    el.innerHTML = el.innerHTML.replace(/грн\.?/gi, "₴");
  });

  // Пошук
  const searchWrapper = document.querySelector(".hfe-search-button-wrapper");
  if (searchWrapper) {
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
  }
});

// Скрол хедера
window.addEventListener("scroll", function () {
  const header = document.querySelector(".smart-header");
  if (header) {
    header.classList.toggle("scrolled", window.scrollY > 50);
  }
});

// Автоперемикання валюти WOOCS
document.addEventListener("DOMContentLoaded", function () {
  const lang = document.documentElement.lang.toLowerCase();
  const langToCurrency = { uk: "UAH", uk_UA: "UAH", en: "USD", en_US: "USD" };
  const targetCurrency = langToCurrency[lang];
  if (!targetCurrency) return;

  const interval = setInterval(function () {
    if (
      typeof woocs_current_currency !== "undefined" &&
      typeof woocs_set_currency === "function"
    ) {
      if (woocs_current_currency !== targetCurrency) {
        woocs_set_currency(targetCurrency);
      }
      clearInterval(interval);
    }
  }, 300);
});

//Поле для введення міста
document.addEventListener("DOMContentLoaded", function () {
  var trigger = document.getElementById("city-trigger");
  var container = document.getElementById("city-input-container");

  if (trigger && container) {
    trigger.addEventListener("click", function () {
      container.style.display =
        container.style.display === "none" ? "block" : "none";
      if (container.style.display === "block") {
        container.querySelector("input").focus();
      }
    });
  }
});

jQuery(function ($) {
  // 1. Селект для МІСТА
  $("#billing_city")
    .select2({
      width: "100%",
      minimumInputLength: 3,
      placeholder: "Оберіть місто...",
      language: {
        inputTooShort: function () {
          return "Введіть хоча б 3 символи";
        },
        searching: function () {
          return "Шукаємо...";
        },
        noResults: function () {
          return "Місто не знайдено";
        },
      },
      ajax: {
        url: wc_checkout_params.ajax_url,
        type: "POST",
        delay: 300,
        data: function (params) {
          return {
            action: "custom_search_cities",
            search: params.term,
          };
        },
        processResults: function (data) {
          return { results: data };
        },
      },
    })
    .on("select2:select", function (e) {
      // Зберігаємо REF обраного міста
      $("#billing_city_ref").val(e.params.data.id);

      // Очищуємо та активуємо поле відділень
      $("#billing_address_1").val(null).trigger("change");

      // Оновлюємо чеккаут для перерахунку доставки
      $("body").trigger("update_checkout");
    });

  // 2. Селект для ВІДДІЛЕННЯ
  $("#billing_address_1").select2({
    width: "100%",
    placeholder: "Оберіть відділення...",
    ajax: {
      url: wc_checkout_params.ajax_url,
      type: "POST",
      delay: 200,
      data: function (params) {
        return {
          action: "custom_search_warehouses",
          city_ref: $("#billing_city_ref").val(), // Передаємо REF міста
          search: params.term,
        };
      },
      processResults: function (data) {
        return { results: data };
      },
    },
  });
});
