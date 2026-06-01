@extends('admin.layout.app')

@section('content')

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">

    <div>
        <h1>Certification Management</h1>
        <p>Create and manage student certifications</p>
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

        New Certificate

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
               placeholder="Search certificates..."
               oninput="filterCertificates(this.value)">

        <span id="certificate-count"
              style="font-size:12px;color:var(--faint);white-space:nowrap">
        </span>

    </div>

    <div style="overflow-x:auto">

        <table class="roles-table">

            <thead>

                <tr>

                    <th>#</th>
                    <th>Student</th>
                    <th>Parents</th>
                    <th>Mobile</th>
                    <th>Level</th>
                    <th>Score</th>
                    <th>Result</th>
                    <th>Created</th>

                    <th style="text-align:right">
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody id="certificateBody"></tbody>

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

            <p>No Certificates Found</p>

            <span>
                Create your first certification record
            </span>

        </div>

    </div>

</div>

{{-- ═══════════ CREATE / EDIT MODAL ═══════════ --}}
<div class="modal-backdrop"
     id="formModal"
     onclick="handleBackdropClick(event)">

    <div class="modal"
         style="max-width:1000px;width:95%">

        <div class="modal-header">

            <h2 id="modalTitle">
                New Certification
            </h2>

            <button class="btn-icon"
                    onclick="closeFormModal()">

                ✖

            </button>

        </div>

        <div class="modal-body">

            {{-- CERTIFICATION DETAILS --}}
            <div class="section-title">
                Certification Details
            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Trainer Name
                    </label>

                    <input type="text"
                           id="trainer_name"
                           class="form-control">

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Certificate Date
                    </label>

                    <input type="date"
                           id="certificate_date"
                           class="form-control">

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Level
                    </label>

                    <input type="text"
                           id="level"
                           class="form-control">

                </div>

            </div>

            {{-- STUDENT DETAILS --}}
            <div class="section-title">
                Student Details
            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Student Name *
                    </label>

                    <input type="text"
                           id="student_name"
                           class="form-control">

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Parents Name
                    </label>

                    <input type="text"
                           id="parents_name"
                           class="form-control">

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Mobile No.
                    </label>

                    <input type="text"
                           id="mobile_no"
                           class="form-control">

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Exam Date
                    </label>

                    <input type="date"
                           id="exam_date"
                           class="form-control">

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Score
                    </label>

                    <input type="number"
                           id="score"
                           class="form-control">

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Result
                    </label>

                    <select id="result"
                            class="form-control">

                        <option value="">
                            Select Result
                        </option>

                        <option value="Outstanding">
                            Outstanding
                        </option>

                        <option value="Pass">
                            Pass
                        </option>

                        <option value="Fail">
                            Fail
                        </option>

                    </select>

                </div>

            </div>

            {{-- ADDRESS --}}
            <div class="section-title">
                Address Details
            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Address
                    </label>

                    <textarea id="address"
                              class="form-control"
                              rows="3"></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Receiver Contact
                    </label>

                    <input type="text"
                           id="receiver_contact"
                           class="form-control">

                </div>

            </div>

            {{-- FILES --}}
            <div class="section-title">
                Upload Files
            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Address Image
                    </label>

                    <input type="file"
                           id="address_image"
                           class="form-control">

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Certificate Image
                    </label>

                    <input type="file"
                           id="certificate_image"
                           class="form-control">

                </div>

            </div>

            {{-- DISPATCH --}}
            <div class="section-title">
                Dispatch Details
            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Dispatch Date
                    </label>

                    <input type="date"
                           id="dispatch_date"
                           class="form-control">

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Dispatch ID
                    </label>

                    <input type="text"
                           id="dispatch_id"
                           class="form-control">

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Received Date
                    </label>

                    <input type="date"
                           id="received_date"
                           class="form-control">

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Remark
                    </label>

                    <input type="text"
                           id="remark"
                           class="form-control">

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
                    onclick="saveCertificate()">

                <span class="btn-label">
                    Save Certificate
                </span>

            </button>

        </div>

    </div>

</div>

{{-- ═══════════ VIEW MODAL ═══════════ --}}
<div class="modal-backdrop"
     id="viewModal"
     onclick="handleViewBackdrop(event)">

    <div class="modal"
         style="max-width:900px;width:95%">

        <div class="modal-header">

            <h2>
                Certification Details
            </h2>

            <button class="btn-icon"
                    onclick="closeViewModal()">

                ✖

            </button>

        </div>

        <div class="modal-body"
             id="viewContent">

        </div>

    </div>

</div>

<div id="toast-container"></div>

<script>

let certificates = @json($certifications ?? []);

let editingId = null;

const CSRF =
    document.querySelector('meta[name="csrf-token"]')?.content ?? '';

function formatDate(str) {

    if (!str) return '—';

    return new Date(str).toLocaleDateString('en-US', {

        month: 'short',
        day: 'numeric',
        year: 'numeric'

    });
}

