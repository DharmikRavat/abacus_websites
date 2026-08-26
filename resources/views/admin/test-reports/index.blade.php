@extends('admin.layout.app')

@section('content')

{{-- ═══════════════════════════════════════════════
   PAGE HEADER
═══════════════════════════════════════════════ --}}
<div class="roles-header">

    <div>
        <h1>Test Reports</h1>
        <p>Create and manage Weekly / Monthly test reports</p>
    </div>

    <button class="btn btn-primary"
            onclick="openCreateReportModal()">

        + Create Report

    </button>

</div>


{{-- ═══════════════════════════════════════════════
   MAIN CARD
═══════════════════════════════════════════════ --}}
<div class="card">

    {{-- SEARCH --}}
    <div class="search-bar">

        <svg width="15"
             height="15"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2"
             style="color:var(--faint);flex-shrink:0">

            <circle cx="11"
                    cy="11"
                    r="8"/>

            <line x1="21"
                  y1="21"
                  x2="16.65"
                  y2="16.65"/>

        </svg>

        <input type="text"
               id="searchInput"
               placeholder="Search student / test / report..."
               oninput="filterReports(this.value)">

        <span id="report-count"
              style="font-size:12px;color:var(--faint);white-space:nowrap">
        </span>

    </div>


    {{-- TABLE --}}
    <div style="overflow-x:auto">

        <table class="roles-table">

            <thead>

                <tr>

                    <th style="width:40px">#</th>

                    <th>Report No.</th>

                    <th>Test</th>

                    <th>Type</th>

                    <th>Level</th>

                    <th>Trainer</th>

                    <th>Date</th>

                    <th>Students</th>

                    <th style="width:120px;text-align:right">
                        Action
                    </th>

                </tr>

            </thead>


            <tbody id="reportBody"></tbody>

        </table>


        {{-- EMPTY --}}
        <div id="emptyState"
             class="empty-state"
             style="display:none">

            <svg width="40"
                 height="40"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="1.5">

                <circle cx="12"
                        cy="12"
                        r="10"/>

                <path d="M9 12l2 2 4-4"/>

            </svg>

            <p>No Test Reports Found</p>

            <span>
                Create a report or try another search keyword
            </span>

        </div>


        <div id="pagination"
             class="pagination">
        </div>

    </div>

</div>


