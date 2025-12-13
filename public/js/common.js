// Common JavaScript Functions - Barcha sahifalar uchun umumiy funksiyalar

/**
 * Debounce function - funksiyani belgilangan vaqt ichida bir marta chaqirish
 * @param {Function} func - Chaqiriladigan funksiya
 * @param {number} wait - Kutish vaqti (millisekundlarda)
 * @returns {Function}
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Throttle function - funksiyani belgilangan vaqt ichida maksimal bir marta chaqirish
 * @param {Function} func - Chaqiriladigan funksiya
 * @param {number} limit - Cheklov vaqti (millisekundlarda)
 * @returns {Function}
 */
function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

/**
 * Format number - raqamni formatlash
 * @param {number} num - Formatlanadigan raqam
 * @param {number} decimals - Kasr soni
 * @returns {string}
 */
function formatNumber(num, decimals = 0) {
    return new Intl.NumberFormat('uz-UZ', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
    }).format(num);
}

/**
 * Format date - sanani formatlash
 * @param {Date|string} date - Formatlanadigan sana
 * @param {string} locale - Til kodi (default: 'uz-UZ')
 * @returns {string}
 */
function formatDate(date, locale = 'uz-UZ') {
    const dateObj = date instanceof Date ? date : new Date(date);
    return new Intl.DateTimeFormat(locale, {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }).format(dateObj);
}

/**
 * Copy to clipboard - matnni clipboard'ga ko'chirish
 * @param {string} text - Ko'chiriladigan matn
 * @returns {Promise<boolean>}
 */
async function copyToClipboard(text) {
    try {
        await navigator.clipboard.writeText(text);
        return true;
    } catch (err) {
        console.error('Clipboard yozishda xatolik:', err);
        return false;
    }
}

/**
 * Confirm dialog - tasdiqlash dialogi
 * @param {string} message - Xabar matni
 * @param {string} title - Sarlavha
 * @returns {Promise<boolean>}
 */
function confirmDialog(message, title = 'Tasdiqlash') {
    return new Promise((resolve) => {
        if (confirm(`${title}\n\n${message}`)) {
            resolve(true);
        } else {
            resolve(false);
        }
    });
}

/**
 * Show loading spinner - yuklanish ko'rsatkichini ko'rsatish
 * @param {HTMLElement} element - Spinner ko'rsatiladigan element
 */
function showLoading(element) {
    if (!element) return;
    element.classList.add('loading');
    element.disabled = true;
}

/**
 * Hide loading spinner - yuklanish ko'rsatkichini yashirish
 * @param {HTMLElement} element - Spinner yashiriladigan element
 */
function hideLoading(element) {
    if (!element) return;
    element.classList.remove('loading');
    element.disabled = false;
}

/**
 * Scroll to top - sahifaning yuqorisiga scroll qilish
 * @param {number} duration - Scroll davomiyligi (millisekundlarda)
 */
function scrollToTop(duration = 500) {
    const start = window.pageYOffset;
    const distance = -start;
    let startTime = null;

    function animation(currentTime) {
        if (startTime === null) startTime = currentTime;
        const timeElapsed = currentTime - startTime;
        const run = easeInOutQuad(timeElapsed, start, distance, duration);
        window.scrollTo(0, run);
        if (timeElapsed < duration) requestAnimationFrame(animation);
    }

    function easeInOutQuad(t, b, c, d) {
        t /= d / 2;
        if (t < 1) return c / 2 * t * t + b;
        t--;
        return -c / 2 * (t * (t - 2) - 1) + b;
    }

    requestAnimationFrame(animation);
}

/**
 * Get URL parameter - URL parametrini olish
 * @param {string} name - Parametr nomi
 * @returns {string|null}
 */
function getURLParameter(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

/**
 * Set URL parameter - URL parametrini o'rnatish
 * @param {string} name - Parametr nomi
 * @param {string} value - Parametr qiymati
 */
function setURLParameter(name, value) {
    const url = new URL(window.location);
    url.searchParams.set(name, value);
    window.history.pushState({}, '', url);
}

// DOM ready event
document.addEventListener('DOMContentLoaded', function() {
    // Barcha sahifalar uchun umumiy initialization
    console.log('Common JavaScript yuklandi');
});
