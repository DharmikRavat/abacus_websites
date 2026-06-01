@extends('admin.layout.app')

@section('content')

    {{-- ═══════════ PAGE HEADER ═══════════ --}}
    <div class="roles-header">
        <div>
            <h1>Teachers</h1>
            <p>Manage teachers and their details</p>
        </div>

        <button class="btn btn-primary" onclick="openCreateModal()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>

            New Teacher
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

            <input type="text" id="searchInput" placeholder="Search Teachers…" oninput="filterTeachers(this.value)">

            <span id="teacher-count" style="font-size:12px;color:var(--faint);white-space:nowrap">
            </span>

        </div>

        <div style="overflow-x:auto">

            <table class="roles-table">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Profile</th>

                        <th>Name</th>

                        <th>Email</th>

                        <th>Type</th>

                        <th>Status</th>

                        <th>Created</th>

                        <th style="text-align:right">Actions</th>

                    </tr>

                </thead>

                <tbody id="teacherBody"></tbody>

            </table>

            <div id="emptyState" class="empty-state" style="display:none">

                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">

                    <circle cx="12" cy="12" r="10" />

                    <path d="M16 11c1.657 0 3 1.343 3 3v2H5v-2c0-1.657 1.343-3 3-3" />

                    <circle cx="12" cy="7" r="3" />

                </svg>

                <p>No Teachers Found</p>

                <span>Try different search or add a teacher</span>

            </div>

        </div>

    </div>

    {{-- ═══════════ CREATE / EDIT MODAL ═══════════ --}}
    <div class="modal-backdrop" id="formModal" onclick="handleBackdropClick(event)">

        <div class="modal">

            <div class="modal-header">

                <h2 id="modalTitle">New Teacher</h2>

                <button class="btn-icon" onclick="closeFormModal()">

                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">

                        <line x1="18" y1="6" x2="6" y2="18" />

                        <line x1="6" y1="6" x2="18" y2="18" />

                    </svg>

                </button>

            </div>

            <div class="modal-body">

                <div class="form-group">

                    <label class="form-label">Profile</label>

                    <input type="file" id="teacherProfile" class="form-control">

                </div>

                <div class="form-group">

                    <label class="form-label">Name *</label>

                    <input type="text" id="teacherName" class="form-control" placeholder="Enter teacher name">

                </div>

                <div class="form-group">

                    <label class="form-label">Email *</label>

                    <input type="email" id="teacherEmail" class="form-control" placeholder="Enter email">

                </div>

                <div class="form-group">

                    <label class="form-label">Password</label>

                    <input type="password" id="teacherPassword" class="form-control" placeholder="Enter password">

                </div>


                <div class="form-group">

                    <label class="form-label">Status</label>

                    <label class="toggle-row">

                        <div>

                            <div class="toggle-row-label">Active</div>

                            <div class="toggle-row-sub">
                                Teacher account active
                            </div>

                        </div>

                        <label class="toggle">

                            <input type="checkbox" id="teacherStatus" checked>

                            <span class="toggle-slider"></span>

                        </label>

                    </label>

                </div>

            </div>

            <div class="modal-footer">

                <button class="btn btn-ghost" onclick="closeFormModal()">
                    Cancel
                </button>

                <button class="btn btn-primary" id="saveBtn" onclick="saveTeacher()">

                    <span class="spinner"></span>

                    <span class="btn-label">
                        Save Teacher
                    </span>

                </button>

            </div>

        </div>

    </div>

    {{-- ═══════════ DELETE MODAL ═══════════ --}}
    <div class="modal-backdrop" id="deleteModal" onclick="handleDeleteBackdropClick(event)">

        <div class="modal" style="max-width:370px">

            <div class="confirm-modal-body">

                <div class="confirm-icon">🗑️</div>

                <h3>Delete Teacher?</h3>

                <p>
                    Are you sure you want to delete this teacher?
                    <br>This action cannot be undone.
                </p>

            </div>

            <div class="modal-footer" style="justify-content:center;gap:10px">

                <button class="btn btn-ghost" onclick="closeDeleteModal()">
                    Cancel
                </button>

                <button class="btn btn-danger" onclick="confirmDelete()">

                    Delete Teacher

                </button>

            </div>

        </div>

    </div>



