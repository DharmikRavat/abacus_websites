@extends('admin.layout.app')

@section('page-title', 'Location')

@section('content')

{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<style>
#map {
    height: 300px;
    border-radius: 10px;
    margin-top: 10px;
}
</style>


<div class="roles-header">
    <h1>Locations</h1>
    <button class="btn btn-primary" onclick="openModal()">+ New Location</button>
</div>


{{-- TABLE CARD --}}
<div class="card">

    <!-- SEARCH BAR -->
    <div class="search-bar">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--faint);flex-shrink:0">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>

        <input type="text"
               id="searchInput"
               placeholder="Search locations…"
               oninput="filterData(this.value)">

        <span id="count"
              style="font-size:12px;color:var(--faint);white-space:nowrap"></span>
    </div>

    <!-- TABLE -->
    <div style="overflow-x:auto">
        <table class="roles-table">
            <thead>
                <tr>
                    <th style="width:36px">#</th>
                    <th>Location</th>
                    <th>Code</th>
                    <th>Coordinates</th>
                    <th>Radius</th>
                    <th>Status</th>
                    <th style="width:120px">Created</th>
                    <th style="width:90px;text-align:right">Actions</th>
                </tr>
            </thead>

            <tbody id="tableBody"></tbody>
        </table>

        <!-- EMPTY STATE -->
        <div id="emptyState" class="empty-state" style="display:none">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 8v4"/>
                <circle cx="12" cy="16" r="1"/>
            </svg>

            <p>No locations found</p>
            <span>Try a different search or create a new location</span>
        </div>
    </div>
</div>

{{-- MODAL --}}
<div class="modal-backdrop" id="formModal" onclick="handleBackdropClick(event)">
    <div class="modal">

        <!-- HEADER -->
        <div class="modal-header">
            <h2 id="modalTitle">New Location</h2>

            <button class="btn-icon" onclick="closeModal()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <!-- BODY -->
        <div class="modal-body">

            <div class="form-group">
                <label class="form-label">Location Name *</label>
                <input type="text" id="name" class="form-control" placeholder="e.g. Pune Office">
            </div>

            <div class="form-group">
                <label class="form-label">Code</label>
                <input type="text" id="code" class="form-control" placeholder="e.g. PUNE-01">
            </div>

            <div class="form-group">
                <label class="form-label">Address</label>
                <textarea id="address" class="form-control" placeholder="Full address"></textarea>
            </div>
            {{-- Search Location --}}

<div class="form-group">
    <label class="form-label">Search Location</label>
    <input type="text" id="searchLocation"
           class="form-control"
           placeholder="Type city / address...">
</div>
            <!-- MAP -->
            <div class="form-group">
                <label class="form-label">Select Location on Map</label>
                <div id="map" style="height:300px;border-radius:10px;overflow:hidden;"></div>
            </div>

            <!-- LAT LONG -->
            <div class="form-group">
                <label class="form-label">Coordinates</label>
                <div style="display:flex;gap:10px;">
                    <input type="text" id="latitude" class="form-control" placeholder="Latitude">
                    <input type="text" id="longitude" class="form-control" placeholder="Longitude">
                </div>
            </div>

            <!-- RADIUS -->
            <div class="form-group">
                <label class="form-label">Radius (meters)</label>
                <input type="number" id="radius" class="form-control" value="100">
            </div>

            <!-- STATUS -->
            <div class="form-group">
                <label class="form-label">Status</label>

                <label class="toggle-row">
                    <div>
                        <div class="toggle-row-label">Active</div>
                        <div class="toggle-row-sub">Location is usable for tracking</div>
                    </div>

                    <label class="toggle">
                        <input type="checkbox" id="status" checked>
                        <span class="toggle-slider"></span>
                    </label>
                </label>
            </div>

        </div>

        <!-- FOOTER -->
        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal()">Cancel</button>

            <button class="btn btn-primary" onclick="save()">
                <span class="spinner"></span>
                <span class="btn-label">Save Location</span>
            </button>
        </div>

    </div>
</div>

<div class="modal-backdrop" id="deleteModal" onclick="handleDeleteBackdropClick(event)">
    <div class="modal" style="max-width:370px">

        <div class="confirm-modal-body">
            <div class="confirm-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14H6L5 6"/>
                </svg>
            </div>

            <h3>Delete Department?</h3>
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

