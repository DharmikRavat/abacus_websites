@extends('admin.layout.app')

@section('content')

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">

    <div>
        <h1>Gallery</h1>
        <p>Manage gallery images and videos</p>
    </div>

    <button class="btn btn-primary" onclick="openCreateModal()">

        <svg width="14" height="14" viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2.5">

            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>

        </svg>

        New Gallery

    </button>

</div>

{{-- ═══════════ TABLE CARD ═══════════ --}}
<div class="card">

    <div class="search-bar">

        <input type="text"
               id="searchInput"
               placeholder="Search gallery..."
               oninput="filterGallery(this.value)">

        <span id="gallery-count"
              style="font-size:12px;color:var(--faint)">
        </span>

    </div>

    <div style="overflow-x:auto">

        <table class="roles-table">

            <thead>

                <tr>
                    <th>#</th>
                    <th>Preview</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Dashboard</th>
                    <th>Created</th>
                    <th style="text-align:right">Actions</th>
                </tr>

            </thead>

            <tbody id="galleryBody"></tbody>

        </table>

        <div id="emptyState"
             class="empty-state"
             style="display:none">

            <p>No gallery items found</p>

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

            <h2 id="modalTitle">New Gallery</h2>

            <button class="btn-icon"
                    onclick="closeFormModal()">
                ✕
            </button>

        </div>

        <div class="modal-body">

            <div class="form-group">

                <label class="form-label">Title</label>

                <input type="text"
                       id="galleryTitle"
                       class="form-control"
                       placeholder="Enter title">

            </div>

            <div class="form-group">

                <label class="form-label">Media Type</label>

                <select id="mediaType"
                        class="form-control"
                        onchange="toggleMediaFields()">

                    <option value="1">Image</option>
                    <option value="2">YouTube Video</option>
                    <option value="3">Local Video</option>

                </select>

            </div>

            <div class="form-group"
                 id="imageField">

                <label class="form-label">Image</label>

                <input type="file"
                       id="galleryMedia"
                       class="form-control"
                       accept="image/*">

            </div>
            <div class="form-group"
     id="videoField"
     style="display:none">

    <label class="form-label">Video File</label>

    <input type="file"
           id="videoFile"
           class="form-control"
           accept="video/*">

</div>

            <div class="form-group"
                 id="youtubeField"
                 style="display:none">

                <label class="form-label">YouTube Link</label>

                <input type="text"
                       id="youtubeLink"
                       class="form-control"
                       placeholder="Enter YouTube link">

            </div>

            <div class="form-group">

                <label class="toggle-row">

                    <div>
                        <div class="toggle-row-label">Active</div>
                    </div>

                    <label class="toggle">

                        <input type="checkbox"
                               id="isActive"
                               checked>

                        <span class="toggle-slider"></span>

                    </label>

                </label>

            </div>

            <div class="form-group">

                <label class="toggle-row">

                    <div>
                        <div class="toggle-row-label">
                            Show On Dashboard
                        </div>
                    </div>

                    <label class="toggle">

                        <input type="checkbox"
                               id="isDashboard">

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
                    onclick="saveGallery()">

                Save Gallery

            </button>

        </div>

    </div>

</div>

{{-- ═══════════ DELETE MODAL ═══════════ --}}
<div class="modal-backdrop"
     id="deleteModal">

    <div class="modal"
         style="max-width:350px">

        <div class="confirm-modal-body">

            <h3>Delete Gallery?</h3>

            <p>
                Are you sure you want to delete this item?
            </p>

        </div>

        <div class="modal-footer"
             style="justify-content:center">

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

