@extends('admin.layout.app')

@section('content')

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">
    <div>
        <h1>Scores</h1>
        <p>View and manage exam scores</p>
    </div>

    <button class="btn btn-primary">
        Total Scores : {{ count($scores) }}
    </button>
</div>

{{-- ═══════════ MAIN CARD ═══════════ --}}
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

            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>

        </svg>

        <input type="text"
               id="searchInput"
               placeholder="Search student / exam..."
               oninput="filterScores(this.value)">
        <select id="typeFilter" onchange="filterScores(document.getElementById('searchInput').value)" style="margin-right: 15px; padding: 6px 12px; border-radius: 6px; border: 1px solid var(--border-color); font-size: 14px; outline: none; background: white; color: var(--text-color);">
            <option value="">All Types</option>
            <option value="practice">Practice</option>
            <option value="test">Online Test</option>
            <option value="exam">Online Exam</option>
        </select>

        <span id="score-count"
              style="font-size:12px;color:var(--faint);white-space:nowrap">
        </span>

    </div>

    {{-- TABLE --}}
    <div style="overflow-x:auto">

        <table class="roles-table">

            <thead>
                <tr>
                    <th style="width:40px">#</th>
                    <th>Enrollment ID</th>
<th style="width:40px;">Student</th>
<th>Email</th>
                    <th>Exam</th>
                    <th>Mode</th>
                    <th>Score</th>
                    <th>Wrong</th>
                    <th>Skipped</th>
                    <th>Time</th>
                    <th>Date</th>
                    <th style="width:100px;text-align:right">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody id="scoreBody"></tbody>

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

                <circle cx="12" cy="12" r="10"/>
                <path d="M9 12l2 2 4-4"/>

            </svg>

            <p>No Scores Found</p>

            <span>
                Try another search keyword
            </span>

        </div>
<div id="pagination" class="pagination"></div>
    </div>

</div>

{{-- ═══════════ VIEW MODAL ═══════════ --}}
<div class="modal-backdrop"
     id="viewModal"
     onclick="handleBackdrop(event)">

    <div class="modal"
         style="max-width:600px">

        <div class="modal-header">

            <h2>
                Score Details
            </h2>

            <button class="btn-icon"
                    onclick="closeViewModal()">

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

        <div class="modal-body"
             id="scoreDetails">

        </div>

    </div>

</div>

@endsection

@section('script')

<script>

let currentPage = 1;
const perPage = 5;
const scores = {!! json_encode(

    $scores->map(function ($s) {

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

            'exam' =>
                ucfirst($s->exam_type)
                . ' | Level ' .
                ($s->exam_level ?? '-'),

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

            'exam_selfie' =>
                $s->exam_selfie,

            'latitude' =>
                $s->latitude,

            'longitude' =>
                $s->longitude,

            'created_at' =>
                $s->created_at
                    ? $s->created_at->format('d M Y h:i A')
                    : '',

            'is_visible' =>
                $s->is_visible,
        ];

    })->values()
) !!};

