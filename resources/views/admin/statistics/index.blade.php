@extends('admin.layout.app')

@section('content')

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">
    <div>
        <h1>Statistics</h1>
        <p>Update website statistics</p>
    </div>
</div>

{{-- ═══════════ FORM CARD ═══════════ --}}

<div class="form-section">

 <div class="section-header">
            <h3>Count Settings</h3>
            <p>Configure count options</p>
        </div>
    <form id="statsForm">

        <div class="form-group">
            <label>Course Count *</label>
            <input type="number"
                   id="courseCount"
                   class="form-control"
                   value="{{ $statistics->course_count ?? 0 }}">
        </div>

        <div class="form-group">
            <label>Teachers Count *</label>
            <input type="number"
                   id="teachersCount"
                   class="form-control"
                   value="{{ $statistics->teachers_count ?? 0 }}">
        </div>

        <div class="form-group">
            <label>Members Count *</label>
            <input type="number"
                   id="membersCount"
                   class="form-control"
                   value="{{ $statistics->members_count ?? 0 }}">
        </div>

        <div class="form-group">
            <label>Countries Count *</label>
            <input type="number"
                   id="countriesCount"
                   class="form-control"
                   value="{{ $statistics->countries_count ?? 0 }}">
        </div>

 

        <div class="form-group">

        </div>

    </form>
                <button type="button"
                    class="btn btn-primary"
                    onclick="saveStats()">
                Save Statistics
            </button>

</div>

<div id="toast-container"></div>

<script>

const CSRF = document.querySelector('meta[name="csrf-token"]').content;

// ───────── SAVE SINGLE RECORD ─────────
async function saveStats() {

    const payload = {
        course_count: document.getElementById('courseCount').value,
        teachers_count: document.getElementById('teachersCount').value,
        members_count: document.getElementById('membersCount').value,
        countries_count: document.getElementById('countriesCount').value,
    };

    const res = await fetch('/admin/statistics', {
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
        alert(data.message ?? 'Something went wrong');
        return;
    }

    alert('Statistics updated successfully');
}

</script>

@endsection