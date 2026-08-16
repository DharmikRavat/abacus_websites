@extends('admin.layout.app')

@section('content')

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">
    <div>
        <h1>Attendance</h1>
        <p>Manage student attendance records</p>
    </div>

<div style="display:flex;gap:10px;align-items:center;">
 <button class="btn btn-primary"
            onclick="openMonthlyReportModal()">

     Monthly Attendance

    </button>
    <button class="btn btn-primary" onclick="openCreateModal()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>

        Mark Attendance
    </button>
    </div>
</div>

{{-- ═══════════ TABLE CARD ═══════════ --}}
<div class="card">

    <div class="search-bar">

        <svg width="15" height="15" viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2"
             style="color:var(--faint);flex-shrink:0">

            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>

        </svg>

        <input type="text"
               id="searchInput"
               placeholder="Search student..."
               oninput="filterAttendance(this.value)">

        <span id="attendance-count"
              style="font-size:12px;color:var(--faint);white-space:nowrap">
        </span>

    </div>

    <div style="overflow-x:auto">

        <table class="roles-table">

            <thead>

                <tr>

                    <th>#</th>
                    <th>Student</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Remark</th>
                    <th>Marked By</th>
                    <th>Created</th>
                    <th style="text-align:right">Actions</th>

                </tr>

            </thead>

            <tbody id="attendanceBody"></tbody>

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

                <path d="M9 12l2 2 4-4"/>

            </svg>

            <p>No Attendance Found</p>

            <span>
                Create attendance records
            </span>

        </div>

    </div>
</div>

{{-- ═══════════ CREATE / EDIT MODAL ═══════════ --}}
<div class="modal-backdrop"
     id="formModal"
     onclick="handleBackdropClick(event)">

    <div class="modal">

        <div class="modal-header">

            <h2 id="modalTitle">
                Mark Attendance
            </h2>

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

            {{-- Student --}}
            <div class="form-group">

                <label class="form-label">
                    Student *
                </label>

                <select id="student_id"
                        class="form-control">

                    <option value="">
                        Select Student
                    </option>

                    @foreach($students as $student)

                        <option value="{{ $student->id }}">
                            {{ $student->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Date --}}
            <div class="form-group">

                <label class="form-label">
                    Attendance Date *
                </label>

                <input type="date"
                       id="attendance_date"
                       class="form-control">

            </div>

            {{-- Status --}}
            <div class="form-group">

                <label class="form-label">
                    Status *
                </label>

                <select id="status"
                        class="form-control">

                    <option value="P">Present</option>
                    <option value="A">Absent</option>
                    <option value="H">Holiday</option>
                    <option value="E">Extra Class</option>
                    <option value="L">Leave</option>

                </select>

            </div>

            {{-- Remark --}}
            <div class="form-group">

                <label class="form-label">
                    Remark
                </label>

                <textarea id="remark"
                          rows="3"
                          class="form-control"
                          placeholder="Optional remark"></textarea>

            </div>

        </div>

        <div class="modal-footer">

            <button class="btn btn-ghost"
                    onclick="closeFormModal()">

                Cancel

            </button>

            <button class="btn btn-primary"
                    id="saveBtn"
                    onclick="saveAttendance()">

                <span class="spinner"></span>

                <span class="btn-label">
                    Save Attendance
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

            <h3>Delete Attendance?</h3>

            <p>
                This action cannot be undone.
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


{{-- ═══════════════════════════════════════════════
     MONTHLY ATTENDANCE MODAL
═══════════════════════════════════════════════ --}}

<div class="modal-backdrop"
     id="monthlyReportModal"
     onclick="handleMonthlyReportBackdrop(event)">

    <div class="modal"
         style="max-width:450px;">

        <div class="modal-header">

            <h2>
                Monthly Attendance Report
            </h2>

            <button class="btn-icon"
                    onclick="closeMonthlyReportModal()">

                ✕

            </button>

        </div>

        <div class="modal-body">

            <div style="
                padding:12px;
                margin-bottom:18px;
                border-radius:8px;
                background:var(--surface);
                border:1px solid var(--border);
                font-size:13px;
                line-height:1.5;
            ">

                Select the start and end date.

                <br>

                <strong>
                    Both dates must be from the same month.
                </strong>

            </div>

            {{-- Start Date --}}
            <div class="form-group">

                <label class="form-label">
                    Start Date *
                </label>

                <input
                    type="date"
                    id="monthly_start_date"
                    class="form-control"
                >

            </div>

            {{-- End Date --}}
            <div class="form-group">

                <label class="form-label">
                    End Date *
                </label>

                <input
                    type="date"
                    id="monthly_end_date"
                    class="form-control"
                >

            </div>

        </div>

        <div class="modal-footer">

            <button class="btn btn-ghost"
                    onclick="closeMonthlyReportModal()">

                Cancel

            </button>

            <button class="btn btn-primary"
                    onclick="generateMonthlyReport()">

                📊 Generate Report

            </button>

        </div>

    </div>

