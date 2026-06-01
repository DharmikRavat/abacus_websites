@extends('admin.layout.app')

@section('content')

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">

    <div>
        <h1>Question Types</h1>
        <p>Manage question types for exams and practice</p>
    </div>

    <button class="btn btn-primary" onclick="openCreateModal()">

        <svg width="14"
             height="14"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2.5">

            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>

        </svg>

        New Question Type

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
               placeholder="Search Question Types..."
               oninput="filterQuestionTypes(this.value)">

        <span id="question-type-count"
              style="font-size:12px;color:var(--faint);white-space:nowrap">
        </span>

    </div>

    <div style="overflow-x:auto">

        <table class="roles-table">

            <thead>

                <tr>

                    <th>#</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th style="text-align:right">Actions</th>

                </tr>

            </thead>

            <tbody id="questionTypeBody"></tbody>

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
                <path d="M8 12h8"/>
                <path d="M12 8v8"/>

            </svg>

            <p>No Question Types Found</p>

            <span>Create your first question type</span>

        </div>

    </div>

</div>

{{-- ═══════════ CREATE / EDIT MODAL ═══════════ --}}
<div class="modal-backdrop"
     id="formModal"
     onclick="handleBackdropClick(event)">

    <div class="modal">

        <div class="modal-header">

            <h2 id="modalTitle">New Question Type</h2>

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

            <div class="form-group">

                <label class="form-label">Name *</label>

                <input type="text"
                       id="qtName"
                       class="form-control"
                       placeholder="Enter name">

            </div>

            <div class="form-group">

                <label class="form-label">Type *</label>

                <input type="text"
                       id="qtType"
                       class="form-control"
                       placeholder="practice / test / exam">

            </div>

            <div class="form-group">

                <label class="form-label">Description</label>

                <textarea id="qtDescription"
                          class="form-control"
                          rows="4"
                          placeholder="Enter description"></textarea>

            </div>

            <div class="form-group">

                <label class="form-label">Status</label>

                <label class="toggle-row">

                    <div>

                        <div class="toggle-row-label">
                            Active
                        </div>

                        <div class="toggle-row-sub">
                            Visible to users
                        </div>

                    </div>

                    <label class="toggle">

                        <input type="checkbox"
                               id="qtActive"
                               checked>

                        <span class="toggle-slider"></span>

                    </label>

                </label>

            </div>

        </div>

        <div class="modal-footer">

            <button class="btn btn-ghost"
                    onclick="closeFormModal()">

                Cancel

            </button>

            <button class="btn btn-primary"
                    id="saveBtn"
                    onclick="saveQuestionType()">

                <span class="spinner"></span>

                <span class="btn-label">
                    Save Question Type
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

                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6"/>
                    <path d="M14 11v6"/>
                    <path d="M9 6V4h6v2"/>

                </svg>

            </div>

            <h3>Delete Question Type?</h3>

            <p>
                This action cannot be undone.
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

<script>

let questionTypes = @json($questionTypes);

let editingId  = null;
let deletingId = null;

const CSRF =
    document.querySelector('meta[name="csrf-token"]')?.content ?? '';

function formatDate(str) {

    if (!str) return '—';

    return new Date(str).toLocaleDateString('en-US', {

        month:'short',
        day:'numeric',
        year:'numeric'

    });
}

function render(list) {

    const tbody = document.getElementById('questionTypeBody');
    const empty = document.getElementById('emptyState');

    document.getElementById('question-type-count').textContent =
        list.length + ' Types';

    if (!list.length) {

        tbody.innerHTML = '';

        empty.style.display = 'block';

        return;
    }

    empty.style.display = 'none';

    tbody.innerHTML = list.map((item, i) => {

        const active = item.is_active == 1;

        return `
        <tr>

            <td>${i + 1}</td>

            <td>
                <strong>${escHtml(item.name)}</strong>
            </td>

            <td>
                <span class="badge">
                    ${escHtml(item.type)}
                </span>
            </td>

            <td style="max-width:300px">
                ${escHtml(item.description ?? '—')}
            </td>

            <td>

                <div class="toggle-wrap">

                    <label class="toggle">

                        <input type="checkbox"
                               ${active ? 'checked' : ''}
                               onchange="toggleStatus(${item.id}, this.checked)">

                        <span class="toggle-slider"></span>

                    </label>

                    <span class="toggle-label ${active ? 'active' : 'inactive'}">
                        ${active ? 'Active' : 'Inactive'}
                    </span>

                </div>

            </td>

            <td>${formatDate(item.created_at)}</td>

            <td>

                <div class="actions-cell"
                     style="justify-content:flex-end">

                    <button class="btn-icon"
                            onclick="openEditModal(${item.id})">

                        ✏️

                    </button>

                    <button class="btn-icon"
                            style="color:red"
                            onclick="openDeleteModal(${item.id})">

                        🗑️

                    </button>

                </div>

            </td>

        </tr>
        `;

    }).join('');
}

