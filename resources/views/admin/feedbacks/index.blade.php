@extends('admin.layout.app')

@section('content')

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">
    <div>
        <h1>Feedbacks</h1>
        <p>Manage user feedbacks and ratings</p>
    </div>

    {{-- <button class="btn btn-primary" onclick="openCreateModal()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        New Feedback
    </button> --}}
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
               placeholder="Search feedback..."
               oninput="filterFeedbacks(this.value)">

        <span id="feedback-count"
              style="font-size:12px;color:var(--faint);white-space:nowrap">
        </span>

    </div>

    <div style="overflow-x:auto">

        <table class="roles-table">

            <thead>
                <tr>
                    <th>#</th>
                    <th>User ID</th>
                    <th>Message</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>

            <tbody id="feedbackBody"></tbody>

        </table>

        <div id="emptyState"
             class="empty-state"
             style="display:none">

            <p>No feedbacks found</p>

        </div>

    </div>
</div>

{{-- ═══════════ CREATE / EDIT MODAL ═══════════ --}}
<div class="modal-backdrop"
     id="formModal"
     onclick="handleBackdropClick(event)">

    <div class="modal">

        <div class="modal-header">

            <h2 id="modalTitle">New Feedback</h2>

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

                <label class="form-label">User ID *</label>

                <input type="number"
                       id="feedbackUserId"
                       class="form-control"
                       placeholder="Enter user id">

            </div>

            <div class="form-group">

                <label class="form-label">Message *</label>

                <textarea id="feedbackMessage"
                          class="form-control"
                          rows="4"
                          placeholder="Enter feedback"></textarea>

            </div>

            <div class="form-group">

                <label class="form-label">Rating *</label>

                <select id="feedbackRating"
                        class="form-control">

                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>

                </select>

            </div>

            <div class="form-group">

                <label class="form-label">Date *</label>

                <input type="date"
                       id="feedbackDate"
                       class="form-control">

            </div>

            <div class="form-group">

                <label class="form-label">Status</label>

                <label class="toggle-row">

                    <div>
                        <div class="toggle-row-label">Active</div>

                        <div class="toggle-row-sub">
                            Feedback visible to users
                        </div>
                    </div>

                    <label class="toggle">

                        <input type="checkbox"
                               id="feedbackStatus"
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
                    onclick="saveFeedback()">

                <span class="spinner"></span>

                <span class="btn-label">
                    Save Feedback
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

            <h3>Delete Feedback?</h3>

            <p>
                Are you sure you want to delete this feedback?
            </p>

        </div>

        <div class="modal-footer"
             style="justify-content:center;gap:10px">

            <button class="btn btn-ghost"
                    onclick="closeDeleteModal()">

                Cancel

            </button>

            <button class="btn btn-danger"
                    onclick="confirmDelete()">

                Delete

            </button>

        </div>

    </div>

</div>

<script>

