@extends('admin.layout.app')

@section('page-title', 'Suppliers')

@section('content')



    {{-- ═══════════ PAGE HEADER ═══════════ --}}
    <div class="roles-header">
        <div>
            <h1>Suppliers</h1>
            <p>Manage supplier across your application.</p>
        </div>
        <button class="btn btn-primary" onclick="openCreateModal()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            New Supplier
        </button>
    </div>

    {{-- ═══════════ TABLE CARD ═══════════ --}}
    <div class="card">
        <div class="search-bar">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                style="color:var(--faint);flex-shrink:0">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>

            <input type="text" id="searchInput" placeholder="Search suppliers" oninput="filterData(this.value)">

            <span id="count" style="font-size:12px;color:var(--faint);white-space:nowrap"></span>
        </div>

        <div style="overflow-x:auto">
            <table class="roles-table">
                <thead>
                    <tr>
                        <th style="width:36px">#</th>
                        <th>Supplier Name</th>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>GST</th>
                        <th>PAN</th>
                        <th>Status</th>
                        <th style="width:120px">Created</th>
                        <th style="width:90px;text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>
            </table>

            <div id="emptyState" class="empty-state" style="display:none">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="8" y1="12" x2="16" y2="12" />
                </svg>
                <p>No suppliers found</p>
                <span>Try a different search or create a new suppliers</span>
            </div>
        </div>
    </div>

    {{-- ═══════════ CREATE / EDIT SUPPLIER MODAL ═══════════ --}}
    <div class="modal-backdrop" id="formModal" onclick="handleBackdropClick(event)">
        <div class="modal">
            <div class="modal-header">
                <h2 id="modalTitle">New Supplier</h2>

                <button class="btn-icon" onclick="closeModal()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            <div class="modal-body">

                {{-- NAME --}}
                <div class="form-group">
                    <label class="form-label">Supplier Name *</label>
                    <input type="text" id="name" class="form-control" placeholder="e.g. Raj Traders">
                </div>

                {{-- COMPANY --}}
                <div class="form-group">
                    <label class="form-label">Company Name</label>
                    <input type="text" id="company_name" class="form-control" placeholder="e.g. Raj Enterprises Pvt Ltd">
                </div>

                {{-- CONTACT --}}
                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" id="phone" class="form-control" placeholder="e.g. 9876543210">
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" id="email" class="form-control" placeholder="e.g. supplier@mail.com">
                </div>

                {{-- ADDRESS --}}
                <div class="form-group">
                    <label class="form-label">Address</label>
                    <textarea id="address" class="form-control" placeholder="Full address"></textarea>
                </div>

                {{-- LOCATION --}}
                <div class="form-group">
                    <label class="form-label">City</label>
                    <input type="text" id="city" class="form-control" placeholder="e.g. Mumbai">
                </div>

                <div class="form-group">
                    <label class="form-label">State</label>
                    <input type="text" id="state" class="form-control" placeholder="e.g. Maharashtra">
                </div>

                <div class="form-group">
                    <label class="form-label">Country</label>
                    <input type="text" id="country" class="form-control" value="India">
                </div>

                {{-- TAX --}}
                <div class="form-group">
                    <label class="form-label">GST Number</label>
                    <input type="text" id="gst_number" class="form-control" placeholder="e.g. 27ABCDE1234F1Z5">
                </div>

                <div class="form-group">
                    <label class="form-label">PAN Number</label>
                    <input type="text" id="pan_number" class="form-control" placeholder="e.g. ABCDE1234F">
                </div>

                {{-- STATUS --}}
                <div class="form-group">
                    <label class="form-label">Status</label>

                    <label class="toggle-row">
                        <div>
                            <div class="toggle-row-label">Active</div>
                            <div class="toggle-row-sub">Supplier is available for transactions</div>
                        </div>

                        <label class="toggle">
                            <input type="checkbox" id="status" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </label>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-ghost" onclick="closeModal()">Cancel</button>

                <button class="btn btn-primary" id="saveBtn" onclick="save()">
                    <span class="spinner"></span>
                    <span class="btn-label">Save Supplier</span>
                </button>
            </div>
        </div>
    </div>

    {{-- ═══════════ DELETE SUPPLIER MODAL ═══════════ --}}
    <div class="modal-backdrop" id="deleteModal" onclick="handleDeleteBackdropClick(event)">
        <div class="modal" style="max-width:370px">

            <div class="confirm-modal-body">
                <div class="confirm-icon">
                    🗑️
                </div>

                <h3>Delete Supplier?</h3>
                <p>
                    Are you sure you want to delete
                    <strong id="deleteText"></strong>?
                    <br>This action cannot be undone.
                </p>
            </div>

            <div class="modal-footer" style="justify-content:center;gap:10px">
                <button class="btn btn-ghost" onclick="closeDelete()">Cancel</button>

                <button class="btn btn-danger" onclick="confirmDelete()">
                    <span class="btn-label">Delete</span>
                </button>
            </div>

        </div>
    </div>
    <div id="toast-container"></div>
    <script>
        // ── STATE ─────────────────────────────────────────
        let suppliers = @json($suppliers);
        let editingId = null;
        let deletingId = null;
        const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

        // ── FORMAT DATE ───────────────────────────────────
        function formatDate(str) {
            if (!str) return '—';
            return new Date(str).toLocaleDateString('en-US', {
                month: 'short', day: 'numeric', year: 'numeric'
            });
        }

        // ── RENDER ────────────────────────────────────────
        function render(list) {
            const tbody = document.getElementById('tableBody');
            const empty = document.getElementById('emptyState');

            document.getElementById('count').textContent =
                list.length + ' supplier' + (list.length !== 1 ? 's' : '');

            if (!list.length) {
                tbody.innerHTML = '';
                empty.style.display = 'block';
                return;
            }

            empty.style.display = 'none';

            tbody.innerHTML = list.map((s, i) => {
                const active = s.status == 1 || s.status === true;

                return `
            <tr data-id="${s.id}">

                <!-- Serial Number -->
                <td style="color:var(--faint);font-size:12px">
                    ${i + 1}
                </td>

                <!-- Supplier Name -->
                <td>
                    <strong>${escapeHtml(s.name)}</strong>
                </td>

                <!-- Company -->
                <td>
                    ${s.company_name
                        ? escapeHtml(s.company_name)
                        : '-'}
                </td>

                <!-- Email -->
                <td>
                    ${s.email
                        ? escapeHtml(s.email)
                        : '-'}
                </td>

                <!-- Phone -->
                <td>
                    ${s.phone
                        ? escapeHtml(s.phone)
                        : '-'}
                </td>

                <!-- City -->
                <td>
                    ${s.city
                        ? escapeHtml(s.city)
                        : '-'}
                </td>

                <!-- GST -->
                <td>
                    ${s.gst_number
                        ? escapeHtml(s.gst_number)
                        : '-'}
                </td>

                <!-- PAN -->
                <td>
                    ${s.pan_number
                        ? escapeHtml(s.pan_number)
                        : '-'}
                </td>

                <!-- Status -->
                <td>
                    <div class="toggle-wrap">
                        <label class="toggle">
                            <input 
                                type="checkbox"
                                ${active ? 'checked' : ''}
                                onchange="toggleStatus(${s.id}, this.checked)"
                            >
                            <span class="toggle-slider"></span>
                        </label>

                        <span class="toggle-label ${active ? 'active' : 'inactive'}">
                            ${active ? 'Active' : 'Inactive'}
                        </span>
                    </div>
                </td>

                <!-- Created Date -->
                <td style="color:var(--muted);font-size:12px">
                    ${formatDate(s.created_at)}
                </td>

              <!-- Actions -->
    <td>
        <div class="actions-cell" style="justify-content:flex-end">

            <!-- Edit Button -->
            <button 
                class="btn-icon" 
                title="Edit"
                onclick="openEditModal(${s.id})">

                <svg width="13" height="13" viewBox="0 0 24 24" 
                     fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>

            </button>

            <!-- Delete Button -->
            <button 
                class="btn-icon"
                title="Delete"
                style="color:var(--red);border-color:#f3c9c9"
                onclick="openDeleteModal(${s.id}, '${escapeAttr(s.name)}')">

                <svg width="13" height="13" viewBox="0 0 24 24" 
                     fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6"/>
                    <path d="M14 11v6"/>
                    <path d="M9 6V4h6v2"/>
                </svg>

            </button>

        </div>
    </td>
            </tr>`;
            }).join('');
        }
        // ── FILTER ────────────────────────────────────────
        function filterData(q) {
            q = q.toLowerCase();
            render(suppliers.filter(s =>
                s.name.toLowerCase().includes(q) ||
                (s.company_name ?? '').toLowerCase().includes(q) ||
                (s.phone ?? '').toLowerCase().includes(q)
            ));
        }

        // ── MODAL ─────────────────────────────────────────
        function openCreateModal() {
            editingId = null;
            document.getElementById('modalTitle').textContent = 'New Supplier';
            clearForm();
            document.getElementById('formModal').classList.add('open');
        }

        function openEditModal(id) {
            const s = suppliers.find(x => x.id === id);
            if (!s) return;

            editingId = id;

            document.getElementById('modalTitle').textContent = 'Edit Supplier';

            document.getElementById('name').value = s.name ?? '';
            document.getElementById('company_name').value = s.company_name ?? '';
            document.getElementById('phone').value = s.phone ?? '';
            document.getElementById('email').value = s.email ?? '';
            document.getElementById('address').value = s.address ?? '';
            document.getElementById('city').value = s.city ?? '';
            document.getElementById('state').value = s.state ?? '';
            document.getElementById('country').value = s.country ?? 'India';
            document.getElementById('gst_number').value = s.gst_number ?? '';
            document.getElementById('pan_number').value = s.pan_number ?? '';
            document.getElementById('status').checked = s.status == 1;

            document.getElementById('formModal').classList.add('open');
        }

        function closeModal() {
            document.getElementById('formModal').classList.remove('open');
        }

        function handleBackdropClick(e) {
            if (e.target.id === 'formModal') closeModal();
        }

        // ── SAVE ──────────────────────────────────────────
        async function save() {
            const name = document.getElementById('name').value.trim();

            if (!name) {
                alert('Supplier name is required');
                return;
            }

            const payload = {
                name,
                company_name: document.getElementById('company_name').value,
                phone: document.getElementById('phone').value,
                email: document.getElementById('email').value,
                address: document.getElementById('address').value,
                city: document.getElementById('city').value,
                state: document.getElementById('state').value,
                country: document.getElementById('country').value,
                gst_number: document.getElementById('gst_number').value,
                pan_number: document.getElementById('pan_number').value,
                status: document.getElementById('status').checked ? 1 : 0
            };

            const url = editingId
                ? `/admin/suppliers/${editingId}`
                : `/admin/suppliers`;

            const method = editingId ? 'PUT' : 'POST';

            try {
                const res = await fetch(url, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await res.json();

                if (!res.ok) throw new Error(data.message || 'Failed');

                if (editingId) {
                    const index = suppliers.findIndex(x => x.id === editingId);
                    suppliers[index] = data.data;
                    toast('Updated successfully');
                } else {
                    suppliers.unshift(data.data);
                    toast('Created successfully');
                }

                render(suppliers);
                closeModal();

            } catch (err) {
                toast(err.message, 'error');
            }
        }

        // ── DELETE ────────────────────────────────────────
        function openDeleteModal(id, name) {
            deletingId = id;
            document.getElementById('deleteText').textContent = name;
            document.getElementById('deleteModal').classList.add('open');
        }

        function closeDelete() {
            document.getElementById('deleteModal').classList.remove('open');
        }

        async function confirmDelete() {
            try {
                const res = await fetch(`/admin/suppliers/${deletingId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json'
                    }
                });

                if (!res.ok) throw new Error('Delete failed');

                suppliers = suppliers.filter(s => s.id !== deletingId);

                render(suppliers);
                closeDelete();
                toast('Deleted');

            } catch (err) {
                toast(err.message, 'error');
            }
        }

        // ── STATUS ────────────────────────────────────────
        async function toggleStatus(id, checked) {
            try {
                const res = await fetch(`/admin/suppliers/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status: checked ? 1 : 0 })
                });

                const data = await res.json();
                if (!res.ok) throw new Error(data.message || 'Failed');

                const s = suppliers.find(x => x.id === id);
                if (s) s.status = checked ? 1 : 0;

                toast('Status updated');

            } catch (err) {
                toast(err.message, 'error');
            }
        }

        // ── HELPERS ───────────────────────────────────────
        function clearForm() {
            document.getElementById('name').value = '';
            document.getElementById('company_name').value = '';
            document.getElementById('phone').value = '';
            document.getElementById('email').value = '';
            document.getElementById('address').value = '';
            document.getElementById('city').value = '';
            document.getElementById('state').value = '';
            document.getElementById('country').value = 'India';
            document.getElementById('gst_number').value = '';
            document.getElementById('pan_number').value = '';
            document.getElementById('status').checked = true;
        }

        function escapeHtml(str) {
            return String(str ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        function escapeAttr(str) {
            return String(str ?? '').replace(/'/g, "\\'");
        }

        // ── TOAST ─────────────────────────────────────────
        function toast(msg, type = 'success') {
            const container = document.getElementById('toast-container');
            const el = document.createElement('div');

            el.className = `toast toast-${type}`;
            el.innerText = msg;

            container.appendChild(el);
            setTimeout(() => el.remove(), 3000);
        }

        // ── INIT ──────────────────────────────────────────
        render(suppliers);
    </script>
@endsection