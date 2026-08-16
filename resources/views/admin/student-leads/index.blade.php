@extends('admin.layout.app')

@section('style')
    <style>
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        div.dt-buttons {
            margin-bottom: 0px;
        }

        div.dataTables_wrapper div.dt-buttons {
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('content')

    {{-- ═══════════ PAGE HEADER ═══════════ --}}
    <div class="roles-header">
        <div>
            <h1>Student Leads</h1>
            <p>Manage student leads, follow-ups, demos and admissions.</p>
        </div>

        <button class="btn btn-primary" onclick="openCreateModal()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>

            New Student Lead
        </button>
    </div>


    {{-- ═══════════ TABLE CARD ═══════════ --}}
    <div class="card">

        <div id="reportButtons"></div>

        <div style="overflow-x:auto; padding:20px;">

            <table id="studentLeadTable"
                class="table table-striped table-bordered roles-table">

                <thead>
                    <tr>
                        <th style="width:60px">#</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Region</th>
                        <th>Follow Up</th>
                        <th>Response</th>
                        <th>Demo</th>
                        <th>Admission</th>
                        <th>Teacher</th>
                        <th>Remark</th>
                        <th>Feedback</th>
                        <th style="width:120px;text-align:right">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody id="recordBody"></tbody>

            </table>

            <div id="emptyState"
                class="empty-state"
                style="display:none">

                <svg width="40" height="40"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5">

                    <circle cx="12" cy="12" r="10" />
                    <path d="M9 9h6" />
                    <path d="M9 13h6" />
                    <path d="M9 17h4" />

                </svg>

                <p>No Student Leads Found</p>

                <span>
                    Try a different search or create a new student lead.
                </span>

            </div>

        </div>

    </div>


    {{-- ═══════════ ADD / EDIT STUDENT LEAD MODAL ═══════════ --}}
    <div class="modal-backdrop"
        id="formModal"
        onclick="handleBackdropClick(event)">

        <div class="modal" style="max-width:750px;">

            <div class="modal-header">

                <h2 id="modalTitle">
                    New Student Lead
                </h2>

                <button class="btn-icon"
                    onclick="closeFormModal()">

                    <svg width="15"
                        height="15"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5">

                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />

                    </svg>

                </button>

            </div>


            <div class="modal-body">

                <input type="hidden" id="recordId">


                {{-- STUDENT DETAILS --}}
                <h4 style="margin-bottom:15px;font-size:15px;font-weight:600;">
                    Student Details
                </h4>

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            Name <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            id="name"
                            class="form-control"
                            placeholder="Enter student name">

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Mobile <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            id="mobile"
                            class="form-control"
                            placeholder="Enter mobile number">

                    </div>

                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            Email
                        </label>

                        <input type="email"
                            id="email"
                            class="form-control"
                            placeholder="Enter email address">

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Region
                        </label>

                        <input type="text"
                            id="region"
                            class="form-control"
                            placeholder="Enter region">

                    </div>

                </div>


                <div class="form-group">

                    <label class="form-label">
                        Message
                    </label>

                    <textarea id="message"
                        rows="3"
                        class="form-control"
                        placeholder="Enter message"></textarea>

                </div>


                <hr style="margin:20px 0">


                {{-- FOLLOW UP --}}
                <h4 style="margin-bottom:15px;font-size:15px;font-weight:600;">
                    Follow Up Details
                </h4>


                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            Follow Up Date
                        </label>

                        <input type="date"
                            id="follow_up_date"
                            class="form-control">

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Response
                        </label>

                        <select id="response"
                            class="form-control">

                            <option value="">
                                Select Response
                            </option>

                            <option value="Yes">
                                Yes
                            </option>

                            <option value="No">
                                No
                            </option>

                            <option value="Pending">
                                Pending
                            </option>

                        </select>

                    </div>

                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            Demo
                        </label>

                        <select id="demo"
                            class="form-control">

                            <option value="">
                                Select Demo Status
                            </option>

                            <option value="Done">
                                Done
                            </option>

                            <option value="No">
                                No
                            </option>

                            <option value="Pending">
                                Pending
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Admission
                        </label>

                        <select id="admission"
                            class="form-control">

                            <option value="">
                                Select Admission Status
                            </option>

                            <option value="Done">
                                Done
                            </option>

                            <option value="No">
                                No
                            </option>

                            <option value="Pending">
                                Pending
                            </option>

                        </select>

                    </div>

                </div>


                {{-- TEACHER --}}
                <div class="form-group">

                    <label class="form-label">
                        Teacher Name
                    </label>

                    <select id="teacher_name"
                        class="form-control">

                        <option value="">
                            Select Teacher
                        </option>

                        @foreach($teachers ?? [] as $teacher)

                            <option value="{{ $teacher->name }}">
                               {{ $teacher->teacher_enrollment_id }} - {{ $teacher->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="form-group">

                    <label class="form-label">
                        Remark
                    </label>

                    <textarea id="remark"
                        rows="3"
                        class="form-control"
                        placeholder="Enter remark"></textarea>

                </div>


                <div class="form-group">

                    <label class="form-label">
                        Feedback
                    </label>

                    <textarea id="feedback"
                        rows="3"
                        class="form-control"
                        placeholder="Enter feedback"></textarea>

                </div>

            </div>


            {{-- MODAL FOOTER --}}
            <div class="modal-footer">

                <button class="btn btn-ghost"
                    onclick="closeFormModal()">

                    Cancel

                </button>


                <button class="btn btn-primary"
                    id="saveBtn"
                    onclick="saveRecord()">

                    <span class="spinner"></span>

                    <span class="btn-label">
                        Save Lead
                    </span>

                </button>

            </div>

        </div>

    </div>

@endsection


@section('script')

<script>

    const records = @json($records);

    let editingId = null;


    // ═══════════════════════════════════════
    // RENDER TABLE
    // ═══════════════════════════════════════

    function renderTable() {

        if ($.fn.DataTable.isDataTable('#studentLeadTable')) {

            $('#studentLeadTable')
                .DataTable()
                .destroy();

        }


        let tbody = $('#recordBody');

        tbody.empty();


        if (!records.length) {

            $('#emptyState').show();

        } else {

            $('#emptyState').hide();

        }


        records.forEach((item, index) => {

            tbody.append(`

                <tr>

                    <td>
                        ${index + 1}
                    </td>

                    <td>
                        ${escapeHtml(item.name ?? '')}
                    </td>

                    <td>
                        ${escapeHtml(item.mobile ?? '')}
                    </td>

                    <td>
                        ${escapeHtml(item.email ?? '')}
                    </td>

                    <td>
                        ${escapeHtml(item.region ?? '')}
                    </td>

                    <td>
                        ${item.follow_up_date ?? ''}
                    </td>

                    <td>
                        ${escapeHtml(item.response ?? '')}
                    </td>

                    <td>
                        ${escapeHtml(item.demo ?? '')}
                    </td>

                    <td>
                        ${escapeHtml(item.admission ?? '')}
                    </td>

                    <td>
                        ${escapeHtml(item.teacher_name ?? '')}
                    </td>

                    <td>
                        ${escapeHtml(item.remark ?? '')}
                    </td>

                    <td>
                        ${escapeHtml(item.feedback ?? '')}
                    </td>

                    <td>

                        <button class="btn-icon"
                            onclick="openEditModal(${item.id})">

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
                            onclick="deleteRecord(${item.id})">

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

                    </td>

                </tr>

            `);

        });


        $('#studentLeadTable').DataTable({

            destroy: true,

            responsive: true,

            scrollX: true,

            pageLength: 10,

            dom: 'Bfrtip',

            buttons: [

                'copy',
                'excel',
                'csv',
                'pdf',
                'print'

            ]

        });

    }


    // ═══════════════════════════════════════
    // ESCAPE HTML
    // ═══════════════════════════════════════

    function escapeHtml(value) {

        if (value === null || value === undefined) {
            return '';
        }

        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

    }


    // ═══════════════════════════════════════
    // SAVE / UPDATE
    // ═══════════════════════════════════════

    function saveRecord() {

        let url = editingId
            ? `/admin/student-leads/${editingId}`
            : `/admin/student-leads`;

        let method = editingId
            ? "PUT"
            : "POST";


        const saveBtn = document.getElementById("saveBtn");

        saveBtn.disabled = true;


        fetch(url, {

            method: method,

            headers: {

                "Content-Type": "application/json",

                "Accept": "application/json",

                "X-CSRF-TOKEN":
                    document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content

            },


            body: JSON.stringify({

                name:
                    document.getElementById("name").value,

                mobile:
                    document.getElementById("mobile").value,

                email:
                    document.getElementById("email").value,

                message:
                    document.getElementById("message").value,

                region:
                    document.getElementById("region").value,

                follow_up_date:
                    document.getElementById("follow_up_date").value,

                response:
                    document.getElementById("response").value,

                demo:
                    document.getElementById("demo").value,

                admission:
                    document.getElementById("admission").value,

                teacher_name:
                    document.getElementById("teacher_name").value,

                remark:
                    document.getElementById("remark").value,

                feedback:
                    document.getElementById("feedback").value

            })

        })

        .then(async response => {

            const data = await response.json();

            if (!response.ok) {

                throw new Error(
                    data.message || 'Something went wrong.'
                );

            }

            return data;

        })

        .then(res => {

            console.log(res);

            location.reload();

        })

        .catch(error => {

            console.error(error);

            alert(error.message);

            saveBtn.disabled = false;

        });

    }


    // ═══════════════════════════════════════
    // CREATE MODAL
    // ═══════════════════════════════════════

    function openCreateModal() {

        editingId = null;

        document.getElementById("modalTitle").innerText =
            "New Student Lead";

        document.getElementById("saveBtn")
            .querySelector(".btn-label")
            .innerText = "Save Lead";


        clearForm();


        document.getElementById("formModal")
            .classList.add("open");

    }


    // ═══════════════════════════════════════
    // EDIT MODAL
    // ═══════════════════════════════════════

    function openEditModal(id) {

        const record =
            records.find(r => r.id == id);


        if (!record) {
            return;
        }


        editingId = id;


        document.getElementById("modalTitle").innerText =
            "Edit Student Lead";

        document.getElementById("saveBtn")
            .querySelector(".btn-label")
            .innerText = "Update Lead";


        document.getElementById("recordId").value =
            record.id;


        document.getElementById("name").value =
            record.name ?? '';

        document.getElementById("mobile").value =
            record.mobile ?? '';

        document.getElementById("email").value =
            record.email ?? '';

        document.getElementById("message").value =
            record.message ?? '';

        document.getElementById("region").value =
            record.region ?? '';

        document.getElementById("follow_up_date").value =
            record.follow_up_date ?? '';

        document.getElementById("response").value =
            record.response ?? '';

        document.getElementById("demo").value =
            record.demo ?? '';

        document.getElementById("admission").value =
            record.admission ?? '';

        document.getElementById("teacher_name").value =
            record.teacher_name ?? '';

        document.getElementById("remark").value =
            record.remark ?? '';

        document.getElementById("feedback").value =
            record.feedback ?? '';


        document.getElementById("formModal")
            .classList.add("open");

    }


    // ═══════════════════════════════════════
    // CLEAR FORM
    // ═══════════════════════════════════════

    function clearForm() {

        document.getElementById("recordId").value = "";

        document.getElementById("name").value = "";

        document.getElementById("mobile").value = "";

        document.getElementById("email").value = "";

        document.getElementById("message").value = "";

        document.getElementById("region").value = "";

        document.getElementById("follow_up_date").value = "";

        document.getElementById("response").value = "";

        document.getElementById("demo").value = "";

        document.getElementById("admission").value = "";

        document.getElementById("teacher_name").value = "";

        document.getElementById("remark").value = "";

        document.getElementById("feedback").value = "";

    }


    // ═══════════════════════════════════════
    // DELETE
    // ═══════════════════════════════════════

    function deleteRecord(id) {

        const record =
            records.find(r => r.id == id);


        if (!record) {
            return;
        }


        if (!confirm(
            `Are you sure you want to delete the lead "${record.name}"?`
        )) {
            return;
        }


        fetch(`/admin/student-leads/${id}`, {

            method: "DELETE",

            headers: {

                "Accept": "application/json",

                "X-CSRF-TOKEN":
                    document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content

            }

        })

        .then(async response => {

            const data = await response.json();

            if (!response.ok) {

                throw new Error(
                    data.message ||
                    'Unable to delete student lead.'
                );

            }

            return data;

        })

        .then(res => {

            console.log(res);

            location.reload();

        })

        .catch(error => {

            console.error(error);

            alert(error.message);

        });

    }


    // ═══════════════════════════════════════
    // CLOSE MODAL
    // ═══════════════════════════════════════

    function closeFormModal() {

        document.getElementById("formModal")
            .classList.remove("open");

    }


    // ═══════════════════════════════════════
    // BACKDROP CLICK
    // ═══════════════════════════════════════

    function handleBackdropClick(e) {

        if (e.target.id === "formModal") {

            closeFormModal();

        }

    }


    // ═══════════════════════════════════════
    // DOCUMENT READY
    // ═══════════════════════════════════════

    $(document).ready(function () {

        renderTable();

    });

</script>

@endsection