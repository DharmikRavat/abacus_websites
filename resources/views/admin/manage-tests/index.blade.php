@extends('admin.layout.app')

@section('content')

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">

    <div>
        <h1>Manage Tests</h1>
        <p>Create and manage exam schedules</p>
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

        Schedule Test

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
               placeholder="Search Tests..."
               oninput="filterSchedules(this.value)">

        <span id="schedule-count"
              style="font-size:12px;color:var(--faint);white-space:nowrap">
        </span>

    </div>

    <div style="overflow-x:auto">

        <table class="roles-table">

            <thead>

                <tr>

                    <th>#</th>
                    <th>Type</th>
                    <th>Level</th>
                    <th>Exam Type</th>
                    <th>Date</th>
                    <th>Questions</th>
                    <th>Duration</th>
                    <th>Password</th>
                    <th>Created</th>
                    <th style="text-align:right">Actions</th>

                </tr>

            </thead>

            <tbody id="scheduleBody"></tbody>

        </table>

        {{-- EMPTY STATE --}}
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

                <path d="M9.09 9a3 3 0 1 1 5.82 1
                         c0 2-3 3-3 3"/>

                <line x1="12" y1="17" x2="12.01" y2="17"/>

            </svg>

            <p>No schedules found</p>

            <span>
                Try a different search or create a new schedule
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
                Schedule Test
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

            {{-- TEST TYPE --}}
            <div class="form-group">

                <label class="form-label">
                    Select Type
                </label>

                <div class="d-flex gap-4 mt-2">

                    <label>
                        <input type="radio"
                               name="test_type"
                               value="test">

                        Test
                    </label>

                    <label>
                        <input type="radio"
                               name="test_type"
                               value="exam">

                        Exam
                    </label>

                </div>

            </div>

            {{-- LEVEL --}}
            <div class="form-group">

                <label class="form-label">
                    Exam Level
                </label>

                <select id="examLevel"
                        class="form-control">

                    @for($i = 0; $i <= 10; $i++)

                        <option value="Level {{ $i }}">
                            Level {{ $i }}
                        </option>

                    @endfor

                </select>

            </div>

            {{-- DATE --}}
            <div class="form-group">

                <label class="form-label">
                    Schedule Date
                </label>

                <input type="date"
                       id="scheduleDate"
                       class="form-control">

            </div>

            {{-- EXAM TYPE --}}
            <div class="form-group">

                <label class="form-label">
                    Schedule Type
                </label>

                <select id="scheduleExamType"
                        class="form-control">

                    <option value="">
                        Select Type
                    </option>

                </select>

            </div>

            {{-- QUESTIONS --}}
            <div class="form-group">

                <label class="form-label">
                    No Of Questions
                </label>

                <input type="number"
                       id="noOfQuestions"
                       class="form-control">

            </div>

            {{-- DURATION --}}
            <div class="form-group">

                <label class="form-label">
                    Duration (Minutes)
                </label>

                <input type="number"
                       id="scheduleTime"
                       class="form-control">

            </div>

            {{-- PASSWORD --}}
            <div class="form-group">

                <label class="form-label">
                    Schedule Password
                </label>

                <input type="text"
                       id="schedulePassword"
                       class="form-control">

            </div>

        </div>

        <div class="modal-footer">

            <button class="btn btn-ghost"
                    onclick="closeFormModal()">

                Cancel

            </button>

            <button class="btn btn-primary"
                    id="saveBtn"
                    onclick="saveSchedule()">

                <span class="btn-label">
                    Save Schedule
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

                🗑️

            </div>

            <h3>Delete Schedule?</h3>

            <p>
                Are you sure you want to delete this schedule?
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

@endsection

@section('script')

<script>
let schedules = @json($schedules ?? []);
let editingId   = null;
let deletingId  = null;

const CSRF =
    document.querySelector('meta[name="csrf-token"]')?.content ?? '';

/* =====================================================
   FORMAT DATE
===================================================== */

function formatDate(str) {

    if (!str) return '-';

    return new Date(str).toLocaleDateString('en-US', {

        month : 'short',
        day   : 'numeric',
        year  : 'numeric'

    });
}

/* =====================================================
   RENDER
===================================================== */

