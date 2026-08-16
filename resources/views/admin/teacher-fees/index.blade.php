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
            <h1>Teacher Admissions</h1>
            <p>Manage teacher admission and level fee details.</p>
        </div>

        <button class="btn btn-primary" onclick="openCreateModal()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>

            New Teacher Admission
        </button>
    </div>


    {{-- ═══════════ TABLE CARD ═══════════ --}}
    <div class="card">

        <div id="reportButtons"></div>

        <div style="overflow-x:auto; padding:20px;">

            <table id="teacherTable"
                class="table table-striped table-bordered roles-table">

                <thead>
                    <tr>

                        <th style="width:60px">#</th>

                        <th>Teacher ID</th>

                        <th>Teacher Name</th>

                        <th>Mobile No.</th>

                        <th>Trainer Name</th>

                        <th>Address</th>

                        <th>Region</th>

                        <th>Admission Date</th>

                        <th>Junior</th>

                        <th>Level 01</th>

                        <th>Level 02</th>

                        <th>Level 03</th>

                        <th>Level 04</th>

                        <th>Level 05</th>

                        <th>Level 06</th>

                        <th>Level 07</th>

                        <th>Level 08</th>

                        <th>Level 09</th>

                        <th>Level 10</th>

                        <th>Remark</th>

                        <th style="width:120px;text-align:right">
                            Actions
                        </th>

                    </tr>
                </thead>

                <tbody id="recordBody">
                </tbody>

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

                <p>No Teacher Admissions Found</p>

                <span>
                    Try a different search or create a new teacher admission.
                </span>

            </div>

        </div>

    </div>


    {{-- ═══════════ ADD / EDIT MODAL ═══════════ --}}
    <div class="modal-backdrop"
        id="formModal"
        onclick="handleBackdropClick(event)">

        <div class="modal" style="max-width:850px;">

            <div class="modal-header">

                <h2 id="modalTitle">
                    New Teacher Admission
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


                {{-- Teacher Information --}}
                <h4 style="margin-bottom:15px;font-size:15px;font-weight:600;">
                    Teacher Information
                </h4>


                <div class="form-row">
    <div class="form-group">
    
     <label class="form-label">
                           Select Teacher
                            <span class="text-danger">*</span>
                        </label>
                  <select id="teacher_id" class="form-control">
    <option value="">Select Teacher</option>

   @foreach($teachers as $teacher)
    <option
        value="{{ $teacher->teacher_enrollment_id }}"
        data-name="{{ $teacher->name }}"
    >
        {{ $teacher->teacher_enrollment_id }} - {{ $teacher->name }}
    </option>
@endforeach
</select>
<input type="hidden" id="teacher_name">
</div>
    <div class="form-group"> 
    <label class="form-label">
                            Select Financial Year
                            <span class="text-danger">*</span>
                        </label>
<select id="financial_year" class="form-control">
    <option value="">Select Financial Year</option>
    <option value="2025-2026">2025-2026</option>
    <option value="2026-2027">2026-2027</option>