{{-- ═══════════════════════════════════════════════
   CREATE REPORT MODAL
═══════════════════════════════════════════════ --}}
<div class="modal-backdrop"
     id="createReportModal"
     onclick="handleCreateBackdrop(event)">

    <div class="modal"
         style="max-width:900px">

        <div class="modal-header">

            <h2>
                Create Test Report
            </h2>

            <button class="btn-icon"
                    onclick="closeCreateReportModal()">

                <svg width="15"
                     height="15"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2.5">

                    <line x1="18"
                          y1="6"
                          x2="6"
                          y2="18"/>

                    <line x1="6"
                          y1="6"
                          x2="18"
                          y2="18"/>

                </svg>

            </button>

        </div>


        <div class="modal-body">

            {{-- REPORT DETAILS --}}
            <div style="
                display:grid;
                grid-template-columns:1fr 1fr;
                gap:15px;
                margin-bottom:20px;
            ">


                {{-- REPORT TYPE --}}
                <div class="form-group">

                    <label class="form-label">
                        Report Type
                    </label>

                    <select id="createReportType"
                            class="form-control"
                            onchange="updateReportPreview()">

                        <option value="Weekly">
                            Weekly
                        </option>

                        <option value="Monthly">
                            Monthly
                        </option>

                    </select>

                </div>


                {{-- TEST --}}
                <div class="form-group">

                    <label class="form-label">
                        Test / Exam
                    </label>

                    <select id="createTest"
                            class="form-control"
                            onchange="loadReportStudents()">

                        <option value="">
                            Select Test
                        </option>

                    </select>

                </div>


                {{-- LEVEL --}}
                <div class="form-group">

                    <label class="form-label">
                        Level
                    </label>

                    <select id="createLevel"
                            class="form-control"
                            onchange="loadReportStudents()">

                        <option value="">
                            Select Level
                        </option>

                    </select>

                </div>


                {{-- DATE --}}
                <div class="form-group">

                    <label class="form-label">
                        Report Date
                    </label>

                    <input type="date"
                           id="createReportDate"
                           class="form-control"
                           onchange="updateReportPreview()">

                </div>


                {{-- TRAINER --}}
                <div class="form-group">

                    <label class="form-label">
                        Abacus Trainer's Name
                    </label>

                    <input type="text"
                           id="createTrainerName"
                           class="form-control"
                           placeholder="Enter trainer name">

                </div>


                {{-- REPORT NUMBER --}}
                <div class="form-group">

                    <label class="form-label">
                        Report No.
                    </label>

                    <input type="text"
                           id="createReportNumber"
                           class="form-control"
                           value="01">

                </div>

            </div>


            {{-- STUDENTS --}}
            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                margin-bottom:10px;
            ">

                <div>

                    <h3 style="
                        margin:0;
                        font-size:16px;
                    ">
                        Students
                    </h3>

                    <span style="
                        font-size:12px;
                        color:var(--faint);
                    ">
                        Select students to include in this report
                    </span>

                </div>


                <label style="
                    display:flex;
                    align-items:center;
                    gap:7px;
                    font-size:13px;
                ">

                    <input type="checkbox"
                           id="selectAllStudents"
                           onchange="toggleAllStudents(this.checked)">

                    Select All

                </label>

            </div>


            <div style="
                border:1px solid #e5e5e5;
                border-radius:8px;
                overflow:hidden;
            ">

                <div style="
                    max-height:300px;
                    overflow-y:auto;
                ">

                    <table class="roles-table">

                        <thead>

                            <tr>

                                <th style="width:45px">
                                </th>

                                <th>Enrollment ID</th>

                                <th>Student</th>

                                <th>Total</th>

                                <th>Correct</th>

                                <th>Time</th>

                                <th>Result</th>

                                <th>Remark</th>

                            </tr>

                        </thead>

                        <tbody id="studentReportBody">

                            <tr>

                                <td colspan="8"
                                    style="text-align:center;padding:30px;color:var(--faint)">

                                    Select a test to load students.

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- REPORT PREVIEW --}}
            <div style="margin-top:25px">

                <h3 style="
                    font-size:16px;
                    margin-bottom:12px;
                ">
                    Report Preview
                </h3>


                <div id="reportPreview"
                     style="
                        border:1px solid #ddd;
                        padding:25px;
                        border-radius:8px;
                        background:#fff;
                     ">

                    <div style="
                        text-align:center;
                        margin-bottom:20px;
                    ">

                        <h2 style="
                            margin:0;
                            font-size:22px;
                        ">
                            Indian Abacus Academy
                        </h2>

                        <h3 id="previewTitle"
                            style="
                                margin:8px 0 0;
                                font-size:17px;
                            ">
                            Junior Level Weekly Test Report
                        </h3>

                        <p id="previewDate"
                           style="
                                margin:6px 0 0;
                                font-size:13px;
                           ">
                            Report 01/01/2025
                        </p>

                    </div>


                    <div style="
                        display:grid;
                        grid-template-columns:1fr 1fr;
                        gap:8px 20px;
                        margin-bottom:20px;
                        font-size:13px;
                    ">

                        <div>
                            <strong>Report No.:</strong>
                            <span id="previewReportNumber">
                                01
                            </span>
                        </div>

                        <div>
                            <strong>Type:</strong>
                            <span id="previewType">
                                Weekly
                            </span>
                        </div>

                        <div>
                            <strong>Abacus Trainer's Name:</strong>
                            <span id="previewTrainer">
                                -
                            </span>
                        </div>

                        <div>
                            <strong>Level:</strong>
                            <span id="previewLevel">
                                -
                            </span>
                        </div>

                    </div>


                    <div style="overflow-x:auto">

                        <table class="roles-table">

                            <thead>

                                <tr>

                                    <th>S.No.</th>

                                    <th>Date</th>

                                    <th>Name</th>

                                    <th>Total / Time</th>

                                    <th>Correct</th>

                                    <th>Time</th>

                                    <th>Result</th>

                                    <th>Remark</th>

                                    <th>Remark</th>

                                </tr>

                            </thead>

                            <tbody id="previewStudentBody">

                                <tr>

                                    <td colspan="9"
                                        style="
                                            text-align:center;
                                            color:var(--faint);
                                            padding:20px;
                                        ">

                                        No students selected.

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>


                    <div style="
                        margin-top:20px;
                        font-size:13px;
                        line-height:1.6;
                    ">

                        <strong>
                            Dear Parents,
                        </strong>

                        it's

                        <span id="previewMessageType">
                            Weekly
                        </span>

                        Test Report.

                    </div>


                    <div style="
                        margin-top:10px;
                        font-size:12px;
                        line-height:1.7;
                    ">

                        <strong>
                            Result Remarks :-
                        </strong>

                        70-84 Good,
                        85-89 Very Good,
                        90-94 Excellent,
                        95-100 Outstanding

                    </div>

                </div>

            </div>

        </div>


        <div style="
            display:flex;
            justify-content:flex-end;
            gap:10px;
            padding:15px 20px;
            border-top:1px solid #eee;
        ">

            <button class="btn btn-secondary"
                    onclick="closeCreateReportModal()">

                Cancel

            </button>

            <button class="btn btn-primary"
                    onclick="saveReport()">

                Save

            </button>

            <button class="btn btn-primary"
                    onclick="downloadReport()">

                Download

            </button>

        </div>

    </div>

