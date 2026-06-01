@extends('admin.layout.app')

@section('page-title', 'Designations')

@section('content')



{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">
    <div>
        <h1>Designations</h1>
        <p>Manage designation across your application.</p>
    </div>
    <button class="btn btn-primary" onclick="openCreateModal()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        New Designation
    </button>
</div>

{{-- ═══════════ TABLE CARD ═══════════ --}}
<div class="card">
    <div class="search-bar">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--faint);flex-shrink:0">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>

        <input type="text"
               id="searchInput"
               placeholder="Search designations…"
               oninput="filterData(this.value)">

        <span id="count" style="font-size:12px;color:var(--faint);white-space:nowrap"></span>
    </div>

    <div style="overflow-x:auto">
        <table class="roles-table">
            <thead>
                <tr>
                    <th style="width:36px">#</th>
                    <th>Designation Name</th>
                    <th>Code</th>
                    <th>Status</th>
                    <th style="width:120px">Created</th>
                    <th style="width:90px;text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>

        <div id="emptyState" class="empty-state" style="display:none">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="12" cy="12" r="10"/>
                <line x1="8" y1="12" x2="16" y2="12"/>
            </svg>
            <p>No designations found</p>
            <span>Try a different search or create a new designation</span>
        </div>
    </div>
</div>

{{-- ═══════════ CREATE / EDIT MODAL ═══════════ --}}
<div class="modal-backdrop" id="formModal" onclick="handleBackdropClick(event)">
    <div class="modal">
        <div class="modal-header">
            <h2 id="modalTitle">New Designation</h2>

            <button class="btn-icon" onclick="closeModal()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <div class="modal-body">

            <div class="form-group">
                <label class="form-label">Designation Name *</label>
                <input type="text" id="name" class="form-control" placeholder="e.g. Software Engineer">
            </div>

            <div class="form-group">
                <label class="form-label">Code</label>
                <input type="text" id="code" class="form-control" placeholder="e.g. SE-01">
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea id="description" class="form-control" placeholder="Optional description"></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>

                <label class="toggle-row">
                    <div>
                        <div class="toggle-row-label">Active</div>
                        <div class="toggle-row-sub">Designation is available for employees</div>
                    </div>

                    <label class="toggle">
                        <input type="checkbox" id="status" checked>
                        <span class="toggle-slider"></span>
                    </label>
                </label>
            </div>

        </div>

        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal()">Cancel</button>

            <button class="btn btn-primary" id="saveBtn" onclick="save()">
                <span class="spinner"></span>
                <span class="btn-label">Save Designation</span>
            </button>
        </div>
    </div>
</div>

{{-- ═══════════ DELETE CONFIRM MODAL ═══════════ --}}
<div class="modal-backdrop" id="deleteModal" onclick="handleDeleteBackdropClick(event)">
    <div class="modal" style="max-width:370px">

        <div class="confirm-modal-body">
            <div class="confirm-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14H6L5 6"/>
                </svg>
            </div>

            <h3>Delete Designation?</h3>
            <p>
                Are you sure you want to delete
                <strong id="deleteText"></strong>?
                <br>This action cannot be undone.
            </p>
        </div>

        <div class="modal-footer" style="justify-content:center;gap:10px">
            <button class="btn btn-ghost" onclick="closeDelete()">Cancel</button>

            <button class="btn btn-danger" onclick="confirmDelete()">
                <span class="btn-label">Delete</span>
            </button>
        </div>

    </div>
</div>
<div id="toast-container"></div>

<script>
// ── STATE ─────────────────────────────────────────
let designations = @json($designations);
let editingId = null;
let deletingId = null;
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

// ── FORMAT DATE ───────────────────────────────────
function formatDate(str) {
    if (!str) return '—';
    return new Date(str).toLocaleDateString('en-US', {
        month: 'short', day: 'numeric', year: 'numeric'
    });
}

