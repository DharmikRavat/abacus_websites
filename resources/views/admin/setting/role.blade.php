@extends('admin.layout.app')

@section('content')



{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">
    <div>
        <h1>Roles</h1>
        <p>Manage access roles across your application</p>
    </div>
    <button class="btn btn-primary" onclick="openCreateModal()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        New Role
    </button>
</div>

{{-- ═══════════ TABLE CARD ═══════════ --}}
<div class="card">
    <div class="search-bar">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--faint);flex-shrink:0">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" id="searchInput" placeholder="Search roles…" oninput="filterRoles(this.value)">
        <span id="role-count" style="font-size:12px;color:var(--faint);white-space:nowrap"></span>
    </div>

    <div style="overflow-x:auto">
        <table class="roles-table">
            <thead>
                <tr>
                    <th style="width:36px">#</th>
                    <th>Role Name</th>
                    <th>Permissions</th>
                    <th>Status</th>
                    <th style="width:120px">Created</th>
                    <th style="width:90px;text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody id="rolesBody"></tbody>
        </table>

        <div id="emptyState" class="empty-state" style="display:none">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <p>No roles found</p>
            <span>Try a different search or create a new role</span>
        </div>
    </div>
</div>

{{-- ═══════════ CREATE / EDIT MODAL ═══════════ --}}
<div class="modal-backdrop" id="formModal" onclick="handleBackdropClick(event)">
    <div class="modal">
        <div class="modal-header">
            <h2 id="modalTitle">New Role</h2>
            <button class="btn-icon" onclick="closeFormModal()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">Role Name *</label>
                <input type="text" id="roleName" class="form-control" placeholder="e.g. Super Admin">
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <label class="toggle-row" for="roleActive">
                    <div>
                        <div class="toggle-row-label">Active</div>
                        <div class="toggle-row-sub">Role can be assigned to users</div>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" id="roleActive" checked>
                        <span class="toggle-slider"></span>
                    </label>
                </label>
            </div>
<div class="form-group">
    <label class="form-label">Permissions</label>

    <div class="permissions-grid">
        @foreach($permissions->groupBy('module') as $module => $modulePermissions)
            <div class="module-box">
                <strong>{{ ucfirst(str_replace('_',' ',$module)) }}</strong>

                <div class="module-actions">
                    @foreach($modulePermissions as $perm)
                        <label class="perm-item">
                            <input type="checkbox"
                                   class="perm-checkbox"
                                   value="{{ $perm->id }}">
                            {{ ucfirst($perm->action) }}
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeFormModal()">Cancel</button>
            <button class="btn btn-primary" id="saveBtn" onclick="saveRole()">
                <span class="spinner"></span>
                <span class="btn-label">Save Role</span>
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
                    <path d="M10 11v6"/><path d="M14 11v6"/>
                    <path d="M9 6V4h6v2"/>
                </svg>
            </div>
            <h3>Delete Role?</h3>
            <p>Are you sure you want to delete <strong id="deleteRoleName"></strong>?<br>This action cannot be undone.</p>
        </div>
        <div class="modal-footer" style="justify-content:center;gap:10px">
            <button class="btn btn-ghost" onclick="closeDeleteModal()">Cancel</button>
            <button class="btn btn-danger" id="confirmDeleteBtn" onclick="confirmDelete()">
                <span class="spinner" style="border-color:rgba(163,45,45,.3);border-top-color:var(--red)"></span>
                <span class="btn-label">Delete Role</span>
            </button>
        </div>
    </div>
</div>

<div id="toast-container"></div>

<script>
// ── State ──────────────────────────────────────────────────
let roles      = @json($roles);
let editingId  = null;
let deletingId = null;
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

const avatarColors = [
    { bg: 'var(--blue-bg)',   color: 'var(--blue)'   },
    { bg: 'var(--green-bg)',  color: 'var(--green)'  },
    { bg: 'var(--amber-bg)',  color: 'var(--amber)'  },
    { bg: 'var(--purple-bg)', color: 'var(--purple)' },
    { bg: 'var(--red-bg)',    color: 'var(--red)'    },
];

