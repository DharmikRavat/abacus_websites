@extends('admin.layout.app')

@section('style')
<style>

.form-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:16px;
}

.full-width{
    grid-column:1/-1;
}

</style>
@endsection

@section('content')

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">
    <div>
        <h1>Students</h1>
        <p>Manage students and their details</p>
    </div>

    <button class="btn btn-primary" onclick="openCreateModal()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>

        New Student
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
               placeholder="Search Students…"
               oninput="filterStudents(this.value)">

        <span id="student-count"
              style="font-size:12px;color:var(--faint);white-space:nowrap">
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

                    <th>Mobile</th>

                    <th>Status</th>

                    <th>Created</th>

                    <th style="text-align:right">Actions</th>

                </tr>

            </thead>

            <tbody id="studentBody"></tbody>

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

                <circle cx="12" cy="12" r="10"/>

                <path d="M16 11c1.657 0 3 1.343 3 3v2H5v-2c0-1.657 1.343-3 3-3"/>

                <circle cx="12" cy="7" r="3"/>

            </svg>

            <p>No Students Found</p>

            <span>Try different search or add a student</span>

        </div>

    </div>

</div>

{{-- ═══════════ CREATE / EDIT MODAL ═══════════ --}}
<div class="modal-backdrop"
     id="formModal"
     onclick="handleBackdropClick(event)">

    <div class="modal"
         style="max-width:900px">

        <div class="modal-header">

            <h2 id="modalTitle">New Student</h2>

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

            <div class="form-grid">

                {{-- Profile --}}
                <div class="form-group">

                    <label class="form-label">Profile</label>

                    <input type="file"
                           id="studentProfile"
                           class="form-control">

                </div>

                {{-- Name --}}
                <div class="form-group">

                    <label class="form-label">Name *</label>

                    <input type="text"
                           id="studentName"
                           class="form-control"
                           placeholder="Enter student name">

                </div>

                {{-- Email --}}
                <div class="form-group">

                    <label class="form-label">Email</label>

                    <input type="email"
                           id="studentEmail"
                           class="form-control"
                           placeholder="Enter email">

                </div>

                {{-- Mobile --}}
                <div class="form-group">

                    <label class="form-label">Mobile *</label>

                    <input type="text"
                           id="studentMobile"
                           class="form-control"
                           placeholder="Enter mobile number">

                </div>

                {{-- Password --}}
                <div class="form-group">

                    <label class="form-label">Password</label>

                    <input type="password"
                           id="studentPassword"
                           class="form-control"
                           placeholder="Enter password">

                </div>

                {{-- Login Type --}}
                <div class="form-group">

                    <label class="form-label">Login Type</label>

                    <select id="studentLoginType"
                            class="form-control">

                        <option value="1">Normal</option>

                        <option value="2">Google</option>

                        <option value="3">Mobile OTP</option>

                    </select>

                </div>

                {{-- Center ID --}}
                <div class="form-group">

                    <label class="form-label">Center ID</label>

                    <input type="number"
                           id="studentCenterId"
                           class="form-control">

                </div>

                {{-- Added By --}}
                <div class="form-group">

                    <label class="form-label">Added By</label>

                    <input type="text"
                           id="studentAddedBy"
                           class="form-control">

                </div>

                {{-- City --}}
                <div class="form-group">

                    <label class="form-label">City</label>

                    <input type="text"
                           id="studentCity"
                           class="form-control">

                </div>

                {{-- State --}}
                <div class="form-group">

                    <label class="form-label">State</label>

                    <input type="text"
                           id="studentState"
                           class="form-control">

                </div>

                {{-- Country --}}
                <div class="form-group">

                    <label class="form-label">Country</label>

                    <input type="text"
                           id="studentCountry"
                           class="form-control">

                </div>

                {{-- Latitude --}}
                <div class="form-group">

                    <label class="form-label">Latitude</label>

                    <input type="text"
                           id="studentLatitude"
                           class="form-control">

                </div>

                {{-- Longitude --}}
                <div class="form-group">

                    <label class="form-label">Longitude</label>

                    <input type="text"
                           id="studentLongitude"
                           class="form-control">

                </div>

                {{-- Facebook --}}
                <div class="form-group">

                    <label class="form-label">Facebook ID</label>

                    <input type="text"
                           id="studentFacebook"
                           class="form-control">

                </div>

                {{-- Twitter --}}
                <div class="form-group">

                    <label class="form-label">Twitter ID</label>

                    <input type="text"
                           id="studentTwitter"
                           class="form-control">

                </div>

                {{-- Instagram --}}
                <div class="form-group">

                    <label class="form-label">Instagram ID</label>

                    <input type="text"
                           id="studentInstagram"
                           class="form-control">

                </div>

                {{-- Youtube --}}
                <div class="form-group">

                    <label class="form-label">Youtube ID</label>

                    <input type="text"
                           id="studentYoutube"
                           class="form-control">

                </div>

                {{-- Address --}}
                <div class="form-group full-width">

                    <label class="form-label">Address</label>

                    <textarea id="studentAddress"
                              class="form-control"
                              rows="3"></textarea>

                </div>

                {{-- About --}}
                <div class="form-group full-width">

                    <label class="form-label">About Me</label>

                    <textarea id="studentAbout"
                              class="form-control"
                              rows="3"></textarea>

                </div>

                {{-- Status --}}
                <div class="form-group">

                    <label class="form-label">Status</label>

                    <label class="toggle">

                        <input type="checkbox"
                               id="studentStatus"
                               checked>

                        <span class="toggle-slider"></span>

                    </label>

                </div>

                {{-- Premium --}}
                <div class="form-group">

                    <label class="form-label">Premium User</label>

                    <label class="toggle">

                        <input type="checkbox"
                               id="studentPremium">

                        <span class="toggle-slider"></span>

                    </label>

                </div>

                {{-- Notification --}}
                <div class="form-group">

                    <label class="form-label">Notification</label>

                    <label class="toggle">

                        <input type="checkbox"
                               id="studentNotification"
                               checked>

                        <span class="toggle-slider"></span>

                    </label>

                </div>

                {{-- Subscription --}}
                <div class="form-group">

                    <label class="form-label">Subscription</label>

                    <label class="toggle">

                        <input type="checkbox"
                               id="studentSubscription">

                        <span class="toggle-slider"></span>

                    </label>

                </div>

            </div>

        </div>

        <div class="modal-footer">

            <button class="btn btn-ghost"
                    onclick="closeFormModal()">

                Cancel

            </button>

            <button class="btn btn-primary"
                    id="saveBtn"
                    onclick="saveStudent()">

                <span class="spinner"></span>

                <span class="btn-label">
                    Save Student
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

            <h3>Delete Student?</h3>

            <p>
                Are you sure you want to delete this student?
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

                Delete Student

            </button>

        </div>

    </div>