let feedbacks = @json($feedbacks);

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

    const tbody = document.getElementById('feedbackBody');
    const empty = document.getElementById('emptyState');

    document.getElementById('feedback-count').textContent =
        list.length + ' Feedback' + (list.length !== 1 ? 's' : '');

    if (!list.length) {

        tbody.innerHTML = '';

        empty.style.display = 'block';

        return;
    }

    empty.style.display = 'none';

    tbody.innerHTML = list.map((feedback, i) => {

        const active = feedback.status == 1;

        return `
        <tr>

            <td>${i + 1}</td>

            <td>${feedback.user_id}</td>

            <td style="max-width:300px">
                ${escHtml(feedback.message.substring(0, 80))}
                ${feedback.message.length > 80 ? '...' : ''}
            </td>

            <td>
                ⭐ ${feedback.rating}
            </td>

            <td>

                <div class="toggle-wrap">

                    <label class="toggle">

                        <input type="checkbox"
                               ${active ? 'checked' : ''}
                               onchange="toggleStatus(${feedback.id}, this.checked)">

                        <span class="toggle-slider"></span>

                    </label>

                    <span class="toggle-label ${active ? 'active' : 'inactive'}">

                        ${active ? 'Active' : 'Inactive'}

                    </span>

                </div>

            </td>

            <td>
                ${formatDate(feedback.date)}
            </td>

            <td>

                <div class="actions-cell"
                     style="justify-content:flex-end">

                    <button class="btn-icon"
                            onclick="openEditModal(${feedback.id})">

                        ✏️

                    </button>

                    <button class="btn-icon"
                            style="color:red"
                            onclick="openDeleteModal(${feedback.id})">

                        🗑️

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
function filterFeedbacks(q) {

    const lower = q.toLowerCase();

    render(
        feedbacks.filter(f =>
            f.message.toLowerCase().includes(lower)
        )
    );
}

// ─────────────────────────────────────
// Create
// ─────────────────────────────────────
function openCreateModal() {

    editingId = null;

    document.getElementById('modalTitle').textContent =
        'New Feedback';

    document.getElementById('feedbackUserId').value = '';
    document.getElementById('feedbackMessage').value = '';
    document.getElementById('feedbackRating').value = '5';
    document.getElementById('feedbackDate').value = '';
    document.getElementById('feedbackStatus').checked = true;

    document.getElementById('formModal').classList.add('open');
}

// ─────────────────────────────────────
// Edit
// ─────────────────────────────────────
function openEditModal(id) {

    const feedback = feedbacks.find(f => f.id === id);

    if (!feedback) return;

    editingId = id;

    document.getElementById('modalTitle').textContent =
        'Edit Feedback';

    document.getElementById('feedbackUserId').value =
        feedback.user_id;

    document.getElementById('feedbackMessage').value =
        feedback.message;

    document.getElementById('feedbackRating').value =
        feedback.rating;

    document.getElementById('feedbackDate').value =
        feedback.date;

    document.getElementById('feedbackStatus').checked =
        feedback.status == 1;

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
// Save
// ─────────────────────────────────────
async function saveFeedback() {

    const user_id = document.getElementById('feedbackUserId').value;
    const message = document.getElementById('feedbackMessage').value.trim();
    const rating  = document.getElementById('feedbackRating').value;
    const date    = document.getElementById('feedbackDate').value;
    const status  = document.getElementById('feedbackStatus').checked ? 1 : 0;

    if (!user_id || !message || !rating || !date) {
        alert('Please fill all fields');
        return;
    }

    const btn = document.getElementById('saveBtn');

    btn.classList.add('loading');
    btn.disabled = true;

    const url =
        editingId
            ? `/admin/feedback/${editingId}`
            : `/admin/feedback`;

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
                user_id,
                message,
                rating,
                date,
                status
            })
        });

        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message ?? 'Something went wrong');
        }

        if (editingId) {

            const index = feedbacks.findIndex(f => f.id === editingId);

            if (index > -1) {
                feedbacks[index] = data.feedback;
            }

        } else {

            feedbacks.unshift(data.feedback);
        }

        render(feedbacks);

        closeFormModal();

        alert(data.message);

    } catch (err) {

        alert(err.message);

    } finally {

        btn.classList.remove('loading');
        btn.disabled = false;
    }
}

// ─────────────────────────────────────
// Toggle Status
// ─────────────────────────────────────
async function toggleStatus(id, checked) {

    const feedback = feedbacks.find(f => f.id === id);

    if (!feedback) return;

    try {

        const res = await fetch(`/admin/feedback/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                user_id: feedback.user_id,
                message: feedback.message,
                rating: feedback.rating,
                date: feedback.date,
                status: checked ? 1 : 0
            })
        });

        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message ?? 'Failed');
        }

        feedback.status = checked ? 1 : 0;

        render(feedbacks);

    } catch (err) {

        alert(err.message);
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

        const res = await fetch(`/admin/feedback/${deletingId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            }
        });

        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message ?? 'Delete failed');
        }

        feedbacks = feedbacks.filter(f => f.id !== deletingId);

        render(feedbacks);

        closeDeleteModal();

        alert(data.message);

    } catch (err) {

        alert(err.message);
    }
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

render(feedbacks);

</script>

@endsection