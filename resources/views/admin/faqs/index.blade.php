@extends('admin.layout.app')

@section('content')

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">
    <div>
        <h1>FAQs</h1>
        <p>Manage frequently asked questions</p>
    </div>

    <button class="btn btn-primary" onclick="openCreateModal()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        New FAQ
    </button>
</div>

{{-- ═══════════ TABLE CARD ═══════════ --}}
<div class="card">

    <div class="search-bar">
        <svg width="15" height="15" viewBox="0 0 24 24"
             fill="none" stroke="currentColor"
             stroke-width="2"
             style="color:var(--faint);flex-shrink:0">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>

        <input type="text"
               id="searchInput"
               placeholder="Search FAQs…"
               oninput="filterFaqs(this.value)">

        <span id="faq-count"
              style="font-size:12px;color:var(--faint);white-space:nowrap">
        </span>
    </div>

    <div style="overflow-x:auto">

        <table class="roles-table">

            <thead>
                <tr>
                    <th style="width:40px">#</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Status</th>
                    <th style="width:120px">Created</th>
                    <th style="width:100px;text-align:right">Actions</th>
                </tr>
            </thead>

            <tbody id="faqBody"></tbody>

        </table>

        <div id="emptyState"
             class="empty-state"
             style="display:none">

            <svg width="40" height="40" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="12" cy="12" r="10"/>
                <path d="M9.09 9a3 3 0 1 1 5.82 1
                         c0 2-3 3-3 3"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>

            <p>No FAQs found</p>
            <span>Try a different search or create a new FAQ</span>

        </div>

    </div>
</div>

{{-- ═══════════ CREATE / EDIT MODAL ═══════════ --}}
<div class="modal-backdrop"
     id="formModal"
     onclick="handleBackdropClick(event)">

    <div class="modal">

        <div class="modal-header">
            <h2 id="modalTitle">New FAQ</h2>

            <button class="btn-icon" onclick="closeFormModal()">
                <svg width="15" height="15" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <div class="modal-body">

            <div class="form-group">
                <label class="form-label">Question *</label>

                <input type="text"
                       id="faqQuestion"
                       class="form-control"
                       placeholder="Enter question">
            </div>

            <div class="form-group">
                <label class="form-label">Answer *</label>

                <textarea id="faqAnswer"
                          class="form-control"
                          rows="5"
                          placeholder="Enter answer"></textarea>
            </div>

            <div class="form-group">

                <label class="form-label">Status</label>

                <label class="toggle-row" for="faqActive">

                    <div>
                        <div class="toggle-row-label">Active</div>

                        <div class="toggle-row-sub">
                            FAQ visible to users
                        </div>
                    </div>

                    <label class="toggle">
                        <input type="checkbox"
                               id="faqActive"
                               checked>

                        <span class="toggle-slider"></span>
                    </label>

                </label>

            </div>

        </div>

        <div class="modal-footer">

            <button class="btn btn-ghost"
                    onclick="closeFormModal()">
                Cancel
            </button>

            <button class="btn btn-primary"
                    id="saveBtn"
                    onclick="saveFaq()">

                <span class="spinner"></span>

                <span class="btn-label">
                    Save FAQ
                </span>

            </button>

        </div>

    </div>
</div>

{{-- ═══════════ DELETE MODAL ═══════════ --}}
<div class="modal-backdrop"
     id="deleteModal"
     onclick="handleDeleteBackdropClick(event)">

    <div class="modal" style="max-width:370px">

        <div class="confirm-modal-body">

            <div class="confirm-icon">
                <svg width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6"/>
                    <path d="M14 11v6"/>
                    <path d="M9 6V4h6v2"/>
                </svg>
            </div>

            <h3>Delete FAQ?</h3>

            <p>
                Are you sure you want to delete this FAQ?
                <br>This action cannot be undone.
            </p>

        </div>

        <div class="modal-footer"
             style="justify-content:center;gap:10px">

            <button class="btn btn-ghost"
                    onclick="closeDeleteModal()">
                Cancel
            </button>

            <button class="btn btn-danger"
                    id="confirmDeleteBtn"
                    onclick="confirmDelete()">

                <span class="spinner"></span>

                <span class="btn-label">
                    Delete FAQ
                </span>

            </button>

        </div>

    </div>
</div>

<div id="toast-container"></div>

<script>

let faqs       = @json($faqs);
let editingId  = null;
let deletingId = null;

const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

function formatDate(str) {
    if (!str) return '—';

    return new Date(str).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });
}

// ─────────────────────────────────────
// Render
// ─────────────────────────────────────
function render(list) {

    const tbody = document.getElementById('faqBody');
    const empty = document.getElementById('emptyState');

    document.getElementById('faq-count').textContent =
        list.length + ' FAQ' + (list.length !== 1 ? 's' : '');

    if (!list.length) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }

    empty.style.display = 'none';

    tbody.innerHTML = list.map((faq, i) => {

        const active = faq.is_active == 1;

        return `
        <tr>

            <td>${i + 1}</td>

            <td>
                <strong>${escHtml(faq.question)}</strong>
            </td>

            <td style="max-width:300px">
                ${escHtml(faq.answer.substring(0, 80))}
                ${faq.answer.length > 80 ? '...' : ''}
            </td>

            <td>

                <div class="toggle-wrap">

                    <label class="toggle">

                        <input type="checkbox"
                               ${active ? 'checked' : ''}
                               onchange="toggleStatus(${faq.id}, this.checked)">

                        <span class="toggle-slider"></span>

                    </label>

                    <span class="toggle-label ${active ? 'active' : 'inactive'}">
                        ${active ? 'Active' : 'Inactive'}
                    </span>

                </div>

            </td>

            <td>
                ${formatDate(faq.created_at)}
            </td>
<td>
    <div class="actions-cell" style="justify-content:flex-end">

        <button class="btn-icon"
                title="Edit"
                onclick="openEditModal(${faq.id})">

            <svg width="13"
                 height="13"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">

                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>

                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>

            </svg>

        </button>

        <button class="btn-icon"
                title="Delete"
                style="color:var(--red);border-color:#f3c9c9"
                onclick="openDeleteModal(${faq.id})">

            <svg width="13"
                 height="13"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">

                <polyline points="3 6 5 6 21 6"/>

                <path d="M19 6l-1 14H6L5 6"/>

                <path d="M10 11v6"/>

                <path d="M14 11v6"/>

                <path d="M9 6V4h6v2"/>

            </svg>

        </button>

    </div>
</td>

        </tr>
        `;

    }).join('');
}