</div>


{{-- ═══════════════════════════════════════════════
   VIEW REPORT MODAL
═══════════════════════════════════════════════ --}}
<div class="modal-backdrop"
     id="viewReportModal"
     onclick="handleViewBackdrop(event)">

    <div class="modal"
         style="max-width:1000px">

        <div class="modal-header">

            <h2>
                Test Report
            </h2>

            <button class="btn-icon"
                    onclick="closeViewReportModal()">

                <svg width="15"
                     height="15"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2.5">

                    <line x1="18"
                          y1="6"
                          x2="6"
                          y2="18"/>

                    <line x1="6"
                          y1="6"
                          x2="18"
                          y2="18"/>

                </svg>

            </button>

        </div>


        <div class="modal-body"
             id="viewReportContent">

        </div>

    </div>

</div>


@endsection


@section('script')

<script>

let currentPage = 1;

const perPage = 5;




/* ═══════════════════════════════════════════════
   SCORE DATA
═══════════════════════════════════════════════ */

const scores = {!! json_encode(

    $scores->map(function ($s) {

        $percentage = $s->total > 0
            ? round(($s->correct / $s->total) * 100, 2)
            : 0;

        if ($percentage >= 95) {
            $remark = 'Outstanding';
        } elseif ($percentage >= 90) {
            $remark = 'Excellent';
        } elseif ($percentage >= 85) {
            $remark = 'Very Good';
        } elseif ($percentage >= 70) {
            $remark = 'Good';
        } else {
            $remark = 'Needs Improvement';
        }

        return [

            'id' => $s->id,

            'student_enrollment_id' =>
                optional($s->customer)->student_enrollment_id ?? '--',

            'student_name' =>
                optional($s->customer)->name
                ?? ('User #' . $s->user_id),

            'email' =>
                optional($s->customer)->email
                ?? '-',

            'exam_type' =>
                ucfirst($s->exam_type ?? '-'),

            'exam' =>
                ucfirst($s->exam_type)
                . ' | Level '
                . ($s->exam_level ?? '-'),

            'exam_level' =>
                $s->exam_level ?? '-',

            'score_id' =>
                $s->score_unique_id,

            'mode' =>
                $s->exam_mode,

            'total' =>
                $s->total,

            'correct' =>
                $s->correct,

            'wrong' =>
                $s->wrong,

            'skipped' =>
                $s->skipped,

            'time' =>
                $s->time,

            'schedule_test_type' =>
                $s->schedule_test_type,

            'percentage' =>
                $percentage,

            'remark' =>
                $remark,

            'result' =>
                $percentage >= 70
                    ? 'Green'
                    : 'Red',

            'created_at' =>
                $s->created_at
                    ? $s->created_at->format('d M Y h:i A')
                    : '',

            'date' =>
                $s->created_at
                    ? $s->created_at->format('d/m/Y')
                    : '',

        ];

    })->values()

) !!};


/* ═══════════════════════════════════════════════
   REPORTS
═══════════════════════════════════════════════ */

let reports = {!! json_encode(
    $reports->map(function ($report) {

        return [
            'id' => $report->id,
            'report_number' => $report->report_number,
            'type' => $report->type,
            'test' => $report->test,
            'level' => $report->level,
            'trainer' => $report->trainer,
            'date' => $report->report_date
                ? $report->report_date->format('Y-m-d')
                : '',
            'students' => $report->students->map(function ($item) {

                $score = $item->score;

                return [
                    'id' => $score->id,
                    'student_enrollment_id' =>
                        optional($score->customer)->student_enrollment_id ?? '--',
                    'student_name' =>
                        optional($score->customer)->name
                        ?? ('User #' . $score->user_id),
                    'email' =>
                        optional($score->customer)->email ?? '-',
                    'exam' =>
                        ucfirst($score->exam_type ?? '-') .
                        ' | Level ' .
                        ($score->exam_level ?? '-'),
                    'exam_level' =>
                        $score->exam_level ?? '-',
                    'total' => $score->total,
                    'correct' => $score->correct,
                    'wrong' => $score->wrong,
                    'skipped' => $score->skipped,
                    'time' => $score->time,
                    'date' => $score->created_at
                        ? $score->created_at->format('d/m/Y')
                        : '',
                    'percentage' => $item->percentage,
                    'result' => $item->result,
                    'remark' => $item->remark,
                ];

            })->values(),
        ];

    })->values()
) !!};