/* ═══════════════════════════════
   ESCAPE
═══════════════════════════════ */
function escHtml(str) {

    return String(str ?? '')
        .replace(/&/g,'&amp;')
        .replace(/</g,'&lt;')
        .replace(/>/g,'&gt;')
        .replace(/"/g,'&quot;');
}

/* ═══════════════════════════════
   RENDER
═══════════════════════════════ */
function render(list) {

    const tbody = document.getElementById('scoreBody');
    const empty = document.getElementById('emptyState');

    document.getElementById('score-count').textContent =
        list.length + ' Score' +
        (list.length !== 1 ? 's' : '');

 if (!list.length) {

        tbody.innerHTML = '';

        empty.style.display = 'block';

        document.getElementById('pagination').innerHTML = '';

        return;
    }

    empty.style.display = 'none';

    const totalPages = Math.ceil(list.length / perPage);

    if (currentPage > totalPages)
        currentPage = totalPages;

    const start = (currentPage - 1) * perPage;

    const pageData = list.slice(start, start + perPage);

    tbody.innerHTML = pageData.map((score, i) => {

        return `
        <tr>

            <td>${start + i + 1}</td>
<td>${score.student_enrollment_id ?? "--"}</td>
            <td>

                <div style="display:flex;align-items:center;gap:10px">



                        <strong>
                            ${escHtml(score.student_name)}
                        </strong>

                        <div style="font-size:12px;color:var(--faint)">
                            ${escHtml(score.score_id ?? '')}
                        </div>

                    </div>



            </td>

<td style="
    width:120px;
    max-width:120px;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
">
    ${escHtml(score.email)}
</td>

            <td>
                ${escHtml(score.exam)}
            </td>

            <td>

                <span class="badge
                    ${score.mode === 'easy'
                        ? 'bg-success'
                        : 'bg-warning'}">

                    ${escHtml(score.mode)}

                </span>

            </td>

            <td>

                <strong style="color:green">
                    ${score.is_visible == 0 ? '-' : score.correct}
                </strong>

                /

                ${score.is_visible == 0 ? '-' : score.total}

            </td>

            <td style="color:red">
                ${score.is_visible == 0 ? '-' : score.wrong}
            </td>

            <td>
                ${score.is_visible == 0 ? '-' : score.skipped}
            </td>

            <td>
                ${score.time}
            </td>

            <td>
                ${score.created_at}
            </td>

          <td>
    <div class="actions-cell" style="justify-content:flex-end;gap:8px;">

        <!-- View -->
        <button class="btn-icon"
                title="View"
                onclick="viewScore(${score.id})">

            <svg width="15"
                 height="15"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">

                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/>
                <circle cx="12" cy="12" r="3"/>

            </svg>

        </button>

        <!-- Share -->
        <button class="btn-icon"
                title="Share"
                onclick="shareScore(${score.id})">

            <svg width="15"
                 height="15"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">

                <circle cx="18" cy="5" r="3"/>
                <circle cx="6" cy="12" r="3"/>
                <circle cx="18" cy="19" r="3"/>

                <line x1="8.6" y1="13.5" x2="15.4" y2="17.5"/>
                <line x1="15.4" y1="6.5" x2="8.6" y2="10.5"/>

            </svg>

        </button>

        <!-- Copy -->
        <button class="btn-icon"
                title="Copy Score ID"
                onclick="copyScore(${score.id})">

            <svg width="15"
                 height="15"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">

                <rect x="9" y="9" width="13" height="13" rx="2"/>
                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>

            </svg>

        </button>

        <!-- Reset visibility -->
        <button class="btn-icon"
                title="Reset score visibility"
                onclick="resetScore(${score.id})">

            <svg width="15"
                 height="15"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">

                <path d="M3 12a9 9 0 1 0 3-6.7"/>
                <polyline points="3 4 3 10 9 10"/>

            </svg>

        </button>

    </div>
</td>

        </tr>
        `;

    }).join('');
        renderPagination(totalPages);
}

function copyScore(id) {

    const s = scores.find(x => x.id === id);

    if (!s) return;

    const text =
`Student : ${s.student_name}
Enrollment ID : ${s.student_enrollment_id ?? "--"}
Email : ${s.email}
Exam : ${s.exam}
Score : ${s.correct}/${s.total}
Wrong : ${s.wrong}
Skipped : ${s.skipped ?? "--"}
Time : ${s.time}
Score ID : ${s.score_id ?? "--"}`;

    navigator.clipboard.writeText(text).then(() => {
        alert("Score details copied!");
    });

}

function resetScore(id) {
    if (!confirm('Hide this score from the student score sheet?')) return;

    fetch('{{ url('/admin/scores') }}/' + id + '/reset', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    }).then(response => {
        if (!response.ok) throw new Error('Reset failed');
        const score = scores.find(item => item.id === id);
        if (score) score.is_visible = 0;
        alert('Score hidden from the student score sheet.');
    }).catch(() => alert('Unable to reset score.'));
}

function shareScore(id) {

    const s = scores.find(x => x.id === id);

    if (!s) return;

    const text =
`Student : ${s.student_name}
Exam : ${s.exam}
Score : ${s.correct}/${s.total}
Wrong : ${s.wrong}
Skipped : ${s.skipped}
Score ID : ${s.score_unique_id}`;

    if (navigator.share) {

        navigator.share({
            title: 'Exam Score',
            text: text
        });

    } else {

        navigator.clipboard.writeText(text);

        alert("Score details copied. You can paste and share.");

    }

}

function renderPagination(totalPages) {

    let html = '';

    html += `
        <button
            ${currentPage == 1 ? 'disabled' : ''}
            onclick="changePage(${currentPage-1})">
            Previous
        </button>
    `;

    for (let i = 1; i <= totalPages; i++) {

        html += `
            <button
                class="${currentPage==i ? 'active' : ''}"
                onclick="changePage(${i})">
                ${i}
            </button>
        `;
    }

    html += `
        <button
            ${currentPage==totalPages ? 'disabled' : ''}
            onclick="changePage(${currentPage+1})">
            Next
        </button>
    `;

    document.getElementById('pagination').innerHTML = html;
}