function colorFor(name) {
    let h = 0;
    for (let i = 0; i < name.length; i++) h = name.charCodeAt(i) + ((h << 5) - h);
    return avatarColors[Math.abs(h) % avatarColors.length];
}
function initials(name) {
    return name.split(' ').slice(0,2).map(w => w[0]).join('').toUpperCase();
}
function formatDate(str) {
    if (!str) return '—';
    return new Date(str).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

// ── Render ─────────────────────────────────────────────────
function render(list) {
    const tbody = document.getElementById('rolesBody');
    const empty = document.getElementById('emptyState');
    document.getElementById('role-count').textContent = list.length + ' role' + (list.length !== 1 ? 's' : '');

    if (!list.length) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    tbody.innerHTML = list.map((r, i) => {
        const c      = colorFor(r.name);
        const active = r.is_active == 1 || r.is_active === true;
        return `
        <tr data-id="${r.id}">
            <td style="color:var(--faint);font-size:12px">${i + 1}</td>
            <td>
                <div class="role-name-cell">
                    <span class="role-avatar" style="background:${c.bg};color:${c.color}">${initials(r.name)}</span>
                    <span style="font-weight:500">${escHtml(r.name)}</span>
                </div>
            </td>
            <td>
    <div class="perm-badges">
        ${
            (r.permissions || []).slice(0, 3).map(p =>
                `<span class="perm-badge">${p.module}.${p.action}</span>`
            ).join('')
        }
        ${
            (r.permissions || []).length > 3
                ? `<span class="perm-more">+${r.permissions.length - 3}</span>`
                : ''
        }
    </div>
</td>

            <td>
                <div class="toggle-wrap">
                    <label class="toggle" onclick="event.stopPropagation()">
                        <input type="checkbox" ${active ? 'checked' : ''} onchange="toggleStatus(${r.id}, this.checked)">
                        <span class="toggle-slider"></span>
                    </label>
                    <span class="toggle-label ${active ? 'active' : 'inactive'}" id="lbl-${r.id}">
                        ${active ? 'Active' : 'Inactive'}
                    </span>
                </div>
            </td>
            <td style="color:var(--muted);font-size:12px">${formatDate(r.created_at)}</td>
            <td>
                <div class="actions-cell" style="justify-content:flex-end">
                    <button class="btn-icon" title="Edit" onclick="openEditModal(${r.id})">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>
                    <button class="btn-icon" title="Delete" style="color:var(--red);border-color:#f3c9c9"
                            onclick="openDeleteModal(${r.id}, '${escAttr(r.name)}')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14H6L5 6"/>
                            <path d="M10 11v6"/><path d="M14 11v6"/>
                            <path d="M9 6V4h6v2"/>
                        </svg>
                    </button>
                </div>
            </td>
        </tr>`;
    }).join('');
}

// ── Inline toggle ──────────────────────────────────────────
async function toggleStatus(id, checked) {
    const role = roles.find(r => r.id === id);
    if (!role) return;
    try {
        const res = await fetch(`/admin/roles/${id}`, {
            method : 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body   : JSON.stringify({ name: role.name, is_active: checked ? 1 : 0 }),
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message ?? 'Failed to update');

        role.is_active = checked ? 1 : 0;
        const lbl = document.getElementById(`lbl-${id}`);
        if (lbl) {
            lbl.textContent = checked ? 'Active' : 'Inactive';
            lbl.className   = `toggle-label ${checked ? 'active' : 'inactive'}`;
        }
        toast(`Role marked as ${checked ? 'active' : 'inactive'}`, 'success');
    } catch (err) {
        render(roles); // revert
        toast(err.message, 'error');
    }
}

// ── Filter ─────────────────────────────────────────────────
function filterRoles(q) {
    const lower = q.toLowerCase();
    render(roles.filter(r => r.name.toLowerCase().includes(lower)));
}

// ── CREATE modal ───────────────────────────────────────────
function openCreateModal() {
    editingId = null;
    document.getElementById('modalTitle').textContent = 'New Role';
    document.getElementById('roleName').value = '';
    document.getElementById('roleActive').checked = true;
    document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = false);
    document.getElementById('saveBtn').querySelector('.btn-label').textContent = 'Save Role';
    document.getElementById('formModal').classList.add('open');
    setTimeout(() => document.getElementById('roleName').focus(), 120);
}

// ── EDIT modal ─────────────────────────────────────────────
function openEditModal(id) {
    const role = roles.find(r => r.id === id);
    if (!role) return;
    editingId = id;
    document.getElementById('modalTitle').textContent = 'Edit Role';
    document.getElementById('roleName').value = role.name;
    document.getElementById('roleActive').checked = role.is_active == 1 || role.is_active === true;
    document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = false);
    // set selected
if (role.permissions) {
    role.permissions.forEach(p => {
        const el = document.querySelector(`.perm-checkbox[value="${p.id}"]`);
        if (el) el.checked = true;
    });
}
    document.getElementById('saveBtn').querySelector('.btn-label').textContent = 'Update Role';
    document.getElementById('formModal').classList.add('open');
    setTimeout(() => document.getElementById('roleName').focus(), 120);
}