</div>

<script>

let students = @json($students);

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

    const tbody = document.getElementById('studentBody');
    const empty = document.getElementById('emptyState');

    document.getElementById('student-count').textContent =
        list.length + ' Student' + (list.length !== 1 ? 's' : '');

    if (!list.length) {

        tbody.innerHTML = '';

        empty.style.display = 'block';

        return;
    }

    empty.style.display = 'none';

    tbody.innerHTML = list.map((student, i) => {

        return `
            <tr>

                <td>${i + 1}</td>


                <td>
    <img src="${
        (function() {
            // 1. Fallback if no profile exists
            if (!student.profile) {
                return 'https://ui-avatars.com/api/?name=' + encodeURIComponent(student.name);
            }

            // 2. Production Check: If it's already a correct absolute URL, use it
            if (student.profile.startsWith('http://') || student.profile.startsWith('https://')) {
                // If it's a broken development leftover or missing /storage/
                if (!student.profile.includes('/storage/')) {
                    // Extract just the structural path after 'teachers/'
                    const parts = student.profile.split('students/');
                    const filename = parts[parts.length - 1];
                    return `${window.location.origin}/storage/students/${filename}`;
                }
                return student.profile;
            }

            // 3. Fallback for pure relative database paths (e.g., 'teachers/abc.jpg')
            const cleanPath = student.profile.replace(/^\/+/, '').replace(/^storage\//, '');
            return `${window.location.origin}/storage/${cleanPath}`;
        })()
    }"
    width="40"
    height="40"
    style="border-radius:50%; object-fit:cover;"
    onerror="this.src='https://ui-avatars.com/api/?name=' + encodeURIComponent('${escHtml(student.name)}')">
</td>


                </td>

                <td>
                    <strong>${escHtml(student.name)}</strong>
                </td>

                <td>${escHtml(student.email ?? '—')}</td>

                <td>${escHtml(student.mobile ?? '—')}</td>

                <td>

                    <span class="toggle-label ${student.isActive ? 'active' : 'inactive'}">
                        ${student.isActive ? 'Active' : 'Inactive'}
                    </span>

                </td>

                <td>${formatDate(student.created_at)}</td>

                <td>

                    <div class="actions-cell" style="justify-content:flex-end">

                        <button class="btn-icon"
                                onclick="openEditModal(${student.id})">

                            ✏️

                        </button>

                        <button class="btn-icon"
                                style="color:red"
                                onclick="openDeleteModal(${student.id})">

                            🗑️

                        </button>

                    </div>

                </td>

            </tr>
        `;

    }).join('');
}

function filterStudents(q) {

    const lower = q.toLowerCase();

    render(
        students.filter(s =>
            s.name.toLowerCase().includes(lower) ||
            (s.email ?? '').toLowerCase().includes(lower)
        )
    );
}

function openCreateModal() {

    editingId = null;

    document.getElementById('modalTitle').textContent = 'New Student';

    clearForm();

    document.getElementById('formModal').classList.add('open');
}