/* ═══════════════════════════════════════════════
   ESCAPE HTML
═══════════════════════════════════════════════ */

function escHtml(str)
{
    return String(str ?? '')
        .replace(/&/g,'&amp;')
        .replace(/</g,'&lt;')
        .replace(/>/g,'&gt;')
        .replace(/"/g,'&quot;')
        .replace(/'/g,'&#039;');
}


/* ═══════════════════════════════════════════════
   BUILD TEST LIST
═══════════════════════════════════════════════ */

function buildTestList()
{
    const testSelect =
        document.getElementById('createTest');

    const tests = [];

    scores.forEach(score => {

        const key =
            score.exam +
            '|' +
            score.exam_level;

        if (!tests.some(t => t.key === key)) {

            tests.push({

                key: key,

                exam: score.exam,

                level: score.exam_level

            });

        }

    });


    testSelect.innerHTML =
        '<option value="">Select Test</option>';


    tests.forEach(test => {

        const option =
            document.createElement('option');

        option.value = test.key;

        option.textContent =
            test.exam;

        option.dataset.level =
            test.level;

        testSelect.appendChild(option);

    });
}


/* ═══════════════════════════════════════════════
   TEST SELECTED
═══════════════════════════════════════════════ */

function loadReportStudents()
{
    const test =
        document.getElementById('createTest').value;

    const level =
        document.getElementById('createLevel').value;


    let filtered = scores;


    if (test) {

        const parts = test.split('|');

        filtered = filtered.filter(score =>

            score.exam === parts[0] &&
            score.exam_level === parts[1]

        );

    }


    if (level) {

        filtered = filtered.filter(score =>

            score.exam_level === level

        );

    }


    renderStudentSelection(filtered);

    updateReportPreview();
}


/* ═══════════════════════════════════════════════
   STUDENT SELECTION
═══════════════════════════════════════════════ */

function renderStudentSelection(list)
{
    const tbody =
        document.getElementById('studentReportBody');


    if (!list.length) {

        tbody.innerHTML = `

            <tr>

                <td colspan="8"
                    style="
                        text-align:center;
                        padding:30px;
                        color:var(--faint);
                    ">

                    No students found for this test.

                </td>

            </tr>

        `;

        return;

    }


    tbody.innerHTML =
        list.map(score => `

            <tr>

                <td>

                    <input type="checkbox"
                           class="student-checkbox"
                           value="${score.id}"
                           onchange="updateReportPreview()">

                </td>

                <td>
                    ${escHtml(score.student_enrollment_id)}
                </td>

                <td>
                    ${escHtml(score.student_name)}
                </td>

                <td>
                    ${score.total}
                </td>

                <td>
                    <strong style="color:green">
                        ${score.correct}
                    </strong>
                </td>

                <td>
                    ${escHtml(score.time)}
                </td>

                <td>

                    <span class="badge ${
                        score.result === 'Green'
                            ? 'bg-success'
                            : 'bg-danger'
                    }">

                        ${score.result}

                    </span>

                </td>

                <td>
                    ${escHtml(score.remark)}
                </td>

            </tr>

        `).join('');
}


/* ═══════════════════════════════════════════════
   SELECT ALL
═══════════════════════════════════════════════ */

function toggleAllStudents(checked)
{
    document
        .querySelectorAll('.student-checkbox')
        .forEach(checkbox => {

            checkbox.checked = checked;

        });

    updateReportPreview();
}


/* ═══════════════════════════════════════════════
   GET SELECTED STUDENTS
═══════════════════════════════════════════════ */

function getSelectedStudents()
{
    const ids = Array.from(
        document.querySelectorAll('.student-checkbox:checked')
    ).map(el => Number(el.value));


    return scores.filter(score =>
        ids.includes(Number(score.id))
    );
}


/* ═══════════════════════════════════════════════
   UPDATE PREVIEW
═══════════════════════════════════════════════ */

function updateReportPreview()
{
    const type =
        document.getElementById('createReportType').value;

    const level =
        document.getElementById('createLevel').value
        || 'Junior';


    const date =
        document.getElementById('createReportDate').value;


    const trainer =
        document.getElementById('createTrainerName').value
        || '-';


    const reportNumber =
        document.getElementById('createReportNumber').value
        || '01';


    document.getElementById('previewTitle').textContent =

        level +
        ' Level ' +
        type +
        ' Test Report';


    document.getElementById('previewDate').textContent =

        'Report ' +
        formatDate(date);


    document.getElementById('previewReportNumber').textContent =
        reportNumber;


    document.getElementById('previewType').textContent =
        type;


    document.getElementById('previewTrainer').textContent =
        trainer;


    document.getElementById('previewLevel').textContent =
        level + ' Level';


    document.getElementById('previewMessageType').textContent =
        type;


    const students =
        getSelectedStudents();


    const tbody =
        document.getElementById('previewStudentBody');


    if (!students.length) {

        tbody.innerHTML = `

            <tr>

                <td colspan="9"
                    style="
                        text-align:center;
                        color:var(--faint);
                        padding:20px;
                    ">

                    No students selected.

                </td>

            </tr>

        `;

        return;

    }


    tbody.innerHTML =
        students.map((student, index) => `

            <tr>

                <td>
                    ${index + 1}
                </td>

                <td>
                    ${escHtml(student.date)}
                </td>

                <td style="text-align:left">
                    ${escHtml(student.student_name)}
                </td>

                <td>
                    ${student.total} / ${escHtml(student.time)}
                </td>

                <td>
                    ${student.correct}
                </td>

                <td>
                    ${escHtml(student.time)}
                </td>

                <td>

                    <span class="badge ${
                        student.result === 'Green'
                            ? 'bg-success'
                            : 'bg-danger'
                    }">

                        ${student.result}

                    </span>

                </td>

                <td>
                    ${escHtml(student.remark)}
                </td>

                <td>
                    sent H.W / C.W, Test
                </td>

            </tr>

        `).join('');
}


/* ═══════════════════════════════════════════════
   FORMAT DATE
═══════════════════════════════════════════════ */

function formatDate(date)
{
    if (!date) {
        return '';
    }


    const parts = date.split('-');


    if (parts.length !== 3) {
        return date;
    }


    return parts[2] +
        '/' +
        parts[1] +
        '/' +
        parts[0];
}


/* ═══════════════════════════════════════════════
   OPEN CREATE MODAL
═══════════════════════════════════════════════ */

function openCreateReportModal()
{
    document
        .getElementById('createReportModal')
        .classList
        .add('open');


    const date =
        new Date().toISOString().split('T')[0];


    document.getElementById('createReportDate').value =
        date;


    buildTestList();


    buildLevelList();


    updateReportPreview();
}


/* ═══════════════════════════════════════════════
   BUILD LEVEL LIST
═══════════════════════════════════════════════ */

function buildLevelList()
{
    const select =
        document.getElementById('createLevel');


    const levels = [];


    scores.forEach(score => {

        if (
            score.exam_level &&
            !levels.includes(score.exam_level)
        ) {

            levels.push(score.exam_level);

        }

    });


    select.innerHTML =
        '<option value="">Select Level</option>';


    levels.forEach(level => {

        const option =
            document.createElement('option');

        option.value = level;

        option.textContent =
            level + ' Level';

        select.appendChild(option);

    });
}


/* ═══════════════════════════════════════════════
   CLOSE CREATE MODAL
═══════════════════════════════════════════════ */

function closeCreateReportModal()
{
    document
        .getElementById('createReportModal')
        .classList
        .remove('open');
}


/* ═══════════════════════════════════════════════
   BACKDROP
═══════════════════════════════════════════════ */

function handleCreateBackdrop(e)
{
    if (e.target.id === 'createReportModal') {

        closeCreateReportModal();

    }
}


/* ═══════════════════════════════════════════════
   SAVE REPORT
═══════════════════════════════════════════════ */

function saveReport()
{
    const students = getSelectedStudents();

    if (!students.length) {
        alert('Please select at least one student.');
        return;
    }

    const data = {
        report_number:
            document.getElementById('createReportNumber').value,

        type:
            document.getElementById('createReportType').value,

        test:
            document.getElementById('createTest').value,

        level:
            document.getElementById('createLevel').value,

        trainer:
            document.getElementById('createTrainerName').value,

        date:
            document.getElementById('createReportDate').value,

        students:
            students.map(student => student.id)
    };

    fetch("{{ route('teacher.test-reports.store') }}", {

        method: 'POST',

        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN':
                document.querySelector('meta[name="csrf-token"]').content
        },

        body: JSON.stringify(data)

    })
    .then(response => response.json())

    .then(result => {

        if (!result.success) {
            alert(result.message || 'Unable to save report.');
            return;
        }

        alert('Test report saved successfully.');

        location.reload();

    })
    .catch(error => {

        console.error(error);

        alert('Something went wrong while saving the report.');

    });
}

// Delete report
function deleteReport(id)
{
    const report = reports.find(x => x.id === id);

    if (!report) return;

    if (!confirm(
        `Are you sure you want to delete Report ${report.report_number}?`
    )) {
        return;
    }

    fetch(
        `{{ url('/teacher/test-reports') }}/${id}`,
        {
            method: 'DELETE',

            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN':
                    document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content
            }
        }
    )
    .then(response => response.json())

    .then(result => {

        if (!result.success) {
            alert(result.message || 'Unable to delete report.');
            return;
        }

        alert('Test report deleted successfully.');

        location.reload();

    })
    .catch(error => {

        console.error(error);

        alert('Something went wrong.');

    });
}
/* ═══════════════════════════════════════════════
   RENDER REPORTS
═══════════════════════════════════════════════ */