// ─────────────────────────────────────
// Search
// ─────────────────────────────────────
function filterFaqs(q) {

    const lower = q.toLowerCase();

    render(
        faqs.filter(f =>
            f.question.toLowerCase().includes(lower)
        )
    );
}

// ─────────────────────────────────────
// Create Modal
// ─────────────────────────────────────
function openCreateModal() {

    editingId = null;

    document.getElementById('modalTitle').textContent = 'New FAQ';

    document.getElementById('faqQuestion').value = '';
    document.getElementById('faqAnswer').value = '';
    document.getElementById('faqActive').checked = true;

    document.querySelector('#saveBtn .btn-label').textContent =
        'Save FAQ';

    document.getElementById('formModal').classList.add('open');
}

// ─────────────────────────────────────
// Edit Modal
// ─────────────────────────────────────
function openEditModal(id) {

    const faq = faqs.find(f => f.id === id);

    if (!faq) return;

    editingId = id;

    document.getElementById('modalTitle').textContent = 'Edit FAQ';

    document.getElementById('faqQuestion').value = faq.question;
    document.getElementById('faqAnswer').value = faq.answer;

    document.getElementById('faqActive').checked =
        faq.is_active == 1;

    document.querySelector('#saveBtn .btn-label').textContent =
        'Update FAQ';

    document.getElementById('formModal').classList.add('open');
}

function closeFormModal() {
    document.getElementById('formModal').classList.remove('open');
}

function handleBackdropClick(e) {

    if (e.target === document.getElementById('formModal')) {
        closeFormModal();
    }
}

// ─────────────────────────────────────
// Save FAQ
// ─────────────────────────────────────
async function saveFaq() {

    const question = document.getElementById('faqQuestion').value.trim();
    const answer   = document.getElementById('faqAnswer').value.trim();
    const is_active   = document.getElementById('faqActive').checked ? 1 : 0;

    if (!question || !answer) {
        alert('Please fill all fields');
        return;
    }

    const btn = document.getElementById('saveBtn');

    btn.classList.add('loading');
    btn.disabled = true;

    const url =
        editingId
            ? `/admin/faqs/${editingId}`
            : `/admin/faqs`;

    const method =
        editingId
            ? 'PUT'
            : 'POST';

    try {

        const res = await fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                question,
                answer,
                is_active
            })
        });

        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message ?? 'Something went wrong');
        }

        if (editingId) {

            const index = faqs.findIndex(f => f.id === editingId);

            if (index > -1) {
                faqs[index] = data.faq;
            }

            toast('FAQ updated successfully');

        } else {

            faqs.unshift(data.faq);

            toast('FAQ created successfully');
        }

        render(faqs);

        closeFormModal();

    } catch (err) {

        toast(err.message, 'error');

    } finally {

        btn.classList.remove('loading');
        btn.disabled = false;
    }
}

// ─────────────────────────────────────
// Toggle Status
// ─────────────────────────────────────
async function toggleStatus(id, checked) {

    const faq = faqs.find(f => f.id === id);

    if (!faq) return;

    try {

        const res = await fetch(`/admin/faqs/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                question: faq.question,
                answer: faq.answer,
                is_active: checked ? 1 : 0
            })
        });

        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message ?? 'Failed');
        }

        faq.is_active = checked ? 1 : 0;

        render(faqs);

    } catch (err) {

        toast(err.message, 'error');
    }
}

// ─────────────────────────────────────
// Delete
// ─────────────────────────────────────
function openDeleteModal(id) {

    deletingId = id;

    document.getElementById('deleteModal').classList.add('open');
}

function closeDeleteModal() {

    deletingId = null;

    document.getElementById('deleteModal').classList.remove('open');
}

function handleDeleteBackdropClick(e) {

    if (e.target === document.getElementById('deleteModal')) {
        closeDeleteModal();
    }
}

async function confirmDelete() {

    if (!deletingId) return;

    try {

        const res = await fetch(`/admin/faqs/${deletingId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            }
        });

        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message ?? 'Failed');
        }

        faqs = faqs.filter(f => f.id !== deletingId);

        render(faqs);

        closeDeleteModal();

        toast('FAQ deleted successfully');

    } catch (err) {

        toast(err.message, 'error');
    }
}

// ─────────────────────────────────────
// Toast
// ─────────────────────────────────────
function toast(msg, type = 'success') {

    alert(msg);
}

function escHtml(str) {

    return String(str ?? '')
        .replace(/&/g,'&amp;')
        .replace(/</g,'&lt;')
        .replace(/>/g,'&gt;')
        .replace(/"/g,'&quot;');
}

document.addEventListener('keydown', e => {

    if (e.key === 'Escape') {
        closeFormModal();
        closeDeleteModal();
    }
});

render(faqs);

</script>

@endsection