</select>
                </div>
                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            Mobile No.
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            id="mobile_no"
                            class="form-control"
                            placeholder="Enter mobile number">

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Trainer Name
                        </label>

                        <input type="text"
                            id="trainer_name"
                            class="form-control"
                            placeholder="Enter trainer name">

                    </div>

                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            Region
                        </label>

                        <input type="text"
                            id="region"
                            class="form-control"
                            placeholder="Enter region">

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Admission Date
                        </label>

                        <input type="date"
                            id="admission_date"
                            class="form-control">

                    </div>

                </div>


                <div class="form-group">

                    <label class="form-label">
                        Address
                    </label>

                    <textarea
                        id="address"
                        rows="3"
                        class="form-control"
                        placeholder="Enter address"></textarea>

                </div>


                <hr style="margin:20px 0">


                {{-- Level Details --}}
                <h4 style="margin-bottom:15px;font-size:15px;font-weight:600;">
                    Level Fee Details
                </h4>


                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            Junior
                        </label>

                        <input type="number"
                            id="junior_amount"
                            class="form-control level-fee"
                            value="0"
                            min="0"
                            step="0.01">

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Level 01
                        </label>

                        <input type="number"
                            id="level_01_amount"
                            class="form-control level-fee"
                            value="0"
                            min="0"
                            step="0.01">

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Level 02
                        </label>

                        <input type="number"
                            id="level_02_amount"
                            class="form-control level-fee"
                            value="0"
                            min="0"
                            step="0.01">

                    </div>

                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            Level 03
                        </label>

                        <input type="number"
                            id="level_03_amount"
                            class="form-control level-fee"
                            value="0"
                            min="0"
                            step="0.01">

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Level 04
                        </label>

                        <input type="number"
                            id="level_04_amount"
                            class="form-control level-fee"
                            value="0"
                            min="0"
                            step="0.01">

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Level 05
                        </label>

                        <input type="number"
                            id="level_05_amount"
                            class="form-control level-fee"
                            value="0"
                            min="0"
                            step="0.01">

                    </div>

                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            Level 06
                        </label>

                        <input type="number"
                            id="level_06_amount"
                            class="form-control level-fee"
                            value="0"
                            min="0"
                            step="0.01">

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Level 07
                        </label>

                        <input type="number"
                            id="level_07_amount"
                            class="form-control level-fee"
                            value="0"
                            min="0"
                            step="0.01">

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Level 08
                        </label>

                        <input type="number"
                            id="level_08_amount"
                            class="form-control level-fee"
                            value="0"
                            min="0"
                            step="0.01">

                    </div>

                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            Level 09
                        </label>

                        <input type="number"
                            id="level_09_amount"
                            class="form-control level-fee"
                            value="0"
                            min="0"
                            step="0.01">

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Level 10
                        </label>

                        <input type="number"
                            id="level_10_amount"
                            class="form-control level-fee"
                            value="0"
                            min="0"
                            step="0.01">

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Total Amount
                        </label>

                        <input type="number"
                            id="total_amount"
                            class="form-control"
                            readonly
                            value="0">

                    </div>

                </div>


                <div class="form-group">

                    <label class="form-label">
                        Remark
                    </label>

                    <textarea
                        id="remark"
                        rows="4"
                        class="form-control"
                        placeholder="Enter remark"></textarea>

                </div>

            </div>


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

    let editingId = null;


    /*
    |--------------------------------------------------------------------------
    | Render Table
    |--------------------------------------------------------------------------
    */

    function renderTable()
    {
        if ($.fn.DataTable.isDataTable('#teacherTable')) {
            $('#teacherTable').DataTable().destroy();
        }

        const tbody = $('#recordBody');

        tbody.empty();

        if (!records || records.length === 0) {

            $('#emptyState').show();

        } else {

            $('#emptyState').hide();

            records.forEach((item, index) => {

                tbody.append(`

                    <tr>

                        <td>
                            ${index + 1}
                        </td>

                        <td>
                            ${item.teacher_id ?? ''}
                        </td>

                        <td>
                            ${item.teacher_name ?? ''}
                        </td>

                        <td>
                            ${item.mobile_no ?? ''}
                        </td>

                        <td>
                            ${item.trainer_name ?? ''}
                        </td>

                        <td>
                            ${item.address ?? ''}
                        </td>

                        <td>
                            ${item.region ?? ''}
                        </td>

                        <td>
                            ${item.admission_date ?? ''}
                        </td>

                        <td>
                            ₹${item.junior_amount ?? 0}
                        </td>

                        <td>
                            ₹${item.level_01_amount ?? 0}
                        </td>

                        <td>
                            ₹${item.level_02_amount ?? 0}
                        </td>

                        <td>
                            ₹${item.level_03_amount ?? 0}
                        </td>

                        <td>
                            ₹${item.level_04_amount ?? 0}
                        </td>

                        <td>
                            ₹${item.level_05_amount ?? 0}
                        </td>

                        <td>
                            ₹${item.level_06_amount ?? 0}
                        </td>

                        <td>
                            ₹${item.level_07_amount ?? 0}
                        </td>

                        <td>
                            ₹${item.level_08_amount ?? 0}
                        </td>

                        <td>
                            ₹${item.level_09_amount ?? 0}
                        </td>

                        <td>
                            ₹${item.level_10_amount ?? 0}
                        </td>

                        <td>
                            ${item.remark ?? ''}
                        </td>

                        <td style="white-space:nowrap;">

                            <button
                                type="button"
                                class="btn-icon"
                                onclick="openEditModal(${item.id})">

                                <svg width="13"
                                    height="13"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2">

                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>

                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4-4 9.5-9.5z"/>

                                </svg>

                            </button>

                        </td>

                    </tr>

                `);

            });
        }


        /*
        |--------------------------------------------------------------------------
        | DataTable
        |--------------------------------------------------------------------------
        */

        $('#teacherTable').DataTable({

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


    /*
    |--------------------------------------------------------------------------
    | Save Record
    |--------------------------------------------------------------------------
    */

    function saveRecord()
    {
        const url = editingId
            ? `/admin/teacher-fees/${editingId}`
            : `/admin/teacher-fees`;

        const method = editingId
            ? "PUT"
            : "POST";


        const data = {

            teacher_id:
                document.getElementById("teacher_id").value,
    teacher_name:
        document.getElementById("teacher_name").value,

            financial_year:
                document.getElementById("financial_year").value,

            trainer_name:
                document.getElementById("trainer_name").value,

            address:
                document.getElementById("address").value,

            region:
                document.getElementById("region").value,
mobile_no: document.getElementById("mobile_no").value,
            admission_date:
                document.getElementById("admission_date").value,


            junior_amount:
                document.getElementById("junior_amount").value,

            level_01_amount:
                document.getElementById("level_01_amount").value,

            level_02_amount:
                document.getElementById("level_02_amount").value,

            level_03_amount:
                document.getElementById("level_03_amount").value,

            level_04_amount:
                document.getElementById("level_04_amount").value,

            level_05_amount:
                document.getElementById("level_05_amount").value,

            level_06_amount:
                document.getElementById("level_06_amount").value,

            level_07_amount:
                document.getElementById("level_07_amount").value,

            level_08_amount:
                document.getElementById("level_08_amount").value,

            level_09_amount:
                document.getElementById("level_09_amount").value,

            level_10_amount:
                document.getElementById("level_10_amount").value,

            remark:
                document.getElementById("remark").value
        };


        fetch(url, {

            method: method,

            headers: {

                "Content-Type": "application/json",

                "Accept": "application/json",

                "X-CSRF-TOKEN":
                    document
                        .querySelector('meta[name="csrf-token"]')
                        .content

            },

            body: JSON.stringify(data)

        })

        .then(async response => {

            const result = await response.json();

            if (!response.ok) {

                throw new Error(
                    result.message ||
                    'Validation failed.'
                );

            }

            return result;

        })

        .then(res => {

            if (res.success) {

                location.reload();

            } else {

                alert(
                    res.message ||
                    'Something went wrong.'
                );

            }

        })

        .catch(error => {

            console.error(error);

            alert(error.message);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Create Modal
    |--------------------------------------------------------------------------
    */

    function openCreateModal()
    {
        editingId = null;

        document.getElementById("modalTitle").innerText =
            "New Teacher Admission";

        clearForm();

        document
            .getElementById("formModal")
            .classList
            .add("open");
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Modal
    |--------------------------------------------------------------------------
    */

    function openEditModal(id)
    {
        const record =
            records.find(r => r.id == id);

        if (!record) {

            console.error(
                "Teacher admission record not found:",
                id
            );

            return;
        }


        editingId = id;


        document.getElementById("modalTitle").innerText =
            "Edit Teacher Admission";


        document.getElementById("recordId").value =
            record.id ?? "";


        /*
        |--------------------------------------------------------------------------
        | Teacher
        |--------------------------------------------------------------------------
        */

        document.getElementById("teacher_id").value =
            record.teacher_id ?? "";
document.getElementById("teacher_name").value =
    record.teacher_name ?? "";

        /*
        |--------------------------------------------------------------------------
        | Financial Year
        |--------------------------------------------------------------------------
        */


const financialYearSelect =
    document.getElementById("financial_year");

const financialYear =
    String(record.financial_year ?? '').trim();

financialYearSelect.value = financialYear;

        /*
        |--------------------------------------------------------------------------
        | Other Details
        |--------------------------------------------------------------------------
        */

        document.getElementById("trainer_name").value =
            record.trainer_name ?? "";


        document.getElementById("address").value =
            record.address ?? "";


        document.getElementById("region").value =
            record.region ?? "";


        document.getElementById("admission_date").value =
            record.admission_date ?? "";

        document.getElementById("mobile_no").value =
            record.mobile_no ?? "";
        /*
        |--------------------------------------------------------------------------
        | Levels
        |--------------------------------------------------------------------------
        */

        document.getElementById("junior_amount").value =
            record.junior_amount ?? 0;


        document.getElementById("level_01_amount").value =
            record.level_01_amount ?? 0;


        document.getElementById("level_02_amount").value =
            record.level_02_amount ?? 0;


        document.getElementById("level_03_amount").value =
            record.level_03_amount ?? 0;


        document.getElementById("level_04_amount").value =
            record.level_04_amount ?? 0;


        document.getElementById("level_05_amount").value =
            record.level_05_amount ?? 0;


        document.getElementById("level_06_amount").value =
            record.level_06_amount ?? 0;


        document.getElementById("level_07_amount").value =
            record.level_07_amount ?? 0;


        document.getElementById("level_08_amount").value =
            record.level_08_amount ?? 0;


        document.getElementById("level_09_amount").value =
            record.level_09_amount ?? 0;


        document.getElementById("level_10_amount").value =
            record.level_10_amount ?? 0;


        /*
        |--------------------------------------------------------------------------
        | Remark
        |--------------------------------------------------------------------------
        */

        document.getElementById("remark").value =
            record.remark ?? "";


        calculateTotal();


        /*
        |--------------------------------------------------------------------------
        | Open Modal
        |--------------------------------------------------------------------------
        */

        document
            .getElementById("formModal")
            .classList
            .add("open");
    }


    /*
    |--------------------------------------------------------------------------
    | Clear Form
    |--------------------------------------------------------------------------
    */

    function clearForm()
    {
        document.getElementById("recordId").value = "";

        document.getElementById("teacher_id").value = "";

    document.getElementById("teacher_name").value = "";
   document.getElementById("mobile_no").value = "";
        document.getElementById("financial_year").value = "";

        document.getElementById("trainer_name").value = "";

        document.getElementById("address").value = "";

        document.getElementById("region").value = "";

        document.getElementById("admission_date").value = "";


        document
            .querySelectorAll(".level-fee")
            .forEach(input => {

                input.value = 0;

            });


        document.getElementById("total_amount").value =
            "0.00";


        document.getElementById("remark").value = "";
    }


    /*
    |--------------------------------------------------------------------------
    | Calculate Total
    |--------------------------------------------------------------------------
    */

    function calculateTotal()
    {
        let total = 0;


        document
            .querySelectorAll(".level-fee")
            .forEach(input => {

                total +=
                    parseFloat(input.value) || 0;

            });


        document.getElementById("total_amount").value =
            total.toFixed(2);
    }


    /*
    |--------------------------------------------------------------------------
    | Close Modal
    |--------------------------------------------------------------------------
    */

    function closeFormModal()
    {
        document
            .getElementById("formModal")
            .classList
            .remove("open");
    }


    /*
    |--------------------------------------------------------------------------
    | Backdrop Click
    |--------------------------------------------------------------------------
    */

    function handleBackdropClick(e)
    {
        if (e.target.id === "formModal") {

            closeFormModal();

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Calculate Total On Input
    |--------------------------------------------------------------------------
    */

    $(document).on(
        'input',
        '.level-fee',
        function () {

            calculateTotal();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Initialize
    |--------------------------------------------------------------------------
    */

    $(document).ready(function () {

        renderTable();

    });
    $('#teacher_id').on('change', function () {

    const selectedOption = $(this).find('option:selected');

    const teacherId = selectedOption.val();
    const teacherName = selectedOption.data('name') || '';

    $('#teacher_name').val(teacherName);

});

</script>

@endsection