function changePage(page) {

    currentPage = page;

    const lower = document
        .getElementById('searchInput')
        .value
        .toLowerCase();

    const typeFilter = document.getElementById('typeFilter').value.toLowerCase();

    const filtered = scores.filter(score => {
        let matchesSearch = (score.student_name ?? '').toLowerCase().includes(lower) ||
                            (score.email ?? '').toLowerCase().includes(lower) ||
                            (score.exam ?? '').toLowerCase().includes(lower) ||
                            (score.score_id ?? '').toLowerCase().includes(lower);

        let matchesType = typeFilter === '' || (score.exam ?? '').toLowerCase().includes(typeFilter);

        return matchesSearch && matchesType;
    });

    render(filtered);
}

/* ═══════════════════════════════
   SEARCH
═══════════════════════════════ */
function filterScores(query) {

    currentPage = 1;

    const lower = query.toLowerCase();

    const typeFilter = document.getElementById('typeFilter').value.toLowerCase();

    const filtered = scores.filter(score => {
        let matchesSearch = (score.student_name ?? '').toLowerCase().includes(lower) ||
                            (score.email ?? '').toLowerCase().includes(lower) ||
                            (score.exam ?? '').toLowerCase().includes(lower) ||
                            (score.score_id ?? '').toLowerCase().includes(lower);

        let matchesType = typeFilter === '' || (score.exam ?? '').toLowerCase().includes(typeFilter);

        return matchesSearch && matchesType;
    });

    render(filtered);
}
/* ═══════════════════════════════
   VIEW SCORE
═══════════════════════════════ */
function viewScore(id) {

    const s = scores.find(x => x.id === id);

    if (!s) return;

    document.getElementById('scoreDetails').innerHTML = `

        ${
            s.exam_selfie
                ? `
                <div class="form-group">
                    <label class="form-label">Exam Selfie</label>
                    <div>
                        <img src="${s.exam_selfie}"
                             alt="Exam Selfie"
                             style="max-width:220px;border-radius:8px;border:1px solid #ddd;">
                    </div>
                </div>
                `
                : ''
        }

        <div class="form-group">
            <label class="form-label">Student</label>
            <div>${s.student_name}</div>
        </div>

        <div class="form-group">
            <label class="form-label">Email</label>
            <div>${s.email}</div>
        </div>

        <div class="form-group">
            <label class="form-label">Exam</label>
            <div>${s.exam}</div>
        </div>

        <div class="form-group">
            <label class="form-label">Score ID</label>
            <div>${s.score_id}</div>
        </div>

        <div class="form-group">
            <label class="form-label">Correct Answers</label>
            <div>${s.is_visible == 0 ? '-' : s.correct}</div>
        </div>

        <div class="form-group">
            <label class="form-label">Wrong Answers</label>
            <div>${s.is_visible == 0 ? '-' : s.wrong}</div>
        </div>

        <div class="form-group">
            <label class="form-label">Skipped</label>
            <div>${s.is_visible == 0 ? '-' : s.skipped}</div>
        </div>

        <div class="form-group">
            <label class="form-label">Total Questions</label>
            <div>${s.is_visible == 0 ? '-' : s.total}</div>
        </div>

        <div class="form-group">
            <label class="form-label">Time</label>
            <div>${s.time}</div>
        </div>

        <div class="form-group">
            <label class="form-label">Mode</label>
            <div>${s.mode}</div>
        </div>

        <div class="form-group">
            <label class="form-label">Latitude</label>
            <div>${s.latitude ?? '-'}</div>
        </div>

        <div class="form-group">
            <label class="form-label">Longitude</label>
            <div>${s.longitude ?? '-'}</div>
        </div>

        <div class="form-group">
            <label class="form-label">Date</label>
            <div>${s.created_at}</div>
        </div>

    `;

    document.getElementById('viewModal')
        .classList
        .add('open');
}

/* ═══════════════════════════════
   CLOSE MODAL
═══════════════════════════════ */
function closeViewModal() {

    document.getElementById('viewModal')
        .classList
        .remove('open');
}

function handleBackdrop(e) {

    if (e.target.id === 'viewModal') {
        closeViewModal();
    }
}

/* ═══════════════════════════════
   ESC KEY
═══════════════════════════════ */
document.addEventListener('keydown', e => {

    if (e.key === 'Escape') {
        closeViewModal();
    }
});

/* ═══════════════════════════════
   INIT
═══════════════════════════════ */
render(scores);

</script>

@endsection