</div>

<script>

let attendances = @json($attendances);
let editingId = null;
let deletingId = null;

const CSRF =
    document.querySelector('meta[name="csrf-token"]')?.content ?? '';

function formatDate(date) {

    if (!date) return '—';

    return new Date(date).toLocaleDateString('en-US', {
        month:'short',
        day:'numeric',
        year:'numeric'
    });
}

// ─────────────────────────────────────
// Render
// ─────────────────────────────────────
function render(list) {

    const tbody = document.getElementById('attendanceBody');
    const empty = document.getElementById('emptyState');

    document.getElementById('attendance-count').textContent =
        list.length + ' Record' + (list.length != 1 ? 's' : '');

    if (!list.length) {

        tbody.innerHTML = '';

        empty.style.display = 'block';

        return;
    }

    empty.style.display = 'none';

    tbody.innerHTML = list.map((item, i) => {

        return `
        <tr>

            <td>${i + 1}</td>

            <td>
                ${item.student?.name ?? '—'}
            </td>

            <td>
                ${formatDate(item.attendance_date)}
            </td>

            <td>
                <span class="badge">
                    ${item.status}
                </span>
            </td>

            <td>
                ${item.remark ?? '—'}
            </td>

            <td>
                ${item.marked_by?.name ?? '—'}
            </td>

            <td>
                ${formatDate(item.created_at)}
            </td>

            <td>

                <div class="actions-cell"
                     style="justify-content:flex-end">

                    {{-- Edit --}}
                    <button class="btn-icon"
                            onclick="openEditModal(${item.id})">

                        ✏️

                    </button>

                    {{-- Delete --}}
                    <button class="btn-icon"
                            style="color:red"
                            onclick="openDeleteModal(${item.id})">

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
function filterAttendance(q) {

    q = q.toLowerCase();

    render(
        attendances.filter(item =>
            (item.student?.name ?? '')
                .toLowerCase()
                .includes(q)
        )
    );
}

// ─────────────────────────────────────
// Create Modal
// ─────────────────────────────────────
function openCreateModal() {

    editingId = null;

    document.getElementById('modalTitle').textContent =
        'Mark Attendance';

    document.getElementById('student_id').value = '';
    document.getElementById('attendance_date').value = '';
    document.getElementById('status').value = 'P';
    document.getElementById('remark').value = '';

    document.querySelector('#saveBtn .btn-label').textContent =
        'Save Attendance';

    document.getElementById('formModal').classList.add('open');
}

// ─────────────────────────────────────
// Edit
// ─────────────────────────────────────
function openEditModal(id) {

    const item = attendances.find(x => Number(x.id) === Number(id));

    if (!item) {
        console.error('Attendance record not found:', id);
        return;
    }

    editingId = item.id;

    document.getElementById('modalTitle').textContent =
        'Edit Attendance';

    // Student
    document.getElementById('student_id').value =
        item.student_id ?? '';

    // Attendance Date
    let attendanceDate = item.attendance_date ?? '';

    /*
    |--------------------------------------------------------------------------
    | Convert Laravel date to YYYY-MM-DD
    |--------------------------------------------------------------------------
    |
    | Examples:
    | 2026-07-01
    | 2026-07-01T00:00:00.000000Z
    | 2026-07-01 00:00:00
    |
    */

    if (attendanceDate) {
        attendanceDate = String(attendanceDate).substring(0, 10);
    }

    document.getElementById('attendance_date').value =
        attendanceDate;

    // Status
    document.getElementById('status').value =
        item.status ?? 'P';

    // Remark
    document.getElementById('remark').value =
        item.remark ?? '';

    document.querySelector('#saveBtn .btn-label').textContent =
        'Update Attendance';

    document.getElementById('formModal').classList.add('open');

    console.log('Editing attendance:', item);
    console.log('Date:', attendanceDate);
}
function closeFormModal() {

    document.getElementById('formModal')
        .classList.remove('open');
}

function handleBackdropClick(e) {

    if (e.target.id === 'formModal') {
        closeFormModal();
    }
}

// ─────────────────────────────────────
// Save
// ─────────────────────────────────────
async function saveAttendance() {

    const student_id =
        document.getElementById('student_id').value;

    const attendance_date =
        document.getElementById('attendance_date').value;

    const status =
        document.getElementById('status').value;

    const remark =
        document.getElementById('remark').value;

    if (!student_id || !attendance_date) {

        alert('Please fill all required fields');

        return;
    }

    const url =
        editingId
            ? `/admin/attendance/${editingId}`
            : `/admin/attendance`;

    const method =
        editingId
            ? 'PUT'
            : 'POST';

    try {

        const res = await fetch(url, {

            method,

            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':CSRF,
                'Accept':'application/json'
            },

            body: JSON.stringify({
                student_id,
                attendance_date,
                status,
                remark
            })

        });

        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message ?? 'Failed');
        }

        if (editingId) {

            const index =
                attendances.findIndex(x => x.id === editingId);

            attendances[index] = data.attendance;

        } else {

            attendances.unshift(data.attendance);
        }

        render(attendances);

        closeFormModal();

        alert(data.message);

    } catch(err) {

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

function handleDeleteBackdropClick(e) {

    if (e.target.id === 'deleteModal') {
        closeDeleteModal();
    }
}

async function confirmDelete() {

    if (!deletingId) return;

    try {

        const res = await fetch(
            `/admin/attendance/${deletingId}`,
            {
                method:'DELETE',
                headers:{
                    'X-CSRF-TOKEN':CSRF,
                    'Accept':'application/json'
                }
            }
        );

        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message ?? 'Failed');
        }

        attendances =
            attendances.filter(x => x.id !== deletingId);

        render(attendances);

        closeDeleteModal();

        alert(data.message);

    } catch(err) {

        alert(err.message);
    }
}

document.addEventListener('keydown', e => {

    if (e.key === 'Escape') {

        closeFormModal();
        closeDeleteModal();
    }
});



// ═══════════════════════════════════════════════
// MONTHLY ATTENDANCE REPORT
// ═══════════════════════════════════════════════

function openMonthlyReportModal() {

    const now = new Date();

    const year = now.getFullYear();

    const month =
        String(now.getMonth() + 1)
            .padStart(2, '0');

    /*
    |--------------------------------------------------------------------------
    | First day of current month
    |--------------------------------------------------------------------------
    */

    const firstDay =
        `${year}-${month}-01`;

    /*
    |--------------------------------------------------------------------------
    | Last day of current month
    |--------------------------------------------------------------------------
    */

    const lastDayNumber =
        new Date(
            year,
            now.getMonth() + 1,
            0
        ).getDate();

    const lastDay =
        `${year}-${month}-${String(lastDayNumber).padStart(2, '0')}`;

    document.getElementById(
        'monthly_start_date'
    ).value = firstDay;

    document.getElementById(
        'monthly_end_date'
    ).value = lastDay;

    document.getElementById(
        'monthlyReportModal'
    ).classList.add('open');
}


function closeMonthlyReportModal() {

    document.getElementById(
        'monthlyReportModal'
    ).classList.remove('open');
}


function handleMonthlyReportBackdrop(event) {

    if (
        event.target.id ===
        'monthlyReportModal'
    ) {
        closeMonthlyReportModal();
    }
}


function generateMonthlyReport() {

    const startDate =
        document.getElementById(
            'monthly_start_date'
        ).value;

    const endDate =
        document.getElementById(
            'monthly_end_date'
        ).value;


    if (!startDate || !endDate) {

        alert(
            'Please select Start Date and End Date.'
        );

        return;
    }


    if (startDate > endDate) {

        alert(
            'Start Date cannot be greater than End Date.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Check same month
    |--------------------------------------------------------------------------
    */

    const start =
        new Date(startDate + 'T00:00:00');

    const end =
        new Date(endDate + 'T00:00:00');


    if (
        start.getMonth() !== end.getMonth() ||
        start.getFullYear() !== end.getFullYear()
    ) {

        alert(
            'Start Date and End Date must be from the same month.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Build URL
    |--------------------------------------------------------------------------
    */

    const url =
        '/admin/attendance/monthly-report' +
        '?start_date=' +
        encodeURIComponent(startDate) +
        '&end_date=' +
        encodeURIComponent(endDate);


    /*
    |--------------------------------------------------------------------------
    | Open report in NEW TAB
    |--------------------------------------------------------------------------
    */

    window.open(
        url,
        '_blank'
    );


    closeMonthlyReportModal();
}

render(attendances);

</script>

@endsection