{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
/* ───────── STATE ───────── */
let data = @json($locations ?? []);
let editingId = null;
let deletingId = null;

const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

let map, marker, circle;

/* ───────── MAP ───────── */
function initMap(lat = 18.5204, lng = 73.8567) {
    setTimeout(() => {
        if (map) map.remove();

        map = L.map('map').setView([lat, lng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        marker = L.marker([lat, lng], { draggable: true }).addTo(map);

        circle = L.circle([lat, lng], {
            radius: document.getElementById('radius').value || 100,
            color: '#3b82f6',
            fillOpacity: 0.15
        }).addTo(map);

        updateInputs(lat, lng);

        marker.on('dragend', e => {
            const pos = e.target.getLatLng();
            updateInputs(pos.lat, pos.lng);
            updateCircle();
        });

        map.on('click', e => {
            marker.setLatLng(e.latlng);
            updateInputs(e.latlng.lat, e.latlng.lng);
            updateCircle();
        });

    }, 200);
}

function updateInputs(lat, lng) {
    document.getElementById('latitude').value = lat.toFixed(6);
    document.getElementById('longitude').value = lng.toFixed(6);
}

function updateCircle() {
    if (!circle) return;
    circle.setLatLng(marker.getLatLng());
    circle.setRadius(parseInt(document.getElementById('radius').value) || 100);
}

/* ───────── MODAL ───────── */
function openModal() {
    editingId = null;
    resetForm();
    document.getElementById('modalTitle').textContent = 'New Location';
    document.getElementById('formModal').classList.add('open');
    initMap();
}

function closeModal() {
    document.getElementById('formModal').classList.remove('open');
}

function resetForm() {
    document.getElementById('name').value = '';
    document.getElementById('code').value = '';
    document.getElementById('address').value = '';
    document.getElementById('latitude').value = '';
    document.getElementById('longitude').value = '';
    document.getElementById('radius').value = 100;
    document.getElementById('status').checked = true;
}

/* ───────── RENDER ───────── */
function render(list = data) {
    const tbody = document.getElementById('tableBody');
    const empty = document.getElementById('emptyState');

    document.getElementById('count').textContent =
        list.length + ' location' + (list.length !== 1 ? 's' : '');

    if (!list.length) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }

    empty.style.display = 'none';

    tbody.innerHTML = list.map((d, i) => {
        const active = d.status == 1 || d.status === true;

        return `
        <tr>
            <td>${i + 1}</td>
            <td><strong>${escapeHtml(d.name)}</strong></td>
            <td>${d.code ?? '-'}</td>
            <td style="font-size:12px;color:var(--muted)">
                ${d.latitude ?? '-'}<br>${d.longitude ?? '-'}
            </td>
            <td>${d.radius ?? 0} m</td>
            <td>
                <div class="toggle-wrap">
                    <label class="toggle">
                        <input type="checkbox"
                            ${active ? 'checked' : ''}
                            onchange="toggleStatus(${d.id}, this.checked)">
                        <span class="toggle-slider"></span>
                    </label>
                    <span class="toggle-label ${active ? 'active':'inactive'}">
                        ${active ? 'Active':'Inactive'}
                    </span>
                </div>
            </td>
            <td>${formatDate(d.created_at)}</td>
           <td>
    <div class="actions-cell" style="justify-content:flex-end">
        <button class="btn-icon" title="Edit" onclick="edit(${d.id})">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
        </button>

        <button class="btn-icon" title="Delete"
            style="color:var(--red);border-color:#f3c9c9"
            onclick="openDeleteModal(${d.id}, '${escapeHtml(d.name)}')">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14H6L5 6"/>
                <path d="M10 11v6"/><path d="M14 11v6"/>
                <path d="M9 6V4h6v2"/>
            </svg>
        </button>
    </div>
</td>
            
        </tr>`;
    }).join('');
}

/* ───────── SEARCH ───────── */
function filterData(q) {
    const lower = q.toLowerCase();
    render(data.filter(d =>
        d.name.toLowerCase().includes(lower) ||
        (d.code || '').toLowerCase().includes(lower)
    ));
}

/* ───────── EDIT ───────── */
function edit(id) {
    const d = data.find(x => x.id === id);
    if (!d) return;

    editingId = id;

    document.getElementById('name').value = d.name;
    document.getElementById('code').value = d.code;
    document.getElementById('address').value = d.address;
    document.getElementById('latitude').value = d.latitude;
    document.getElementById('longitude').value = d.longitude;
    document.getElementById('radius').value = d.radius;
    document.getElementById('status').checked = d.status;

    document.getElementById('modalTitle').textContent = 'Edit Location';
    document.getElementById('formModal').classList.add('open');

    initMap(d.latitude, d.longitude);
}

/* ───────── SAVE ───────── */
async function save() {
    const nameInput = document.getElementById('name');

    if (!nameInput.value || !nameInput.value.trim()) {
        shake(nameInput);
        nameInput.focus();
        return;
    }

    const payload = {
        name: nameInput.value,
        code: document.getElementById('code').value,
        address: document.getElementById('address').value,
        latitude: document.getElementById('latitude').value,
        longitude: document.getElementById('longitude').value,
        radius: document.getElementById('radius').value,
        status: document.getElementById('status').checked ? 1 : 0
    };

    const url = editingId
        ? `/admin/locations/${editingId}`
        : `/admin/locations`;

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

        const json = await res.json();
        if (!res.ok) throw new Error(json.message || 'Error');

        if (editingId) {
            const i = data.findIndex(x => x.id === editingId);
            data[i] = json.data;
            toast('Location updated', 'success');
        } else {
            data.unshift(json.data);
            toast('Location created', 'success');
        }

        render();
        closeModal();

    } catch (err) {
        toast(err.message, 'error');
    }
}

/* ───────── DELETE ───────── */
function openDeleteModal(id, name) {
    deletingId = id;
    document.getElementById('deleteText').textContent = name;
    document.getElementById('deleteModal').classList.add('open');
}

function closeDelete() {
    deletingId = null;
    document.getElementById('deleteModal').classList.remove('open');
}

function handleDeleteBackdropClick(e) {
    if (e.target.id === 'deleteModal') closeDelete();
}

async function confirmDelete() {
    if (!deletingId) return;

    try {
        const res = await fetch(`/admin/locations/${deletingId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            }
        });

        const json = await res.json();
        if (!res.ok) throw new Error(json.message || 'Delete failed');

        data = data.filter(x => x.id !== deletingId);

        render();
        closeDelete();
        toast('Location deleted', 'success');

    } catch (err) {
        toast(err.message, 'error');
    }
}

/* ───────── STATUS ───────── */
async function toggleStatus(id, checked) {
    const item = data.find(x => x.id === id);
    if (!item) return;

    try {
        const res = await fetch(`/admin/locations/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                ...item,
                status: checked ? 1 : 0
            })
        });

        if (!res.ok) throw new Error('Update failed');

        item.status = checked ? 1 : 0;
        toast('Status updated', 'success');
        render();

    } catch (err) {
        toast(err.message, 'error');
    }
}

