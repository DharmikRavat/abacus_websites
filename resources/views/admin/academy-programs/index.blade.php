@extends('admin.layout.app')

@section('style')
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .pagination button {
            border: 1px solid #ddd;
            background: #fff;
            padding: 8px 14px;
            border-radius: 8px;
            cursor: pointer;
        }

        .pagination button:hover {
            background: #f3f4f6;
        }

        .pagination button.active {
            background: #2563eb;
            color: #fff;
            border-color: #2563eb;
        }

        .pagination button:disabled {
            opacity: .5;
            cursor: not-allowed;
        }
    </style>

@endsection

@section('content')

    {{-- ═══════════ PAGE HEADER ═══════════ --}}
    <div class="roles-header">
        <div>
            <h1>Academy Programs</h1>
            <p>Manage academy programs and courses</p>
        </div>

        <button class="btn btn-primary" onclick="openCreateModal()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            New Program
        </button>
    </div>

    {{-- ═══════════ TABLE CARD ═══════════ --}}
    <div class="card">

        <div class="search-bar">

            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                style="color:var(--faint);flex-shrink:0">

                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />

            </svg>

            <input type="text" id="searchInput" placeholder="Search programs…" oninput="filterPrograms(this.value)">

            <span id="program-count" style="font-size:12px;color:var(--faint);white-space:nowrap">
            </span>

        </div>

        <div style="overflow-x:auto">

            <table class="roles-table">

                <thead>
                    <tr>
                        <th style="width:40px">#</th>
                        <th>Image</th>
                        <th>Program</th>
                        <th>Description</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>

                <tbody id="programBody"></tbody>


            </table>

            <div id="emptyState" class="empty-state" style="display:none">

                <p>No Programs Found</p>

            </div>
            <div id="pagination" class="pagination"></div>

        </div>

    </div>

    {{-- ═══════════ FORM MODAL ═══════════ --}}
    <div class="modal-backdrop" id="formModal" onclick="handleBackdropClick(event)">

        <div class="modal">

            <div class="modal-header">

                <h2 id="modalTitle">New Program</h2>

                <button class="btn-icon" onclick="closeFormModal()">
                    ✕
                </button>

            </div>

            <div class="modal-body">

                <div class="form-group">

                    <label class="form-label">Program Name *</label>

                    <input type="text" id="programName" class="form-control" placeholder="Enter program name">

                </div>

                <div class="form-group">

                    <label class="form-label">Description</label>

                    <textarea id="programDescription" class="form-control" rows="4"
                        placeholder="Enter description"></textarea>

                </div>


                <div class="form-group">

                    <label class="form-label">Duration</label>

                    <input type="text" id="programDuration" class="form-control" placeholder="Example: 6 Months">

                </div>
                <div class="form-group">

    <label class="form-label">Program Link</label>

    <input
        type="url"
        id="programLink"
        class="form-control"
        placeholder="https://example.com">

</div>


                {{-- IMAGE --}}
                <div class="form-group">

                    <label class="form-label">Program Image</label>

                    <input type="file" id="programImage" class="form-control" accept="image/*">

                </div>

                {{-- IMAGE PREVIEW --}}
                <div class="form-group" id="imagePreviewWrapper" style="display:none;">

                    <img id="imagePreview" src="" alt="Preview" style="
                            width:100px;
                            height:100px;
                            object-fit:cover;
                            border-radius:12px;
                            border:1px solid #e5e7eb;
                         ">

                </div>

                {{-- Multiple image --}}
                <div class="form-group">

    <label class="form-label">Program Gallery Images</label>

    <input
        type="file"
        id="programImages"
        class="form-control"
        accept="image/*"
        multiple>

</div>

<div class="form-group" id="galleryPreviewWrapper" style="display:none;">

    <div id="galleryPreview"
        style="display:flex;flex-wrap:wrap;gap:10px;">
    </div>

