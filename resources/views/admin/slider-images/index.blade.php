@extends('admin.layout.app')

@section('content')

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">
    <div>
        <h1>Sliders</h1>
        <p>Manage banner slider images</p>
    </div>

    <button class="btn btn-primary" onclick="openCreateModal()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>

        New Slider
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
               placeholder="Search sliders..."
               oninput="filterSliders(this.value)">

        <span id="slider-count"
              style="font-size:12px;color:var(--faint);white-space:nowrap">
        </span>

    </div>

    <div style="overflow-x:auto">

        <table class="roles-table">

            <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th style="width:120px;text-align:right">Actions</th>
                </tr>
            </thead>

            <tbody id="sliderBody"></tbody>

        </table>

        <div id="emptyState"
             class="empty-state"
             style="display:none">

            <p>No sliders found</p>

        </div>
<div id="pagination" class="pagination"></div>
    </div>
</div>

{{-- ═══════════ CREATE / EDIT MODAL ═══════════ --}}

<div class="modal-backdrop"
     id="formModal"
     onclick="handleBackdropClick(event)">

    <div class="modal">

        <div class="modal-header">

            <h2 id="modalTitle">New Slider</h2>

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

                <label class="form-label">Slider Image *</label>

                <input type="file"
                       id="sliderImage"
                       class="form-control"
                       accept="image/*">

            </div>

            <div class="form-group">

                <label class="form-label">Status</label>

                <label class="toggle-row">

                    <div>
                        <div class="toggle-row-label">Active</div>

                        <div class="toggle-row-sub">
                            Slider visible to users
                        </div>
                    </div>

                    <label class="toggle">

                        <input type="checkbox"
                               id="sliderStatus"
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
                    onclick="saveSlider()">

                <span class="spinner"></span>

                <span class="btn-label">
                    Save Slider
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

            <h3>Delete Slider?</h3>

            <p>
                Are you sure you want to delete this slider?
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

let sliders = @json($sliders);

let editingId  = null;
let deletingId = null;

let currentPage = 1;
const perPage = 5;

const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
function renderPagination(totalPages) {

    let html = '';

    html += `
        <button
            ${currentPage == 1 ? 'disabled' : ''}
            onclick="changePage(${currentPage - 1})">
            Previous
        </button>
    `;

    for (let i = 1; i <= totalPages; i++) {

        html += `
            <button
                class="${i == currentPage ? 'active' : ''}"
                onclick="changePage(${i})">
                ${i}
            </button>
        `;
    }

    html += `
        <button
            ${currentPage == totalPages ? 'disabled' : ''}
            onclick="changePage(${currentPage + 1})">
            Next
        </button>
    `;

    document.getElementById('pagination').innerHTML = html;
}

function changePage(page) {

    currentPage = page;

    filterSliders(document.getElementById('searchInput').value);
}

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

    const tbody = document.getElementById('sliderBody');

    const empty = document.getElementById('emptyState');

    document.getElementById('slider-count').textContent =
        list.length + ' Slider' + (list.length !== 1 ? 's' : '');

if (!list.length) {

    tbody.innerHTML = '';

    empty.style.display = 'block';

    document.getElementById('pagination').innerHTML = '';

    return;
}

empty.style.display = 'none';

const totalPages = Math.ceil(list.length / perPage);

if (currentPage > totalPages)
    currentPage = totalPages;

const start = (currentPage - 1) * perPage;

const pageData = list.slice(start, start + perPage);

tbody.innerHTML = pageData.map((slider, i) => {

        const active = slider.is_active  == 1;

        return `
        <tr>

        <td>${start + i + 1}</td>

            <td>

                <img src="/uploads/sliders/${slider.image}"
                     width="120"
                     height="60"
                     style="object-fit:cover;border-radius:10px">

            </td>

            <td>

                <div class="toggle-wrap">

                    <label class="toggle">

                        <input type="checkbox"
                               ${active ? 'checked' : ''}
                               onchange="toggleStatus(${slider.id}, this.checked)">

                        <span class="toggle-slider"></span>

                    </label>

                    <span class="toggle-label ${active ? 'active' : 'inactive'}">

                        ${active ? 'Active' : 'Inactive'}

                    </span>

                </div>

            </td>

            <td>
                ${formatDate(slider.created_at)}
            </td>

            <td>

                <div class="actions-cell"
                     style="justify-content:flex-end">

                    <button class="btn-icon"
                            onclick="openEditModal(${slider.id})">

                        ✏️

                    </button>

                    <button class="btn-icon"
                            style="color:red"
                            onclick="openDeleteModal(${slider.id})">

                        🗑️

                    </button>

                </div>

            </td>

        </tr>
        `;

    }).join('');
    renderPagination(totalPages);
}

// ─────────────────────────────────────
// Search
// ─────────────────────────────────────
function filterSliders(q) {

    currentPage = 1;

    q = q.toLowerCase();

    render(
        sliders.filter(s =>
            (s.image ?? '').toLowerCase().includes(q)
        )
    );
}

// ─────────────────────────────────────
// Create
// ─────────────────────────────────────
function openCreateModal() {

    editingId = null;

    document.getElementById('modalTitle').textContent =
        'New Slider';

    document.getElementById('sliderImage').value = '';

    document.getElementById('sliderStatus').checked = true;

    document.getElementById('formModal').classList.add('open');
}

// ─────────────────────────────────────
// Edit
// ─────────────────────────────────────

function openEditModal(id) {

    const slider = sliders.find(s => s.id === id);

    if (!slider) return;

    editingId = id;

    document.getElementById('modalTitle').textContent =
        'Edit Slider';

    document.getElementById('sliderStatus').checked =
        slider.is_active  == 1;

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

async function saveSlider() {

    const image  = document.getElementById('sliderImage').files[0];
    const is_active  = document.getElementById('sliderStatus').checked ? 1 : 0;

    if (!editingId && !image) {
        alert('Please select image');
        return;
    }

    const formData = new FormData();

    if (image) {
        formData.append('image', image);
    }

    formData.append('is_active ', is_active );

    if (editingId) {
        formData.append('_method', 'PUT');
    }

    const url =
        editingId
            ? `/admin/slider-images/${editingId}`
            : `/admin/slider-images`;

    try {

        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message ?? 'Something went wrong');
        }

        if (editingId) {

            const index = sliders.findIndex(s => s.id === editingId);

            if (index > -1) {
                sliders[index] = data.slider;
            }

        } else {

            sliders.unshift(data.slider);
        }

        render(sliders);

        closeFormModal();

        alert(data.message);

    } catch (err) {

        alert(err.message);
    }
}

// ─────────────────────────────────────
// Toggle Status
// ─────────────────────────────────────

async function toggleStatus(id, checked) {

    const slider = sliders.find(s => s.id === id);

    if (!slider) return;

    const formData = new FormData();

    formData.append('_method', 'PUT');
    formData.append('is_active ', checked ? 1 : 0);

    try {

        const res = await fetch(`/admin/slider-images/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message ?? 'Failed');
        }

        slider.is_active  = checked ? 1 : 0;

        render(sliders);

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

        const res = await fetch(`/admin/slider-images/${deletingId}`, {
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

        sliders = sliders.filter(s => s.id !== deletingId);

        render(sliders);

        closeDeleteModal();

        alert(data.message);

    } catch (err) {

        alert(err.message);
    }
}

document.addEventListener('keydown', e => {

    if (e.key === 'Escape') {

        closeFormModal();

        closeDeleteModal();
    }
});

render(sliders);

</script>

@endsection