function render(list) {

    const tbody =
        document.getElementById('scheduleBody');

    const empty =
        document.getElementById('emptyState');

    document.getElementById('schedule-count').textContent =
        list.length + ' Schedule' + (list.length !== 1 ? 's' : '');

    if (!list.length) {

        tbody.innerHTML = '';

        empty.style.display = 'block';

        return;
    }

    empty.style.display = 'none';

    tbody.innerHTML = list.map((s, i) => {

        return `

            <tr>

                <td>${i + 1}</td>

                <td>
                     <strong>${escHtml(s.test_type)}</strong>
                </td>

                <td>
                    ${escHtml(s.exam_level)}
                </td>

                <td>
                    ${escHtml(s.schedule_exam_type)}
                </td>

                <td>
                    ${formatDate(s.schedule_date)}
                </td>

                <td>
                    ${s.no_of_questions}
                </td>

                <td>
                    ${s.schedule_time} Min
                </td>

                <td>
                    ${escHtml(s.schedule_password)}
                </td>

                <td>
                    ${formatDate(s.created_at)}
                </td>

                <td>

                    <div class="actions-cell"
                         style="justify-content:flex-end;gap:10px">

        {{-- Share --}}
        <button class="btn-icon"
                title="Share"
                onclick="shareSchedule(${s.id})">
            <svg width="16"
                 height="16"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">

                <circle cx="18" cy="5" r="3"/>
                <circle cx="6" cy="12" r="3"/>
                <circle cx="18" cy="19" r="3"/>

                <line x1="8.59" y1="13.51"
                      x2="15.42" y2="17.49"/>

                <line x1="15.41" y1="6.51"
                      x2="8.59" y2="10.49"/>

            </svg>
        </button>


                        <button class="btn-icon"
                                onclick="openEditModal(${s.id})">

                            ✏️

                        </button>

                        <button class="btn-icon"
                                style="color:red"
                                onclick="openDeleteModal(${s.id})">

                            🗑️

                        </button>

                    </div>

                </td>

            </tr>

        `;

    }).join('');
}

/* =====================================================
   SEARCH
===================================================== */

function filterSchedules(value) {

    value = value.toLowerCase();

    const filtered = schedules.filter(item =>

        item.test_type.toLowerCase().includes(value) ||
        item.exam_level.toLowerCase().includes(value)

    );

    render(filtered);
}

/* =====================================================
   CREATE MODAL
===================================================== */

function openCreateModal() {

    editingId = null;

    clearForm();

    document.getElementById('modalTitle').textContent =
        'Schedule Test';

    document.querySelector('#saveBtn .btn-label').textContent =
        'Save Schedule';

    document.getElementById('formModal')
        .classList.add('open');
}

/* =====================================================
   EDIT MODAL
===================================================== */

function openEditModal(id) {

    const schedule =
        schedules.find(x => x.id === id);

    if (!schedule) return;

    editingId = id;

    document.getElementById('modalTitle').textContent =
        'Edit Schedule';

    document.querySelector('#saveBtn .btn-label').textContent =
        'Update Schedule';

    document.querySelector(
        `input[name="test_type"][value="${schedule.test_type}"]`
    ).checked = true;

    document.getElementById('examLevel').value =
        schedule.exam_level;

    document.getElementById('scheduleDate').value =
        schedule.schedule_date;

    document.getElementById('scheduleExamType').innerHTML =
        `<option value="${schedule.schedule_exam_type}">
            ${schedule.schedule_exam_type}
        </option>`;

    document.getElementById('scheduleExamType').value =
        schedule.schedule_exam_type;

    document.getElementById('noOfQuestions').value =
        schedule.no_of_questions;

    document.getElementById('scheduleTime').value =
        schedule.schedule_time;

    document.getElementById('schedulePassword').value =
        schedule.schedule_password;

    document.getElementById('formModal')
        .classList.add('open');
}

/* =====================================================
   SAVE
===================================================== */

async function saveSchedule() {

    const payload = {

        test_type:
            document.querySelector('input[name="test_type"]:checked')?.value,

        exam_level:
            document.getElementById('examLevel').value,

        schedule_date:
            document.getElementById('scheduleDate').value,

        schedule_exam_type:
            document.getElementById('scheduleExamType').value,

        no_of_questions:
            document.getElementById('noOfQuestions').value,

        schedule_time:
            document.getElementById('scheduleTime').value,

        schedule_password:
            document.getElementById('schedulePassword').value

    };

    const url =
        editingId
            ? `/admin/manage-tests/${editingId}`
            : `/admin/manage-tests`;

    const method =
        editingId
            ? 'PUT'
            : 'POST';

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

    if (!res.ok) {

        alert(data.message ?? 'Something went wrong');

        return;
    }

    location.reload();
}

