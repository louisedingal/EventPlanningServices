import './bootstrap.js';
import {
    hasAdminPendingLiveTables,
    initAdminPendingLiveUi,
    refreshAdminPendingTables,
    startAdminPendingPolling,
} from './admin-pending-realtime.js';
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

let realtimeSocket = null;
let realtimeReconnectTimer = null;

function getRealtimeWebSocketBaseUrl() {
    const { protocol, host } = window.location;
    const wsProtocol = protocol === 'https:' ? 'wss:' : 'ws:';
    const configuredBase = document.body?.dataset?.realtimeWsBase || '';

    if (configuredBase) {
        return configuredBase;
    }

    const hostParts = host.split(':');
    const hostname = hostParts[0];

    return `${wsProtocol}//${hostname}:8081`;
}

function showRealtimeToast(message) {
    const existing = document.getElementById('realtime-toast');
    if (existing) {
        existing.remove();
    }

    const toast = document.createElement('div');
    toast.id = 'realtime-toast';
    toast.textContent = message;
    toast.style.cssText = [
        'position:fixed',
        'right:16px',
        'bottom:16px',
        'z-index:99999',
        'background:#0f172a',
        'color:#ffffff',
        'padding:10px 14px',
        'border-radius:10px',
        'box-shadow:0 8px 20px rgba(0,0,0,0.25)',
        'font-size:13px',
        'font-weight:600',
    ].join(';');

    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2500);
}

async function connectRealtimeWebSocket() {
    const tokenEndpoint = document.body?.dataset?.realtimeTokenEndpoint || '';
    if (!tokenEndpoint) {
        return;
    }
    if (realtimeSocket && (realtimeSocket.readyState === WebSocket.OPEN || realtimeSocket.readyState === WebSocket.CONNECTING)) {
        return;
    }

    try {
        const tokenRes = await fetch(tokenEndpoint, {
            credentials: 'same-origin',
            headers: { Accept: 'application/json' },
        });
        if (!tokenRes.ok) {
            return;
        }

        const { token } = await tokenRes.json();
        if (!token) {
            return;
        }

        const wsBaseUrl = getRealtimeWebSocketBaseUrl();
        realtimeSocket = new WebSocket(`${wsBaseUrl}/?token=${encodeURIComponent(token)}`);

        realtimeSocket.onmessage = (event) => {
            let payload = null;
            try {
                payload = JSON.parse(event.data);
            } catch (e) {
                return;
            }

            if (!payload || !payload.type) {
                return;
            }

            const path = window.location.pathname;
            const isAdminPendingDataPage =
                path.startsWith('/admin/pending-requests')
                || path === '/admin/'
                || path === '/admin'
                || path.startsWith('/admin/staff-dashboard');
            const isAdminDataPage =
                path.startsWith('/admin/events')
                || path.startsWith('/admin/records')
                || path === '/admin/'
                || path === '/admin'
                || path.startsWith('/admin/staff-dashboard')
                || path.startsWith('/admin/analytics');
            const isPublicCatalogPage =
                path.startsWith('/services')
                || path.startsWith('/portfolio')
                || path.startsWith('/themes')
                || path.startsWith('/venue')
                || path === '/';

            if (payload.type === 'admin.pending_requests.updated' && isAdminPendingDataPage) {
                if (hasAdminPendingLiveTables()) {
                    refreshAdminPendingTables({ flashNewRow: true })
                        .then((ok) => {
                            if (ok) {
                                showRealtimeToast('New booking received');
                            }
                        })
                        .catch(() => {});
                }
                return;
            }

            if (payload.type === 'admin.catalog.updated' && isAdminDataPage) {
                showRealtimeToast('Admin data changed. Refreshing...');
                setTimeout(() => window.location.reload(), 350);
                return;
            }

            if (payload.type === 'customer.catalog.updated' && isPublicCatalogPage) {
                showRealtimeToast('Catalog updated. Refreshing...');
                setTimeout(() => window.location.reload(), 350);
            }
        };

        realtimeSocket.onerror = () => {
            realtimeSocket = null;
        };

        realtimeSocket.onclose = () => {
            realtimeSocket = null;
            if (realtimeReconnectTimer) {
                clearTimeout(realtimeReconnectTimer);
            }
            realtimeReconnectTimer = setTimeout(connectRealtimeWebSocket, 3000);
        };
    } catch (e) {
        if (realtimeReconnectTimer) {
            clearTimeout(realtimeReconnectTimer);
        }
        realtimeReconnectTimer = setTimeout(connectRealtimeWebSocket, 4000);
    }
}

function initRealtimeWebSocket() {
    connectRealtimeWebSocket();
}

document.addEventListener('DOMContentLoaded', initRealtimeWebSocket);
document.addEventListener('turbo:load', initRealtimeWebSocket);
function initAdminPendingLiveTables() {
    initAdminPendingLiveUi();
    if (hasAdminPendingLiveTables()) {
        refreshAdminPendingTables({ silent: true }).catch(() => {});
        startAdminPendingPolling(3000);
    }
}

document.addEventListener('DOMContentLoaded', initAdminPendingLiveTables);
document.addEventListener('turbo:load', initAdminPendingLiveTables);

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