function filterQuestionTypes(q) {

    const lower = q.toLowerCase();

    render(
        questionTypes.filter(item =>
            item.name.toLowerCase().includes(lower) ||
            item.type.toLowerCase().includes(lower)
        )
    );
}

function openCreateModal() {

    editingId = null;

    document.getElementById('modalTitle').textContent =
        'New Question Type';

    clearForm();

    document.getElementById('formModal').classList.add('open');
}

function openEditModal(id) {

    const item =
        questionTypes.find(q => q.id === id);

    if (!item) return;

    editingId = id;

    document.getElementById('modalTitle').textContent =
        'Edit Question Type';

    document.getElementById('qtName').value =
        item.name ?? '';

    document.getElementById('qtType').value =
        item.type ?? '';

    document.getElementById('qtDescription').value =
        item.description ?? '';

    document.getElementById('qtActive').checked =
        item.is_active == 1;

    document.getElementById('formModal').classList.add('open');
}

function clearForm() {

    document.getElementById('qtName').value = '';
    document.getElementById('qtType').value = '';
    document.getElementById('qtDescription').value = '';
    document.getElementById('qtActive').checked = true;
}

function closeFormModal() {

    document.getElementById('formModal').classList.remove('open');
}

function handleBackdropClick(e) {

    if (e.target === document.getElementById('formModal')) {
        closeFormModal();
    }
}

async function saveQuestionType() {

    const formData = {

        name:
            document.getElementById('qtName').value,

        type:
            document.getElementById('qtType').value,

        description:
            document.getElementById('qtDescription').value,

        is_active:
            document.getElementById('qtActive').checked ? 1 : 0

    };

    try {

        const res = await fetch(

            editingId
                ? `/admin/question-types/${editingId}`
                : `/admin/question-types`,

            {

                method: editingId ? 'PUT' : 'POST',

                headers: {

                    'Content-Type': 'application/json',

                    'X-CSRF-TOKEN': CSRF,

                    'Accept': 'application/json'

                },

                body: JSON.stringify(formData)

            }

        );

        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message ?? 'Something went wrong');
        }

        if (editingId) {

            const index =
                questionTypes.findIndex(q => q.id === editingId);

            questionTypes[index] = data.question_type;

        } else {

            questionTypes.unshift(data.question_type);
        }

        render(questionTypes);

        closeFormModal();

        alert(data.message);

    } catch (err) {

        alert(err.message);

    }
}

async function toggleStatus(id, checked) {

    const item =
        questionTypes.find(q => q.id === id);

    if (!item) return;

    try {

        const res = await fetch(`/admin/question-types/${id}`, {

            method: 'PUT',

            headers: {

                'Content-Type': 'application/json',

                'X-CSRF-TOKEN': CSRF,

                'Accept': 'application/json'

            },

            body: JSON.stringify({

                name: item.name,
                type: item.type,
                description: item.description,
                is_active: checked ? 1 : 0

            })

        });

        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message ?? 'Failed');
        }

        item.is_active = checked ? 1 : 0;

        render(questionTypes);

    } catch (err) {

        alert(err.message);

    }
}

function openDeleteModal(id) {

    deletingId = id;

    document.getElementById('deleteModal').classList.add('open');
}

function closeDeleteModal() {

    deletingId = null;

    document.getElementById('deleteModal').classList.remove('open');
}

function handleDeleteBackdropClick(e) {

    if (e.target === document.getElementById('deleteModal')) {
        closeDeleteModal();
    }
}

async function confirmDelete() {

    if (!deletingId) return;

    try {

        const res = await fetch(
            `/admin/question-types/${deletingId}`,
            {

                method: 'DELETE',

                headers: {

                    'X-CSRF-TOKEN': CSRF,

                    'Accept': 'application/json'

                }

            }
        );

        const data = await res.json();

        questionTypes =
            questionTypes.filter(q => q.id !== deletingId);

        render(questionTypes);

        closeDeleteModal();

        alert(data.message);

    } catch (err) {

        alert(err.message);

    }
}

function escHtml(str) {

    return String(str ?? '')
        .replace(/&/g,'&amp;')
        .replace(/</g,'&lt;')
        .replace(/>/g,'&gt;')
        .replace(/"/g,'&quot;');
}

document.addEventListener('keydown', e => {

    if (e.key === 'Escape') {

        closeFormModal();

        closeDeleteModal();

    }

});

render(questionTypes);

</script>

@endsection