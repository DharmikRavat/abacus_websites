@extends('admin.layout.app')

@section('content')

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">

    <div>
        <h1>Locate Centers</h1>
        <p>Manage all training centers and assigned teachers</p>
    </div>

    <button class="btn btn-primary"
            onclick="openCreateModal()">

        <svg width="14"
             height="14"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2.5">

            <line x1="12" y1="5" x2="12" y2="19"/>

            <line x1="5" y1="12" x2="19" y2="12"/>

        </svg>

        New Center

    </button>

</div>

{{-- ═══════════ TABLE CARD ═══════════ --}}
<div class="card">

    <div class="search-bar">

        <svg width="15"
             height="15"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2"
             style="color:var(--faint);flex-shrink:0">

            <circle cx="11" cy="11" r="8"/>

            <line x1="21" y1="21" x2="16.65" y2="16.65"/>

        </svg>

        <input type="text"
               id="searchInput"
               placeholder="Search Centers..."
               oninput="filterCenters(this.value)">

        <span id="center-count"
              style="font-size:12px;color:var(--faint);white-space:nowrap">
        </span>

    </div>

    <div style="overflow-x:auto">

        <table class="roles-table">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Center Name</th>

                    <th>Country</th>

                    <th>State</th>

                    <th>District</th>

                    <th>Teacher</th>

                    <th>Contact</th>

                    <th>Created</th>

                    <th style="text-align:right">Actions</th>

                </tr>

            </thead>

            <tbody id="centerBody"></tbody>

        </table>

        <div id="emptyState"
             class="empty-state"
             style="display:none">

            <svg width="40"
                 height="40"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="1.5">

                <path d="M12 21s-6-4.35-6-10a6 6 0 1 1 12 0c0 5.65-6 10-6 10z"/>

                <circle cx="12" cy="11" r="2.5"/>

            </svg>

            <p>No Centers Found</p>

            <span>Try different search or add a center</span>

        </div>

    </div>

</div>

{{-- ═══════════ CREATE / EDIT MODAL ═══════════ --}}
<div class="modal-backdrop"
     id="formModal"
     onclick="handleBackdropClick(event)">

    <div class="modal">

        <div class="modal-header">

            <h2 id="modalTitle">New Center</h2>

            <button class="btn-icon"
                    onclick="closeFormModal()">

                <svg width="15"
                     height="15"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2.5">

                    <line x1="18" y1="6" x2="6" y2="18"/>

                    <line x1="6" y1="6" x2="18" y2="18"/>

                </svg>

            </button>

        </div>

        <div class="modal-body">

            <div class="form-group">

                <label class="form-label">Center Name *</label>

                <input type="text"
                       id="centerName"
                       class="form-control"
                       placeholder="Enter center name">

            </div>

            <div class="form-group">

                <label class="form-label">Country</label>

                <input type="text"
                       id="countryName"
                       class="form-control">

            </div>

            <div class="form-group">

                <label class="form-label">State</label>

                <input type="text"
                       id="stateName"
                       class="form-control">

            </div>

            <div class="form-group">

                <label class="form-label">District</label>

                <input type="text"
                       id="districtName"
                       class="form-control">

            </div>

            <div class="form-group">

                <label class="form-label">Center Contact</label>

                <input type="text"
                       id="centerContact"
                       class="form-control">

            </div>

            <div class="form-group">

                <label class="form-label">Center Address</label>

                <textarea id="centerAddress"
                          class="form-control"
                          rows="3"></textarea>

            </div>

            <div class="form-group">

                <label class="form-label">Assigned Teacher Name</label>

                <input type="text"
                       id="teacherName"
                       class="form-control">

            </div>

            <div class="form-group">

                <label class="form-label">Teacher ID</label>

                <input type="number"
                       id="teacherId"
                       class="form-control">

            </div>

            <div class="form-group">

                <label class="form-label">Teacher About</label>

                <textarea id="teacherAbout"
                          class="form-control"
                          rows="3"></textarea>

            </div>

        </div>

        <div class="modal-footer">

            <button class="btn btn-ghost"
                    onclick="closeFormModal()">

                Cancel

            </button>

            <button class="btn btn-primary"
                    id="saveBtn"
                    onclick="saveCenter()">

                <span class="spinner"></span>

                <span class="btn-label">
                    Save Center
                </span>

            </button>

        </div>

    </div>

</div>

{{-- ═══════════ DELETE MODAL ═══════════ --}}
<div class="modal-backdrop"
     id="deleteModal"
     onclick="handleDeleteBackdropClick(event)">

    <div class="modal"
         style="max-width:370px">

        <div class="confirm-modal-body">

            <div class="confirm-icon">

                <svg width="20"
                     height="20"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2.5">

                    <polyline points="3 6 5 6 21 6"/>

                    <path d="M19 6l-1 14H6L5 6"/>

                    <path d="M10 11v6"/>

                    <path d="M14 11v6"/>

                    <path d="M9 6V4h6v2"/>

                </svg>

            </div>

            <h3>Delete Center?</h3>

            <p>
                Are you sure you want to delete this center?
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
                    onclick="confirmDelete()">

                Delete Center

            </button>

        </div>

    </div>

</div>

<script>

let centers = @json($centers);