function renderReports(list)
{
    const tbody =
        document.getElementById('reportBody');

    const empty =
        document.getElementById('emptyState');


    document.getElementById('report-count').textContent =

        list.length +
        ' Report' +
        (list.length !== 1 ? 's' : '');


    if (!list.length) {

        tbody.innerHTML = '';

        empty.style.display = 'block';

        document.getElementById('pagination').innerHTML = '';

        return;

    }


    empty.style.display = 'none';


    const totalPages =
        Math.ceil(list.length / perPage);


    if (currentPage > totalPages) {

        currentPage = totalPages;

    }


    const start =
        (currentPage - 1) * perPage;


    const pageData =
        list.slice(start, start + perPage);


    tbody.innerHTML =
        pageData.map((report, index) => `

            <tr>

                <td>
                    ${start + index + 1}
                </td>

                <td>
                    ${escHtml(report.report_number)}
                </td>

                <td>
                    ${escHtml(report.test || '-')}
                </td>

                <td>

                    <span class="badge bg-warning">
                        ${escHtml(report.type)}
                    </span>

                </td>

                <td>
                    ${escHtml(report.level || '-')}
                </td>

                <td>
                    ${escHtml(report.trainer || '-')}
                </td>

                <td>
                    ${formatDate(report.date)}
                </td>

                <td>
                    ${report.students.length}
                </td>

                <td>

                    <div class="actions-cell"
                         style="
                            justify-content:flex-end;
                            gap:8px;
                         ">

                        {{-- VIEW --}}
                        <button class="btn-icon"
                                title="View"
                                onclick="viewReport(${report.id})">

                            <svg width="15"
                                 height="15"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">

                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/>

                                <circle cx="12"
                                        cy="12"
                                        r="3"/>

                            </svg>

                        </button>
                        <button class="btn-icon"
        title="Delete"
        onclick="deleteReport(${report.id})">

    <svg width="15"
         height="15"
         viewBox="0 0 24 24"
         fill="none"
         stroke="currentColor"
         stroke-width="2">

        <polyline points="3 6 5 6 21 6"></polyline>
        <path d="M19 6l-1 14H6L5 6"></path>
        <path d="M10 11v6"></path>
        <path d="M14 11v6"></path>
        <path d="M9 6V4h6v2"></path>

    </svg>

</button>


                        {{-- SHARE --}}
                        <button class="btn-icon"
                                title="Share"
                                onclick="shareReport(${report.id})">

                            <svg width="15"
                                 height="15"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">

                                <circle cx="18"
                                        cy="5"
                                        r="3"/>

                                <circle cx="6"
                                        cy="12"
                                        r="3"/>

                                <circle cx="18"
                                        cy="19"
                                        r="3"/>

                                <line x1="8.6"
                                      y1="13.5"
                                      x2="15.4"
                                      y2="17.5"/>

                                <line x1="15.4"
                                      y1="6.5"
                                      x2="8.6"
                                      y2="10.5"/>

                            </svg>

                        </button>


                        {{-- DOWNLOAD --}}
                        <button class="btn-icon"
                                title="Download"
                                onclick="downloadExistingReport(${report.id})">

                            <svg width="15"
                                 height="15"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">

                                <path d="M12 3v12"/>

                                <path d="M7 10l5 5 5-5"/>

                                <path d="M5 21h14"/>

                            </svg>

                        </button>

                    </div>

                </td>

            </tr>

        `).join('');


    renderPagination(totalPages);
}


