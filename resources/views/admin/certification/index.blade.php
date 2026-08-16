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
                <th>Certificate ID</th>
                <th>Title</th>
                <th>Student Enrollment ID</th>
                <th>Student Name</th>
                <th>File</th>
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
            Upload your first certificate.
        </span>

    </div>

</div>

</div>

{{-- ═══════════ CREATE / EDIT MODAL ═══════════ --}}
<div class="modal-backdrop"
     id="formModal"
     onclick="handleBackdropClick(event)">

    <div class="modal"
         style="max-width:700px;width:95%">

        <div class="modal-header">

            <h2 id="modalTitle">
                Upload Certificate
            </h2>

            <button class="btn-icon"
                    onclick="closeFormModal()">

                ✖

            </button>

        </div>

        <div class="modal-body">

            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Certificate Title <span style="color:red">*</span>
                    </label>

                    <input
                        type="text"
                        id="title"
                        class="form-control"
                        placeholder="Enter certificate title">

                </div>

             <div class="form-group">

    <label class="form-label">
        Student <span style="color:red">*</span>
    </label>

    <select
        id="student_enrollment_id"
        class="form-control">

        <option value="">
            -- Select Student --
        </option>

        @foreach($students as $student)

            <option value="{{ $student->student_enrollment_id }}">

                {{ $student->name }}
                ({{ $student->student_enrollment_id }})

            </option>

        @endforeach

    </select>

</div>

                <div class="form-group full-width">

                    <label class="form-label">
                        Certificate File
                    </label>

                    <input
                        type="file"
                        id="file"
                        class="form-control"
                        accept=".pdf,.jpg,.jpeg,.png">

                    <small style="color:#666">
                        Allowed: PDF, JPG, JPEG, PNG (Max 5 MB)
                    </small>

                </div>

            </div>

        </div>

        <div class="modal-footer">

            <button
                class="btn btn-ghost"
                onclick="closeFormModal()">

                Cancel

            </button>

            <button
                class="btn btn-primary"
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

let certificates = @json($certificates ?? []);

let editingId = null;

const CSRF =
document.querySelector('meta[name="csrf-token"]')?.content ?? '';

function formatDate(date){

    if(!date) return '-';

    return new Date(date).toLocaleDateString();
}

// ================================
// Render Table
// ================================
function render(list){

    const tbody=document.getElementById('certificateBody');
    const empty=document.getElementById('emptyState');

    document.getElementById('certificate-count').innerText =
        list.length + ' Certificates';

    if(list.length===0){

        tbody.innerHTML='';

        empty.style.display='block';

        return;
    }

    empty.style.display='none';

    tbody.innerHTML=list.map((item,index)=>`

        <tr>

            <td>${index+1}</td>

            <td>${item.certificate_unique_id}</td>

            <td>${item.title}</td>

            <td>${item.student_enrollment_id}</td>

         <td>${item.student ? item.student.name : '-'}</td>

            <td>

                <a href="/${item.file}"
                   target="_blank"
                   class="btn btn-sm btn-primary">

                    View

                </a>

            </td>

            <td>${formatDate(item.created_at)}</td>

            <td>

                <div class="actions-cell"
                     style="justify-content:flex-end;gap:8px;">

                    <button class="btn-icon"
                        onclick="editCertificate(${item.id})">

                        ✏️

                    </button>

                    <button class="btn-icon"
                        style="color:red"
                        onclick="deleteCertificate(${item.id})">

                        🗑️

                    </button>

                </div>

            </td>

        </tr>

    `).join('');

}


// ================================
// Search
// ================================
function filterCertificates(q){

    q=q.toLowerCase();

    render(

        certificates.filter(item=>

            item.title.toLowerCase().includes(q) ||

            item.student_enrollment_id.toLowerCase().includes(q) ||

            item.certificate_unique_id.toLowerCase().includes(q)

        )

    );

}


// ================================
// Open Modal
// ================================
function openCreateModal(){

    editingId=null;

    clearForm();

    document.getElementById('modalTitle').innerText =
        'Upload Certificate';

    document.querySelector('#saveBtn .btn-label').innerText =
        'Save Certificate';

    document
        .getElementById('formModal')
        .classList.add('open');

}


// ================================
// Clear Form
// ================================
function clearForm(){

    document.getElementById('title').value='';

    document.getElementById('student_enrollment_id').value='';

    document.getElementById('file').value='';

}


// ================================
// Close Modal
// ================================
function closeFormModal(){

    document
        .getElementById('formModal')
        .classList.remove('open');

}


function handleBackdropClick(e){

    if(e.target.id==='formModal'){

        closeFormModal();

    }

}
// ================================
// Save / Update Certificate
// ================================
async function saveCertificate() {

    let formData = new FormData();

    formData.append(
        'title',
        document.getElementById('title').value
    );

    formData.append(
        'student_enrollment_id',
        document.getElementById('student_enrollment_id').value
    );

    let file =
        document.getElementById('file').files[0];

    if (file) {
        formData.append('file', file);
    }

    let url = '/admin/certification';

    if (editingId) {

        url = `/admin/certification/${editingId}`;

        formData.append('_method', 'PUT');
    }

    try {

        const response = await fetch(url, {

            method: 'POST',

            headers: {

                'X-CSRF-TOKEN': CSRF,

                'Accept': 'application/json'

            },

            body: formData

        });

        const data = await response.json();

        if (!response.ok) {

            throw new Error(data.message || 'Something went wrong.');

        }

        if (editingId) {

            const index =
                certificates.findIndex(x => x.id == editingId);

            if (index !== -1) {

                certificates[index] = data.data;

            }

            alert('Certificate updated successfully.');

        } else {

            certificates.unshift(data.data);

            alert('Certificate uploaded successfully.');

        }

        render(certificates);

        closeFormModal();

    } catch (err) {

        alert(err.message);

    }

}


// ================================
// Edit
// ================================
async function editCertificate(id) {

    try {

        const response =
            await fetch(`/admin/certification/${id}/edit`);

        const data = await response.json();

        if (!data.success) {

            throw new Error(data.message);

        }

        const item = data.data;

        editingId = item.id;

        document.getElementById('modalTitle').innerText =
            'Update Certificate';

        document.querySelector('#saveBtn .btn-label').innerText =
            'Update Certificate';

        document.getElementById('title').value =
            item.title ?? '';

        document.getElementById('student_enrollment_id').value =
            item.student_enrollment_id ?? '';

        document.getElementById('formModal')
            .classList.add('open');

    } catch (err) {

        alert(err.message);

    }

}


// ================================
// Download
// ================================
function downloadCertificate(id) {

    window.open(
        `/admin/certification/download/${id}`,
        '_blank'
    );

}


// ================================
// Delete
// ================================
async function deleteCertificate(id) {

    if (!confirm('Are you sure you want to delete this certificate?')) {

        return;

    }

    try {

        const response =
            await fetch(`/admin/certification/${id}`, {

                method: 'DELETE',

                headers: {

                    'X-CSRF-TOKEN': CSRF,

                    'Accept': 'application/json'

                }

            });

        const data = await response.json();

        if (!response.ok) {

            throw new Error(data.message);

        }

        certificates =
            certificates.filter(item => item.id != id);

        render(certificates);

        alert(data.message);

    } catch (err) {

        alert(err.message);

    }

}


// ================================
// Initial Render
// ================================
render(certificates);


</script>


@endsection