@endsection
@section('script')
    <script>

        let teachers = @json($teachers);

        let editingId = null;
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

        function render(list) {

            const tbody = document.getElementById('teacherBody');
            const empty = document.getElementById('emptyState');

            document.getElementById('teacher-count').textContent =
                list.length + ' Teacher' + (list.length !== 1 ? 's' : '');

            if (!list.length) {

                tbody.innerHTML = '';

                empty.style.display = 'block';

                return;
            }

            empty.style.display = 'none';

            tbody.innerHTML = list.map((teacher, i) => {

                return `
                <tr>

                    <td>${i + 1}</td>
<td>
    <img src="${
        (function() {
            // 1. Fallback if no profile exists
            if (!teacher.profile) {
                return 'https://ui-avatars.com/api/?name=' + encodeURIComponent(teacher.name);
            }

            // 2. Production Check: If it's already a correct absolute URL, use it
            if (teacher.profile.startsWith('http://') || teacher.profile.startsWith('https://')) {
                // If it's a broken development leftover or missing /storage/
                if (!teacher.profile.includes('/storage/')) {
                    // Extract just the structural path after 'teachers/'
                    const parts = teacher.profile.split('teachers/');
                    const filename = parts[parts.length - 1];
                    return `${window.location.origin}/storage/teachers/${filename}`;
                }
                return teacher.profile;
            }

            // 3. Fallback for pure relative database paths (e.g., 'teachers/abc.jpg')
            const cleanPath = teacher.profile.replace(/^\/+/, '').replace(/^storage\//, '');
            return `${window.location.origin}/storage/${cleanPath}`;
        })()
    }"
    width="40"
    height="40"
    style="border-radius:50%; object-fit:cover;"
    onerror="this.src='https://ui-avatars.com/api/?name=' + encodeURIComponent('${escHtml(teacher.name)}')">
</td>

                    <td>
                        <strong>${escHtml(teacher.name)}</strong>
                    </td>

                    <td>${escHtml(teacher.email ?? '—')}</td>

                    <td>${teacher.type ?? 0}</td>

                    <td>

                        <span class="toggle-label ${teacher.status ? 'active' : 'inactive'}">
                            ${teacher.status ? 'Active' : 'Inactive'}
                        </span>

                    </td>

                    <td>${formatDate(teacher.created_at)}</td>

                    <td>

                        <div class="actions-cell" style="justify-content:flex-end">

                            <button class="btn-icon"
                                    onclick="openEditModal(${teacher.id})">

                                ✏️

                            </button>

                            <button class="btn-icon"
                                    style="color:red"
                                    onclick="openDeleteModal(${teacher.id})">

                                🗑️

                            </button>

                        </div>

                    </td>

                </tr>
            `;

            }).join('');
        }

        function filterTeachers(q) {

            const lower = q.toLowerCase();

            render(
                teachers.filter(t =>
                    t.name.toLowerCase().includes(lower) ||
                    (t.email ?? '').toLowerCase().includes(lower)
                )
            );
        }

        function openCreateModal() {

            editingId = null;

            document.getElementById('modalTitle').textContent = 'New Teacher';

            clearForm();

            document.getElementById('formModal').classList.add('open');
        }

        function openEditModal(id) {

            const teacher = teachers.find(t => t.id === id);

            if (!teacher) return;

            editingId = id;

            document.getElementById('modalTitle').textContent = 'Edit Teacher';

            document.getElementById('teacherName').value = teacher.name ?? '';
            document.getElementById('teacherEmail').value = teacher.email ?? '';

            document.getElementById('teacherStatus').checked = teacher.status == 1;

            document.getElementById('formModal').classList.add('open');
        }

        function clearForm() {

            document.getElementById('teacherProfile').value = '';
            document.getElementById('teacherName').value = '';
            document.getElementById('teacherEmail').value = '';
            document.getElementById('teacherPassword').value = '';
            document.getElementById('teacherStatus').checked = true;
        }

        function closeFormModal() {

            document.getElementById('formModal').classList.remove('open');
        }

        function handleBackdropClick(e) {

            if (e.target === document.getElementById('formModal')) {
                closeFormModal();
            }
        }

        async function saveTeacher() {

            const formData = new FormData();

            formData.append('name', document.getElementById('teacherName').value);
            formData.append('email', document.getElementById('teacherEmail').value);
            formData.append('password', document.getElementById('teacherPassword').value);

            formData.append('status', document.getElementById('teacherStatus').checked ? 1 : 0);

            const profile = document.getElementById('teacherProfile').files[0];

            if (profile) {
                formData.append('profile', profile);
            }

            if (editingId) {
                formData.append('_method', 'PUT');
            }

            try {

                const res = await fetch(
                    editingId
                        ? `/admin/teachers/${editingId}`
                        : `/admin/teachers`,
                    {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': CSRF,
                            'Accept': 'application/json'
                        },
                        body: formData
                    }
                );

                const data = await res.json();

                if (!res.ok) {
                    throw new Error(data.message ?? 'Something went wrong');
                }

                if (editingId) {

                    const index = teachers.findIndex(t => t.id === editingId);

                    teachers[index] = data.teacher;

                } else {

                    teachers.unshift(data.teacher);
                }

                render(teachers);

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

                const res = await fetch(`/admin/teachers/${deletingId}`, {

                    method: 'DELETE',

                    headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json'
                    }

                });

                const data = await res.json();

                teachers = teachers.filter(t => t.id !== deletingId);

                render(teachers);

                closeDeleteModal();

                alert(data.message);

            } catch (err) {

                alert(err.message);
            }
        }

        function escHtml(str) {

            return String(str ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        render(teachers);

    </script>

@endsection