/* ───────── LOCATION SEARCH ───────── */
document.getElementById('searchLocation').addEventListener('keydown', async function(e) {
    if (e.key !== 'Enter') return;

    const query = this.value;
    if (!query) return;

    const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`);
    const result = await res.json();

    if (!result.length) {
        toast('Location not found', 'error');
        return;
    }

    const lat = parseFloat(result[0].lat);
    const lng = parseFloat(result[0].lon);

    map.setView([lat, lng], 15);
    marker.setLatLng([lat, lng]);

    updateInputs(lat, lng);
    updateCircle();
});

/* ───────── HELPERS ───────── */
function escapeHtml(str) {
    return String(str ?? '')
        .replace(/&/g,'&amp;')
        .replace(/</g,'&lt;')
        .replace(/>/g,'&gt;')
        .replace(/"/g,'&quot;');
}

function formatDate(str) {
    if (!str) return '—';
    return new Date(str).toLocaleDateString();
}

function toast(msg, type = 'success') {
    const c = document.getElementById('toast-container');
    const el = document.createElement('div');
    el.className = `toast toast-${type}`;
    el.innerHTML = `<span>${escapeHtml(msg)}</span>`;
    c.appendChild(el);

    requestAnimationFrame(() => el.classList.add('show'));

    setTimeout(() => {
        el.classList.remove('show');
        setTimeout(() => el.remove(), 250);
    }, 3000);
}

function shake(el) {
    el.style.animation = 'none';
    el.offsetHeight;
    el.style.animation = 'shake .35s ease';
}

/* ───────── INIT ───────── */
render();
</script>

@endsection