// ── RENDER ────────────────────────────────────────
function render(list) {
    const tbody = document.getElementById('tableBody');
    const empty = document.getElementById('emptyState');

    document.getElementById('count').textContent =
        list.length + ' designation' + (list.length !== 1 ? 's' : '');

    if (!list.length) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }

    empty.style.display = 'none';

    tbody.innerHTML = list.map((d, i) => {
        const active = d.status == 1 || d.status === true;

        return `
        <tr data-id="${d.id}">
            <td style="color:var(--faint);font-size:12px">${i + 1}</td>

            <td style="font-weight:500">${escapeHtml(d.name)}</td>

            <td>${d.code ?? '-'}</td>

            <td>
                <div class="toggle-wrap">
                    <label class="toggle" onclick="event.stopPropagation()">
                        <input type="checkbox"
                            ${active ? 'checked' : ''}
                            onchange="toggleStatus(${d.id}, this.checked)">
                        <span class="toggle-slider"></span>
                    </label>
                    <span class="toggle-label ${active ? 'active' : 'inactive'}" id="lbl-${d.id}">
                        ${active ? 'Active' : 'Inactive'}
                    </span>
                </div>
            </td>

            <td style="color:var(--muted);font-size:12px">
                ${formatDate(d.created_at)}
            </td>

            <td>
                <div class="actions-cell" style="justify-content:flex-end">
                    
                    <!-- EDIT -->
                    <button class="btn-icon" title="Edit"
                        onclick="openEditModal(${d.id})">
                        <svg width="13" height="13" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>

                    <!-- DELETE -->
                    <button class="btn-icon"
                        title="Delete"
                        style="color:var(--red);border-color:#f3c9c9"
                        onclick="openDeleteModal(${d.id}, '${escapeAttr(d.name)}')">
                        <svg width="13" height="13" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14H6L5 6"/>
                            <path d="M10 11v6"/>
                            <path d="M14 11v6"/>
                            <path d="M9 6V4h6v2"/>
                        </svg>
                    </button>

                </div>
            </td>
        </tr>`;
    }).join('');
}
// ── FILTER ────────────────────────────────────────
function filterData(q) {
    q = q.toLowerCase();
    render(designations.filter(d =>
        d.name.toLowerCase().includes(q) ||
        (d.code ?? '').toLowerCase().includes(q)
    ));
}

// ── MODAL ─────────────────────────────────────────
function openCreateModal() {
    editingId = null;

    document.getElementById('modalTitle').textContent = 'New Designation';
    clearForm();

    document.getElementById('formModal').classList.add('open');
}

function openEditModal(id) {
    const d = designations.find(x => x.id === id);
    if (!d) return;

    editingId = id;

    document.getElementById('modalTitle').textContent = 'Edit Designation';
    document.getElementById('name').value = d.name;
    document.getElementById('code').value = d.code ?? '';
    document.getElementById('description').value = d.description ?? '';
    document.getElementById('status').checked = d.status == 1;

    document.getElementById('formModal').classList.add('open');
}

function closeModal() {
    document.getElementById('formModal').classList.remove('open');
}

function handleBackdropClick(e) {
    if (e.target.id === 'formModal') closeModal();
}

// ── SAVE ──────────────────────────────────────────
async function save() {
    const name = document.getElementById('name').value.trim();
    const code = document.getElementById('code').value;
    const description = document.getElementById('description').value;
    const status = document.getElementById('status').checked ? 1 : 0;

    if (!name) {
        alert('Name is required');
        return;
    }

    const payload = { name, code, description, status };

    const url = editingId
        ? `/admin/designations/${editingId}`
        : `/admin/designations`;

    const method = editingId ? 'PUT' : 'POST';

    try {
        const res = await fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        const data = await res.json();

        if (!res.ok) throw new Error(data.message || 'Failed');

        if (editingId) {
            const index = designations.findIndex(x => x.id === editingId);
            designations[index] = data.data;
            toast('Updated successfully');
        } else {
            designations.unshift(data.data);
            toast('Created successfully');
        }

        render(designations);
        closeModal();

    } catch (err) {
        toast(err.message, 'error');
    }
}

// ── DELETE ────────────────────────────────────────
function openDeleteModal(id, name) {
    deletingId = id;
    document.getElementById('deleteText').textContent = `Delete ${name}?`;
    document.getElementById('deleteModal').classList.add('open');
}

function closeDelete() {
    document.getElementById('deleteModal').classList.remove('open');
}

async function confirmDelete() {
    try {
        const res = await fetch(`/admin/designations/${deletingId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            }
        });

        if (!res.ok) throw new Error('Delete failed');

        designations = designations.filter(d => d.id !== deletingId);

        render(designations);
        closeDelete();
        toast('Deleted');

    } catch (err) {
        toast(err.message, 'error');
    }
}

// ── STATUS ────────────────────────────────────────
async function toggleStatus(id, checked) {
    try {
        const res = await fetch(`/admin/designations/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: checked ? 1 : 0 })
        });

        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Failed');

        const d = designations.find(x => x.id === id);
        if (d) d.status = checked ? 1 : 0;

        toast('Status updated');

    } catch (err) {
        toast(err.message, 'error');
    }
}

// ── HELPERS ───────────────────────────────────────
function clearForm() {
    document.getElementById('name').value = '';
    document.getElementById('code').value = '';
    document.getElementById('description').value = '';
    document.getElementById('status').checked = true;
}

function escapeHtml(str) {
    return String(str ?? '')
        .replace(/&/g,'&amp;')
        .replace(/</g,'&lt;')
        .replace(/>/g,'&gt;')
        .replace(/"/g,'&quot;');
}

function escapeAttr(str) {
    return String(str ?? '').replace(/'/g, "\\'");
}

// ── TOAST ─────────────────────────────────────────
function toast(msg, type = 'success') {
    const container = document.getElementById('toast-container');
    const el = document.createElement('div');

    el.className = `toast toast-${type}`;
    el.innerText = msg;

    container.appendChild(el);
    setTimeout(() => el.remove(), 3000);
}

// ── INIT ──────────────────────────────────────────
render(designations);
</script>

@endsection
