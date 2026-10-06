@extends('admin.layout.app')

@section('content')

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">
    <div>
        <h1>Questions</h1>
        <p>Manage exam questions</p>
    </div>

    <button class="btn btn-primary" onclick="openCreateModal()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
        </svg>
        New Question
    </button>
</div>

{{-- ═══════════ TABLE CARD ═══════════ --}}
<div class="card">

    <div class="search-bar">

        <svg width="15" height="15" viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            style="color:var(--faint);flex-shrink:0">

            <circle cx="11" cy="11" r="8" />
            <line x1="21" y1="21" x2="16.65" y2="16.65" />

        </svg>

        <input type="text"
            id="searchInput"
            placeholder="Search Questions…">

        <span id="question-count"
            style="font-size:12px;color:var(--faint);white-space:nowrap">
        </span>

    </div>

    <div style="overflow-x:auto">

        <table class="roles-table">

            <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <th>Question</th>
                    <th>Type</th>
                    <th>Level</th>
                    <th>Difficulty</th>
                    <th style="width:120px;text-align:right">Actions</th>
                </tr>
            </thead>

            <tbody id="questionBody"></tbody>

        </table>

        <div id="emptyState"
            class="empty-state"
            style="display:none">

            <svg width="40" height="40" viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5">

                <circle cx="12" cy="12" r="10" />
                <path d="M9.09 9a3 3 0 1 1 5.82 1c0 2-3 3-3 3" />
                <line x1="12" y1="17" x2="12.01" y2="17" />

            </svg>

            <p>No Questions found</p>
            <span>Try a different search or create a new question</span>

        </div>

    </div>

</div>

{{-- ═══════════ CREATE / EDIT MODAL ═══════════ --}}
<div class="modal-backdrop"
    id="formModal"
    onclick="handleBackdropClick(event)">

    <div class="modal"
        style="max-width:1100px">

        <div class="modal-header">

            <h2 id="modalTitle">Add Questions</h2>

            <button class="btn-icon" onclick="closeFormModal()">

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

            {{-- TOP FORM --}}
            <div class="row">

                <div class="col-md-3 form-group">
                    <label class="form-label">Question Type</label>

                    <select id="questionType" class="form-control">

                        <option value="">Select Type</option>

                        @foreach($questionTypes as $type)
                        <option value="{{ $type->id }}">
                            {{ $type->name }}
                        </option>
                        @endforeach

                    </select>
                </div>

               <div class="col-md-3 form-group" id="difficultyContainer">
    <label class="form-label">Difficulty</label>

    <select id="difficulty" class="form-control">
        <option value="">Select Difficulty</option>
        <option value="easy">Easy</option>
        <option value="medium">Medium</option>
        <option value="hard">Hard</option>
    </select>
</div>
                <div class="col-md-3 form-group">
                    <label class="form-label">Level</label>

                    <select id="examLevel" class="form-control">

                        <option value="">Select Level</option>

                        @foreach($levels as $level)
                        <option value="{{ $level->level }}">
                            Level {{ $level->level }}
                        </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-3 form-group">
                    <label class="form-label">
                        Number of Questions
                    </label>

                    <input type="number"
                        id="numberOfQuestions"
                        class="form-control"
                        min="1"
                        max="100"
                        placeholder="Enter number">
                </div>

            </div>

            <hr style="margin:20px 0">

            {{-- DYNAMIC QUESTIONS --}}
            <div id="dynamicQuestions"></div>

        </div>

        <div class="modal-footer">

            <button class="btn btn-ghost"
                onclick="closeFormModal()">

                Cancel

            </button>

            <button class="btn btn-primary"
                id="saveBtn"
                onclick="saveQuestion()">

                <span class="btn-label">
                    Save Questions
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

                    <polyline points="3 6 5 6 21 6" />
                    <path d="M19 6l-1 14H6L5 6" />
                    <path d="M10 11v6" />
                    <path d="M14 11v6" />
                    <path d="M9 6V4h6v2" />

                </svg>

            </div>

            <h3>Delete Question?</h3>

            <p>
                Are you sure you want to delete this question?
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