/* =====================================================
   DELETE
===================================================== */

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

    if (e.target ===
        document.getElementById('deleteModal')) {

        closeDeleteModal();
    }
}

async function confirmDelete() {

    const res = await fetch(`/admin/manage-tests/${deletingId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': CSRF,
            'Accept': 'application/json'
        }
    });

    const data = await res.json();

    console.log(data);

    if (!res.ok) {
        alert(data.message || 'Delete failed');
        return;
    }

    location.reload();
}
/* =====================================================
   CLOSE MODAL
===================================================== */

function closeFormModal() {

    document.getElementById('formModal')
        .classList.remove('open');

    clearForm();
}

function handleBackdropClick(e) {

    if (e.target ===
        document.getElementById('formModal')) {

        closeFormModal();
    }
}

/* =====================================================
   CLEAR FORM
===================================================== */

function clearForm() {

    document.querySelectorAll('input[name="test_type"]')
        .forEach(el => el.checked = false);

    document.getElementById('examLevel').value = '';
    document.getElementById('scheduleDate').value = '';
    document.getElementById('scheduleExamType').innerHTML =
        '<option value="">Select Type</option>';

    document.getElementById('noOfQuestions').value = '';
    document.getElementById('scheduleTime').value = '';
    document.getElementById('schedulePassword').value = '';
}

/* =====================================================
   DYNAMIC EXAM TYPE
===================================================== */

document.querySelectorAll('input[name="test_type"]')
    .forEach(radio => {

        radio.addEventListener('change', function () {

            const typeSelect =
                document.getElementById('scheduleExamType');

            typeSelect.innerHTML = this.value === 'test'
                ? `
                    <option value="weekly_test">
                        Weekly Test
                    </option>

                    <option value="monthly_test">
                        Monthly Test
                    </option>
                  `
                : `
                    <option value="olympiad">
                        Olympiad
                    </option>

                    <option value="final_exam">
                        Final Exam
                    </option>
                  `;
        });
    });
/* =====================================================
   SHARE SCHEDULE
===================================================== */

async function shareSchedule(id) {

    const schedule = schedules.find(x => x.id === id);

    if (!schedule) {
        alert('Schedule not found');
        return;
    }

    const shareUrl =
        `https://abacus.moyalr.com/`;

const shareText = `
Test: ${schedule.test_type}
Level: ${schedule.exam_level}
Exam Type: ${schedule.schedule_exam_type
    .replace(/_/g, ' ')
    .replace(/\b\w/g, char => char.toUpperCase())}
Date: ${formatDate(schedule.schedule_date)}
Questions: ${schedule.no_of_questions}
Duration: ${schedule.schedule_time} Minutes
Password: ${schedule.schedule_password}
`.trim();

    /* Native Share */
    if (navigator.share) {

        try {

            await navigator.share({
                title: `${schedule.test_type} - ${schedule.exam_level}`,
                text: shareText,
                url: shareUrl
            });

        } catch (error) {

            // User cancelled sharing
            if (error.name !== 'AbortError') {
                console.error('Share failed:', error);
            }

        }

        return;
    }

    /* Desktop fallback - Copy to clipboard */

    const copyText =
        `${shareText}\n\nOpen Test:\n${shareUrl}`;

    try {

        await navigator.clipboard.writeText(copyText);

        alert('Test details copied to clipboard!');

    } catch (error) {

        // Older browser fallback
        const textarea = document.createElement('textarea');

        textarea.value = copyText;

        document.body.appendChild(textarea);

        textarea.select();

        document.execCommand('copy');

        textarea.remove();

        alert('Test details copied to clipboard!');

    }
}

/* =====================================================
   HELPERS
===================================================== */

function escHtml(str) {

    return String(str ?? '')
        .replace(/&/g,'&amp;')
        .replace(/</g,'&lt;')
        .replace(/>/g,'&gt;')
        .replace(/"/g,'&quot;');
}

/* =====================================================
   ESC KEY
===================================================== */

document.addEventListener('keydown', e => {

    if (e.key === 'Escape') {

        closeFormModal();

        closeDeleteModal();
    }
});

/* =====================================================
   INIT
===================================================== */

render(schedules);

</script>

@endsection