/* ═══════════════════════════════════════════════
   PAGINATION
═══════════════════════════════════════════════ */

function renderPagination(totalPages)
{
    let html = '';


    html += `

        <button
            ${currentPage == 1 ? 'disabled' : ''}
            onclick="changePage(${currentPage - 1})">

            Previous

        </button>

    `;


    for (
        let i = 1;
        i <= totalPages;
        i++
    ) {

        html += `

            <button
                class="${currentPage == i ? 'active' : ''}"
                onclick="changePage(${i})">

                ${i}

            </button>

        `;

    }


    html += `

        <button
            ${currentPage == totalPages ? 'disabled' : ''}
            onclick="changePage(${currentPage + 1})">

            Next

        </button>

    `;


    document.getElementById('pagination').innerHTML =
        html;
}


/* ═══════════════════════════════════════════════
   CHANGE PAGE
═══════════════════════════════════════════════ */

function changePage(page)
{
    currentPage = page;


    const lower =
        document
            .getElementById('searchInput')
            .value
            .toLowerCase();


    const filtered =
        reports.filter(report =>

            (report.report_number ?? '')
                .toLowerCase()
                .includes(lower)

            ||

            (report.test ?? '')
                .toLowerCase()
                .includes(lower)

            ||

            (report.level ?? '')
                .toLowerCase()
                .includes(lower)

            ||

            (report.trainer ?? '')
                .toLowerCase()
                .includes(lower)

        );


    renderReports(filtered);
}


