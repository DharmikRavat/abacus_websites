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

                    <th>Enrollment ID</th>

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
          <div id="pagination" class="pagination"></div>


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

    <div style="margin-bottom:10px">
        <img id="studentProfilePreview"
             src=""
             alt="Profile"
             style="
                width:80px;
                height:80px;
                border-radius:50%;
                object-fit:cover;
                display:none;
             ">
    </div>

    <input type="file"
           id="studentProfile"
           class="form-control"
           onchange="previewStudentProfile(this)">

</div>
                {{-- Enrollment ID --}}
                                <div class="form-group">
    <label class="form-label">Enrollment ID</label>

    <input type="text"
           id="studentEnrollmentId"
           class="form-control"
           placeholder="IAA2026S0005">
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
{{-- ═══════════ CERTIFICATIONS ═══════════ --}}
<div id="certificationSection"
     style="display:none;margin-top:25px;border-top:1px solid var(--border);padding-top:20px;">

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px">

        <div>
            <h3 style="margin:0">Student Certifications</h3>

            <p style="margin:4px 0 0;color:var(--faint);font-size:13px">
                Manage certificates issued to this student
            </p>
        </div>

        <button type="button"
                class="btn btn-primary"
                onclick="openCertificationModal()">
            + Add Certification
        </button>

    </div>

    <div id="certificationList">
        <div style="color:var(--faint);font-size:13px">
            No certifications found.
        </div>
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

{{-- Certification Modal --}}
{{-- ═══════════ CERTIFICATION MODAL ═══════════ --}}
<div class="modal-backdrop"
     id="certificationModal"
     onclick="handleCertificationBackdropClick(event)">

    <div class="modal" style="max-width:850px">

        <div class="modal-header">

            <h2 id="certificationModalTitle">
                Add Certification
            </h2>

            <button class="btn-icon"
                    onclick="closeCertificationModal()">

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

                {{-- Trainer --}}
                <div class="form-group">
                    <label class="form-label">Trainer Name</label>

                    <input type="text"
                           id="certTrainerName"
                           class="form-control">
                </div>

                {{-- Certificate Date --}}
                <div class="form-group">
                    <label class="form-label">Certificate Date</label>

                    <input type="date"
                           id="certCertificateDate"
                           class="form-control">
                </div>

                {{-- Level --}}
                <div class="form-group">
                    <label class="form-label">Level</label>

                    <input type="text"
                           id="certLevel"
                           class="form-control">
                </div>

                {{-- Exam Date --}}
                <div class="form-group">
                    <label class="form-label">Exam Date</label>

                    <input type="date"
                           id="certExamDate"
                           class="form-control">
                </div>

                {{-- Score --}}
                <div class="form-group">
                    <label class="form-label">Score</label>

                    <input type="text"
                           id="certScore"
                           class="form-control">
                </div>

                {{-- Result --}}
                <div class="form-group">
                    <label class="form-label">Result</label>

                    <select id="certResult"
                            class="form-control">

                        <option value="">Select Result</option>
                        <option value="Pass">Pass</option>
                        <option value="Fail">Fail</option>

                    </select>
                </div>

                {{-- Student Name Snapshot --}}
                <div class="form-group">
                    <label class="form-label">Student Name</label>

                    <input type="text"
                           id="certStudentName"
                           class="form-control">
                </div>

                {{-- Parent Name --}}
                <div class="form-group">
                    <label class="form-label">Parent Name</label>

                    <input type="text"
                           id="certParentsName"
                           class="form-control">
                </div>

                {{-- Mobile --}}
                <div class="form-group">
                    <label class="form-label">Mobile</label>

                    <input type="text"
                           id="certMobile"
                           class="form-control">
                </div>

                {{-- Receiver Name --}}
<div class="form-group">

    <label class="form-label">
        Receiver Name
    </label>

    <input type="text"
           id="certReceiverName"
           class="form-control">

</div>


                {{-- Receiver Contact --}}
                <div class="form-group">
                    <label class="form-label">Receiver Contact</label>

                    <input type="text"
                           id="certReceiverContact"
                           class="form-control">
                </div>

                {{-- Address --}}
                <div class="form-group full-width">

                    <label class="form-label">
                        Address
                    </label>

                    <textarea id="certAddress"
                              class="form-control"
                              rows="3"></textarea>

                </div>

                {{-- Address Image --}}
                <div class="form-group">

                    <label class="form-label">
                        Address Image
                    </label>

                    <input type="file"
                           id="certAddressImage"
                           class="form-control"
                           accept="image/*">

                </div>

                {{-- Certificate Image --}}
                <div class="form-group">

                    <label class="form-label">
                        Certificate Image
                    </label>

                    <input type="file"
                           id="certCertificateImage"
                           class="form-control"
                           accept="image/*">

                </div>

                {{-- Dispatch Date --}}
                <div class="form-group">

                    <label class="form-label">
                        Dispatch Date
                    </label>

                    <input type="date"
                           id="certDispatchDate"
                           class="form-control">

                </div>

                {{-- Dispatch ID --}}
                <div class="form-group">

                    <label class="form-label">
                        Dispatch ID
                    </label>

                    <input type="text"
                           id="certDispatchId"
                           class="form-control">

                </div>

                {{-- Received Date --}}
                <div class="form-group">

                    <label class="form-label">
                        Received Date
                    </label>

                    <input type="date"
                           id="certReceivedDate"
                           class="form-control">

                </div>

                {{-- Download Type --}}
                <div class="form-group">

                    <label class="form-label">
                        Download Type
                    </label>

                    <input type="text"
                           id="certDownloadType"
                           class="form-control">

                </div>

                {{-- Remark --}}
                <div class="form-group full-width">

                    <label class="form-label">
                        Remark
                    </label>

                    <textarea id="certRemark"
                              class="form-control"
                              rows="3"></textarea>

                </div>

            </div>

        </div>

        <div class="modal-footer">

            <button class="btn btn-ghost"
                    onclick="closeCertificationModal()">
                Cancel
            </button>

            <button class="btn btn-primary"
                    onclick="saveCertification()">

                <span class="btn-label">
                    Save Certification
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

