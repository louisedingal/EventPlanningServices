/**
 * Live updates for admin pending event request tables (no full page reload).
 */

function escapeHtml(value) {
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

function renderSourceBadge(request) {
    if (request.isFromMobileApp) {
        return '<span class="source-badge source-mobile" title="Submitted from Dingal mobile app"><i class="bi bi-phone"></i> Mobile app</span>';
    }

    return '<span class="source-badge source-web" title="Submitted from website"><i class="bi bi-globe"></i> Website</span>';
}

function renderPendingRow(request, showViewButton) {
    const viewButton = showViewButton
        ? `<button type="button" class="action-btn view-btn" data-view-request="${request.id}" style="padding: 0.5rem 1rem;">
                <i class="bi bi-eye"></i> View
           </button>`
        : '';

    return `<tr data-request-id="${request.id}">
        <td>${escapeHtml(request.createdAt)}</td>
        <td>${renderSourceBadge(request)}</td>
        <td><strong>${escapeHtml(request.clientEmail)}</strong></td>
        <td>${escapeHtml(request.eventType)}</td>
        <td>${escapeHtml(request.preferredDate || '-')}</td>
        <td>${escapeHtml(request.guestCount ?? '-')}</td>
        <td>${escapeHtml(request.budget || '-')}</td>
        <td>
            <span class="status-badge pending" style="padding: 0.35rem 0.75rem; border-radius: 6px; font-size: 0.8rem; font-weight: 600; background: #fef3c7; color: #92400e; text-transform: uppercase;">
                ${escapeHtml(request.status)}
            </span>
        </td>
        <td>
            <div style="display: flex; gap: 0.5rem; align-items: center;">
                ${viewButton}
                <form method="post" action="${escapeHtml(request.markDoneUrl)}" style="display: inline-block; margin: 0;">
                    <input type="hidden" name="_token" value="${escapeHtml(request.markDoneToken)}">
                    <button type="submit" class="action-btn" style="padding: 0.5rem 1rem; background: #10b981; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; transition: all 0.2s ease;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">
                        <i class="bi bi-check-circle"></i> Done
                    </button>
                </form>
            </div>
        </td>
    </tr>`;
}

function renderPendingTableBody(tbody, requests, showViewButton) {
    if (!tbody) {
        return;
    }

    if (!requests.length) {
        tbody.innerHTML = '<tr><td colspan="9" class="empty-state"><p>No pending event requests</p></td></tr>';
        return;
    }

    tbody.innerHTML = requests.map((request) => renderPendingRow(request, showViewButton)).join('');
}

function updatePendingHeadings(count) {
    document.querySelectorAll('.js-pending-requests-heading').forEach((heading) => {
        heading.textContent = `Pending Event Requests (${count})`;
    });
}

function updatePendingKpi(count) {
    document.querySelectorAll('.js-pending-kpi-value').forEach((el) => {
        el.textContent = String(count);
    });
}

function syncRequestData(requests) {
    window.requestData = {};
    requests.forEach((request) => {
        window.requestData[request.id] = {
            id: request.id,
            source: request.source,
            clientEmail: request.clientEmail,
            eventType: request.eventType,
            preferredDate: request.preferredDate,
            guestCount: request.guestCount,
            budget: request.budget,
            venue: request.venue,
            theme: request.theme,
            preferredStyleLabel: request.preferredStyleLabel,
            preferredStyleImageUrl: request.preferredStyleImageUrl,
            specialRequests: request.specialRequests,
            servicePackage: request.servicePackage,
            preferredTime: request.preferredTime,
            createdAt: request.createdAtFull,
        };
    });
}

function getPendingFeedUrl() {
    return document.body?.dataset?.adminPendingFeed || '';
}

export function hasAdminPendingLiveTables() {
    return document.querySelectorAll('.js-pending-requests-tbody').length > 0;
}

export async function refreshAdminPendingTables(options = {}) {
    const feedUrl = getPendingFeedUrl();
    if (!feedUrl || !hasAdminPendingLiveTables()) {
        return false;
    }

    const response = await fetch(feedUrl, {
        credentials: 'same-origin',
        headers: { Accept: 'application/json' },
    });

    if (!response.ok) {
        return false;
    }

    const payload = await response.json();
    const requests = Array.isArray(payload.requests) ? payload.requests : [];
    const count = typeof payload.count === 'number' ? payload.count : requests.length;

    document.querySelectorAll('.js-pending-requests-tbody').forEach((tbody) => {
        const showViewButton = tbody.dataset.showView === '1';
        renderPendingTableBody(tbody, requests, showViewButton);
    });

    updatePendingHeadings(count);
    updatePendingKpi(count);
    syncRequestData(requests);

    if (options.flashNewRow && requests.length > 0) {
        const newestId = requests[0]?.id;
        if (newestId) {
            const row = document.querySelector(`tr[data-request-id="${newestId}"]`);
            if (row) {
                row.style.transition = 'background-color 0.6s ease';
                row.style.backgroundColor = '#ecfdf5';
                setTimeout(() => {
                    row.style.backgroundColor = '';
                }, 1800);
            }
        }
    }

    return true;
}

export function initAdminPendingLiveUi() {
    document.body.addEventListener('click', (event) => {
        const viewBtn = event.target.closest('[data-view-request]');
        if (!viewBtn) {
            return;
        }
        const requestId = Number(viewBtn.getAttribute('data-view-request'));
        if (requestId && typeof window.openRequestModal === 'function') {
            window.openRequestModal(requestId);
        }
    });
}
