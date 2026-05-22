import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import './styles/landing.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

/**
 * Restrict amount-style fields: integers, decimals, or "money range" text (digits, . , - space only).
 * Mark inputs with data-numeric-only="integer" | "decimal" | "money-text".
 */
function bindNumericOnlyInputs() {
    const navigationKeys = new Set([
        'Backspace', 'Delete', 'Tab', 'Escape', 'Enter',
        'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown', 'Home', 'End',
    ]);

    document.querySelectorAll('[data-numeric-only]').forEach((el) => {
        if (el.tagName !== 'INPUT' && el.tagName !== 'TEXTAREA') {
            return;
        }
        if (el.dataset.numericBound === '1') {
            return;
        }
        el.dataset.numericBound = '1';

        const mode = el.getAttribute('data-numeric-only') || 'integer';

        const onInputInteger = () => {
            const v = el.value.replace(/\D/g, '');
            if (el.value !== v) {
                el.value = v;
            }
        };

        const onInputDecimal = () => {
            let v = el.value.replace(/[^\d.]/g, '');
            const firstDot = v.indexOf('.');
            if (firstDot !== -1) {
                v = v.slice(0, firstDot + 1) + v.slice(firstDot + 1).replace(/\./g, '');
            }
            if (el.value !== v) {
                el.value = v;
            }
        };

        const onInputMoneyText = () => {
            const v = el.value.replace(/[^0-9\s.,\-]/g, '');
            if (el.value !== v) {
                el.value = v;
            }
        };

        const allowKeyInteger = (e) => {
            if (e.ctrlKey || e.metaKey || e.altKey) {
                return true;
            }
            if (navigationKeys.has(e.key)) {
                return true;
            }
            return /^\d$/.test(e.key);
        };

        const allowKeyDecimal = (e) => {
            if (e.ctrlKey || e.metaKey || e.altKey) {
                return true;
            }
            if (navigationKeys.has(e.key)) {
                return true;
            }
            if (/^\d$/.test(e.key)) {
                return true;
            }
            return e.key === '.' && !String(el.value).includes('.');
        };

        const allowKeyMoneyText = (e) => {
            if (e.ctrlKey || e.metaKey || e.altKey) {
                return true;
            }
            if (navigationKeys.has(e.key)) {
                return true;
            }
            return /^[\d.,\-]$/.test(e.key) || e.key === ' ';
        };

        if (mode === 'integer') {
            el.addEventListener('input', onInputInteger);
            el.addEventListener('keydown', (e) => {
                if (!allowKeyInteger(e)) {
                    e.preventDefault();
                }
            });
        } else if (mode === 'decimal') {
            el.addEventListener('input', onInputDecimal);
            el.addEventListener('keydown', (e) => {
                if (!allowKeyDecimal(e)) {
                    e.preventDefault();
                }
            });
        } else if (mode === 'money-text') {
            el.addEventListener('input', onInputMoneyText);
            el.addEventListener('keydown', (e) => {
                if (!allowKeyMoneyText(e)) {
                    e.preventDefault();
                }
            });
        }
    });
}

function initNumericOnlyOnPage() {
    bindNumericOnlyInputs();
}

document.addEventListener('DOMContentLoaded', initNumericOnlyOnPage);
document.addEventListener('turbo:load', initNumericOnlyOnPage);
document.addEventListener('turbo:render', initNumericOnlyOnPage);

// Hover-triggered random image rotator for Services
document.addEventListener('DOMContentLoaded', () => {
    const stack = document.querySelector('.rotator-stack');
    if (!stack) return;

    const frames = Array.from(stack.querySelectorAll('.rotator-frame'));
    if (frames.length === 0) return;

    let intervalId = null;
    let currentIndex = frames.findIndex(f => f.classList.contains('is-visible'));
    if (currentIndex < 0) currentIndex = 0;

    const showIndex = (idx) => {
        frames.forEach((f, i) => f.classList.toggle('is-visible', i === idx));
    };

    const pickNextRandomIndex = () => {
        if (frames.length <= 1) return 0;
        let next = currentIndex;
        while (next === currentIndex) {
            next = Math.floor(Math.random() * frames.length);
        }
        return next;
    };

    const start = () => {
        if (intervalId) return;
        intervalId = setInterval(() => {
            const next = pickNextRandomIndex();
            currentIndex = next;
            showIndex(currentIndex);
        }, 2000);
    };

    const stop = () => {
        if (intervalId) {
            clearInterval(intervalId);
            intervalId = null;
        }
    };

    // Start auto-rotation immediately without requiring hover
    start();
});