let editingId = null;
let deletingId = null;
let editingCertificationId = null;

let currentPage = 1;
const perPage = 5;

const CSRF =
    document.querySelector('meta[name="csrf-token"]')?.content ?? '';

/* =========================================================
   PROFILE
========================================================= */

function previewStudentProfile(input) {

    const preview =
        document.getElementById('studentProfilePreview');

    if (input.files && input.files[0]) {

        preview.src =
            URL.createObjectURL(input.files[0]);

        preview.style.display = 'block';
    }
}


/* =========================================================
   ENROLLMENT ID
========================================================= */

function generateEnrollmentId() {

    const prefix = 'IAA2026S';

    let maxNumber = 0;

    students.forEach(student => {

        if (!student.student_enrollment_id) {
            return;
        }

        const match =
            student.student_enrollment_id.match(
                /IAA\d{4}S(\d+)/
            );

        if (match) {

            const num = parseInt(match[1]);

            if (num > maxNumber) {
                maxNumber = num;
            }
        }
    });

    const nextNumber = maxNumber + 1;

    return prefix +
        String(nextNumber).padStart(4, '0');
}


/* =========================================================
   DATE
========================================================= */

function formatDate(str) {

    if (!str) {
        return '—';
    }

    const date = new Date(str);

    if (isNaN(date.getTime())) {
        return '—';
    }

    return date.toLocaleDateString('en-US', {

        month: 'short',
        day: 'numeric',
        year: 'numeric'

    });
}


/* =========================================================
   PROFILE URL
========================================================= */