function openEditModal(id) {

    const student = students.find(s => s.id === id);

    if (!student) return;

    editingId = id;

    document.getElementById('modalTitle').textContent = 'Edit Student';

    document.getElementById('studentName').value = student.name ?? '';
    document.getElementById('studentEmail').value = student.email ?? '';
    document.getElementById('studentMobile').value = student.mobile ?? '';
    document.getElementById('studentAddress').value = student.address ?? '';
    document.getElementById('studentAbout').value = student.about_me ?? '';

    document.getElementById('studentCity').value = student.city ?? '';
    document.getElementById('studentState').value = student.state ?? '';
    document.getElementById('studentCountry').value = student.country ?? '';

    document.getElementById('studentLatitude').value = student.latitude ?? '';
    document.getElementById('studentLongitude').value = student.longitude ?? '';

    document.getElementById('studentFacebook').value = student.facebook_id ?? '';
    document.getElementById('studentTwitter').value = student.twiiter_id ?? '';
    document.getElementById('studentInstagram').value = student.instagram_id ?? '';
    document.getElementById('studentYoutube').value = student.youtube_id ?? '';

    document.getElementById('studentLoginType').value = student.logintype ?? 1;

    document.getElementById('studentCenterId').value = student.center_id ?? '';
    document.getElementById('studentAddedBy').value = student.added_by ?? '';

    document.getElementById('studentStatus').checked = student.isActive == 1;
    document.getElementById('studentPremium').checked = student.is_premium == 1;
    document.getElementById('studentNotification').checked = student.notification == 1;
    document.getElementById('studentSubscription').checked = student.subscription == 1;

    document.getElementById('formModal').classList.add('open');
}

function clearForm() {

    document.getElementById('studentProfile').value = '';

    document.getElementById('studentName').value = '';
    document.getElementById('studentEmail').value = '';
    document.getElementById('studentMobile').value = '';
    document.getElementById('studentPassword').value = '';

    document.getElementById('studentAddress').value = '';
    document.getElementById('studentAbout').value = '';

    document.getElementById('studentCity').value = '';
    document.getElementById('studentState').value = '';
    document.getElementById('studentCountry').value = '';

    document.getElementById('studentLatitude').value = '';
    document.getElementById('studentLongitude').value = '';

    document.getElementById('studentFacebook').value = '';
    document.getElementById('studentTwitter').value = '';
    document.getElementById('studentInstagram').value = '';
    document.getElementById('studentYoutube').value = '';

    document.getElementById('studentLoginType').value = 1;

    document.getElementById('studentCenterId').value = '';
    document.getElementById('studentAddedBy').value = '';

    document.getElementById('studentStatus').checked = true;
    document.getElementById('studentPremium').checked = false;
    document.getElementById('studentNotification').checked = true;
    document.getElementById('studentSubscription').checked = false;
}

function closeFormModal() {

    document.getElementById('formModal').classList.remove('open');
}

function handleBackdropClick(e) {

    if (e.target === document.getElementById('formModal')) {
        closeFormModal();
    }
}

async function saveStudent() {

    const formData = new FormData();

    formData.append('name', document.getElementById('studentName').value);
    formData.append('email', document.getElementById('studentEmail').value);
    formData.append('mobile', document.getElementById('studentMobile').value);
    formData.append('password', document.getElementById('studentPassword').value);

    formData.append('address', document.getElementById('studentAddress').value);
    formData.append('about_me', document.getElementById('studentAbout').value);

    formData.append('city', document.getElementById('studentCity').value);
    formData.append('state', document.getElementById('studentState').value);
    formData.append('country', document.getElementById('studentCountry').value);

    formData.append('latitude', document.getElementById('studentLatitude').value);
    formData.append('longitude', document.getElementById('studentLongitude').value);

    formData.append('facebook_id', document.getElementById('studentFacebook').value);
    formData.append('twiiter_id', document.getElementById('studentTwitter').value);
    formData.append('instagram_id', document.getElementById('studentInstagram').value);
    formData.append('youtube_id', document.getElementById('studentYoutube').value);

    formData.append('logintype', document.getElementById('studentLoginType').value);

    formData.append('center_id', document.getElementById('studentCenterId').value);

    formData.append('added_by', document.getElementById('studentAddedBy').value);

    formData.append(
        'status',
        document.getElementById('studentStatus').checked ? 1 : 0
    );

    formData.append(
        'is_premium',
        document.getElementById('studentPremium').checked ? 1 : 0
    );

    formData.append(
        'notification',
        document.getElementById('studentNotification').checked ? 1 : 0
    );

    formData.append(
        'subscription',
        document.getElementById('studentSubscription').checked ? 1 : 0
    );

    const profile = document.getElementById('studentProfile').files[0];

    if (profile) {

        formData.append('profile', profile);
    }

    if (editingId) {

        formData.append('_method', 'PUT');
    }

    try {

        const res = await fetch(

            editingId
            ? `/admin/students/${editingId}`
            : `/admin/students`,

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

            const index = students.findIndex(s => s.id === editingId);

            students[index] = data.student;

        } else {

            students.unshift(data.student);
        }

        render(students);

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

        const res = await fetch(`/admin/students/${deletingId}`, {

            method: 'DELETE',

            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            }

        });

        const data = await res.json();

        students = students.filter(s => s.id !== deletingId);

        render(students);

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

render(students);

</script>

@endsection