let questions = [];
let editingId = null;
let deletingId = null;

const CSRF =
document.querySelector('meta[name="csrf-token"]')?.content ?? '';

const questionTypeSelect = document.getElementById('questionType');

questionTypeSelect.addEventListener('change', function () {

const selectedText =
    this.options[this.selectedIndex].text.trim().toLowerCase();

const container =
    document.getElementById('difficultyContainer');

if (selectedText === 'test') {

    container.innerHTML = `
        <label class="form-label">Test Type</label>

        <select id="scheduleTestType" class="form-control">
            <option value="">Select Test Type</option>
            <option value="weekly_test">Weekly Test</option>
            <option value="monthly_test">Monthly Test</option>
        </select>
    `;

} else if (selectedText === 'exam') {

    container.innerHTML = `
        <label class="form-label">Exam Type</label>

        <select id="examType" class="form-control">
            <option value="">Select Exam Type</option>
            <option value="final_exam">Final Exam</option>
            <option value="olympiad_exam">Olympiad Exam</option>
        </select>
    `;

} else {

    container.innerHTML = `
        <label class="form-label">Difficulty</label>

        <select id="difficulty" class="form-control">
            <option value="">Select Difficulty</option>
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select>
    `;
}
});

/* =====================================================
   FETCH QUESTIONS
===================================================== */

async function fetchQuestions() {

    try {

        const res = await fetch(`/admin/questions`, {

            method: 'GET',

            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }

        });

        if (!res.ok) {
            throw new Error('Failed response');
        }

        const data = await res.json();

        console.log('Questions:', data);

        questions = Array.isArray(data)
            ? data
            : (data.questions || []);

        render(questions);

    } catch (err) {

        console.error(err);

        alert('Failed to load questions');
    }
}

/* =====================================================
   RENDER QUESTIONS
===================================================== */

