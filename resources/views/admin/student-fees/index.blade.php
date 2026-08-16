@extends('admin.layout.app')

@section('style')
    <style>
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;

        }

        /* Space between report buttons and the table */
        div.dt-buttons {
            margin-bottom: 0px;
        }

        /* Optional: add a little spacing above as well */
        div.dataTables_wrapper div.dt-buttons {
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('content')

    {{-- ═══════════ PAGE HEADER ═══════════ --}}
    <div class="roles-header">
        <div>
            <h1>Student Admissions</h1>
            <p>Manage fees details of the student.</p>
        </div>

        <button class="btn btn-primary" onclick="openCreateModal()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            New Fees Record
        </button>
    </div>



    {{-- ═══════════ TABLE CARD ═══════════ --}}
    <div class="card">



        <div id="reportButtons"></div>
        <div style="overflow-x:auto; padding:20px;">

            <table id="feeTable" class="table table-striped table-bordered roles-table">

                <thead>
                    <tr>
                        <th style="width:60px">#</th>
                        <th>Student</th>
                        <th>Financial Year</th>
                        <th>April</th>
                        <th>May</th>
                        <th>June</th>
                        <th>July</th>
                        <th>August</th>
                        <th>September</th>
                        <th>October</th>
                        <th>November</th>
                        <th>December</th>
                        <th>January</th>
                        <th>February</th>
                        <th>March</th>
                        <th>Total Amount</th>
                        <th>Remark</th>
                        <th style="width:120px;text-align:right">Actions</th>
                    </tr>
                </thead>

                <tbody id="recordBody">

                </tbody>

            </table>

            <div id="emptyState" class="empty-state" style="display:none">

                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M9 9h6" />
                    <path d="M9 13h6" />
                    <path d="M9 17h4" />
                </svg>

                <p>No Fee Records Found</p>

                <span>
                    Try a different search or create a new fee record.
                </span>

            </div>



        </div>



    </div>

    {{-- ═══════════ ADD / EDIT FEES MODAL ═══════════ --}}
    <div class="modal-backdrop" id="formModal" onclick="handleBackdropClick(event)">

        <div class="modal" style="max-width:650px;">

            <div class="modal-header">

                <h2 id="modalTitle">New Fees Record</h2>

                <button class="btn-icon" onclick="closeFormModal()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>

            </div>

            <div class="modal-body">

                <input type="hidden" id="recordId">

                <div class="form-row">

                    <div class="form-group">
                        <label class="form-label">
                            Student <span class="text-danger">*</span>
                        </label>

                        <select id="student_enrollment_id" class="form-control">
                            <option value="">Select Student</option>

                            @foreach($students as $student)
                                <option value="{{ $student->student_enrollment_id }}">
                                    {{ $student->student_enrollment_id }} - {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            Financial Year <span class="text-danger">*</span>
                        </label>

                        <select id="financial_year" class="form-control">
                            <option value="">Select Financial Year</option>
                            <option value="2025-2026">2025-2026</option>
                            <option value="2026-2027">2026-2027</option>
                        </select>
                    </div>

                </div>

                <hr style="margin:20px 0">

                <h4 style="margin-bottom:15px;font-size:15px;font-weight:600;">
                    Monthly Fee Details
                </h4>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">April</label>
                        <input type="number" id="april" class="form-control month-fee" value="0" min="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">May</label>
                        <input type="number" id="may" class="form-control month-fee" value="0" min="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">June</label>
                        <input type="number" id="june" class="form-control month-fee" value="0" min="0">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">July</label>
                        <input type="number" id="july" class="form-control month-fee" value="0" min="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">August</label>
                        <input type="number" id="august" class="form-control month-fee" value="0" min="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">September</label>
                        <input type="number" id="september" class="form-control month-fee" value="0" min="0">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">October</label>
                        <input type="number" id="october" class="form-control month-fee" value="0" min="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">November</label>
                        <input type="number" id="november" class="form-control month-fee" value="0" min="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">December</label>
                        <input type="number" id="december" class="form-control month-fee" value="0" min="0">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">January</label>
                        <input type="number" id="january" class="form-control month-fee" value="0" min="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">February</label>
                        <input type="number" id="february" class="form-control month-fee" value="0" min="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">March</label>
                        <input type="number" id="march" class="form-control month-fee" value="0" min="0">
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group">
                        <label class="form-label">
                            Total Amount
                        </label>

                        <input type="number" id="total_amount" class="form-control" readonly value="0">
                    </div>



                </div>

                <div class="form-group">

                    <label class="form-label">
                        Remark
                    </label>

                    <textarea id="remark" rows="4" class="form-control" placeholder="Enter remark"></textarea>

                </div>

            </div>

            <div class="modal-footer">

                <button class="btn btn-ghost" onclick="closeFormModal()">
                    Cancel
                </button>

                <button class="btn btn-primary" id="saveBtn" onclick="saveRecord()">

                    <span class="spinner"></span>

                    <span class="btn-label">
                        Save Record
                    </span>

                </button>

            </div>

        </div>

    </div>

@endsection

@section('script')
    <script>
        const records = @json($records);

        function renderTable() {

            // Destroy existing DataTable
            if ($.fn.DataTable.isDataTable('#feeTable')) {
                $('#feeTable').DataTable().destroy();
            }

            let tbody = $('#recordBody');
            tbody.empty();

            records.forEach((item, index) => {

                tbody.append(`

                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.student?.name ?? item.student_enrollment_id}</td>
                        <td>${item.financial_year}</td>
                           <td>${item.april}</td>
        <td>${item.may}</td>
        <td>${item.june}</td>
        <td>${item.july}</td>
        <td>${item.august}</td>
        <td>${item.september}</td>
        <td>${item.october}</td>
        <td>${item.november}</td>
        <td>${item.december}</td>
        <td>${item.january}</td>
        <td>${item.february}</td>
        <td>${item.march}</td>

                        <td>₹${item.total_amount}</td>
                        <td>${item.remark ?? ''}</td>
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
                        </td>
                    </tr>
                `);

            });

$('#feeTable').DataTable({
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
    </script>



    <script>
        function saveRecord() {

            let url = editingId
                ? `/admin/student-fees/${editingId}`
                : `/admin/student-fees`;

            let method = editingId ? "PUT" : "POST";

            fetch(url, {
                method: method,
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({

                    student_enrollment_id: document.getElementById("student_enrollment_id").value,
                    financial_year: document.getElementById("financial_year").value,

                    april: document.getElementById("april").value,
                    may: document.getElementById("may").value,
                    june: document.getElementById("june").value,
                    july: document.getElementById("july").value,
                    august: document.getElementById("august").value,
                    september: document.getElementById("september").value,
                    october: document.getElementById("october").value,
                    november: document.getElementById("november").value,
                    december: document.getElementById("december").value,
                    january: document.getElementById("january").value,
                    february: document.getElementById("february").value,
                    march: document.getElementById("march").value,

                    remark: document.getElementById("remark").value
                })
            })
                .then(r => r.json())
                .then(res => {
                    console.log(res);
                    location.reload();
                })
                .catch(err => {
                    console.log(err);
                });


        }
        $(document).ready(function () {
            renderTable();
        });
    </script>

    <script>
        let editingId = null;

        function openCreateModal() {
            editingId = null;

            document.getElementById("modalTitle").innerText = "New Fees Record";
            document.getElementById("formModal").classList.add("open");
        }

        function openEditModal(id) {

            const record = records.find(r => r.id == id);

            if (!record) return;

            editingId = id;

            document.getElementById("modalTitle").innerText = "Edit Fees Record";

            document.getElementById("recordId").value = record.id;
            document.getElementById("student_enrollment_id").value = record.student_enrollment_id;
            document.getElementById("financial_year").value = record.financial_year;

            document.getElementById("april").value = record.april ?? 0;
            document.getElementById("may").value = record.may ?? 0;
            document.getElementById("june").value = record.june ?? 0;
            document.getElementById("july").value = record.july ?? 0;
            document.getElementById("august").value = record.august ?? 0;
            document.getElementById("september").value = record.september ?? 0;
            document.getElementById("october").value = record.october ?? 0;
            document.getElementById("november").value = record.november ?? 0;
            document.getElementById("december").value = record.december ?? 0;
            document.getElementById("january").value = record.january ?? 0;
            document.getElementById("february").value = record.february ?? 0;
            document.getElementById("march").value = record.march ?? 0;

            document.getElementById("total_amount").value = record.total_amount ?? 0;
            document.getElementById("remark").value = record.remark ?? "";

            document.getElementById("formModal").classList.add("open");
        }

        function closeFormModal() {
            document.getElementById("formModal").classList.remove("open");
        }

        function handleBackdropClick(e) {
            if (e.target.id === "formModal") {
                closeFormModal();
            }
        }
    </script>


@endsection