function getStudentProfileUrl(student) {

    if (!student.profile) {

        return 'https://ui-avatars.com/api/?name=' +
            encodeURIComponent(student.name ?? 'Student');
    }

    if (
        student.profile.startsWith('http://') ||
        student.profile.startsWith('https://')
    ) {

        if (!student.profile.includes('/storage/')) {

            const parts =
                student.profile.split('students/');

            const filename =
                parts[parts.length - 1];

            return `${window.location.origin}/storage/students/${filename}`;
        }

        return student.profile;
    }

    const cleanPath =
        student.profile
            .replace(/^\/+/, '')
            .replace(/^storage\//, '');

    return `${window.location.origin}/storage/${cleanPath}`;
}


/* =========================================================
   RENDER STUDENTS
========================================================= */

function render(list) {

    const tbody =
        document.getElementById('studentBody');

    const empty =
        document.getElementById('emptyState');

    const count =
        document.getElementById('student-count');

    count.textContent =
        list.length +
        ' Student' +
        (list.length !== 1 ? 's' : '');


    /* No records */

    if (!list.length) {

        tbody.innerHTML = '';

        empty.style.display = 'block';

        document.getElementById('pagination').innerHTML = '';

        return;
    }


    empty.style.display = 'none';


    /* Pagination */

    const totalPages =
        Math.ceil(list.length / perPage);

    if (currentPage > totalPages) {
        currentPage = totalPages;
    }

    if (currentPage < 1) {
        currentPage = 1;
    }


    const start =
        (currentPage - 1) * perPage;

    const pageData =
        list.slice(
            start,
            start + perPage
        );


    tbody.innerHTML =
        pageData.map((student, i) => {

            const active =
                student.is_active == 1 ||
                student.isActive == 1;


            const profileUrl =
                getStudentProfileUrl(student);


            const fallback =
                'https://ui-avatars.com/api/?name=' +
                encodeURIComponent(
                    student.name ?? 'Student'
                );


            return `

                <tr>

                    <td>
                        ${start + i + 1}
                    </td>


                    {{-- Profile --}}

                    <td>

                        <img
                            src="${profileUrl}"
                            width="40"
                            height="40"
                            style="
                                width:40px;
                                height:40px;
                                border-radius:50%;
                                object-fit:cover;
                            "
                            onerror="
                                this.onerror=null;
                                this.src='${fallback}';
                            "
                        >

                    </td>


                    {{-- Enrollment ID --}}

                    <td>
                        ${escHtml(
                            student.student_enrollment_id ?? '-'
                        )}
                    </td>


                    {{-- Name --}}

                    <td>

                        <strong>
                            ${escHtml(
                                student.name ?? '—'
                            )}
                        </strong>

                    </td>


                    {{-- Email --}}

                    <td>
                        ${escHtml(
                            student.email ?? '—'
                        )}
                    </td>


                    {{-- Mobile --}}

                    <td>
                        ${escHtml(
                            student.mobile ?? '—'
                        )}
                    </td>


                    {{-- Status --}}

                    <td>

                        <span class="toggle-label ${
                            active
                                ? 'active'
                                : 'inactive'
                        }">

                            ${
                                active
                                    ? 'Active'
                                    : 'Inactive'
                            }

                        </span>

                    </td>


                    {{-- Created --}}

                    <td>
                        ${formatDate(
                            student.created_at
                        )}
                    </td>


                    {{-- Actions --}}

                    <td>

                        <div
                            class="actions-cell"
                            style="justify-content:flex-end"
                        >

                            {{-- Edit --}}

                            <button
                                class="btn-icon"
                                onclick="
                                    openEditModal(
                                        ${student.id}
                                    )
                                "
                                title="Edit"
                            >

                                <svg
                                    width="13"
                                    height="13"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >

                                    <path
                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"
                                    />

                                    <path
                                        d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"
                                    />

                                </svg>

                            </button>


                            {{-- Delete --}}

                            <button
                                class="btn-icon"
                                style="color:red"
                                onclick="
                                    openDeleteModal(
                                        ${student.id}
                                    )
                                "
                                title="Delete"
                            >

                                <svg
                                    width="13"
                                    height="13"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >

                                    <polyline
                                        points="3 6 5 6 21 6"
                                    />

                                    <path
                                        d="M19 6l-1 14H6L5 6"
                                    />

                                    <path
                                        d="M10 11v6"
                                    />

                                    <path
                                        d="M14 11v6"
                                    />

                                    <path
                                        d="M9 6V4h6v2"
                                    />

                                </svg>

                            </button>

                        </div>

                    </td>

                </tr>

            `;

        }).join('');


    renderPagination(totalPages);
}


/* =========================================================
   PAGINATION
========================================================= */

function renderPagination(totalPages) {

    const pagination =
        document.getElementById('pagination');

    if (!totalPages || totalPages <= 1) {

        pagination.innerHTML = '';

        return;
    }


    let html = '';


    /* Previous */

    html += `

        <button
            ${currentPage === 1 ? 'disabled' : ''}
            onclick="
                changePage(
                    ${currentPage - 1}
                )
            "
        >
            Previous
        </button>

    `;


    /* Pages */

    for (
        let i = 1;
        i <= totalPages;
        i++
    ) {

        html += `

            <button
                class="${i === currentPage ? 'active' : ''}"
                onclick="
                    changePage(${i})
                "
            >
                ${i}
            </button>

        `;
    }


    /* Next */

    html += `

        <button
            ${
                currentPage === totalPages
                    ? 'disabled'
                    : ''
            }
            onclick="
                changePage(
                    ${currentPage + 1}
                )
            "
        >
            Next
        </button>

    `;


    pagination.innerHTML = html;
}


/* =========================================================
   CHANGE PAGE
========================================================= */

function changePage(page) {

    const search =
        document.getElementById(
            'searchInput'
        ).value.toLowerCase().trim();


    currentPage = page;


    const filtered =
        students.filter(student => {

            const name =
                (student.name ?? '')
                    .toLowerCase();

            const email =
                (student.email ?? '')
                    .toLowerCase();

            const mobile =
                (student.mobile ?? '')
                    .toLowerCase();

            const enrollment =
                (
                    student.student_enrollment_id ?? ''
                ).toLowerCase();


            return (
                name.includes(search) ||
                email.includes(search) ||
                mobile.includes(search) ||
                enrollment.includes(search)
            );

        });


    render(filtered);
}


/* =========================================================
   SEARCH
========================================================= */

function filterStudents(q) {

    currentPage = 1;

    const lower =
        q.toLowerCase().trim();


    const filtered =
        students.filter(student => {

            const name =
                (student.name ?? '')
                    .toLowerCase();

            const email =
                (student.email ?? '')
                    .toLowerCase();

            const mobile =
                (student.mobile ?? '')
                    .toLowerCase();

            const enrollment =
                (
                    student.student_enrollment_id ?? ''
                ).toLowerCase();


            return (
                name.includes(lower) ||
                email.includes(lower) ||
                mobile.includes(lower) ||
                enrollment.includes(lower)
            );

        });


    render(filtered);
}


/* =========================================================
   CREATE STUDENT
========================================================= */

function openCreateModal() {

    editingId = null;

    document.getElementById(
        'modalTitle'
    ).textContent = 'New Student';


    clearForm();


    document.getElementById(
        'studentEnrollmentId'
    ).value =
        generateEnrollmentId();


    /* Hide certification section */

    const certificationSection =
        document.getElementById(
            'certificationSection'
        );

    if (certificationSection) {

        certificationSection.style.display =
            'none';
    }


    document.getElementById(
        'formModal'
    ).classList.add('open');
}


/* =========================================================
   EDIT STUDENT
========================================================= */

function openEditModal(id) {

    const student =
        students.find(
            s => Number(s.id) === Number(id)
        );


    if (!student) {
        return;
    }


    editingId = student.id;


    document.getElementById(
        'modalTitle'
    ).textContent = 'Edit Student';


    /* Show certification section */

    const certificationSection =
        document.getElementById(
            'certificationSection'
        );


    if (certificationSection) {

        certificationSection.style.display =
            'block';
    }


    /* Render certifications */

    renderCertifications(
        student.certifications ?? []
    );


    /* Student information */

    document.getElementById(
        'studentEnrollmentId'
    ).value =
        student.student_enrollment_id ?? '';


    document.getElementById(
        'studentName'
    ).value =
        student.name ?? '';


    document.getElementById(
        'studentEmail'
    ).value =
        student.email ?? '';


    document.getElementById(
        'studentMobile'
    ).value =
        student.mobile ?? '';


    document.getElementById(
        'studentPassword'
    ).value = '';


    document.getElementById(
        'studentAddress'
    ).value =
        student.address ?? '';


    document.getElementById(
        'studentAbout'
    ).value =
        student.about_me ?? '';


    document.getElementById(
        'studentCity'
    ).value =
        student.city ?? '';


    document.getElementById(
        'studentState'
    ).value =
        student.state ?? '';


    document.getElementById(
        'studentCountry'
    ).value =
        student.country ?? '';


    document.getElementById(
        'studentLatitude'
    ).value =
        student.latitude ?? '';


    document.getElementById(
        'studentLongitude'
    ).value =
        student.longitude ?? '';


    document.getElementById(
        'studentFacebook'
    ).value =
        student.facebook_id ?? '';


    document.getElementById(
        'studentTwitter'
    ).value =
        student.twiiter_id ?? '';


    document.getElementById(
        'studentInstagram'
    ).value =
        student.instagram_id ?? '';


    document.getElementById(
        'studentYoutube'
    ).value =
        student.youtube_id ?? '';


    document.getElementById(
        'studentLoginType'
    ).value =
        student.logintype ?? 1;


    document.getElementById(
        'studentCenterId'
    ).value =
        student.center_id ?? '';


    document.getElementById(
        'studentAddedBy'
    ).value =
        student.added_by ?? '';


    /* Profile */

    const preview =
        document.getElementById(
            'studentProfilePreview'
        );


    if (student.profile) {

        const imageUrl =
            getStudentProfileUrl(student);


        preview.src = imageUrl;

        preview.style.display =
            'block';


        preview.onerror = function () {

            this.onerror = null;

            this.src =
                'https://ui-avatars.com/api/?name=' +
                encodeURIComponent(
                    student.name ?? 'Student'
                );

        };

    } else {

        preview.src =
            'https://ui-avatars.com/api/?name=' +
            encodeURIComponent(
                student.name ?? 'Student'
            );

        preview.style.display =
            'block';
    }


    /* Status */

    document.getElementById(
        'studentStatus'
    ).checked =
        student.is_active == 1 ||
        student.isActive == 1;


    document.getElementById(
        'studentPremium'
    ).checked =
        student.is_premium == 1;


    document.getElementById(
        'studentNotification'
    ).checked =
        student.notification == 1;


    document.getElementById(
        'studentSubscription'
    ).checked =
        student.subscription == 1;


    /* Open modal */

    document.getElementById(
        'formModal'
    ).classList.add('open');
}


/* =========================================================
   CLEAR STUDENT FORM
========================================================= */

function clearForm() {

    document.getElementById(
        'studentProfile'
    ).value = '';


    const preview =
        document.getElementById(
            'studentProfilePreview'
        );


    preview.src = '';

    preview.style.display =
        'none';


    document.getElementById(
        'studentEnrollmentId'
    ).value = '';


    document.getElementById(
        'studentName'
    ).value = '';


    document.getElementById(
        'studentEmail'
    ).value = '';


    document.getElementById(
        'studentMobile'
    ).value = '';


    document.getElementById(
        'studentPassword'
    ).value = '';


    document.getElementById(
        'studentAddress'
    ).value = '';


    document.getElementById(
        'studentAbout'
    ).value = '';


    document.getElementById(
        'studentCity'
    ).value = '';


    document.getElementById(
        'studentState'
    ).value = '';


    document.getElementById(
        'studentCountry'
    ).value = '';


    document.getElementById(
        'studentLatitude'
    ).value = '';


    document.getElementById(
        'studentLongitude'
    ).value = '';


    document.getElementById(
        'studentFacebook'
    ).value = '';


    document.getElementById(
        'studentTwitter'
    ).value = '';


    document.getElementById(
        'studentInstagram'
    ).value = '';


    document.getElementById(
        'studentYoutube'
    ).value = '';


    document.getElementById(
        'studentLoginType'
    ).value = 1;


    document.getElementById(
        'studentCenterId'
    ).value = '';


    document.getElementById(
        'studentAddedBy'
    ).value = '';


    document.getElementById(
        'studentStatus'
    ).checked = true;


    document.getElementById(
        'studentPremium'
    ).checked = false;


    document.getElementById(
        'studentNotification'
    ).checked = true;


    document.getElementById(
        'studentSubscription'
    ).checked = false;
}


/* =========================================================
   CLOSE STUDENT MODAL
========================================================= */

function closeFormModal() {

    document.getElementById(
        'formModal'
    ).classList.remove('open');
}


function handleBackdropClick(e) {

    if (
        e.target ===
        document.getElementById('formModal')
    ) {

        closeFormModal();
    }
}


/* =========================================================
   SAVE STUDENT
========================================================= */

async function saveStudent() {

    const formData =
        new FormData();


    formData.append(
        'student_enrollment_id',
        document.getElementById(
            'studentEnrollmentId'
        ).value
    );


    formData.append(
        'name',
        document.getElementById(
            'studentName'
        ).value
    );


    formData.append(
        'email',
        document.getElementById(
            'studentEmail'
        ).value
    );


    formData.append(
        'mobile',
        document.getElementById(
            'studentMobile'
        ).value
    );


    const password =
        document.getElementById(
            'studentPassword'
        ).value;


    if (password) {

        formData.append(
            'password',
            password
        );
    }


    formData.append(
        'address',
        document.getElementById(
            'studentAddress'
        ).value
    );


    formData.append(
        'about_me',
        document.getElementById(
            'studentAbout'
        ).value
    );


    formData.append(
        'city',
        document.getElementById(
            'studentCity'
        ).value
    );


    formData.append(
        'state',
        document.getElementById(
            'studentState'
        ).value
    );


    formData.append(
        'country',
        document.getElementById(
            'studentCountry'
        ).value
    );


    formData.append(
        'latitude',
        document.getElementById(
            'studentLatitude'
        ).value
    );


    formData.append(
        'longitude',
        document.getElementById(
            'studentLongitude'
        ).value
    );


    formData.append(
        'facebook_id',
        document.getElementById(
            'studentFacebook'
        ).value
    );


    formData.append(
        'twiiter_id',
        document.getElementById(
            'studentTwitter'
        ).value
    );


    formData.append(
        'instagram_id',
        document.getElementById(
            'studentInstagram'
        ).value
    );


    formData.append(
        'youtube_id',
        document.getElementById(
            'studentYoutube'
        ).value
    );


    formData.append(
        'logintype',
        document.getElementById(
            'studentLoginType'
        ).value
    );


    formData.append(
        'center_id',
        document.getElementById(
            'studentCenterId'
        ).value
    );


    formData.append(
        'added_by',
        document.getElementById(
            'studentAddedBy'
        ).value
    );


    formData.append(
        'status',
        document.getElementById(
            'studentStatus'
        ).checked ? 1 : 0
    );


    formData.append(
        'is_premium',
        document.getElementById(
            'studentPremium'
        ).checked ? 1 : 0
    );


    formData.append(
        'notification',
        document.getElementById(
            'studentNotification'
        ).checked ? 1 : 0
    );


    formData.append(
        'subscription',
        document.getElementById(
            'studentSubscription'
        ).checked ? 1 : 0
    );


    /* Profile */

    const profile =
        document.getElementById(
            'studentProfile'
        ).files[0];


    if (profile) {

        formData.append(
            'profile',
            profile
        );
    }


    /* PUT */

    if (editingId) {

        formData.append(
            '_method',
            'PUT'
        );
    }


    try {

        const url =
            editingId

                ? `/admin/students/${editingId}`

                : `/admin/students`;


        const res =
            await fetch(url, {

                method: 'POST',

                headers: {

                    'X-CSRF-TOKEN': CSRF,

                    'Accept':
                        'application/json'

                },

                body: formData

            });


        const data =
            await res.json();


        if (!res.ok) {

            throw new Error(
                data.message ??
                'Something went wrong'
            );
        }


        if (editingId) {

            const index =
                students.findIndex(
                    s => Number(s.id) ===
                        Number(editingId)
                );


            if (index !== -1) {

                /*
                 * Preserve certifications if the
                 * student update response doesn't
                 * contain them.
                 */

                const oldCertifications =
                    students[index]
                        .certifications ?? [];


                students[index] =
                    data.student;


                if (
                    !data.student.certifications
                ) {

                    students[index]
                        .certifications =
                        oldCertifications;
                }
            }

        } else {

            students.unshift(
                data.student
            );
        }


        render(students);

        closeFormModal();


        alert(
            data.message ??
            'Student saved successfully.'
        );


    } catch (err) {

        console.error(err);

        alert(
            err.message ??
            'Something went wrong.'
        );
    }
}


/* =========================================================
   CERTIFICATIONS
========================================================= */

function renderCertifications(certifications) {

    const container =
        document.getElementById(
            'certificationList'
        );


    if (!container) {
        return;
    }


    if (
        !certifications ||
        certifications.length === 0
    ) {

        container.innerHTML = `

            <div style="
                padding:20px;
                text-align:center;
                border:1px dashed var(--border);
                border-radius:8px;
                color:var(--faint);
            ">

                No certifications added yet.

            </div>

        `;

        return;
    }


    container.innerHTML =
        certifications.map(cert => {

            const result =
                cert.result ?? '—';


            const resultClass =
                result.toLowerCase() === 'pass'
                    ? 'active'
                    : 'inactive';


            return `

                <div style="
                    border:1px solid var(--border);
                    border-radius:10px;
                    padding:15px;
                    margin-bottom:10px;
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    gap:15px;
                ">


                    <div style="flex:1">

                        <div style="
                            display:flex;
                            align-items:center;
                            gap:8px;
                            margin-bottom:5px;
                        ">

                            <strong>

                                ${escHtml(
                                    cert.level ??
                                    'Certification'
                                )}

                            </strong>


                            <span class="toggle-label ${resultClass}">

                                ${escHtml(result)}

                            </span>

                        </div>


                        <div style="
                            font-size:13px;
                            color:var(--faint);
                            line-height:1.8;
                        ">

                            <div>

                                <strong>Exam Date:</strong>

                                ${formatDate(
                                    cert.exam_date
                                )}

                            </div>


                            <div>

                                <strong>Score:</strong>

                                ${escHtml(
                                    cert.score ?? '—'
                                )}

                            </div>


                            <div>

                                <strong>Trainer:</strong>

                                ${escHtml(
                                    cert.trainer_name ?? '—'
                                )}

                            </div>


                            <div>

                                <strong>Certificate Date:</strong>

                                ${formatDate(
                                    cert.certificate_date
                                )}

                            </div>

                        </div>

                    </div>


                    <div
                        class="actions-cell"
                        style="flex-shrink:0"
                    >

                        {{-- Edit --}}

                        <button
                            class="btn-icon"
                            onclick="
                                editCertification(
                                    ${cert.id}
                                )
                            "
                            title="Edit Certification"
                        >

                            <svg
                                width="13"
                                height="13"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >

                                <path
                                    d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"
                                />

                                <path
                                    d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"
                                />

                            </svg>

                        </button>


                        {{-- Delete --}}

                        <button
                            class="btn-icon"
                            style="color:red"
                            onclick="
                                deleteCertification(
                                    ${cert.id}
                                )
                            "
                            title="Delete Certification"
                        >

                            <svg
                                width="13"
                                height="13"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >

                                <polyline
                                    points="3 6 5 6 21 6"
                                />

                                <path
                                    d="M19 6l-1 14H6L5 6"
                                />

                                <path
                                    d="M10 11v6"
                                />

                                <path
                                    d="M14 11v6"
                                />

                                <path
                                    d="M9 6V4h6v2"
                                />

                            </svg>

                        </button>

                    </div>

                </div>

            `;

        }).join('');
}


/* =========================================================
   OPEN ADD CERTIFICATION
========================================================= */

function openCertificationModal() {

    console.log('Opening certification modal...');

    // --------------------------------------------------
    // 1. Check student selection
    // --------------------------------------------------
    if (!editingId) {
        alert('Please save/select the student first.');
        return;
    }

    // --------------------------------------------------
    // 2. Reset certification editing state
    // --------------------------------------------------
    editingCertificationId = null;

    // --------------------------------------------------
    // 3. Get modal elements
    // --------------------------------------------------
    const modal = document.getElementById('certificationModal');

    if (!modal) {
        console.error('Certification modal not found.');
        return;
    }

    // --------------------------------------------------
    // 4. Update modal title
    // --------------------------------------------------
    const title = document.getElementById('certificationModalTitle');

    if (title) {
        title.textContent = 'Add Certification';
    }

    // --------------------------------------------------
    // 5. Clear certification form
    // --------------------------------------------------
    const form = document.getElementById('certificationForm');

    if (form) {
        form.reset();
    }

    // --------------------------------------------------
    // 6. Clear certification ID
    // --------------------------------------------------
    const certificationId =
        document.getElementById('certificationId');

    if (certificationId) {
        certificationId.value = '';
    }

    // --------------------------------------------------
    // 7. Find selected student
    // --------------------------------------------------
    let student = null;

    if (Array.isArray(students)) {

        student = students.find(function (s) {
            return Number(s.id) === Number(editingId);
        });

    }

    // --------------------------------------------------
    // 8. Fill student information
    // --------------------------------------------------
    if (student) {

        const studentName =
            document.getElementById('certStudentName');

        if (studentName) {
            studentName.value = student.name ?? '';
        }


        const mobile =
            document.getElementById('certMobile');

        if (mobile) {
            mobile.value = student.mobile ?? '';
        }


        const address =
            document.getElementById('certAddress');

        if (address) {
            address.value = student.address ?? '';
        }

    } else {

        console.warn(
            'Student not found for editingId:',
            editingId
        );

    }

    // --------------------------------------------------
    // 9. Open custom modal
    // --------------------------------------------------
    modal.classList.add('open');

    // Make sure inline display doesn't prevent it
    modal.style.display = 'flex';

    // Prevent background page scrolling
    document.body.style.overflow = 'hidden';

    console.log(
        'Certification modal opened for student:',
        editingId
    );
}

/* =========================================================
   EDIT CERTIFICATION
========================================================= */

function editCertification(id) {

    const student =
        students.find(
            s => Number(s.id) ===
                Number(editingId)
        );


    if (!student) {
        return;
    }


    const certifications =
        student.certifications ?? [];


    const cert =
        certifications.find(
            c => Number(c.id) ===
                Number(id)
        );


    if (!cert) {

        alert(
            'Certification not found.'
        );

        return;
    }


    editingCertificationId =
        cert.id;


    document.getElementById(
        'certificationModalTitle'
    ).textContent =
        'Edit Certification';


    document.getElementById(
        'certTrainerName'
    ).value =
        cert.trainer_name ?? '';


    document.getElementById(
        'certCertificateDate'
    ).value =
        cert.certificate_date ?? '';


    document.getElementById(
        'certLevel'
    ).value =
        cert.level ?? '';


    document.getElementById(
        'certStudentName'
    ).value =
        cert.student_name ??
        student.name ??
        '';


    document.getElementById(
        'certParentsName'
    ).value =
        cert.parents_name ?? '';


    document.getElementById(
        'certMobile'
    ).value =
        cert.mobile_no ??
        student.mobile ??
        '';


    document.getElementById(
        'certExamDate'
    ).value =
        cert.exam_date ?? '';


    document.getElementById(
        'certScore'
    ).value =
        cert.score ?? '';


    document.getElementById(
        'certResult'
    ).value =
        cert.result ?? '';


    document.getElementById(
        'certAddress'
    ).value =
        cert.address ??
        student.address ??
        '';


    document.getElementById(
        'certReceiverContact'
    ).value =
        cert.receiver_contact ?? '';


    document.getElementById(
        'certDispatchDate'
    ).value =
        cert.dispatch_date ?? '';


    document.getElementById(
        'certDispatchId'
    ).value =
        cert.dispatch_id ?? '';


    document.getElementById(
        'certReceivedDate'
    ).value =
        cert.received_date ?? '';


    document.getElementById(
        'certDownloadType'
    ).value =
        cert.download_type ?? '';


    document.getElementById(
        'certRemark'
    ).value =
        cert.remark ?? '';


    /* Reset file fields */

    document.getElementById(
        'certAddressImage'
    ).value = '';


    document.getElementById(
        'certCertificateImage'
    ).value = '';


    document.getElementById(
        'certificationModal'
    ).classList.add('open');
}


/* =========================================================
   CLEAR CERTIFICATION FORM
========================================================= */

function clearCertificationForm() {

    document.getElementById('certTrainerName').value = '';

    document.getElementById('certCertificateDate').value = '';

    document.getElementById('certLevel').value = '';

    document.getElementById('certStudentName').value = '';

    document.getElementById('certParentsName').value = '';

    document.getElementById('certMobile').value = '';

    document.getElementById('certExamDate').value = '';

    document.getElementById('certScore').value = '';

    document.getElementById('certResult').value = '';

    document.getElementById('certAddress').value = '';

    document.getElementById('certReceiverName').value = '';

    document.getElementById('certReceiverContact').value = '';

    document.getElementById('certDispatchDate').value = '';

    document.getElementById('certDispatchId').value = '';

   

    document.getElementById('certReceivedDate').value = '';

    document.getElementById('certRemark').value = '';

    document.getElementById('certAddressImage').value = '';

    document.getElementById('certCertificateImage').value = '';
}

/* =========================================================
   SAVE CERTIFICATION
========================================================= */

async function saveCertification() {

    if (!editingId) {
        alert('Please save the student first.');
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Helper
    |--------------------------------------------------------------------------
    */

    function getValue(id) {

        const element = document.getElementById(id);

        if (!element) {
            console.error(
                `Certification field not found: #${id}`
            );

            throw new Error(
                `Field #${id} is missing from the certification modal.`
            );
        }

        return element.value ?? '';
    }


    function getFile(id) {

        const element = document.getElementById(id);

        if (!element) {
            console.error(
                `Certification file field not found: #${id}`
            );

            throw new Error(
                `File field #${id} is missing from the certification modal.`
            );
        }

        return element.files && element.files.length
            ? element.files[0]
            : null;
    }


    /*
    |--------------------------------------------------------------------------
    | Create FormData
    |--------------------------------------------------------------------------
    */

    const formData = new FormData();

    formData.append(
        'save_certification',
        '1'
    );


    /*
    |--------------------------------------------------------------------------
    | Certification ID
    |--------------------------------------------------------------------------
    */

    if (editingCertificationId) {

        formData.append(
            'certification_id',
            editingCertificationId
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Certification Details
    |--------------------------------------------------------------------------
    */

    formData.append(
        'abacus_trainer_name',
        getValue('certTrainerName')
    );

    formData.append(
        'certificate_date',
        getValue('certCertificateDate')
    );

    formData.append(
        'level',
        getValue('certLevel')
    );

    formData.append(
        'student_name',
        getValue('certStudentName')
    );

    formData.append(
        'parents_name',
        getValue('certParentsName')
    );

    formData.append(
        'mobile_no',
        getValue('certMobile')
    );

    formData.append(
        'exam_date',
        getValue('certExamDate')
    );

    formData.append(
        'score',
        getValue('certScore')
    );

    formData.append(
        'result',
        getValue('certResult')
    );

    formData.append(
        'address',
        getValue('certAddress')
    );

    formData.append(
        'receiver_name',
        getValue('certReceiverName')
    );

    formData.append(
        'receiver_contact',
        getValue('certReceiverContact')
    );


    /*
    |--------------------------------------------------------------------------
    | Dispatch Details
    |--------------------------------------------------------------------------
    */

    formData.append(
        'dispatched_date',
        getValue('certDispatchDate')
    );

    formData.append(
        'dispatched_id',
        getValue('certDispatchId')
    );



    formData.append(
        'received_date',
        getValue('certReceivedDate')
    );

    formData.append(
        'remark',
        getValue('certRemark')
    );


    /*
    |--------------------------------------------------------------------------
    | Images
    |--------------------------------------------------------------------------
    */

    const addressImage =
        getFile('certAddressImage');

    if (addressImage) {

        formData.append(
            'address_image',
            addressImage
        );
    }


    const certificateImage =
        getFile('certCertificateImage');

    if (certificateImage) {

        formData.append(
            'certificate_image',
            certificateImage
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Laravel PUT Method Spoofing
    |--------------------------------------------------------------------------
    */

    formData.append(
        '_method',
        'PUT'
    );


    /*
    |--------------------------------------------------------------------------
    | Submit
    |--------------------------------------------------------------------------
    */

    try {

        const url =
            `/admin/students/${editingId}`;

        console.log(
            'Saving certification...',
            url
        );


        const res = await fetch(url, {

            method: 'POST',

            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },

            body: formData

        });


        /*
        |--------------------------------------------------------------------------
        | Read Response
        |--------------------------------------------------------------------------
        */

        const contentType =
            res.headers.get('content-type') || '';

        let data;

        if (contentType.includes('application/json')) {

            data = await res.json();

        } else {

            const text = await res.text();

            console.error(
                'Non JSON response:',
                text
            );

            throw new Error(
                'Server returned an invalid response.'
            );
        }


        console.log(
            'Certification response:',
            data
        );


        /*
        |--------------------------------------------------------------------------
        | Laravel Error
        |--------------------------------------------------------------------------
        */

        if (!res.ok) {

            console.error(
                'Certification error:',
                data
            );


            if (data.errors) {

                const messages =
                    Object.values(data.errors)
                        .flat()
                        .join('\n');

                throw new Error(messages);
            }


            throw new Error(
                data.message ||
                'Unable to save certification.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Update Local Student
        |--------------------------------------------------------------------------
        */

        const student =
            students.find(
                s =>
                    Number(s.id) ===
                    Number(editingId)
            );


        if (student) {

            student.certifications =
                data.certifications || [];

            if (
                typeof renderCertifications ===
                'function'
            ) {

                renderCertifications(
                    student.certifications
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Close Modal
        |--------------------------------------------------------------------------
        */

        closeCertificationModal();


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        alert(
            data.message ||
            'Certification saved successfully.'
        );


    } catch (error) {

        console.error(
            'Certification Error:',
            error
        );


        alert(
            error.message ||
            'Something went wrong while saving certification.'
        );
    }
}
/* =========================================================
   CLOSE CERTIFICATION MODAL
========================================================= */

function closeCertificationModal() {

    document.getElementById(
        'certificationModal'
    ).classList.remove('open');

    editingCertificationId = null;
}


function handleCertificationBackdropClick(e) {

    if (
        e.target ===
        document.getElementById(
            'certificationModal'
        )
    ) {

        closeCertificationModal();
    }
}


/* =========================================================
   DELETE CERTIFICATION
========================================================= */

async function deleteCertification(id) {

    if (!confirm(
        'Are you sure you want to delete this certification?'
    )) {

        return;
    }


    try {

        const res =
            await fetch(
                `/admin/student-certifications/${id}`,
                {

                    method: 'DELETE',

                    headers: {

                        'X-CSRF-TOKEN':
                            CSRF,

                        'Accept':
                            'application/json'

                    }

                }
            );


        const data =
            await res.json();


        if (!res.ok) {

            throw new Error(
                data.message ??
                'Unable to delete certification.'
            );
        }


        /* Find student */

        const student =
            students.find(
                s => Number(s.id) ===
                    Number(editingId)
            );


        if (student) {

            student.certifications =
                (
                    student.certifications ?? []
                ).filter(
                    cert =>
                        Number(cert.id) !==
                        Number(id)
                );


            renderCertifications(
                student.certifications
            );
        }


        alert(
            data.message ??
            'Certification deleted successfully.'
        );


    } catch (error) {

        console.error(error);

        alert(
            error.message ??
            'Unable to delete certification.'
        );
    }
}


/* =========================================================
   DELETE STUDENT
========================================================= */

function openDeleteModal(id) {

    deletingId = id;

    document.getElementById(
        'deleteModal'
    ).classList.add('open');
}


function closeDeleteModal() {

    deletingId = null;

    document.getElementById(
        'deleteModal'
    ).classList.remove('open');
}


function handleDeleteBackdropClick(e) {

    if (
        e.target ===
        document.getElementById(
            'deleteModal'
        )
    ) {

        closeDeleteModal();
    }
}


/* =========================================================
   CONFIRM DELETE STUDENT
========================================================= */

async function confirmDelete() {

    if (!deletingId) {
        return;
    }


    try {

        const res =
            await fetch(
                `/admin/students/${deletingId}`,
                {

                    method: 'DELETE',

                    headers: {

                        'X-CSRF-TOKEN':
                            CSRF,

                        'Accept':
                            'application/json'

                    }

                }
            );


        const data =
            await res.json();


        if (!res.ok) {

            throw new Error(
                data.message ??
                'Unable to delete student.'
            );
        }


        students =
            students.filter(
                s =>
                    Number(s.id) !==
                    Number(deletingId)
            );


        currentPage = 1;


        render(students);


        closeDeleteModal();


        alert(
            data.message ??
            'Student deleted successfully.'
        );


    } catch (error) {

        console.error(error);

        alert(
            error.message ??
            'Unable to delete student.'
        );
    }
}


/* =========================================================
   HTML ESCAPE
========================================================= */

function escHtml(str) {

    return String(str ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}


/* =========================================================
   INITIAL RENDER
========================================================= */

render(students);

</script>
@endsection