let galleries = @json($galleries);

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

    filterGallery(
        document.getElementById('searchInput').value,
        false
    );
}
// ─────────────────────────────────────
// Render
// ─────────────────────────────────────
function render(list) {

    const tbody = document.getElementById('galleryBody');

    const empty = document.getElementById('emptyState');

    document.getElementById('gallery-count').textContent =
        list.length + ' Items';
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

tbody.innerHTML = pageData.map((gallery, i) => {
        return `
        <tr>

          <td>${start + i + 1}</td>

            <td>

                ${
    gallery.media_type == 1
    ? `<img src="/uploads/gallery/${gallery.media}"
            width="80"
            height="60"
            style="object-fit:cover;border-radius:8px">`

    : gallery.media_type == 2
    ? `<a href="${gallery.youtube_link}" target="_blank">
            YouTube Video
       </a>`

    : `<video width="80" height="60" controls>
            <source src="/uploads/gallery/videos/${gallery.video_file}" type="video/mp4">
       </video>`
}

            </td>

            <td>${gallery.title ?? '-'}</td>

            <td>
                ${gallery.media_type == 1 ? 'Image' : 'Video'}
            </td>

            <td>
                ${gallery.is_active == 1 ? 'Active' : 'Inactive'}
            </td>

            <td>
                ${gallery.is_dashboard == 1 ? 'Yes' : 'No'}
            </td>

            <td>
                ${new Date(gallery.created_at).toLocaleDateString()}
            </td>

            <td>

                <div class="actions-cell"
                     style="justify-content:flex-end">

                    <button class="btn-icon"
                            onclick="openEditModal(${gallery.id})">

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
                            style="color:red"
                            onclick="openDeleteModal(${gallery.id})">

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
    renderPagination(totalPages);
}

// ─────────────────────────────────────
// Search
// ─────────────────────────────────────
function filterGallery(q, reset = true) {

    if (reset) {
        currentPage = 1;
    }

    q = q.toLowerCase();

    render(
        galleries.filter(g =>
            (g.title ?? '').toLowerCase().includes(q)
        )
    );
}
// ─────────────────────────────────────
// Toggle Media Fields
// ─────────────────────────────────────
function toggleMediaFields() {

    const type = document.getElementById('mediaType').value;

    document.getElementById('imageField').style.display =
        type == 1 ? 'block' : 'none';

    document.getElementById('youtubeField').style.display =
        type == 2 ? 'block' : 'none';

    document.getElementById('videoField').style.display =
        type == 3 ? 'block' : 'none';
}

// ─────────────────────────────────────
// Create Modal
// ─────────────────────────────────────
function openCreateModal() {

    editingId = null;

    document.getElementById('modalTitle').textContent =
        'New Gallery';

    document.getElementById('galleryTitle').value = '';

    document.getElementById('mediaType').value = 1;

    document.getElementById('galleryMedia').value = '';

    document.getElementById('youtubeLink').value = '';

    document.getElementById('isActive').checked = true;

    document.getElementById('isDashboard').checked = false;

    toggleMediaFields();

    document.getElementById('formModal').classList.add('open');
}

// ─────────────────────────────────────
// Edit Modal
// ─────────────────────────────────────
function openEditModal(id) {

    const gallery = galleries.find(g => g.id === id);

    if (!gallery) return;

    editingId = id;

    document.getElementById('modalTitle').textContent =
        'Edit Gallery';

    document.getElementById('galleryTitle').value =
        gallery.title ?? '';

    document.getElementById('mediaType').value =
        gallery.media_type;

    document.getElementById('youtubeLink').value =
        gallery.youtube_link ?? '';

    document.getElementById('isActive').checked =
        gallery.is_active == 1;

    document.getElementById('isDashboard').checked =
        gallery.is_dashboard == 1;

    toggleMediaFields();

    document.getElementById('formModal').classList.add('open');
}

function closeFormModal() {

    document.getElementById('formModal').classList.remove('open');
}

// ─────────────────────────────────────
// Save
// ─────────────────────────────────────
async function saveGallery() {

    const formData = new FormData();

    formData.append('title',
        document.getElementById('galleryTitle').value);

    formData.append('media_type',
        document.getElementById('mediaType').value);

    formData.append('youtube_link',
        document.getElementById('youtubeLink').value);

    formData.append('is_active',
        document.getElementById('isActive').checked ? 1 : 0);

    formData.append('is_dashboard',
        document.getElementById('isDashboard').checked ? 1 : 0);

    const media =
        document.getElementById('galleryMedia').files[0];
    const video =
    document.getElementById('videoFile').files[0];

    if (media) {
        formData.append('media', media);
    }
    if (video) {
    formData.append('video_file', video);
}

    if (editingId) {
        formData.append('_method', 'PUT');
    }

    const url =
        editingId
            ? `/admin/gallery/${editingId}`
            : `/admin/gallery`;

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
            throw new Error(data.message ?? 'Failed');
        }

        if (editingId) {

            const index =
                galleries.findIndex(g => g.id === editingId);

            galleries[index] = data.gallery;

        } else {

            galleries.unshift(data.gallery);
        }

        render(galleries);

        closeFormModal();

        alert(data.message);

    } catch (err) {

        alert(err.message);
    }
}

// ─────────────────────────────────────
// Delete
// ─────────────────────────────────────
function openDeleteModal(id) {

    deletingId = id;

    document.getElementById('deleteModal')
        .classList.add('open');
}

function closeDeleteModal() {

    deletingId = null;

    document.getElementById('deleteModal')
        .classList.remove('open');
}

async function confirmDelete() {

    if (!deletingId) return;

    try {

        const res = await fetch(`/admin/gallery/${deletingId}`, {

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

        galleries =
            galleries.filter(g => g.id !== deletingId);

        render(galleries);

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

render(galleries);

</script>

@endsection