// ─────────────────────────────
// Render
// ─────────────────────────────
function render(list) {

    const tbody =
        document.getElementById('certificateBody');

    const empty =
        document.getElementById('emptyState');

    document.getElementById('certificate-count').textContent =
        list.length + ' Certificates';

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
                <strong>${item.student_name ?? ''}</strong>
            </td>

            <td>${item.parents_name ?? '-'}</td>

            <td>${item.mobile_no ?? '-'}</td>

            <td>${item.level ?? '-'}</td>

            <td>${item.score ?? '-'}</td>

            <td>${item.result ?? '-'}</td>

            <td>${formatDate(item.created_at)}</td>

            <td>

                <div class="actions-cell"
                     style="justify-content:flex-end;gap:8px">

<button class="btn-icon"
        title="View Certificate"
        onclick="window.open('/admin/certification/view/${item.id}', '_blank')">

    👁️

</button>

                    <button class="btn-icon"
                            title="Edit"
                            onclick="editCertificate(${item.id})">

                        ✏️

                    </button>

                    <button class="btn-icon"
                            title="Delete"
                            style="color:red"
                            onclick="deleteCertificate(${item.id})">

                        🗑️

                    </button>

                </div>

            </td>

        </tr>

        `;

    }).join('');
}

// ─────────────────────────────
// Search
// ─────────────────────────────
function filterCertificates(q) {

    q = q.toLowerCase();

    render(

        certificates.filter(item =>

            item.student_name?.toLowerCase().includes(q)

        )

    );
}

// ─────────────────────────────
// Open Create Modal
// ─────────────────────────────
function openCreateModal() {

    editingId = null;

    clearForm();

    document.getElementById('modalTitle').innerText =
        'New Certification';

    document.querySelector('#saveBtn .btn-label').innerText =
        'Save Certificate';

    document.getElementById('formModal')
        .classList.add('open');
}

// ─────────────────────────────
// Clear Form
// ─────────────────────────────
function clearForm() {

    document.getElementById('trainer_name').value = '';
    document.getElementById('certificate_date').value = '';
    document.getElementById('level').value = '';
    document.getElementById('student_name').value = '';
    document.getElementById('parents_name').value = '';
    document.getElementById('mobile_no').value = '';
    document.getElementById('exam_date').value = '';
    document.getElementById('score').value = '';
    document.getElementById('result').value = '';
    document.getElementById('address').value = '';
    document.getElementById('receiver_contact').value = '';
    document.getElementById('dispatch_date').value = '';
    document.getElementById('dispatch_id').value = '';
    document.getElementById('received_date').value = '';
    document.getElementById('remark').value = '';

    document.getElementById('address_image').value = '';
    document.getElementById('certificate_image').value = '';
}

// ─────────────────────────────
// Close Modal
// ─────────────────────────────
function closeFormModal() {

    document.getElementById('formModal')
        .classList.remove('open');
}

function handleBackdropClick(e) {

    if (e.target.id === 'formModal') {

        closeFormModal();
    }
}

// ─────────────────────────────
// Save / Update
// ─────────────────────────────
async function saveCertificate() {

    let formData = new FormData();

    formData.append('trainer_name',
        document.getElementById('trainer_name').value);

    formData.append('certificate_date',
        document.getElementById('certificate_date').value);

    formData.append('level',
        document.getElementById('level').value);

    formData.append('student_name',
        document.getElementById('student_name').value);

    formData.append('parents_name',
        document.getElementById('parents_name').value);

    formData.append('mobile_no',
        document.getElementById('mobile_no').value);

    formData.append('exam_date',
        document.getElementById('exam_date').value);

    formData.append('score',
        document.getElementById('score').value);

    formData.append('result',
        document.getElementById('result').value);

    formData.append('address',
        document.getElementById('address').value);

    formData.append('receiver_contact',
        document.getElementById('receiver_contact').value);

    formData.append('dispatch_date',
        document.getElementById('dispatch_date').value);

    formData.append('dispatch_id',
        document.getElementById('dispatch_id').value);

    formData.append('received_date',
        document.getElementById('received_date').value);

    formData.append('remark',
        document.getElementById('remark').value);

    let addressImage =
        document.getElementById('address_image').files[0];

    let certificateImage =
        document.getElementById('certificate_image').files[0];

    if (addressImage) {

        formData.append('address_image', addressImage);
    }

    if (certificateImage) {

        formData.append('certificate_image', certificateImage);
    }

    let url = '/admin/certification';

    if (editingId) {

        url = `/admin/certification/${editingId}`;

        formData.append('_method', 'PUT');
    }

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

            throw new Error(data.message || 'Failed');
        }

        if (editingId) {

            const index =
                certificates.findIndex(x => x.id == editingId);

            if (index !== -1) {

                certificates[index] = data.certification;
            }

            alert('Certificate updated successfully');

        } else {

            certificates.unshift(data.certification);

            alert('Certificate created successfully');
        }

        render(certificates);

        closeFormModal();

    } catch (err) {

        alert(err.message);
    }
}

// ─────────────────────────────
// Edit
// ─────────────────────────────
async function editCertificate(id) {

    try {

        const res =
            await fetch(`/admin/certification/${id}/edit`);

        const data = await res.json();

        if (!data.success) {

            throw new Error(data.message);
        }

        const item = data.certification;

        editingId = item.id;

        document.getElementById('modalTitle').innerText =
            'Update Certification';

        document.querySelector('#saveBtn .btn-label').innerText =
            'Update Certificate';

        document.getElementById('trainer_name').value =
            item.trainer_name ?? '';

        document.getElementById('certificate_date').value =
            item.certificate_date ?? '';

        document.getElementById('level').value =
            item.level ?? '';

        document.getElementById('student_name').value =
            item.student_name ?? '';

        document.getElementById('parents_name').value =
            item.parents_name ?? '';

        document.getElementById('mobile_no').value =
            item.mobile_no ?? '';

        document.getElementById('exam_date').value =
            item.exam_date ?? '';

        document.getElementById('score').value =
            item.score ?? '';

        document.getElementById('result').value =
            item.result ?? '';

        document.getElementById('address').value =
            item.address ?? '';

        document.getElementById('receiver_contact').value =
            item.receiver_contact ?? '';

        document.getElementById('dispatch_date').value =
            item.dispatch_date ?? '';

        document.getElementById('dispatch_id').value =
            item.dispatch_id ?? '';

        document.getElementById('received_date').value =
            item.received_date ?? '';

        document.getElementById('remark').value =
            item.remark ?? '';

        document.getElementById('formModal')
            .classList.add('open');

    } catch (err) {

        alert(err.message);
    }
}

// ─────────────────────────────
// View
// ─────────────────────────────

async function viewCertificate(id) {

    try {

        const response = await fetch(`/admin/certification/${id}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        // DEBUG RESPONSE
        const text = await response.text();

        console.log(text);

        // convert safely
        const data = JSON.parse(text);

        if (!response.ok) {
            throw new Error(data.message || 'Failed');
        }

        const c = data.certification;

        let html = `
            <div style="padding:10px">

                <div class="form-grid">

                    <div>
                        <strong>Student Name:</strong><br>
                        ${c.student_name ?? '-'}
                    </div>

                    <div>
                        <strong>Parents Name:</strong><br>
                        ${c.parents_name ?? '-'}
                    </div>

                    <div>
                        <strong>Mobile:</strong><br>
                        ${c.mobile_no ?? '-'}
                    </div>

                    <div>
                        <strong>Trainer:</strong><br>
                        ${c.trainer_name ?? '-'}
                    </div>

                    <div>
                        <strong>Level:</strong><br>
                        ${c.level ?? '-'}
                    </div>

                    <div>
                        <strong>Score:</strong><br>
                        ${c.score ?? '-'}
                    </div>

                    <div>
                        <strong>Result:</strong><br>
                        ${c.result ?? '-'}
                    </div>

                    <div>
                        <strong>Exam Date:</strong><br>
                        ${c.exam_date ?? '-'}
                    </div>

                    <div>
                        <strong>Certificate Date:</strong><br>
                        ${c.certificate_date ?? '-'}
                    </div>

                    <div>
                        <strong>Dispatch Date:</strong><br>
                        ${c.dispatch_date ?? '-'}
                    </div>

                    <div>
                        <strong>Received Date:</strong><br>
                        ${c.received_date ?? '-'}
                    </div>

                    <div>
                        <strong>Receiver Contact:</strong><br>
                        ${c.receiver_contact ?? '-'}
                    </div>

                </div>

                <div style="margin-top:20px">

                    <strong>Address:</strong>

                    <div style="margin-top:5px">
                        ${c.address ?? '-'}
                    </div>

                </div>

                <div style="margin-top:20px">

                    <strong>Remark:</strong>

                    <div style="margin-top:5px">
                        ${c.remark ?? '-'}
                    </div>

                </div>

            </div>
        `;

        document.getElementById('viewContent').innerHTML = html;

        document.getElementById('viewModal')
            .classList.add('open');

    } catch (err) {

        console.error(err);

        alert(err.message);
    }
}


// ─────────────────────────────
// Close View Modal
// ─────────────────────────────
function closeViewModal() {

    document.getElementById('viewModal')
        .classList.remove('open');
}

function handleViewBackdrop(e) {

    if (e.target.id === 'viewModal') {

        closeViewModal();
    }
}

// ─────────────────────────────
// Delete
// ─────────────────────────────
async function deleteCertificate(id) {

    if (!confirm('Delete this certificate?')) {

        return;
    }

    try {

        const res =
            await fetch(`/admin/certification/${id}`, {

            method: 'DELETE',

            headers: {

                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'

            }

        });

        const data = await res.json();

        if (!res.ok) {

            throw new Error(data.message || 'Delete failed');
        }

        certificates =
            certificates.filter(item => item.id !== id);

        render(certificates);

        alert(data.message);

    } catch (err) {

        alert(err.message);
    }
}

render(certificates);

</script>

@endsection