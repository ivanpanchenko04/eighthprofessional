//адаптивний хедер

document.addEventListener('DOMContentLoaded', function () {
    let lastScroll = 0;
    const header = document.querySelector('.smart-header');

    if (!header) return;

    window.addEventListener('scroll', function () {
        const currentScroll = window.pageYOffset;

        if (currentScroll > lastScroll && currentScroll > 100) {
            // Прокрутка вниз
            header.classList.add('hide-header');
        } else {
            // Прокрутка вгору
            header.classList.remove('hide-header');
        }

        lastScroll = currentScroll;
    });
});