function closeFormModal() { document.getElementById('formModal').classList.remove('open'); }
function handleBackdropClick(e) { if (e.target === document.getElementById('formModal')) closeFormModal(); }

// ── Save ───────────────────────────────────────────────────
async function saveRole() {
    const name     = document.getElementById('roleName').value.trim();
    const isActive = document.getElementById('roleActive').checked ? 1 : 0;
    const permissionIds = Array.from(document.querySelectorAll('.perm-checkbox:checked'))
    .map(cb => parseInt(cb.value));

    if (!name) { shake(document.getElementById('roleName')); document.getElementById('roleName').focus(); return; }

    const btn = document.getElementById('saveBtn');
    btn.classList.add('loading');
    btn.disabled = true;

    const url    = editingId ? `/admin/role/${editingId}` : '/admin/role';
    const method = editingId ? 'PUT' : 'POST';

    try {
        const res = await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body   : JSON.stringify({ name, is_active: isActive,permission_ids: permissionIds }),
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message ?? 'Something went wrong');

        if (editingId) {
            const idx = roles.findIndex(r => r.id === editingId);
            if (idx > -1) roles[idx] = { ...roles[idx], name, is_active: isActive };
            toast('Role updated successfully', 'success');
        } else {
            const newRole = data.role ?? { id: Date.now(), name, is_active: isActive, created_at: new Date().toISOString() };
            roles.unshift(newRole);
            toast('Role created successfully', 'success');
        }

        closeFormModal();
        render(roles);
    } catch (err) {
        toast(err.message, 'error');
    } finally {
        btn.classList.remove('loading');
        btn.disabled = false;
    }
}

// ── DELETE modal ───────────────────────────────────────────
function openDeleteModal(id, name) {
    deletingId = id;
    document.getElementById('deleteRoleName').textContent = name;
    document.getElementById('deleteModal').classList.add('open');
}
function closeDeleteModal() { document.getElementById('deleteModal').classList.remove('open'); deletingId = null; }
function handleDeleteBackdropClick(e) { if (e.target === document.getElementById('deleteModal')) closeDeleteModal(); }

async function confirmDelete() {
    if (!deletingId) return;
    const btn = document.getElementById('confirmDeleteBtn');
    btn.classList.add('loading');
    btn.disabled = true;
    try {
        const res = await fetch(`/admin/role/${deletingId}`, {
            method : 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message ?? 'Failed to delete');

        roles = roles.filter(r => r.id !== deletingId);
        render(roles);
        closeDeleteModal();
        toast('Role deleted', 'success');
    } catch (err) {
        toast(err.message, 'error');
    } finally {
        btn.classList.remove('loading');
        btn.disabled = false;
    }
}

// ── Toast ──────────────────────────────────────────────────
function toast(msg, type = 'success') {
    const c  = document.getElementById('toast-container');
    const el = document.createElement('div');
    el.className = `toast toast-${type}`;
    el.innerHTML = `
        <div class="toast-icon">
            ${type === 'success'
                ? '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>'
                : '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>'
            }
        </div>
        <span>${escHtml(msg)}</span>`;
    c.appendChild(el);
    requestAnimationFrame(() => el.classList.add('show'));
    setTimeout(() => { el.classList.remove('show'); setTimeout(() => el.remove(), 250); }, 3200);
}

// ── Helpers ────────────────────────────────────────────────
function escHtml(str) {
    return String(str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
function escAttr(str) { return String(str ?? '').replace(/'/g, "\\'"); }
function shake(el) { el.style.animation = 'none'; el.offsetHeight; el.style.animation = 'shake .35s ease'; }

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeFormModal(); closeDeleteModal(); }
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') { e.preventDefault(); document.getElementById('searchInput').focus(); }
});

// ── Init ───────────────────────────────────────────────────
render(roles);
</script>

@endsection