/* ═══════════════════════════════════════════════
   SEARCH
═══════════════════════════════════════════════ */

function filterReports(query)
{
    currentPage = 1;


    const lower =
        query.toLowerCase();


    const filtered =
        reports.filter(report =>

            (report.report_number ?? '')
                .toLowerCase()
                .includes(lower)

            ||

            (report.test ?? '')
                .toLowerCase()
                .includes(lower)

            ||

            (report.level ?? '')
                .toLowerCase()
                .includes(lower)

            ||

            (report.trainer ?? '')
                .toLowerCase()
                .includes(lower)

        );


    renderReports(filtered);
}


/* ═══════════════════════════════════════════════
   VIEW REPORT
═══════════════════════════════════════════════ */

function viewReport(id)
{
    const report =
        reports.find(x => x.id === id);


    if (!report) return;


    let rows = '';


    report.students.forEach((student, index) => {

        rows += `

            <tr>

                <td>
                    ${index + 1}
                </td>

                <td>
                    ${escHtml(student.date)}
                </td>

                <td>
                    ${escHtml(student.student_name)}
                </td>

                <td>
                    ${student.total} / ${escHtml(student.time)}
                </td>

                <td>
                    ${student.correct}
                </td>

                <td>
                    ${escHtml(student.time)}
                </td>

                <td>
                    ${escHtml(student.result)}
                </td>

                <td>
                    ${escHtml(student.remark)}
                </td>

                <td>
                    sent H.W / C.W, Test
                </td>

            </tr>

        `;

    });


    document.getElementById('viewReportContent').innerHTML = `

        <div id="printReport">

            <div style="
                text-align:center;
                margin-bottom:25px;
            ">

                <h2 style="margin:0">
                    Indian Abacus Academy
                </h2>

                <h3 style="margin:8px 0">

                    ${escHtml(report.level)}
                    Level
                    ${escHtml(report.type)}
                    Test Report

                </h3>

                <p>
                    Report ${formatDate(report.date)}
                </p>

            </div>


            <div style="
                display:grid;
                grid-template-columns:1fr 1fr;
                gap:8px 20px;
                margin-bottom:20px;
                font-size:13px;
            ">

                <div>
                    <strong>Report No.:</strong>
                    ${escHtml(report.report_number)}
                </div>

                <div>
                    <strong>Type:</strong>
                    ${escHtml(report.type)}
                </div>

                <div>
                    <strong>Abacus Trainer's Name:</strong>
                    ${escHtml(report.trainer)}
                </div>

                <div>
                    <strong>Level:</strong>
                    ${escHtml(report.level)}
                </div>

            </div>


            <div style="overflow-x:auto">

                <table class="roles-table">

                    <thead>

                        <tr>

                            <th>S.No.</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Total / Time</th>
                            <th>Correct</th>
                            <th>Time</th>
                            <th>Result</th>
                            <th>Remark</th>
                         <th>H.W / C.W / Test</th>

                        </tr>

                    </thead>

                    <tbody>

                        ${rows}

                    </tbody>

                </table>

            </div>


            <div style="
                margin-top:20px;
                font-size:13px;
                line-height:1.6;
            ">

                <strong>
                    Dear Parents,
                </strong>

                it's
                ${escHtml(report.type)}
                Test Report.

            </div>


            <div style="
                margin-top:10px;
                font-size:12px;
                line-height:1.7;
            ">

                <strong>
                    Result Remarks :-
                </strong>

                70-84 Good,
                85-89 Very Good,
                90-94 Excellent,
                95-100 Outstanding

            </div>

        </div>

    `;


    document
        .getElementById('viewReportModal')
        .classList
        .add('open');
}


