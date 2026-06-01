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
<th style="width:150px;">Student</th>
<th style="width:100px;">Email</th>
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

const scores = {!! json_encode(
    $scores->map(function ($s) {

        return [

            'id' => $s->id,

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

            'created_at' =>
                $s->created_at
                    ? $s->created_at->format('d M Y h:i A')
                    : '',

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

        return;
    }

    empty.style.display = 'none';

    tbody.innerHTML = list.map((score, i) => {

        return `
        <tr>

            <td>
                ${i + 1}
            </td>

            <td>

                <div style="display:flex;align-items:center;gap:10px">



                        <strong>
                            ${escHtml(score.student_name)}
                        </strong>

                        <div style="font-size:12px;color:var(--faint)">
                            ${escHtml(score.score_id ?? '')}
                        </div>

                    </div>

                </div>

            </td>

            <td>
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
                    ${score.correct}
                </strong>

                /
                
                ${score.total}

            </td>

            <td style="color:red">
                ${score.wrong}
            </td>

            <td>
                ${score.skipped}
            </td>

            <td>
                ${score.time}
            </td>

            <td>
                ${score.created_at}
            </td>

            <td>

                <div class="actions-cell"
                     style="justify-content:flex-end">

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

                            <circle cx="12"
                                    cy="12"
                                    r="3"/>

                        </svg>

                    </button>

                </div>

            </td>

        </tr>
        `;

    }).join('');
}

/* ═══════════════════════════════
   SEARCH
═══════════════════════════════ */
function filterScores(query) {

    const lower = query.toLowerCase();

    const filtered = scores.filter(score =>

        (score.student_name ?? '')
            .toLowerCase()
            .includes(lower)

        ||

        (score.email ?? '')
            .toLowerCase()
            .includes(lower)

        ||

        (score.exam ?? '')
            .toLowerCase()
            .includes(lower)

        ||

        (score.score_id ?? '')
            .toLowerCase()
            .includes(lower)
    );

    render(filtered);
}

/* ═══════════════════════════════
   VIEW SCORE
═══════════════════════════════ */
function viewScore(id) {

    const s = scores.find(x => x.id === id);

    if (!s) return;

    document.getElementById('scoreDetails').innerHTML = `

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
            <div>${s.correct}</div>
        </div>

        <div class="form-group">
            <label class="form-label">Wrong Answers</label>
            <div>${s.wrong}</div>
        </div>

        <div class="form-group">
            <label class="form-label">Skipped</label>
            <div>${s.skipped}</div>
        </div>

        <div class="form-group">
            <label class="form-label">Total Questions</label>
            <div>${s.total}</div>
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