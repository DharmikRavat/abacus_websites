@extends('admin.layout.app')

@section('content')

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">
    <div>
        <h1>Reports</h1>
        <p>Generate and download system reports</p>
    </div>
</div>

{{-- ═══════════ REPORT FILTER CARD ═══════════ --}}
<div class="card">

    <div class="panel-hdr" style="margin-bottom:20px">
        <span class="panel-title">Generate Report</span>
    </div>

    <form action="{{ route('admin.report.index') }}"
          method="GET">

        <div class="report-grid" style="padding:10px;">

            {{-- REPORT TYPE --}}
            <div class="form-group">

                <label class="form-label">
                    Report Module
                </label>

                <select name="report_type"
                        class="form-control">

                    <option value="attendance"
                        {{ request('report_type') == 'attendance' ? 'selected' : '' }}>
                        Attendance
                    </option>

                    <option value="students"
                        {{ request('report_type') == 'students' ? 'selected' : '' }}>
                        Students
                    </option>

                    <option value="teachers"
                        {{ request('report_type') == 'teachers' ? 'selected' : '' }}>
                        Teachers
                    </option>

                </select>

            </div>

            {{-- START DATE --}}
            <div class="form-group">

                <label class="form-label">
                    Start Date
                </label>

                <input type="date"
                       name="start_date"
                       class="form-control"
                       value="{{ request('start_date') ?? '' }}">

            </div>

            {{-- END DATE --}}
            <div class="form-group">

                <label class="form-label">
                    End Date
                </label>

                <input type="date"
                       name="end_date"
                       class="form-control"
                       value="{{ request('end_date') ?? '' }}">

            </div>

            {{-- STATUS --}}
            <div class="form-group">

                <label class="form-label">
                    Status
                </label>

                <select name="status"
                        class="form-control">

                    <option value="">
                        All Status
                    </option>

                    <option value="active"
                        {{ request('status') == 'active' ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="inactive"
                        {{ request('status') == 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>

                    <option value="P"
                        {{ request('status') == 'P' ? 'selected' : '' }}>
                        Present
                    </option>

                    <option value="A"
                        {{ request('status') == 'A' ? 'selected' : '' }}>
                        Absent
                    </option>

                    <option value="L"
                        {{ request('status') == 'L' ? 'selected' : '' }}>
                        Leave
                    </option>

                </select>

            </div>

        </div>

        {{-- ACTION BUTTONS --}}
        <div class="report-actions" style="padding:10px;">

            <button type="submit"
                    class="btn btn-primary">

                <svg width="14"
                     height="14"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">

                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>

                    <polyline points="7 10 12 15 17 10"/>

                    <line x1="12" y1="15" x2="12" y2="3"/>

                </svg>

                Generate Report

            </button>

            {{-- EXPORT --}}
            <a href="{{ route('admin.report.export', request()->all()) }}"
               class="btn btn-success">

                <svg width="14"
                     height="14"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">

                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>

                    <polyline points="7 10 12 15 17 10"/>

                    <line x1="12" y1="15" x2="12" y2="3"/>

                </svg>

                Export CSV

            </a>

            <a href="{{ route('admin.report.index') }}"
               class="btn btn-ghost">

                Reset

            </a>

        </div>

    </form>

</div>

{{-- ═══════════ REPORT TABLE ═══════════ --}}
<div class="card">

    <div class="panel-hdr">

        <span class="panel-title">
            Report Records
        </span>

        <span style="font-size:13px;color:var(--faint)">

            {{ isset($reports) ? $reports->count() : 0 }}
            Records

        </span>

    </div>

    <div style="overflow-x:auto">

        <table class="roles-table">

            {{-- TABLE HEAD --}}
            <thead>

                {{-- ATTENDANCE --}}
                @if(request('report_type') == 'attendance' || !request('report_type'))

                    <tr>

                        <th>#</th>
                        <th>Student</th>
                        <th>Status</th>
                        <th>Marked By</th>
                        <th>Date</th>

                    </tr>

                {{-- STUDENTS --}}
                @elseif(request('report_type') == 'students')

                    <tr>

                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>

                    </tr>

                {{-- TEACHERS --}}
                @elseif(request('report_type') == 'teachers')

                    <tr>

                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>

                    </tr>

                @endif

            </thead>

            {{-- TABLE BODY --}}
            <tbody>

                @forelse($reports ?? [] as $key => $report)

                    {{-- ═════════ ATTENDANCE ═════════ --}}
                    @if(request('report_type') == 'attendance' || !request('report_type'))

                        <tr>

                            <td>
                                {{ $key + 1 }}
                            </td>

                            <td>
                                {{ $report->student->name ?? 'N/A' }}
                            </td>

                            <td>

                                @if(($report->status ?? '') == 'P')

                                    <span class="pill p-active">
                                        Present
                                    </span>

                                @elseif(($report->status ?? '') == 'A')

                                    <span class="pill p-suspended">
                                        Absent
                                    </span>

                                @elseif(($report->status ?? '') == 'L')

                                    <span class="pill p-pending">
                                        Leave
                                    </span>

                                @else

                                    <span class="pill">
                                        Unknown
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $report->markedBy->name ?? 'Admin' }}
                            </td>

                            <td>

                                @if(!empty($report->attendance_date))

                                    {{ \Carbon\Carbon::parse($report->attendance_date)->format('d M Y') }}

                                @else

                                    —

                                @endif

                            </td>

                        </tr>

                    {{-- ═════════ STUDENTS ═════════ --}}
                    @elseif(request('report_type') == 'students')

                        <tr>

                            <td>
                                {{ $key + 1 }}
                            </td>

                            <td>
                                {{ $report->name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $report->phone ?? '-' }}
                            </td>

                            <td>
                                {{ $report->email ?? '-' }}
                            </td>

                            <td>

                                @if(($report->status ?? '') == 'active')

                                    <span class="pill p-active">
                                        Active
                                    </span>

                                @else

                                    <span class="pill p-suspended">
                                        Inactive
                                    </span>

                                @endif

                            </td>

                        </tr>

                    {{-- ═════════ TEACHERS ═════════ --}}
                    @elseif(request('report_type') == 'teachers')

                        <tr>

                            <td>
                                {{ $key + 1 }}
                            </td>

                            <td>
                                {{ $report->name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $report->email ?? '-' }}
                            </td>

                            <td>
                                {{ $report->phone ?? '-' }}
                            </td>

                            <td>

                                @if(($report->status ?? '') == 'active')

                                    <span class="pill p-active">
                                        Active
                                    </span>

                                @else

                                    <span class="pill p-suspended">
                                        Inactive
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endif

                @empty

                    <tr>

                        <td colspan="10">

                            <div class="empty-state">

                                <svg width="40"
                                     height="40"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.5">

                                    <circle cx="12"
                                            cy="12"
                                            r="10"/>

                                    <path d="M8 12h8"/>

                                </svg>

                                <p>
                                    No report records found
                                </p>

                                <span>
                                    Try changing filters or report type
                                </span>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<style>

.report-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:18px;
}

.report-actions{
    display:flex;
    gap:12px;
    margin-top:20px;
    flex-wrap:wrap;
}

@media(max-width:992px){

    .report-grid{
        grid-template-columns:1fr 1fr;
    }

}

@media(max-width:576px){

    .report-grid{
        grid-template-columns:1fr;
    }

    .report-actions{
        flex-direction:column;
    }

}

</style>

@endsection