</div>


                <div class="form-group">

                    <label class="toggle-row">

                        <div>

                            <div class="toggle-row-label">
                                Active
                            </div>

                            <div class="toggle-row-sub">
                                Program visible to users
                            </div>

                        </div>

                        <label class="toggle">

                            <input type="checkbox" id="programActive" checked>

                            <span class="toggle-slider"></span>

                        </label>

                    </label>

                </div>

            </div>

            <div class="modal-footer">

                <button class="btn btn-ghost" onclick="closeFormModal()">
                    Cancel
                </button>

                <button class="btn btn-primary" id="saveBtn" onclick="saveProgram()">

                    <span class="btn-label">
                        Save Program
                    </span>

                </button>

            </div>

        </div>

    </div>

    {{-- ═══════════ DELETE MODAL ═══════════ --}}
    <div class="modal-backdrop" id="deleteModal" onclick="handleDeleteBackdropClick(event)">

        <div class="modal" style="max-width:370px">

            <div class="confirm-modal-body">

                <h3>Delete Program?</h3>

                <p>
                    This action cannot be undone.
                </p>

            </div>

            <div class="modal-footer" style="justify-content:center">

                <button class="btn btn-ghost" onclick="closeDeleteModal()">
                    Cancel
                </button>

                <button class="btn btn-danger" onclick="confirmDelete()">
                    Delete
                </button>

            </div>

        </div>

    </div>

    <script>

        let programs = @json($academyPrograms);

        let editingId = null;
        let deletingId = null;

        let currentPage = 1;
        const perPage = 5;


        const CSRF =
            document.querySelector('meta[name="csrf-token"]')?.content ?? '';

        function formatDate(str) {

            return new Date(str).toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
        }

        function escHtml(str) {

            return String(str ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        function render(list) {

            const tbody = document.getElementById('programBody');
            const empty = document.getElementById('emptyState');

            document.getElementById('program-count').textContent =
                list.length + ' Program' + (list.length !== 1 ? 's' : '');

            if (!list.length) {

                tbody.innerHTML = '';
                empty.style.display = 'block';

                return;
            }

            empty.style.display = 'none';

            // Pagination
            const totalPages = Math.ceil(list.length / perPage);

            if (currentPage > totalPages)
                currentPage = totalPages;

            const start = (currentPage - 1) * perPage;
            const pageData = list.slice(start, start + perPage);

            tbody.innerHTML = pageData.map((program, i) => {

                const active = program.is_active == 1;

                return `
            <tr>

       <td>${start + i + 1}</td>
                      <td>
        <img src="${(function () {
                        // 1. Fallback if no profile exists
                        if (!program.image) {
                            return 'https://ui-avatars.com/api/?name=' + encodeURIComponent(program.name);
                        }

                        // 2. Production Check: If it's already a correct absolute URL, use it
                        if (program.image.startsWith('http://') || program.image.startsWith('https://')) {
                            // If it's a broken development leftover or missing /storage/
                            if (!program.image.includes('/storage/')) {
                                // Extract just the structural path after 'teachers/'
                                const parts = program.image.split('students/');
                                const filename = parts[parts.length - 1];
                                return `${window.location.origin}/upload/academy-programs/${filename}`;
                            }
                            return program.image;
                        }

                        // 3. Fallback for pure relative database paths (e.g., 'teachers/abc.jpg')
                        const cleanPath = program.image.replace(/^\/+/, '').replace(/^storage\//, '');
                        return `${window.location.origin}/${cleanPath}`;
                    })()
                    }"
        width="40"
        height="40"
        style="border-radius:50%; object-fit:cover;"
        onerror="this.src='https://ui-avatars.com/api/?name=' + encodeURIComponent('${escHtml(program.name)}')">
    </td>
                <td>
                    <strong>${escHtml(program.name)}</strong>
                </td>

                <td style="max-width:300px">
                    ${escHtml(program.description ?? '').substring(0, 80)}
                </td>

                <td>
                    ${escHtml(program.duration ?? '—')}
                </td>

                <td>

                    <div class="toggle-wrap">

                        <label class="toggle">

                            <input type="checkbox"
                                   ${active ? 'checked' : ''}
                                   onchange="toggleStatus(${program.id}, this.checked)">

                            <span class="toggle-slider"></span>

                        </label>

                        <span class="toggle-label ${active ? 'active' : 'inactive'}">
                            ${active ? 'Active' : 'Inactive'}
                        </span>

                    </div>

                </td>

                <td>
                    ${formatDate(program.created_at)}
                </td>

              <td>
        <div class="actions-cell" style="justify-content:flex-end">

            <button class="btn-icon"
                    title="Edit"
                    onclick="openEditModal(${program.id})">

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
                    onclick="openDeleteModal(${program.id})">

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

            const search = document.getElementById('searchInput').value.toLowerCase();

            render(
                programs.filter(p =>
                    p.name.toLowerCase().includes(search)
                )
            );
        }

        function filterPrograms(q) {

            currentPage = 1;

            q = q.toLowerCase();

            render(
                programs.filter(p =>
                    p.name.toLowerCase().includes(q)
                )
            );
        }

        function openCreateModal() {

            editingId = null;

            document.getElementById('modalTitle').textContent =
                'New Program';

            document.getElementById('programName').value = '';
            document.getElementById('programDescription').value = '';
            document.getElementById('programDuration').value = '';
            document.getElementById('programActive').checked = true;
            document.getElementById('programLink').value = '';
            document.getElementById('programImages').value = '';
            document.getElementById('galleryPreview').innerHTML = '';
            document.getElementById('galleryPreviewWrapper').style.display = 'none';


            document.querySelector('#saveBtn .btn-label').textContent =
                'Save Program';

            document.getElementById('formModal')
                .classList.add('open');
        }

        function openEditModal(id) {

            const program = programs.find(p => p.id === id);

            if (!program) return;

            editingId = id;

            document.getElementById('modalTitle').textContent =
                'Edit Program';

            document.getElementById('programName').value =
                program.name;

            document.getElementById('programDescription').value =
                program.description ?? '';

            document.getElementById('programDuration').value =
                program.duration ?? '';

            document.getElementById('programLink').value =
    program.link ?? '';

            document.getElementById('programActive').checked =
                program.is_active == 1;
        
        document.getElementById('galleryPreview').innerHTML = '';

if (program.program_images && program.program_images.length) {

    document.getElementById('galleryPreviewWrapper').style.display = 'block';

    program.program_images.forEach(function(img){

        document.getElementById('galleryPreview').innerHTML += `
            <img
                src="/${img}"
                style="
                    width:80px;
                    height:80px;
                    object-fit:cover;
                    border-radius:10px;
                    border:1px solid #ddd;
                ">
        `;

    });

} else {

    document.getElementById('galleryPreviewWrapper').style.display = 'none';

}

            // RESET FILE INPUT
            const imageInput = document.getElementById('programImage');

            imageInput.value = '';

            // FORCE RESET
            imageInput.type = '';
            imageInput.type = 'file';

            // SHOW EXISTING IMAGE
            if (program.image) {

                document.getElementById('imagePreview').src =
                    `/${program.image}`;

                document.getElementById('imagePreviewWrapper').style.display =
                    'block';

            } else {

                document.getElementById('imagePreview').src = '';

                document.getElementById('imagePreviewWrapper').style.display =
                    'none';
            }

            document.querySelector('#saveBtn .btn-label').textContent =
                'Update Program';

            document.getElementById('formModal')
                .classList.add('open');
        }
        function closeFormModal() {

            document.getElementById('formModal')
                .classList.remove('open');
        }

        function handleBackdropClick(e) {

            if (e.target === document.getElementById('formModal')) {
                closeFormModal();
            }
        }

        async function saveProgram() {

            const name =
                document.getElementById('programName').value.trim();

            const description =
                document.getElementById('programDescription').value.trim();

            const duration =
                document.getElementById('programDuration').value.trim();

            const is_active =
                document.getElementById('programActive').checked ? 1 : 0;

            const image =
                document.getElementById('programImage').files[0];
                const link =
    document.getElementById('programLink').value.trim();

const galleryImages =
    document.getElementById('programImages').files;

            const url =
                editingId
                    ? `/admin/academy-programs/${editingId}`
                    : `/admin/academy-programs`;

            const method =
                editingId ? 'POST' : 'POST';

            // FORM DATA
            const formData = new FormData();

            formData.append('name', name);

            formData.append('description', description);

            formData.append('duration', duration);

            formData.append('link', link);

for (let i = 0; i < galleryImages.length; i++) {
    formData.append('program_images[]', galleryImages[i]);
}
            formData.append('is_active', is_active);

            // IMAGE
            if (image) {
                formData.append('image', image);
            }

            // FOR LARAVEL PUT REQUEST
            if (editingId) {
                formData.append('_method', 'PUT');
            }

            const res = await fetch(url, {

                method,

                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                },

                body: formData
            });

            const data = await res.json();

            if (!res.ok) {

                alert(data.message ?? 'Something went wrong');

                return;
            }

            if (editingId) {

                const index =
                    programs.findIndex(p => p.id === editingId);

                if (index > -1) {

                    programs[index] = data.academy_program;
                }

            } else {

                programs.unshift(data.academy_program);
            }

            render(programs);

            closeFormModal();
        }
        async function toggleStatus(id, checked) {

            const program = programs.find(p => p.id === id);

            if (!program) return;

            const res = await fetch(`/admin/academy-programs/${id}`, {

                method: 'PUT',

                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                },

                body: JSON.stringify({
                    name: program.name,
                    description: program.description,
                    duration: program.duration,
                    is_active: checked ? 1 : 0
                })
            });

            const data = await res.json();

            if (!res.ok) {
                alert(data.message ?? 'Failed');
                return;
            }

            program.is_active = checked ? 1 : 0;

            render(programs);
        }

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

        function handleDeleteBackdropClick(e) {

            if (e.target === document.getElementById('deleteModal')) {
                closeDeleteModal();
            }
        }

        async function confirmDelete() {

            if (!deletingId) return;

            const res = await fetch(`/admin/academy-programs/${deletingId}`, {

                method: 'DELETE',

                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();

            if (!res.ok) {
                alert(data.message ?? 'Delete failed');
                return;
            }

            programs =
                programs.filter(p => p.id !== deletingId);

            render(programs);

            closeDeleteModal();
        }

        document.addEventListener('keydown', e => {

            if (e.key === 'Escape') {

                closeFormModal();
                closeDeleteModal();
            }
        });

        render(programs);

    </script>

    {{-- IMAGE PREVIEW SCRIPT --}}
    <script>

        document.getElementById('programImage').addEventListener('change', function (e) {

            const file = e.target.files[0];

            if (!file) return;

            const reader = new FileReader();

            reader.onload = function (event) {

                document.getElementById('imagePreview').src = event.target.result;

                document.getElementById('imagePreviewWrapper').style.display = 'block';
            };

            reader.readAsDataURL(file);

        });

    </script>
{{-- MULTIPLE IMAGES SCRIPT --}}
<script>
document.getElementById('programImages').addEventListener('change', function(e){

    const preview = document.getElementById('galleryPreview');

    preview.innerHTML = '';

    if (!e.target.files.length) {

        document.getElementById('galleryPreviewWrapper').style.display = 'none';

        return;
    }

    document.getElementById('galleryPreviewWrapper').style.display = 'block';

    [...e.target.files].forEach(file => {

        const reader = new FileReader();

        reader.onload = function(event){

            preview.innerHTML += `
                <img
                    src="${event.target.result}"
                    style="
                        width:80px;
                        height:80px;
                        object-fit:cover;
                        border-radius:10px;
                        border:1px solid #ddd;
                    ">
            `;
        };

        reader.readAsDataURL(file);

    });

});
</script>
@endsection