@extends('admin.layout.app')

@section('page-title', 'Clients')

@section('content')



    {{-- ═══════════ PAGE HEADER ═══════════ --}}
    <div class="roles-header">
        <div>
            <h1>Clients</h1>
            <p>Manage clients across your application.</p>
        </div>
        <button class="btn btn-primary" onclick="openCreateModal()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            New Client
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
            <h2 id="modalTitle">New Client</h2>

            <button class="btn-icon" onclick="closeModal()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <div class="modal-body">

            {{-- CLIENT NAME --}}
            <div class="form-group">
                <label class="form-label">Client Name *</label>
                <input type="text" id="client_name" class="form-control"
                    placeholder="e.g. John Doe">
            </div>

            {{-- COMPANY NAME --}}
            <div class="form-group">
                <label class="form-label">Company Name</label>
                <input type="text" id="company_name" class="form-control"
                    placeholder="e.g. ABC Pvt Ltd">
            </div>

            {{-- EMAIL --}}
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" id="email" class="form-control"
                    placeholder="client@mail.com">
            </div>

            {{-- PHONE --}}
            <div class="form-group">
                <label class="form-label">Phone</label>
                <input type="text" id="phone" class="form-control"
                    placeholder="9876543210">
            </div>

            {{-- ALTERNATE PHONE --}}
            <div class="form-group">
                <label class="form-label">Alternate Phone</label>
                <input type="text" id="alternate_phone" class="form-control"
                    placeholder="Optional alternate number">
            </div>

            {{-- ADDRESS --}}
            <div class="form-group">
                <label class="form-label">Address</label>
                <textarea id="address" class="form-control"
                    placeholder="Full address"></textarea>
            </div>

            {{-- CITY --}}
            <div class="form-group">
                <label class="form-label">City</label>
                <input type="text" id="city" class="form-control"
                    placeholder="Mumbai">
            </div>

            {{-- STATE --}}
            <div class="form-group">
                <label class="form-label">State</label>
                <input type="text" id="state" class="form-control"
                    placeholder="Maharashtra">
            </div>

            {{-- COUNTRY --}}
            <div class="form-group">
                <label class="form-label">Country</label>
                <input type="text" id="country" class="form-control"
                    value="India">
            </div>

            {{-- ZIPCODE --}}
            <div class="form-group">
                <label class="form-label">Zip Code</label>
                <input type="text" id="zipcode" class="form-control"
                    placeholder="411001">
            </div>

            {{-- GST --}}
            <div class="form-group">
                <label class="form-label">GST Number</label>
                <input type="text" id="gst_number" class="form-control"
                    placeholder="27ABCDE1234F1Z5">
            </div>

            {{-- PAN --}}
            <div class="form-group">
                <label class="form-label">PAN Number</label>
                <input type="text" id="pan_number" class="form-control"
                    placeholder="ABCDE1234F">
            </div>

            {{-- WEBSITE --}}
            <div class="form-group">
                <label class="form-label">Website</label>
                <input type="text" id="website" class="form-control"
                    placeholder="https://example.com">
            </div>

            {{-- INDUSTRY --}}
            <div class="form-group">
                <label class="form-label">Industry Type</label>
                <input type="text" id="industry_type" class="form-control"
                    placeholder="Manufacturing / Retail / IT">
            </div>

            {{-- CLIENT TYPE --}}
            <div class="form-group">
                <label class="form-label">Client Type</label>
                <input type="text" id="client_type" class="form-control"
                    placeholder="Corporate / Retail / Distributor">
            </div>

            {{-- CREDIT LIMIT --}}
            <div class="form-group">
                <label class="form-label">Credit Limit</label>
                <input type="number" id="credit_limit" class="form-control"
                    placeholder="50000">
            </div>

            {{-- PAYMENT TERMS --}}
            <div class="form-group">
                <label class="form-label">Payment Terms (Days)</label>
                <input type="number" id="payment_terms_days" class="form-control"
                    placeholder="30">
            </div>

            {{-- NOTES --}}
            <div class="form-group">
                <label class="form-label">Notes</label>
                <textarea id="notes" class="form-control"
                    placeholder="Additional notes"></textarea>
            </div>

            {{-- STATUS --}}
            <div class="form-group">
                <label class="form-label">Status</label>

                <label class="toggle-row">
                    <div>
                        <div class="toggle-row-label">Active</div>
                        <div class="toggle-row-sub">
                            Client is available for transactions
                        </div>
                    </div>

                    <label class="toggle">
                        <input type="checkbox" id="status" checked>
                        <span class="toggle-slider"></span>
                    </label>
                </label>
            </div>

        </div>

        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal()">
                Cancel
            </button>

            <button class="btn btn-primary" id="saveBtn" onclick="save()">
                <span class="spinner"></span>
                <span class="btn-label">Save Client</span>
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
    let clients = @json($clients);
    let editingId = null;
    let deletingId = null;

    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    // ── FORMAT DATE ───────────────────────────────────
    function formatDate(str) {
        if (!str) return '—';

        return new Date(str).toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });
    }

    // ── RENDER ────────────────────────────────────────
    function render(list) {
        const tbody = document.getElementById('tableBody');
        const empty = document.getElementById('emptyState');

        document.getElementById('count').textContent =
            list.length + ' client' + (list.length !== 1 ? 's' : '');

        if (!list.length) {
            tbody.innerHTML = '';
            empty.style.display = 'block';
            return;
        }

        empty.style.display = 'none';

        tbody.innerHTML = list.map((c, i) => {
            const active = c.status == 1 || c.status === true;

            return `
            <tr data-id="${c.id}">
                
                <td>${i + 1}</td>

                <td>
                    <strong>${escapeHtml(c.client_name)}</strong><br>
                    <small style="color:var(--muted)">
                        ${escapeHtml(c.client_code)}
                    </small>
                </td>

                <td>${c.company_name ? escapeHtml(c.company_name) : '-'}</td>

                <td>${c.email ? escapeHtml(c.email) : '-'}</td>

                <td>${c.phone ? escapeHtml(c.phone) : '-'}</td>

                <td>${c.city ? escapeHtml(c.city) : '-'}</td>



                <td>
                    <div class="toggle-wrap">
                        <label class="toggle">
                            <input 
                                type="checkbox"
                                ${active ? 'checked' : ''}
                                onchange="toggleStatus(${c.id}, this.checked)"
                            >
                            <span class="toggle-slider"></span>
                        </label>

                        <span class="toggle-label ${active ? 'active' : 'inactive'}">
                            ${active ? 'Active' : 'Inactive'}
                        </span>
                    </div>
                </td>

                <td>${formatDate(c.created_at)}</td>

             <td>
    <div class="actions-cell" style="justify-content:flex-end">

        <!-- Edit Button -->
        <button 
            class="btn-icon" 
            title="Edit"
            onclick="openEditModal(${c.id})">

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
            onclick="openDeleteModal(${c.id}, '${escapeAttr(c.client_name)}')">

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
            </tr>
            `;
        }).join('');
    }

    // ── FILTER ────────────────────────────────────────
    function filterData(q) {
        q = q.toLowerCase();

        render(clients.filter(c =>
            (c.client_name ?? '').toLowerCase().includes(q) ||
            (c.company_name ?? '').toLowerCase().includes(q) ||
            (c.email ?? '').toLowerCase().includes(q) ||
            (c.phone ?? '').toLowerCase().includes(q)
        ));
    }

    // ── MODAL ─────────────────────────────────────────
    function openCreateModal() {
        editingId = null;

        document.getElementById('modalTitle').textContent = 'New Client';

        clearForm();

        document.getElementById('formModal').classList.add('open');
    }

    function openEditModal(id) {
        const c = clients.find(x => x.id === id);

        if (!c) return;

        editingId = id;

        document.getElementById('modalTitle').textContent = 'Edit Client';

        document.getElementById('client_name').value = c.client_name ?? '';
        document.getElementById('company_name').value = c.company_name ?? '';
        document.getElementById('email').value = c.email ?? '';
        document.getElementById('phone').value = c.phone ?? '';
        document.getElementById('alternate_phone').value = c.alternate_phone ?? '';
        document.getElementById('address').value = c.address ?? '';
        document.getElementById('city').value = c.city ?? '';
        document.getElementById('state').value = c.state ?? '';
        document.getElementById('country').value = c.country ?? 'India';
        document.getElementById('zipcode').value = c.zipcode ?? '';
        document.getElementById('gst_number').value = c.gst_number ?? '';
        document.getElementById('pan_number').value = c.pan_number ?? '';
        document.getElementById('website').value = c.website ?? '';
        document.getElementById('industry_type').value = c.industry_type ?? '';
        document.getElementById('client_type').value = c.client_type ?? '';
        document.getElementById('credit_limit').value = c.credit_limit ?? '';
        document.getElementById('payment_terms_days').value = c.payment_terms_days ?? '';
        document.getElementById('notes').value = c.notes ?? '';
        document.getElementById('status').checked = c.status == 1;

        document.getElementById('formModal').classList.add('open');
    }

    function closeModal() {
        document.getElementById('formModal').classList.remove('open');
    }

    // ── SAVE ──────────────────────────────────────────
    async function save() {
        const clientName = document.getElementById('client_name').value.trim();

        if (!clientName) {
            alert('Client name is required');
            return;
        }

        const payload = {
            client_name: clientName,
            company_name: document.getElementById('company_name').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            alternate_phone: document.getElementById('alternate_phone').value,
            address: document.getElementById('address').value,
            city: document.getElementById('city').value,
            state: document.getElementById('state').value,
            country: document.getElementById('country').value,
            zipcode: document.getElementById('zipcode').value,
            gst_number: document.getElementById('gst_number').value,
            pan_number: document.getElementById('pan_number').value,
            website: document.getElementById('website').value,
            industry_type: document.getElementById('industry_type').value,
            client_type: document.getElementById('client_type').value,
            credit_limit: document.getElementById('credit_limit').value,
            payment_terms_days: document.getElementById('payment_terms_days').value,
            notes: document.getElementById('notes').value,
            status: document.getElementById('status').checked ? 1 : 0
        };

        const url = editingId
            ? `/admin/clients/${editingId}`
            : `/admin/clients`;

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
                const index = clients.findIndex(x => x.id === editingId);
                clients[index] = data.data;
                toast('Client updated successfully');
            } else {
                clients.unshift(data.data);
                toast('Client created successfully');
            }

            render(clients);
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

    async function confirmDelete() {
        try {
            const res = await fetch(`/admin/clients/${deletingId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                }
            });

            if (!res.ok) throw new Error('Delete failed');

            clients = clients.filter(c => c.id !== deletingId);

            render(clients);
            closeDelete();

            toast('Client deleted successfully');

        } catch (err) {
            toast(err.message, 'error');
        }
    }

    function closeDelete() {
        document.getElementById('deleteModal').classList.remove('open');
    }

    // ── STATUS ────────────────────────────────────────
    async function toggleStatus(id, checked) {
        try {
            const res = await fetch(`/admin/clients/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: checked ? 1 : 0
                })
            });

            if (!res.ok) throw new Error('Status update failed');

            const c = clients.find(x => x.id === id);

            if (c) {
                c.status = checked ? 1 : 0;
            }

            toast('Status updated');

        } catch (err) {
            toast(err.message, 'error');
        }
    }

    // ── HELPERS ───────────────────────────────────────
    function clearForm() {
        document.querySelectorAll('#formModal input, #formModal textarea')
            .forEach(el => {
                if (el.type === 'checkbox') {
                    el.checked = true;
                } else {
                    el.value = '';
                }
            });

        document.getElementById('country').value = 'India';
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

    function toast(msg, type = 'success') {
        const container = document.getElementById('toast-container');
        const el = document.createElement('div');

        el.className = `toast toast-${type}`;
        el.innerText = msg;

        container.appendChild(el);

        setTimeout(() => el.remove(), 3000);
    }

    // ── INIT ──────────────────────────────────────────
    render(clients);
</script>
@endsection