/* ═══════════════════════════════════════════════
   CLOSE VIEW MODAL
═══════════════════════════════════════════════ */

function closeViewReportModal()
{
    document
        .getElementById('viewReportModal')
        .classList
        .remove('open');
}


/* ═══════════════════════════════════════════════
   VIEW BACKDROP
═══════════════════════════════════════════════ */

function handleViewBackdrop(e)
{
    if (e.target.id === 'viewReportModal') {

        closeViewReportModal();

    }
}


/* ═══════════════════════════════════════════════
   SHARE REPORT
═══════════════════════════════════════════════ */

function shareReport(id)
{
    const report =
        reports.find(x => x.id === id);


    if (!report) return;


    const text =

`Indian Abacus Academy

${report.level} Level ${report.type} Test Report

Report No.: ${report.report_number}
Date: ${formatDate(report.date)}
Trainer: ${report.trainer}

Students: ${report.students.length}`;


    if (navigator.share) {

        navigator.share({

            title:
                'Test Report',

            text:
                text

        });

    } else {

        navigator.clipboard.writeText(text);

        alert(
            'Report details copied. You can paste and share.'
        );

    }
}


/* ═══════════════════════════════════════════════
   DOWNLOAD REPORT
═══════════════════════════════════════════════ */

function downloadReport()
{
    const report =
        document.getElementById('reportPreview');


    const printWindow =
        window.open('', '_blank');


    printWindow.document.write(`

        <html>

        <head>

            <title>
                Test Report
            </title>

            <style>

                body {
                    font-family: Arial, sans-serif;
                    padding: 30px;
                }

                table {
                    width:100%;
                    border-collapse:collapse;
                }

                th,
                td {
                    border:1px solid #222;
                    padding:8px;
                    text-align:center;
                    font-size:12px;
                }

                th {
                    font-weight:bold;
                }

            </style>

        </head>

        <body>

            ${report.innerHTML}

        </body>

        </html>

    `);


    printWindow.document.close();


    printWindow.focus();


    setTimeout(() => {

        printWindow.print();

    }, 300);
}


/* ═══════════════════════════════════════════════
   DOWNLOAD EXISTING REPORT
═══════════════════════════════════════════════ */

function downloadExistingReport(id)
{
    viewReport(id);


    setTimeout(() => {

        const content =
            document.getElementById('viewReportContent');


        const printWindow =
            window.open('', '_blank');


        printWindow.document.write(`

            <html>

            <head>

                <title>
                    Test Report
                </title>

                <style>

                    body {
                        font-family: Arial, sans-serif;
                        padding: 30px;
                    }

                    table {
                        width:100%;
                        border-collapse:collapse;
                    }

                    th,
                    td {
                        border:1px solid #222;
                        padding:8px;
                        text-align:center;
                        font-size:12px;
                    }

                    th {
                        font-weight:bold;
                    }

                </style>

            </head>

            <body>

                ${content.innerHTML}

            </body>

            </html>

        `);


        printWindow.document.close();

        printWindow.focus();


        setTimeout(() => {

            printWindow.print();

        }, 300);


    }, 200);
}


/* ═══════════════════════════════════════════════
   ESC KEY
═══════════════════════════════════════════════ */

document.addEventListener('keydown', e => {

    if (e.key === 'Escape') {

        closeCreateReportModal();

        closeViewReportModal();

    }

});


/* ═══════════════════════════════════════════════
   INITIALIZE
═══════════════════════════════════════════════ */

renderReports(reports);

</script>

@endsection