function render(list) {

    const tbody =
        document.getElementById('questionBody');

    const empty =
        document.getElementById('emptyState');

    document.getElementById('question-count').textContent =
        list.length + ' Question' + (list.length !== 1 ? 's' : '');

    if (!list.length) {

        tbody.innerHTML = '';

        empty.style.display = 'block';

        return;
    }

    empty.style.display = 'none';

    tbody.innerHTML = list.map((q, i) => {

        return `
        <tr>

            <td>${i + 1}</td>

            <td>
                <strong>${q.question ?? '-'}</strong>
            </td>

            <td>${q.question_type ?? '-'}</td>

            <td>${q.exam_level ?? '-'}</td>

            <td>
                <span class="badge bg-light text-dark">
                    ${q.difficulty ?? '-'}
                </span>
            </td>

            <td>

                <div class="actions-cell"
                    style="justify-content:flex-end;gap:10px">

                    <button class="btn-icon"
                        onclick="openEditModal(${q.id})">

                        ✏️
                    </button>

                    <button class="btn-icon"
                        style="color:red"
                        onclick="openDeleteModal(${q.id})">

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

document.getElementById('searchInput')
.addEventListener('keyup', function() {

    const value = this.value.toLowerCase();

    const filtered = questions.filter(item =>
        (item.question ?? '')
        .toLowerCase()
        .includes(value)
    );

    render(filtered);
});

/* =====================================================
   OPEN CREATE MODAL
===================================================== */

function openCreateModal() {

    editingId = null;

    clearForm();

    document.getElementById('modalTitle').textContent =
        'Add Questions';

    document.querySelector('#saveBtn .btn-label').textContent =
        'Save Questions';

    document.getElementById('formModal')
        .classList.add('open');
}

/* =====================================================
   GENERATE DYNAMIC QUESTIONS
===================================================== */

document.getElementById('numberOfQuestions')
.addEventListener('input', function() {

    if (editingId) return;

    const count = parseInt(this.value) || 0;

    const container =
        document.getElementById('dynamicQuestions');

    container.innerHTML = '';

    if (count <= 0) return;

    for (let i = 1; i <= count; i++) {

        container.innerHTML += `

        <div class="question-block"
            style="
                border:1px solid #e5e7eb;
                border-radius:12px;
                padding:18px;
                margin-bottom:20px;
            ">

            <h4 style="margin-bottom:15px">
                Question ${i}
            </h4>

            <div class="form-group">

                <label class="form-label">
                    Question Text
                </label>

                <textarea
                    class="form-control question-text"
                    rows="3"
                    placeholder="Enter question"></textarea>

            </div>

            <div class="row">

                <div class="col-md-3 form-group">
                    <input type="text"
                        class="form-control option-a"
                        placeholder="Option A">
                </div>

                <div class="col-md-3 form-group">
                    <input type="text"
                        class="form-control option-b"
                        placeholder="Option B">
                </div>

                <div class="col-md-3 form-group">
                    <input type="text"
                        class="form-control option-c"
                        placeholder="Option C">
                </div>

                <div class="col-md-3 form-group">
                    <input type="text"
                        class="form-control option-d"
                        placeholder="Option D">
                </div>

            </div>

            <div class="form-group">

                <label class="form-label">
                    Correct Option
                </label>

                <select class="form-control correct-option">

                    <option value="">
                        Select Correct Option
                    </option>

                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>

                </select>

            </div>

        </div>
        `;
    }
});

/* =====================================================
   EDIT QUESTION
===================================================== */

function openEditModal(id) {

    const q = questions.find(x => x.id === id);

    if (!q) return;

    editingId = id;

    document.getElementById('modalTitle').textContent =
        'Edit Question';

    document.querySelector('#saveBtn .btn-label').textContent =
        'Update Question';

    document.getElementById('questionType').value =
        q.question_type_id ?? '';

    document.getElementById('difficulty').value =
        q.difficulty ?? '';

    document.getElementById('examLevel').value =
        q.exam_level ?? '';

    document.getElementById('numberOfQuestions').value = 1;

    document.getElementById('dynamicQuestions').innerHTML = `

    <div class="question-block"
        style="
            border:1px solid #e5e7eb;
            border-radius:12px;
            padding:18px;
        ">

        <h4 style="margin-bottom:15px">
            Edit Question
        </h4>

        <div class="form-group">

            <label class="form-label">
                Question Text
            </label>

            <textarea
                id="editQuestionText"
                class="form-control"
                rows="3">${q.question ?? ''}</textarea>

        </div>

        <div class="row">

            <div class="col-md-3 form-group">
                <input type="text"
                    id="editOptionA"
                    class="form-control"
                    value="${q.options?.A ?? ''}"
                    placeholder="Option A">
            </div>

            <div class="col-md-3 form-group">
                <input type="text"
                    id="editOptionB"
                    class="form-control"
                    value="${q.options?.B ?? ''}"
                    placeholder="Option B">
            </div>

            <div class="col-md-3 form-group">
                <input type="text"
                    id="editOptionC"
                    class="form-control"
                    value="${q.options?.C ?? ''}"
                    placeholder="Option C">
            </div>

            <div class="col-md-3 form-group">
                <input type="text"
                    id="editOptionD"
                    class="form-control"
                    value="${q.options?.D ?? ''}"
                    placeholder="Option D">
            </div>

        </div>

        <div class="form-group">

            <label class="form-label">
                Correct Option
            </label>

            <select id="editCorrectOption"
                class="form-control">

                <option value="A"
                    ${q.correct_option === 'A' ? 'selected' : ''}>
                    A
                </option>

                <option value="B"
                    ${q.correct_option === 'B' ? 'selected' : ''}>
                    B
                </option>

                <option value="C"
                    ${q.correct_option === 'C' ? 'selected' : ''}>
                    C
                </option>

                <option value="D"
                    ${q.correct_option === 'D' ? 'selected' : ''}>
                    D
                </option>

            </select>

        </div>

    </div>
    `;

    document.getElementById('formModal')
        .classList.add('open');
}

/* =====================================================
   SAVE QUESTIONS
===================================================== */

async function saveQuestion() {
    const questionType =
        document.getElementById('questionType');

    const selectedType =
        questionType.options[questionType.selectedIndex]
            .text
            .trim()
            .toLowerCase();

    const payload = {

        question_type_id:
            document.getElementById('questionType').value,

        exam_level:
            document.getElementById('examLevel').value,


    };
 // ONLY Practice → send difficulty
 if (selectedType === 'practice') {
        payload.difficulty =
            document.getElementById('difficulty')?.value || null;
    }

    // ONLY Test → send schedule_test_type
    if (selectedType === 'test') {
        payload.schedule_test_type =
            document.getElementById('scheduleTestType')?.value || null;
    }
    /* =====================================
       UPDATE
    ===================================== */

    if (editingId) {

        payload.question =
            document.getElementById('editQuestionText').value;

        payload.options = {

            A: document.getElementById('editOptionA').value,
            B: document.getElementById('editOptionB').value,
            C: document.getElementById('editOptionC').value,
            D: document.getElementById('editOptionD').value

        };

        payload.correct_option =
            document.getElementById('editCorrectOption').value;

        const res = await fetch(`/admin/questions/${editingId}`, {

            method: 'PUT',

            headers: {

                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'

            },

            body: JSON.stringify(payload)

        });

        const data = await res.json();

        if (!res.ok) {

            alert(data.message ?? 'Update failed');

            return;
        }

        alert(data.message ?? 'Question updated');

        closeFormModal();

        fetchQuestions();

        return;
    }

    /* =====================================
       CREATE MULTIPLE
    ===================================== */

    const blocks =
        document.querySelectorAll('.question-block');

    payload.questions = [];

    blocks.forEach(block => {

        payload.questions.push({

            question:
                block.querySelector('.question-text').value,

            options: {

                A: block.querySelector('.option-a').value,
                B: block.querySelector('.option-b').value,
                C: block.querySelector('.option-c').value,
                D: block.querySelector('.option-d').value

            },

            correct_option:
                block.querySelector('.correct-option').value
        });
    });

    const res = await fetch(`/admin/questions`, {

        method: 'POST',

        headers: {

            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'Accept': 'application/json'

        },

        body: JSON.stringify(payload)

    });

    const data = await res.json();

    if (!res.ok) {
        let errorMsg = data.message ?? 'Save failed';
        if (data.errors) {
            errorMsg += ':\n';
            for (let key in data.errors) {
                errorMsg += '\n- ' + data.errors[key][0];
            }
        }
        alert(errorMsg);
        return;
    }

    alert(data.message ?? 'Questions added');

    closeFormModal();

    fetchQuestions();
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

async function confirmDelete() {

    const res = await fetch(`/admin/questions/${deletingId}`, {

        method: 'DELETE',

        headers: {

            'X-CSRF-TOKEN': CSRF,
            'Accept': 'application/json'

        }

    });

    const data = await res.json();

    if (!res.ok) {

        alert(data.message ?? 'Delete failed');

        return;
    }

    alert(data.message ?? 'Deleted');

    closeDeleteModal();

    fetchQuestions();
}

/* =====================================================
   MODAL
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

function handleDeleteBackdropClick(e) {

    if (e.target ===
        document.getElementById('deleteModal')) {

        closeDeleteModal();
    }
}

/* =====================================================
   CLEAR FORM
===================================================== */

function clearForm() {

    document.getElementById('questionType').value = '';
    document.getElementById('difficulty').value = '';
    document.getElementById('examLevel').value = '';
    document.getElementById('numberOfQuestions').value = '';

    document.getElementById('dynamicQuestions').innerHTML = '';
}

/* =====================================================
   ESC
===================================================== */

document.addEventListener('keydown', e => {
2
    if (e.key === 'Escape') {

        closeFormModal();

        closeDeleteModal();
    }
});

/* =====================================================
   INIT
===================================================== */

fetchQuestions();

</script>

@endsection