let editingId  = null;
let deletingId = null;

const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

function formatDate(str) {

    if (!str) return '—';

    return new Date(str).toLocaleDateString('en-US', {

        month:'short',
        day:'numeric',
        year:'numeric'

    });
}

function render(list) {

    const tbody = document.getElementById('centerBody');
    const empty = document.getElementById('emptyState');

    document.getElementById('center-count').textContent =
        list.length + ' Center' + (list.length !== 1 ? 's' : '');

    if (!list.length) {

        tbody.innerHTML = '';

        empty.style.display = 'block';

        return;
    }

    empty.style.display = 'none';

    tbody.innerHTML = list.map((center, i) => {

        return `
            <tr>

                <td>${i + 1}</td>

                <td>
                    <strong>${escHtml(center.center_name)}</strong>
                </td>

                <td>${escHtml(center.country_name ?? '—')}</td>

                <td>${escHtml(center.state_name ?? '—')}</td>

                <td>${escHtml(center.district_name ?? '—')}</td>

                <td>${escHtml(center.assigned_teacher_name ?? '—')}</td>

                <td>${escHtml(center.center_contact ?? '—')}</td>

                <td>${formatDate(center.created_at)}</td>

                <td>

                    <div class="actions-cell"
                         style="justify-content:flex-end">

                        <button class="btn-icon"
                                onclick="openEditModal(${center.id})">

                            ✏️

                        </button>

                        <button class="btn-icon"
                                style="color:red"
                                onclick="openDeleteModal(${center.id})">

                            🗑️

                        </button>

                    </div>

                </td>

            </tr>
        `;

    }).join('');
}

function filterCenters(q) {

    const lower = q.toLowerCase();

    render(
        centers.filter(c =>
            c.center_name.toLowerCase().includes(lower) ||
            (c.state_name ?? '').toLowerCase().includes(lower) ||
            (c.district_name ?? '').toLowerCase().includes(lower)
        )
    );
}

function openCreateModal() {

    editingId = null;

    document.getElementById('modalTitle').textContent = 'New Center';

    clearForm();

    document.getElementById('formModal').classList.add('open');
}

function openEditModal(id) {

    const center = centers.find(c => c.id === id);

    if (!center) return;

    editingId = id;

    document.getElementById('modalTitle').textContent = 'Edit Center';

    document.getElementById('centerName').value = center.center_name ?? '';
    document.getElementById('countryName').value = center.country_name ?? '';
    document.getElementById('stateName').value = center.state_name ?? '';
    document.getElementById('districtName').value = center.district_name ?? '';
    document.getElementById('centerContact').value = center.center_contact ?? '';
    document.getElementById('centerAddress').value = center.center_address ?? '';
    document.getElementById('teacherName').value = center.assigned_teacher_name ?? '';
    document.getElementById('teacherId').value = center.assigned_teacher_id ?? '';
    document.getElementById('teacherAbout').value = center.assigned_teacher_about ?? '';

    document.getElementById('formModal').classList.add('open');
}

function clearForm() {

    document.getElementById('centerName').value = '';
    document.getElementById('countryName').value = '';
    document.getElementById('stateName').value = '';
    document.getElementById('districtName').value = '';
    document.getElementById('centerContact').value = '';
    document.getElementById('centerAddress').value = '';
    document.getElementById('teacherName').value = '';
    document.getElementById('teacherId').value = '';
    document.getElementById('teacherAbout').value = '';
}

function closeFormModal() {

    document.getElementById('formModal').classList.remove('open');
}

function handleBackdropClick(e) {

    if (e.target === document.getElementById('formModal')) {
        closeFormModal();
    }
}

async function saveCenter() {

    const formData = {

        center_name: document.getElementById('centerName').value,

        country_name: document.getElementById('countryName').value,

        state_name: document.getElementById('stateName').value,

        district_name: document.getElementById('districtName').value,

        center_contact: document.getElementById('centerContact').value,

        center_address: document.getElementById('centerAddress').value,

        assigned_teacher_name: document.getElementById('teacherName').value,

        assigned_teacher_id: document.getElementById('teacherId').value,

        assigned_teacher_about: document.getElementById('teacherAbout').value,

    };

    try {

        const res = await fetch(
            editingId
            ? `/admin/locate-centers/${editingId}`
            : `/admin/locate-centers`,
            {

                method: editingId ? 'PUT' : 'POST',

                headers: {

                    'Content-Type': 'application/json',

                    'X-CSRF-TOKEN': CSRF,

                    'Accept': 'application/json'

                },

                body: JSON.stringify(formData)

            }
        );

        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message ?? 'Something went wrong');
        }

        if (editingId) {

            const index = centers.findIndex(c => c.id === editingId);

            centers[index] = data.center;

        } else {

            centers.unshift(data.center);
        }

        render(centers);

        closeFormModal();

        alert(data.message);

    } catch (err) {

        alert(err.message);
    }
}

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

        const res = await fetch(`/admin/locate-centers/${deletingId}`, {

            method: 'DELETE',

            headers: {

                'X-CSRF-TOKEN': CSRF,

                'Accept': 'application/json'

            }

        });

        const data = await res.json();

        centers = centers.filter(c => c.id !== deletingId);

        render(centers);

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

render(centers);

</script>

@endsection